<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Maintenance\Issue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Request::merge(['type' => 'issue']);
        return Inertia::render('Maintenance/Issues/Index', [
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

    public function create()
    {
        return Inertia::render('Maintenance/Issues/Create', [
            'departments' => Department::orderBy('lib_dep')->get()->map->only('id', 'lib_dep'),
        ]);
    }

    public function store()
    {
        $validated = Request::validate([
            'intervention_date' => ['required', 'date'],
            'from' => ['required', 'date_format:H:i'],
            'to' => ['nullable', 'date_format:H:i'],
            'type' => ['required', 'in:issue,maintenance'],
            'description' => ['required'],
            'department_id' => ['required', 'exists:departments,id'],
            'commune_id' => ['nullable', 'exists:communes,id'],
            'arrondissement_id' => ['nullable', 'exists:arrondissements,id'],
            'area_id' => ['nullable', 'exists:areas,id'],
        ]);
        
        $issue = Auth::user()->account->issues()->create([
            'intervention_date' => $validated['intervention_date'],
            'from' => $validated['from'],
            'to' => $validated['to'],
            'type' => $validated['type'],
            'description' => $validated['description'],
        ]);

        DB::table('issue_zone')->insert([
            'issue_id' => $issue->id,
            'departement_id' => $validated['departement_id'],
            'commune_id' => $validated['commune_id'],
            'arrondissement_id' => $validated['arrondissement_id'],
            'area_id' => $validated['area_id'],
        ]);

        return Redirect::route('pannes.index')->with('success', 'Panne ajoutée.');
    }

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
    public function update(Request $request, $id)
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
