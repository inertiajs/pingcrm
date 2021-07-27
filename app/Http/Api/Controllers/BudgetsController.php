<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class BudgetsController extends Controller
{
    public function index()
    {
        return Inertia::render('Budgets/Index', [
            'filters' => Request::all('search', 'trashed'),
            'budgets' => Auth::user()->account->budgets()
                ->orderBy('id')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($budget) {
                    return [
                        'id' => $budget->id,
                        'project-name' => $budget->project_name,
                        'resources' => $budget->resources,
                        'cost' => $budget->cost,
                        'profit' => $budget->profit,
                        'loss' => $budget->loss,
                        'deleted_at' => $budget->deleted_at,
                    ];
                }),
        ]);
    }

    public function create()
    {
        return Inertia::render('Budgets/Create');
    }

    public function store()
    {
        Auth::user()->account->budgets()->create(
            Request::validate([
                
                'project_name' => ['required', 'max:100'],
                'resources' => ['nullable', 'max:300'],
                'cost' => ['nullable', 'max:50'],
                'profit' => ['nullable', 'max:50'],
                'loss' => ['nullable', 'max:50'],
            
                
            ])
        );

        return Redirect::route('budgets')->with('success', 'Budget created.');
    }

    public function edit(Budget $budget)
    {
        return Inertia::render('Budgets/Edit', [
            'budget' => [
                'id' => $budget->id,
                'project-name' => $budget->project_name,
                'resources' => $budget->resources,
                'cost' => $budget->cost,
                'profit' => $budget->profit,
                'loss' => $budget->loss,
                'deleted_at' => $budget->deleted_at,
                ],
        ]);
    }

    public function update(Budget $budget)
    {
        $budget->update(
            Request::validate([
                'project_name' => ['required', 'max:100'],
                'resources' => ['nullable', 'max:300'],
                'cost' => ['nullable', 'max:50'],
                'profit' => ['nullable', 'max:50'],
                'loss' => ['nullable', 'max:50'],
            
            ])
        );

        return Redirect::back()->with('success', 'Budget updated.');
    }

    public function destroy(Budget $budget)
    {
        $budget->delete();

        return Redirect::back()->with('success', 'Budget deleted.');
    }

    public function restore(Budget $budget)
    {
        $budget->restore();

        return Redirect::back()->with('success', 'Budget restored.');
    }
}
