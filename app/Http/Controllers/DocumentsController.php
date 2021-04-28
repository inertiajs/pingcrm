<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class DocumentsController extends Controller
{
    public function index()
    {
        return Inertia::render('Documents/Index', [
            'filters' => Request::all('search', 'trashed'),
            'documents' => Auth::user()->account->documents()
                ->orderBy('title')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($document) {
                    return [
                        'id' => $document->id,
                        'title' => $document->title,
                        'customer_name' => $document->customer_name,
                        'document_label' => $document->document_label,
                        'document_type' => $document->document_type,
                        'digit' => $document->digit,
                        'length' => $document->length,
                    ];
                }),
        ]);
    }

    public function create()
    {
        return Inertia::render('Documents/Create');
    }

    public function store()
    {
        Auth::user()->account->documents()->create(
            Request::validate([
                'id' => ['nullable', 'max:50'],
                'title' => ['required', 'max:100'],
                'customer_name' => ['nullable', 'max:300'],
                'document_type' => ['nullable', 'max:50'],
                'document_label' => ['nullable', 'max:150'],
                'digit' => ['nullable', 'max:50'],
                'length' => ['nullable', 'max:50'],
               
            ])
        );

        return Redirect::route('documents')->with('success', 'Documents created.');
    }

    public function edit(Document $document)
    {
        return Inertia::render('Documents/Edit', [
            'document' => [
                'id' => $document->id,
                        'title' => $document->title,
                        'customer_name' => $document->customer_name,
                        'document_label' => $document->document_label,
                        'document_type' => $document->document_type,
                        'digit' => $document->digit,
                        'length' => $document->length,
                //'contacts' => $document->contacts()->orderByName()->get()->map->only('id', 'title', 'city', 'phone'),
            ],
        ]);
    }

    public function update(Document $document)
    {
        $document->update(
            Request::validate([
                'id' => ['nullable', 'max:50'],
                'title' => ['required', 'max:100'],
                'customer_name' => ['nullable', 'max:300'],
                'document_type' => ['nullable', 'max:50'],
                'document_label' => ['nullable', 'max:150'],
                'digit' => ['nullable', 'max:50'],
                'length' => ['nullable', 'max:50'],
            ])
        );

        return Redirect::back()->with('success', 'Document updated.');
    }

    public function destroy(Document $document)
    {
        $document->delete();

        return Redirect::back()->with('success', 'Document deleted.');
    }

    public function restore(Document $document)
    {
        $document->restore();

        return Redirect::back()->with('success', 'Document restored.');
    }
}
