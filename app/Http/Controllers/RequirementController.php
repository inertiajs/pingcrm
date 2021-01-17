<?php

namespace App\Http\Controllers;

use App\Models\Requirement;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class RequirementController extends Controller
{
    public function index()
    {
        return
            Inertia::render('Requirements/Index', [
                'filters' => Request::all('search', 'trashed', 'page'),
                'requirements' => Requirement::orderByName()
                    ->filter(Request::only('search', 'trashed'))
                    ->paginate()
                    ->transform(function ($requirement) {
                        return [
                            'id' => $requirement->id,
                            'name' => $requirement->name,
                            'deleted_at' => $requirement->deleted_at,
                        ];
                    }),
            ]);
    }

    public function create()
    {
        return Inertia::render('Requirements/Create');
    }

    public function store()
    {
        Requirement::create(
            Request::validate([
                'name' => ['required', 'max:100'],
                'description' => ['required', 'max:100'],
            ])
        );

        return Redirect::route('requirements')->with('success', 'Requirement created.');
    }

    public function edit(Requirement $requirement)
    {
        return Inertia::render('Requirements/Edit', [
            'requirement' => [
                'id' => $requirement->id,
                'name' => $requirement->name,
                'description' => $requirement->description,
                'deleted_at' => $requirement->deleted_at,
            ],
        ]);
    }

    public function update(Requirement $requirement)
    {
        $requirement->update(
            Request::validate([
                'name' => ['required', 'max:100'],
                'description' => ['nullable', 'max:200'],
            ])
        );

        return Redirect::back()->with('success', 'Requirement updated.');
    }

    public function destroy(Requirement $requirement)
    {
        $requirement->delete();

        return Redirect::back()->with('success', 'Requirement deleted.');
    }

    public function restore(Requirement $requirement)
    {
        $requirement->restore();

        return Redirect::back()->with('success', 'Requirement restored.');
    }
}
