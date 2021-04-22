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
                ->orderBy('title')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($budget) {
                    return [
                        'id' => $budget->id,
                        'title' => $budget->title,
                        'description' => $budget->description,
                        'user_id' => $budget->user_id,
                        'annually_income' => $budget->annually_income,
                        'monthly_salary' => $budget->monthly_salary,
                        'data_type' => $budget->data_type,
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
                'id' => ['nullable', 'max:50'],
                'title' => ['required', 'max:100'],
                'description' => ['nullable', 'max:300'],
                'user_id' => ['nullable', 'max:50'],
                'annually_salary' => ['nullable', 'max:50'],
                'monthly_salary' => ['nullable', 'max:50'],
                'data_type' => ['nullable', 'max:50'],
                
            ])
        );

        return Redirect::route('budgets')->with('success', 'Budget created.');
    }

    public function edit(Budget $budget)
    {
        return Inertia::render('Budgets/Edit', [
            'budget' => [
                        'id' => $budget->id,
                        'title' => $budget->title,
                        'description' => $budget->description,
                        'user_id' => $budget->user_id,
                        'annually_income' => $budget->annually_income,
                        'monthly_salary' => $budget->monthly_salary,
                        'data_type' => $budget->data_type,
                //'contacts' => $budget->contacts()->orderByName()->get()->map->only('id', 'title', 'city', 'phone'),
            ],
        ]);
    }

    public function update(Budget $budget)
    {
        $budget->update(
            Request::validate([
                'id' => ['nullable', 'max:50'],
                'title' => ['required', 'max:100'],
                'description' => ['nullable', 'max:300'],
                'user_id' => ['nullable', 'max:50'],
                'annually_salary' => ['nullable', 'max:50'],
                'monthly_salary' => ['nullable', 'max:50'],
                'data_type' => ['nullable', 'max:50'],

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