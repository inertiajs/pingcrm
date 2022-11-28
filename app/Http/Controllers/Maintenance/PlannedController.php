<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Models\Maintenance\Issue;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class PlannedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Request::merge(['type' => 'maintenance']);
        
        return Inertia::render('Maintenance/Index', [
            'filters' => Request::all('search', 'type'),
            'issues' => Issue::orderBy('created_at')
                ->filter(Request::only('search', 'type'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($issue) => [
                    'id' => $issue->id,
                    'intervention_date' => $issue->intervention_date,
                    'from' => $issue->from,
                    'to' => $issue->to,
                    'type' => $issue->type,
                    'zones' => $issue->zones(),
                    'description' => $issue->description,
                    'deleted_at' => $issue->deleted_at,
                ]),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
