<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use App\Models\Task;


class EloquentController extends Controller
{
    public function index()
    {
       return Task::where('id',5)
                    ->join('status', 'task.id', '=', 'status.team_id')
                    ->join('priority', 'task.id', '=', 'priority.team_id')
                    ->select('tasks.*', 'status', 'priority')
                    ->get();
       //
       return Task::where('status',100)->orderBy('title')->chunk(100, function ($tasks) {
            //foreach ($tasks as $task) {
                //
            //}
        //});
        
        //return Task::where('priority',10)->where('id',5)->first();
       // return Task::where('id',5)->first();
        //return Task::where('id',5)->get();
        //return Task::find(5);
        //return Task::all();
        //where('priority',10)->orderBy('description','desc')->pluck('task_id','priority')
    }
}
