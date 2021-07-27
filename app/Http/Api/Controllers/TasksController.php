<?php

namespace App\Http\Api\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class TasksController extends Controller
{
    public function __construct()
    {
        auth()->loginUsingId(1);
    }

    public function index()
    {
        return [
            'filters' => Request::all('search', 'trashed'),
            'tasks' => Auth::user()->account->tasks()
                ->orderBy('title')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($task) {
                    return [
                        'id' => $task->id,
                        'title' => $task->title,
                        'description' => $task->description,
                        'user_id' => $task->user_id,
                        'task_id' => $task->task_id,
                        'team_id' => $task->team_id,
                        'project_id' => $task->project_id,
                        'priority' => $task->priority,
                        'status' => $task->status,
                        'creator' => $task->creator,
                        'due_date' => $task->due_date,
                        'completed_date' => $task->completed_date,

                    ];
                }),
        ];
    }

    public function store()
    {
        $task = Auth::user()->account->tasks()->create(
            Request::validate([
                'id' => ['nullable', 'max:50'],
                'title' => ['required', 'max:100'],
                'description' => ['nullable', 'max:300'],
                'user_id' => ['nullable', 'max:50'],
                'task_id' => ['nullable', 'max:150'],
                'team_id' => ['nullable', 'max:50'],
                'project_id' => ['required', 'max:50'],
                'priority' => ['nullable', 'max:2'],
                'status' => ['nullable', 'max:25'],
                'creator' => ['nullable', 'max:25'],
                'due_date' => ['nullable', 'max:25'],
                'completed_date' => ['nullable', 'max:25'],
            ])
        );

        return $task->refresh();
    }

    public function show(Task $task)
    {
        return $task;
    }

    public function edit(Task $task)
    {
        return Inertia::render('Tasks/Edit', [
            'task' => [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'user_id' => $task->user_id,
                'task_id' => $task->task_id,
                'team_id' => $task->team_id,
                'project_id' => $task->project_id,
                'priority' => $task->priority,
                'status' => $task->status,
                'creator' => $task->creator,
                'due_date' => $task->due_date,
                'completed_date' => $task->completed_date,
                //'contacts' => $task->contacts()->orderByName()->get()->map->only('id', 'title', 'city', 'phone'),
            ],
        ]);
    }

    public function update(Task $task)
    {
        $task->update(
            Request::validate([
                'id' => ['nullable', 'max:50'],
                'title' => ['required', 'max:100'],
                'description' => ['nullable', 'max:300'],
                'user_id' => ['nullable', 'max:50'],
                'task_id' => ['nullable', 'max:150'],
                'team_id' => ['nullable', 'max:50'],
                'project_id' => ['nullable', 'max:50'],
                'priority' => ['nullable', 'max:2'],
                'status' => ['nullable', 'max:25'],
                'creator' => ['nullable', 'max:25'],
                'due_date' => ['nullable', 'max:25'],
                'completed_date' => ['nullable', 'max:25'],

            ])
        );

        return $task;
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(['success' => 'Task deleted.']);
    }

    public function restore(Task $task)
    {
        $task->restore();

        return response()->json(['success' => 'Task restored.']);
    }
}
