<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ExperiencesController extends Controller
{
    public function index()
    {
        return Inertia::render('Experiences/Index', [
            'filters' => Request::all('search', 'trashed'),
            'experiences' => Auth::user()->account->experiences()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($experience) {
                    return [
                        'id' => $experience -> id,
                        'name' => $experience -> name,
                        'company' => $experience -> company,
                        'start_date' => $experience -> start_date,
                        'end_date' => $experience -> end_date,
                        'total_experience'=> $experience->total_experience,
                        'deleted_at' => $experience -> deleted_at,
                    ];
                }),
        ]);
    }

    public function create()
    {
        return Inertia::render('Experiences/Create');
    }

    public function store()
    {
        Auth::user()->account->experiences()->create(
            Request::validate([
                'name' => ['required', 'max:100'],
                'company' => ['nullable', 'max:50'],
                'start_date' => ['nullable','max:100'],
                'end_date' => ['nullable','max:100'],
                'total_experience'=>['nullable','max:100'],
                
            ])
        );

        return Redirect::route('experiences')->with('success', 'Experiences created.');
    }

    public function edit(Experience $experience)
    {
        return Inertia::render('Experiences/Edit', [
            'experience' => [
                'id' => $experience -> id,
                'name' => $experience -> name,
                'company' => $experience -> company,
                        'start_date' => $experience -> start_date,
                        'end_date' => $experience -> end_date,
                        'total_experience'=> $experience->total_experience,
                        'deleted_at' => $experience -> deleted_at,
                ],
        ]);
    }

    public function update(Experience $experience)
    {
        $experience->update(
            Request::validate([
                'name' => ['required', 'max:100'],
                'company' => ['nullable', 'max:50'],
                'start_date' => ['nullable','max:100'],
                'end_date' => ['nullable','max:100'],
                'total_experience'=>['nullable','max:100'],
                
            ])
        
        );

        return Redirect::back()->with('success', 'Experience updated.');
    }

    public function destroy(Experience $experience)
    {
        $experience->delete();

        return Redirect::back()->with('success', 'Experience deleted.');
    }

    public function restore(Experience $experience)
    {
        $experience->restore();

        return Redirect::back()->with('success', 'Experience restored.');
    }
}
