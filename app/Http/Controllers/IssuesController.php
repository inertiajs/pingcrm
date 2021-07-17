<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class IssuesController extends Controller
{
    public function index()
    {
        return Inertia::render('Issues/Index', [
            'filters' => Request::all('search', 'trashed'),
            'issues' => Auth::user()->account->issues()
                ->orderBy('title')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($issue) {
                    return [
                        'id' => $issue->id,
                        'title' => $issue->title,
                        'description' => $issue->description,
                        'status' => $issue->status,
                        'priority' => $issue->priority,
                        'solution' => $issue->solution,
                        'assign' => $issue->assign,
                        'due_date' =>$issue->due_date,
                        'completed_date' => $issue->completed_date,
                        'deleted_at' => $issue->deleted_at,
                    ];
                }),
        ]);
    }

    public function create()
    {
        return Inertia::render('Issues/Create');
    }

    public function store()
    {
        Auth::user()->account->issues()->create(
            Request::validate([
                'title' => ['required', 'max:100'],
                'description' => ['nullable', 'max:100'],
                'status' => ['nullable', 'max:4'],
                'priority' => ['nullable', 'max:4'],
                'solution' => ['nullable', 'max:50'],
                'assign' => ['nullable', 'max:50'],
                'due_date' => ['nullable', 'max:30'],
                'completed_date' => ['nullable', 'max:30'],
            ])
        );

        return Redirect::route('issues')->with('success', 'Issues created.');
    }

    public function edit(Issue $issue)
    {
        return Inertia::render('Issues/Edit', [
            'issue' => [
                'id' => $issue->id,
                        'title' => $issue->title,
                        'description' => $issue->description,
                        'status' => $issue->status,
                        'priority' => $issue->priority,
                        'solution' => $issue->solution,
                        'assign' => $issue->assign,
                        'due_date' =>$issue->due_date,
                        'completed_date' => $issue->completed_date,
                        'deleted_at' => $issue->deleted_at,
            ],
        ]);
    }

    public function update(Issue $issue)
    {
        $issue->update(
            Request::validate([
              'title' => ['required', 'max:100'],
              'description' => ['nullable', 'max:100'],
              'status' => ['nullable', 'max:4'],
              'priority' => ['nullable', 'max:4'],
              // 'status' => ['nullable', 'max:4'],
              'solution' => ['nullable', 'max:50'],
              'assign' => ['nullable', 'max:50'],
              'due_date' => ['nullable', 'max:30'],
              'completed_date' => ['nullable', 'max:30'],
            ])
        );

        return Redirect::back()->with('success', 'Issue updated.');
    }

    public function destroy(Issue $issue)
    {
        $issue->delete();

        return Redirect::back()->with('success', 'Issue deleted.');
    }

    public function restore(Issue $issue)
    {
        $issue->restore();

        return Redirect::back()->with('success', 'Issue restored.');
    }
}
