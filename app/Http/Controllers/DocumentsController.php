<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class DocumentsController extends Controller
{
    public function index()
    {
        return Inertia::render('Documents/Index', [
            'filters' => Request::all('search', 'trashed'),
            'documents' => Auth::user()->account->documents()
                ->orderBy('title')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($document) {
                    return [
                        'id' => $document->id,
                        'title' => $document->title,
                        'description' => $document->description,
                        'user_id' => $document->user_id,
                        'document_id' => $document->document_id,
                    ];
                }),
        ]);
    }

    public function create()
    {
        return Inertia::render('Documents/Create');
    }

    public function store()
    {
        Auth::user()->account->documents()->create(
            Request::validate([
                'id' => ['nullable', 'max:50'],
                'title' => ['required', 'max:100'],
                'description' => ['nullable', 'max:300'],
                'user_id' => ['nullable', 'max:50'],
                'document_id' => ['nullable', 'max:150'],
                'team_id' => ['nullable', 'max:50'],
                'project_id' => ['nullable', 'max:50'],
                'priority' => ['nullable', 'max:2'],
                'status' => ['nullable', 'max:25'],
                'creator' => ['nullable', 'max:25'],
                'due_date' => ['nullable', 'max:25'],
                'completed_date' => ['nullable', 'max:25'],
            ])
        );

        return Redirect::route('documents')->with('success', 'Documents created.');
    }

    public function edit(Document $document)
    {
        return Inertia::render('Documents/Edit', [
            'document' => [
                'id' => $document->id,
                'title' => $document->title,
                'description' => $document->description,
                'user_id' => $document->user_id,
                'document_id' => $document->document_id,
                'team_id' => $document->team_id,
                'project_id' => $document->project_id,
                'priority' => $document->priority,
                'status' => $document->status,
                'creator' => $document->creator,
                'due_date' => $document->due_date,
                'completed_date' => $document->completed_date,
                //'contacts' => $document->contacts()->orderByName()->get()->map->only('id', 'title', 'city', 'phone'),
            ],
        ]);
    }

    public function update(Document $document)
    {
        $document->update(
            Request::validate([
                'id' => ['nullable', 'max:50'],
                'title' => ['required', 'max:100'],
                'description' => ['nullable', 'max:300'],
                'user_id' => ['nullable', 'max:50'],
                'document_id' => ['nullable', 'max:150'],
                'team_id' => ['nullable', 'max:50'],
                'project_id' => ['nullable', 'max:50'],
                'priority' => ['nullable', 'max:2'],
                'status' => ['nullable', 'max:25'],
                'creator' => ['nullable', 'max:25'],
                'due_date' => ['nullable', 'max:25'],
                'completed_date' => ['nullable', 'max:25'],

            ])
        );

        return Redirect::back()->with('success', 'Document updated.');
    }

    public function destroy(Document $document)
    {
        $document->delete();

        return Redirect::back()->with('success', 'Document deleted.');
    }

    public function restore(Document $document)
    {
        $document->restore();

        return Redirect::back()->with('success', 'Document restored.');
    }
}
