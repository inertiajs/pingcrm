<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Expedient;
use App\Models\File;
use App\Models\Status;
use Exception;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Documents/Index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expedient  $expedient
     * @return \Illuminate\Http\Response
     */
    public function show(Expedient $expedient)
    {
        // return Inertia::render('Documents/Show', [
        //     'expedient' => [
        //         'id' => $expedient->id,
        //         'name' => $expedient->name,
        //         'documents' => $expedient->requirements->map(function ($R) {
        //             return [
        //                 'id' => $R->document->id,
        //                 'title' => $R->name,
        //                 'description' => $R->description,
        //                 'status' => $R->document->status->key,
        //                 'commentary' => $R->document->commentary,
        //                 'until_valid' => $R->document->until_valid,
        //             ];
        //         }),
        //     ],
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expedient  $expedient
     * @return \Illuminate\Http\Response
     */
    public function edit(Expedient $expedient)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expedient  $expedient
     * @return \Illuminate\Http\Response
     */

    public function update(HttpRequest $request, Document $document)
    {
        Request::validate([
            'status_key' => ['required'],
            'until_valid' => ['exclude_unless:status_key,"valid"|nullable|date'],
            'commentary' => ['required_if:status_key,"invalid"|min:15'],
        ]);
        DB::beginTransaction();
        try {
            $status = Status::where('key', Request::get('status_key'))->first();

            $document->update([
                'commentary' => Request::get('commentary') ? Request::get('commentary') : null,
                'until_valid' => Request::get('until_valid') ? Request::get('until_valid') : null,
            ]);
            $document->status()->associate($status)->save();
        } catch (Exception $e) {
            DB::rollback();
            return $e;
            return Redirect::back()->with('error', 'ERROR Servidor para el Documento.');
        }
        DB::commit();

        return Redirect::back()->with('success', 'Documento Actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expedient  $expedient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expedient $expedient)
    {
        //
    }


    public function uploadFiles(HttpRequest $request, Document $document)
    {
        Request::validate([
            'archivos' => ['required'],
        ]);
        if (!$request->hasFile('archivos'))
            return Redirect::back()->with('error', 'No hay Archivos por Cargar.');
        DB::beginTransaction();
        try {
            $archivos = Request::file('archivos');
            if (is_array($archivos)) {
                foreach ($archivos as $file) {
                    $document->files()->create(
                        [
                            'document_id' => $document->id,
                            'user_id' => Auth::user()->id,
                            'file_name' => $file->getClientOriginalName(),
                            'file_path' => $file ? $file->store('files/expedients/' . $document->expedient_id . "/" . $document->id) : null
                        ]
                    );
                }
                $status = Status::where('key', Status::STATUS_KEY_REVIEW)->first();
                $document->commentary = null;
                $document->status()->associate($status)->save();
            }
        } catch (Exception $e) {
            DB::rollback();
            return $e;
            return Redirect::back()->with('error', 'ERROR Servidor para el Documento.');
        }
        DB::commit();

        return Redirect::back()->with('success', 'Archivo(s) Cargado(s) al Documento');
    }

    public function deleteFile(File $file)
    {
        DB::beginTransaction();
        try {
            $file_path = $file->file_path;
            if (Storage::exists($file_path))
                Storage::delete($file_path);
            $file->delete();
        } catch (Exception $e) {
            DB::rollback();
            return $e;
            return Redirect::back()->with('error', 'ERROR Servidor para el Documento.');
        }
        DB::commit();

        return Redirect::back()->with('success', 'Archivo Eliminado');
    }

    public function downloadFilesZip(Document $document)
    {
        $zip_file = 'documents.zip';
        $zip = new \ZipArchive();
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        $path = Storage::path('files/expedients/' . $document->expedient_id . "/" . $document->id);
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        foreach ($files as $name => $file) {
            // We're skipping all subfolders
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                // extracting filename with substr/strlen
                // return dd($file->getFileName());
                $relativePath =  $document->expedient->name . "/" . $document->requirement->name . '/' . $file->getFileName();
                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();
        return response()->download($zip_file);
    }
}
