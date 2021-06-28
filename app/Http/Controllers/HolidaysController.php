<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class HolidaysController extends Controller
{
    public function index()
    {
        return Inertia::render('Holidays/Index', [
            'filters' => Request::all('search', 'trashed'),
            'holidays' => Auth::user()->account->holidays()
                ->orderBy('month')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($holiday) {
                    return [
                        'id' => $holiday->id,
                        'month' => $holiday->month,
                        'weak' => $holiday->weak,
                        'day' => $holiday->day,
                        'date' => $holiday->date,
                    ];
                }),
        ]);
    }

    public function create()
    {
        return Inertia::render('Holidays/Create');
    }

    public function store()
    {
        Auth::user()->account->holidays()->create(
            Request::validate([
            
                'month' => ['required', 'max:20'],
                'weak' => ['required', 'max:20'],
                'day' => ['required', 'max:20'],
                'date' => ['required', 'max:20'],
            ])
        );

        return Redirect::route('holidays')->with('success', 'Holidays created.');
    }

    public function edit(Holiday $holiday)
    {
        return Inertia::render('Holidays/Edit', [
            'holiday' => [
                'id' => $holiday->id,
                      
                        'month' => $holiday->month,
                        'weak' => $holiday->weak,
                        'day' => $holiday->day,
                        'date' => $holiday->date,
                //'contacts' => $holiday->contacts()->orderByName()->get()->map->only('id', 'name', 'city', 'phone'),
            ],
        ]);
    }

    public function update(Holiday $holiday)
    {
        $holiday->update(
            Request::validate([
                'month' => ['required', 'max:20'],
                'weak' => ['required', 'max:20'],
                'day' => ['required', 'max:20'],
                'date' => ['required', 'max:20'],
            ])
        );

        return Redirect::back()->with('success', 'Holiday updated.');
    }

    public function destroy(Holiday $holiday)
    {
        $holiday->delete();

        return Redirect::back()->with('success', 'Holiday deleted.');
    }

    public function restore(Holiday $holiday)
    {
        $holiday->restore();

        return Redirect::back()->with('success', 'Holiday restored.');
    }
}
