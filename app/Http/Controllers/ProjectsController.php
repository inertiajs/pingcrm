<?php

namespace App\Http\Controllers;

use App\Models\Projects;
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
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($project) {
                    return [
                        'id' => $project->id,
                        'name' => $project->name,
                        'phone' => $project->phone,
                        'priority' => $project->priority,
                        'status' => $project->status,
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
                'name' => ['required', 'max:100'],
                'phone' => ['nullable', 'max:20'],
                'status' => ['nullable', 'max:4'],
                'priority' => ['nullable', 'max:4'],
            ])
        );

        return Redirect::route('projects')->with('success', 'Projects created.');
    }

    public function edit(Project $project)
    {
        return Inertia::render('Projects/Edit', [
            'project' => [
                'id' => $project->id,
                'name' => $project->name,
                'phone' => $project->phone,
                'status' => $project->status,
                'priority' => $project->priority,
                'deleted_at' => $project->deleted_at,
                //'contacts' => $client->contacts()->orderByName()->get()->map->only('id', 'name', 'city', 'phone'),
            ],
        ]);
    }

    public function update(Project $project)
    {
        $project->update(
            Request::validate([
                'name' => ['required', 'max:100'],
                'phone' => ['nullable', 'max:20'],
                'status' => ['nullable', 'max:4'],
                'priority' => ['nullable', 'max:4'],
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
