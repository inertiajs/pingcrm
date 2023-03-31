<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Machinery;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class MachineryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Machinery/Index', [
            'filters' => Request::all('search', 'trashed', 'page'),
            'items' => Machinery::orderByName()
                ->filter(Request::only('search', 'trashed', 'folio'))
                ->paginate(10)
                ->transform(function ($machinery) {
                    return [
                        'id' => $machinery->id,
                        'no_serie' => $machinery->no_serie,
                        'price' => $machinery->price,
                        'category' => $machinery->category->name,
                        'deleted_at' => $machinery->deleted_at,
                    ];
                }),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Machinery/Create', [
            'categories' => Category::all('id', 'name')->map(function ($item) {
                return ['value' => $item->id, 'text' => $item->name];
            })

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Machinery::create(
            Request::validate([
                'category_id' => ['required', 'max:100', Rule::unique('machineries')],
                'no_serie' => ['required', 'max:100'],
                'model' => ['required'],
                'price' => ['required'],
            ])
        );

        return Redirect::route('machineries')->with('success', 'Maquinaria Registrada con Exito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Machinery  $machinery
     * @return \Illuminate\Http\Response
     */
    public function show(Machinery $machinery)
    {
        return Inertia::render('Machinery/Show', [
            'item' => [
                'id' => $machinery->id,
                'category_id' => $machinery->category_id,
                'no_serie' => $machinery->no_serie,
                'model' => $machinery->model,
                'description' => $machinery->description,
                'price' => $machinery->price,
                'acquisition_date' => $machinery->acquisition_date,
                'deleted_at' => $machinery->deleted_at,
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Machinery  $machinery
     * @return \Illuminate\Http\Response
     */
    public function edit(Machinery $machinery)
    {
        return Inertia::render('Machinery/Edit', [
            'categories' => Category::all('id', 'name')->map(function ($item) {
                return ['value' => $item->id, 'text' => $item->name];
            }),
            'item' => [
                'id' => $machinery->id,
                'category_id' => $machinery->category_id,
                'no_serie' => $machinery->no_serie,
                'model' => $machinery->model,
                'description' => $machinery->description,
                'price' => $machinery->price,
                'acquisition_date' => $machinery->acquisition_date,
                'deleted_at' => $machinery->deleted_at,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Machinery  $machinery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Machinery $machinery)
    {
        $machinery->update(
            Request::validate([
                'category_id' => ['required', 'max:100', Rule::unique('machineries')],
                'no_serie' => ['required', 'max:100'],
                'model' => ['required'],
                'price' => ['required'],
            ])
        );

        return Redirect::back()->with('success', 'Maquinaria Actualizada con Exito ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Machinery  $machinery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Machinery $machinery)
    {
        $machinery->delete();

        return Redirect::back()->with('success', 'Maquinaria Eliminada.');
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Models\Machinery  $machinery
     * @return \Illuminate\Http\Response
     */
    public function restore(Machinery $machinery)
    {
        $machinery->restore();

        return Redirect::back()->with('success', 'Maquinaria restored.');
    }
}
