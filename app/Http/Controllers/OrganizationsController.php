<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class OrganizationsController extends Controller
{
    public function index()
    {
        return Inertia::render('Organizations/Index', [
            'filters' => Request::all('search', 'trashed'),
            'organizations' => Auth::user()->account->organizations()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($organization) => [
                    'id' => $organization->id,
                    'name' => $organization->name,
                    'centre' => $organization->centre,
                    'phone' => $organization->phone,
                    'address' => $organization->address,
                    'deleted_at' => $organization->deleted_at,
                ]),
        ]);
    }

    public function create()
    {
        return Inertia::render('Organizations/Create', [
            'departments' => Department::orderBy('lib_dep')->get()->map->only('id', 'lib_dep'),
        ]);
    }

    public function store()
    {
        Auth::user()->account->organizations()->create(
            Request::validate([
                'name' => ['required', 'max:100'],
                'phone' => ['nullable', 'max:50'],
                'address' => ['nullable', 'max:150'],
                'centre' => ['required', 'in:commercial,tech'],
                'department_id' => ['required', 'exists:departments,id'],
                'commune_id' => ['required', 'exists:communes,id'],
                'arrondissement_id' => ['nullable', 'exists:arrondissements,id'],
                'area_id' => ['nullable', 'exists:areas,id'],
            ])
        );

        return Redirect::route('agences.index')->with('success', 'Agence ajoutée.');
    }

    public function edit(Organization $organization)
    {
        return Inertia::render('Organizations/Edit', [
            'departments' => Department::orderBy('lib_dep')->get()->map->only('id', 'lib_dep'),
            'organization' => [
                'id' => $organization->id,
                'name' => $organization->name,
                'phone' => $organization->phone,
                'address' => $organization->address,
                'centre' => $organization->centre,
                'department_id' => $organization->department->id,
                'commune_id' => $organization->commune->id,
                'arrondissement_id' => $organization->arrondissement->id ?? null,
                'area_id' => $organization->area->id ?? null,
                'deleted_at' => $organization->deleted_at,
                'contacts' => $organization->contacts()->orderByName()->get()->map->only('id', 'name', 'support', 'phone'),
            ],
        ]);
    }

    public function update(Organization $organization)
    {
        $organization->update(
            Request::validate([
                'name' => ['required', 'max:100'],
                'phone' => ['nullable', 'max:50'],
                'address' => ['nullable', 'max:150'],
                'centre' => ['required', 'in:commercial,tech'],
                'department_id' => ['required', 'exists:departments,id'],
                'commune_id' => ['required', 'exists:communes,id'],
                'arrondissement_id' => ['nullable', 'exists:arrondissements,id'],
                'area_id' => ['nullable', 'exists:areas,id'],
            ])
        );

        return Redirect::back()->with('success', 'Agence modifiée.');
    }

    public function destroy(Organization $organization)
    {
        $organization->delete();

        return Redirect::back()->with('success', 'Agence supprimée.');
    }

    public function restore(Organization $organization)
    {
        $organization->restore();

        return Redirect::back()->with('success', 'Agence Restaurée.');
    }
}
