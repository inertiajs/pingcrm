<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class EducationsController extends Controller
{
    public function index()
    {
        return Inertia::render('Educations/Index', [
            'filters' => Request::all('search', 'trashed'),
            'Educations' => Auth::user()->account->Educations()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($Education) {
                    return [
                        'id' => $Education->id,
                        'name' => $Education->name,
                        'phone' => $Education->phone,
                        'city' => $Education->city,
                        'deleted_at' => $Education->deleted_at,
                    ];
                }),
        ]);
    }

    public function create()
    {
        return Inertia::render('Educations/Create');
    }

    public function store()
    {
        Auth::user()->account->Educations()->create(
            Request::validate([
                'name' => ['required', 'max:100'],
                'email' => ['nullable', 'max:50', 'email'],
                'phone' => ['nullable', 'max:50'],
                'address' => ['nullable', 'max:150'],
                'city' => ['nullable', 'max:50'],
                'region' => ['nullable', 'max:50'],
                'country' => ['nullable', 'max:2'],
                'postal_code' => ['nullable', 'max:25'],
            ])
        );

        return Redirect::route('Educations')->with('success', 'Educations created.');
    }

    public function edit(Education $Education)
    {
        return Inertia::render('Educations/Edit', [
            'Education' => [
                'id' => $Education->id,
                'name' => $Education->name,
                'email' => $Education->email,
                'phone' => $Education->phone,
                'address' => $Education->address,
                'city' => $Education->city,
                'region' => $Education->region,
                'country' => $Education->country,
                'postal_code' => $Education->postal_code,
                'deleted_at' => $Education->deleted_at,
                'contacts' => $Education->contacts()->orderByName()->get()->map->only('id', 'name', 'city', 'phone'),
            ],
        ]);
    }

    public function update(Education $Education)
    {
        $Education->update(
            Request::validate([
                'name' => ['required', 'max:100'],
                'email' => ['nullable', 'max:50', 'email'],
                'phone' => ['nullable', 'max:50'],
                'address' => ['nullable', 'max:150'],
                'city' => ['nullable', 'max:50'],
                'region' => ['nullable', 'max:50'],
                'country' => ['nullable', 'max:2'],
                'postal_code' => ['nullable', 'max:25'],
            ])
        );

        return Redirect::back()->with('success', 'Education updated.');
    }

    public function destroy(Education $Education)
    {
        $Education->delete();

        return Redirect::back()->with('success', 'Education deleted.');
    }

    public function restore(Education $Education)
    {
        $Education->restore();

        return Redirect::back()->with('success', 'Education restored.');
    }
}