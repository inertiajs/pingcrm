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
            'educations' => Auth::user()->account->educations()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($education) {
                    return [
                        'id' => $education->id,
                        'title' => $education->title,
                        'description' => $education->description,
                        'user_id' => $education->user_id,
                        'education_id' => $education->education_id,
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
                'id' => ['nullable', 'max:50'],
                'title' => ['required', 'max:100'],
                'description' => ['nullable', 'max:300'],
                'user_id' => ['nullable', 'max:50'],
                'education_id' => ['nullable', 'max:150'],
                'team_id' => ['nullable', 'max:50'],
                'project_id' => ['nullable', 'max:50'],
                'priority' => ['nullable', 'max:2'],
                'status' => ['nullable', 'max:25'],
                'creator' => ['nullable', 'max:25'],
                'due_date' => ['nullable', 'max:25'],
                'completed_date' => ['nullable', 'max:25'],
            ])
        );

        return Redirect::route('educations')->with('success', 'Educations created.');
    }

    public function edit(Education $education)
    {
        return Inertia::render('Educations/Edit', [
            'education' => [
                'id' => $education->id,
                'title' => $education->title,
                'description' => $education->description,
                'user_id' => $education->user_id,
                'education_id' => $education->education_id,
                'team_id' => $education->team_id,
                'project_id' => $education->project_id,
                'priority' => $education->priority,
                'status' => $education->status,
                'creator' => $education->creator,
                'due_date' => $education->due_date,
                'completed_date' => $education->completed_date,
                'contacts' => $education->contacts()->orderByName()->get()->map->only('id', 'name', 'city', 'phone'),
            ],
        ]);
    }

    public function update(Education $education)
    {
        $education->update(
            Request::validate([
                'title' => ['required', 'max:100'],
                'description' => ['nullable', 'max:50', 'email'],
                'priority' => ['nullable', 'max:50'],
                'status' => ['nullable', 'max:150'],
                'creator' => ['nullable', 'max:50'],
                'due_date' => ['nullable', 'max:50'],
                'completed_date' => ['nullable', 'max:2'],
             
            ])
        );

        return Redirect::back()->with('success', 'Education updated.');
    }

    public function destroy(Education $education)
    {
        $education->delete();

        return Redirect::back()->with('success', 'Education deleted.');
    }

    public function restore(Education $education)
    {
        $education->restore();

        return Redirect::back()->with('success', 'Education restored.');
    }
}
