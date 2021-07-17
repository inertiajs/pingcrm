<?php

namespace App\Http\Controllers;

use App\Models\RuleCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class RuleCategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('RuleCategory/Index', [
            'filters' => Request::all('search', 'trashed'),
            'rulecategory' => Auth::user()->account->rulecategory()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($rulecategory) {
                    return [
                        'id' => $rulecategory->id,
                        'name' => $rulecategory->name,
                        'description'=>$rulecategory->description,
                        'category' => $rulecategory->category,
                        'parent_id' => $rulecategory->parent_id,
                        'instructor_id' => $rulecategory->instructor_id,
                        'priority'=> $rulecategory->priority,
                    ];
                }),
        ]);
    }

    public function create()
    {
        return Inertia::render('RuleCategory/Create');
    }

    public function store()
    {
        Auth::user()->account->rulecategory()->create(
            Request::validate([
                'name' => ['nullable', 'max:100'],
                'description' => ['nullable', 'max:100'],
                'category' => ['nullable', 'max:50'],
                'parent_id' => ['nullable', 'max:50'],
                'instructor_id' => ['nullable', 'max:50'],
                'priority' => ['nullable', 'max:50'],
            ])
        );

        return Redirect::route('rulecategory')->with('success', 'RuleCategory created.');
    }

    public function edit(RuleCategory $rulecategory)
    {
        return Inertia::render('RuleCategory/Edit', [
            'rulecategory' => [
                'id' => $rulecategory->id,
                'name' => $rulecategory->name,
                'description'=>$rulecategory->description,
                'category' => $rulecategory->category,
                'parent_id' => $rulecategory->parent_id,
                'instructor_id' => $rulecategory->instructor_id,
                'priority'=> $rulecategory->priority,
               
                //'contacts' => $rulecategory->contacts()->orderByName()->get()->map->only('id', 'name', 'city', 'phone'),
            ],
        ]);
    }

    public function update(RuleCategory $rulecategory)
    {
        $rulecategory->update(
            Request::validate([
                'name' => ['nullable', 'max:100'],
                'description' => ['nullable', 'max:100'],
                'category' => ['nullable', 'max:50'],
                'parent_id' => ['nullable', 'max:50'],
                'instructor_id' => ['nullable', 'max:50'],
                'priority' => ['nullable', 'max:50'],
            ])
        );

        return Redirect::back()->with('success', 'RuleCategory updated.');
    }

    public function destroy(RuleCategory $rulecategory)
    {
        $rulecategory->delete();

        return Redirect::back()->with('success', 'RuleCategory deleted.');
    }

    public function restore(RuleCategory $rulecategory)
    {
        $rulecategory->restore();

        return Redirect::back()->with('success', 'RuleCategory restored.');
    }
}
