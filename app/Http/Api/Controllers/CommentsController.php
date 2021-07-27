<?php

namespace App\Http\Api\Controllers;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class CommentsController extends Controller
{
    public function __construct()
    {
        auth()->loginUsingId(1);
    }

    public function index()
    {
        return [
            'filters' => Request::all('search', 'trashed'),
            'comments' => Auth::user()->account->comments()
                ->orderBy('id')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($comment) {
                    return [
                        'id' => $comment->id,
                        'description' => $comment->description,
                        'user_id' => $comment->user_id,
                        'task_id'=>$comment->task_id,
                        'assigned_user_id' => $comment->assigned_user_id,
                        'type'=>$comment->type
                    ];
                }),
        ];
    }

    public function store()
    {
        $comment=Auth::user()->account->comments()->create(
            Request::validate([
                'id' => ['nullable', 'max:50'],
                'description' => ['nullable', 'max:300'],
                'user_id' => ['nullable', 'max:50'],
                'task_id' => ['nullable', 'max:50'],
                'assigned_user_id' => ['nullable', 'max:50'],
                'type' => ['nullable', 'max:50'],
            ])
        );
        
        return $comment->refresh();
    }

    public function show(Comment $comment)
    {
        return $comment;
    }

    public function edit(Comment $comment)
    {
        return Inertia::render('Comments/Edit', [
            'comment' => [
                'id' => $comment->id,
                'description' => $comment->description,
                'user_id' => $comment->user_id,
                'task_id'=>$comment->task_id,
                'assigned_user_id' => $comment->assigned_user_id,
                'type'=>$comment->type
                
                //'contacts' => $comment->contacts()->orderByName()->get()->map->only('id', 'title', 'city', 'phone'),
            ],
        ]);
    }

    public function update(Comment $comment)
    {
        $comment->update(
            Request::validate([
                'id' => ['nullable', 'max:50'],
                'description' => ['nullable', 'max:300'],
                'user_id' => ['nullable', 'max:50'],
                'task_id' => ['nullable', 'max:50'],
                'assigned_user_id' => ['nullable', 'max:50'],
                'type' => ['nullable', 'max:50'],

            ])
        );

        return $comment;
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json(['success' =>'Comment deleted.']);
    }

    public function restore(Comment $comment)
    {
        $comment->restore();

        return response()->json(['success' =>'Comment restored.']);
    }
}
