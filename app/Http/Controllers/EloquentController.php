<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use App\Models\Task;


class EloquentController extends Controller
{
    public function index()
    {
        return Task::where('priority',10)->orderBy('description','desc')->pluck('title','status');
        return Task::where('priority',10)->where('id',5)->first();
        return Task::where('id',5)->first();
        return Task::where('id',5)->get();
        return Task::find(5);
        return Task::all();
    }
}
