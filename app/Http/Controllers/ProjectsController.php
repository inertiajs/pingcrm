<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ProjectsController extends Controller
{
    public function index()
    {
        return Inertia::render('Projects/Index', [
            'filters' => Request::all('search', 'trashed'),
            'projects' => Auth::user()->account->projects()
                ->orderBy('title')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($project) {
                    return [
                        'id' => $project->id,
                        'title' => $project->title,
                        'description' => $project->description,
                        'status' => $project->status,
                        'priority' => $project->priority,
                        'creator' => $project->creator,
                        'due_date' =>$project->due_date,
                        'completed_date' => $project->completed_date,
                        'deleted_at' => $project->deleted_at,
                    ];
                }),
        ]);
    }

    public function create()
    {
        return Inertia::render('Projects/Create');
    }

    public function store()
    {
        Auth::user()->account->projects()->create(
            Request::validate([
                'title' => ['required', 'max:100'],
                'description' => ['nullable', 'max:100'],
                'status' => ['nullable', 'max:4'],
                'priority' => ['nullable', 'max:4'],
                'creator' => ['nullable', 'max:50'],
                'due_date' => ['nullable', 'max:30'],
                'completed_date' => ['nullable', 'max:30'],
            ])
        );

        return Redirect::route('projects')->with('success', 'Projects created.');
    }

    public function edit(Project $project)
    {
        return Inertia::render('Projects/Edit', [
            'project' => [
                'id' => $project->id,
                        'title' => $project->title,
                        'description' => $project->description,
                        'status' => $project->status,
                        'priority' => $project->priority,
                        'creator' => $project->creator,
                        'due_date' =>$project->due_date,
                        'completed_date' => $project->completed_date,
                        'deleted_at' => $project->deleted_at,
            ],
        ]);
    }

    public function update(Project $project)
    {
        $project->update(
            Request::validate([
              'title' => ['required', 'max:100'],
              'description' => ['nullable', 'max:100'],
              'status' => ['nullable', 'max:4'],
              'priority' => ['nullable', 'max:4'],
              // 'status' => ['nullable', 'max:4'],
              'creator' => ['nullable', 'max:50'],
              'due_date' => ['nullable', 'max:30'],
              'completed_date' => ['nullable', 'max:30'],
            ])
        );

        return Redirect::back()->with('success', 'Project updated.');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return Redirect::back()->with('success', 'Project deleted.');
    }

    public function restore(Project $project)
    {
        $project->restore();

        return Redirect::back()->with('success', 'Project restored.');
    }
}
