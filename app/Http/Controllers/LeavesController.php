<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class LeavesController extends Controller
{
    public function index()
    {
        return Inertia::render('Leaves/Index', [
            'filters' => Request::all('search', 'trashed'),
            'leaves' => Auth::user()->account->leaves()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($leave) {
                    return [
                        'id' => $leave->id,
                        'name' => $leave->name,
                        'contact_no'=>$leave->contact_no,
                        'day' => $leave->day,
                        'date' => $leave->date,
                        'reason_of_leave' => $leave->reason_of_leave,

                    ];
                }),
        ]);
    }

    public function create()
    {
        return Inertia::render('Leaves/Create');
    }

    public function store()
    {
        Auth::user()->account->leaves()->create(
            Request::validate([
            
                'name' => ['required', 'max:20'],
                'contact_no' => ['required', 'max:20'],
                'day' => ['required', 'max:20'],
                'date' => ['required', 'max:20'],
                'reason_of_leave' => ['required', 'max:250'],
            ])
        );

        return Redirect::route('leaves')->with('success', 'Leaves created.');
    }

    public function edit(Leave $leave)
    {
        return Inertia::render('Leaves/Edit', [
            'leave' => [
                
                'id' => $leave->id,
                'name' => $leave->name,
                'contact_no'=>$leave->contact_no,
                'day' => $leave->day,
                'date' => $leave->date,
                'reason_of_leave' => $leave->reason_of_leave,

                //'contacts' => $leave->contacts()->orderByName()->get()->map->only('id', 'name', 'city', 'phone'),
            ],
        ]);
    }

    public function update(Leave $leave)
    {
        $leave->update(
            Request::validate([
                'name' => ['required', 'max:20'],
                'contact_no' => ['required', 'max:20'],
                'day' => ['required', 'max:20'],
                'date' => ['required', 'max:20'],
                'reason_of_leave' => ['required', 'max:250'],
            ])
        );

        return Redirect::back()->with('success', 'Leave updated.');
    }

    public function destroy(Leave $leave)
    {
        $leave->delete();

        return Redirect::back()->with('success', 'Leave deleted.');
    }

    public function restore(Leave $leave)
    {
        $leave->restore();

        return Redirect::back()->with('success', 'Leave restored.');
    }
}
