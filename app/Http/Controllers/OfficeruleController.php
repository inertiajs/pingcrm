<?php

namespace App\Http\Controllers;

use App\Models\OfficeRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class OfficeRuleController extends Controller
{
    public function index()
    {
        return Inertia::render('OfficeRule/Index', [
            'filters' => Request::all('search', 'trashed'),
            'officerule' => Auth::user()->account->officerule()
                
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($officerule) {
                    return [
                        
                        'id' => $officerule->id,
                        'title' => $officerule->name,
                        'description' => $officerule->phone,
                        'user_id' => $officerule->priority,
                        'rule_category_id' => $officerule->status,
                        
                    ];
                }),
        ]);
    }

    public function create()
    {
        return Inertia::render('OfficeRule/Create');
    }

    public function store()
    {
        Auth::user()->account->officerule()->create(
            Request::validate([
                'id' => ['nullable', 'max:50'],
                'title' => ['nullable', 'max:100'],
                'description' => ['nullable', 'max:200'],
                'user_id' => ['nullable', 'max:4'],
                'rule_category_id' => ['nullable', 'max:4'],
            ])
        );

        return Redirect::route('officerule')->with('success', 'Officerule created.');
    }

    public function edit(Officerule $officerule)
    {
        return Inertia::render('OfficeRule/Edit', [
            'officerule' => [
                'id' => $officerule->id,
                'title' => $officerule->name,
                'description' => $officerule->phone,
                'user_id' => $officerule->priority,
                'rule_category_id' => $officerule->status,
                //'contacts' => $officerule->contacts()->orderByName()->get()->map->only('id', 'name', 'city', 'phone'),
            ],
        ]);
    }

    public function update(Officerule $officerule)
    {
        $officerule->update(
            Request::validate([
                'id' => ['nullable', 'max:50'],
                'title' => ['nullable', 'max:100'],
                'description' => ['nullable', 'max:200'],
                'user_id' => ['nullable', 'max:4'],
                'rule_category_id' => ['nullable', 'max:4'],
            ])
        );

        return Redirect::back()->with('success', 'Officerule updated.');
    }

    public function destroy(Officerule $officerule)
    {
        $officerule->delete();

        return Redirect::back()->with('success', 'Officerule deleted.');
    }

    public function restore(Officerule $officerule)
    {
        $officerule->restore();

        return Redirect::back()->with('success', 'Officerule restored.');
    }
}
