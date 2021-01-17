<?php

namespace App\Http\Controllers;

use App\Models\Expedient;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ExpedientController extends Controller
{
    public function index()
    {
        return
            Inertia::render('Expedients/Index', [
                'filters' => Request::all('search', 'trashed', 'page'),
                'expedients' => Expedient::orderByName()
                    ->filter(Request::only('search', 'trashed'))
                    ->paginate(10)
                    ->transform(function ($expedient) {
                        return [
                            'id' => $expedient->id,
                            'name' => $expedient->name,
                            'deleted_at' => $expedient->deleted_at,
                        ];
                    }),
            ]);
    }

    public function create()
    {
        return Inertia::render('Expedients/Create');
    }

    public function store()
    {
        Expedient::create(
            Request::validate([
                'name' => ['required', 'max:100'],
            ])
        );

        return Redirect::route('expedients')->with('success', 'Expedient created.');
    }

    public function edit(Expedient $expedient)
    {
        return Inertia::render('Expedients/Edit', [
            'expedient' => [
                'id' => $expedient->id,
                'name' => $expedient->name,
                'deleted_at' => $expedient->deleted_at,
            ],
        ]);
    }

    public function update(Expedient $expedient)
    {
        $expedient->update(
            Request::validate([
                'name' => ['required', 'max:100'],
                'description' => ['nullable', 'max:200'],
            ])
        );

        return Redirect::back()->with('success', 'Expedient updated.');
    }

    public function destroy(Expedient $expedient)
    {
        $expedient->delete();

        return Redirect::back()->with('success', 'Expedient deleted.');
    }

    public function restore(Expedient $expedient)
    {
        $expedient->restore();

        return Redirect::back()->with('success', 'Expedient restored.');
    }
}
