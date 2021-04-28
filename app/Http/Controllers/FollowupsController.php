<?php

namespace App\Http\Controllers;

use App\Models\Followup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class FollowupsController extends Controller
{
    public function index()
    {
        return Inertia::render('Followups/Index', [
            'filters' => Request::all('search', 'trashed'),
            'followups' => Auth::user()->account->followups()
                ->orderBy('title')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($followup) {
                    return [
                        'id' => $followup->id,
                        'title' => $followup->title,
                        'description' => $followup->description,
                        'customer_name' => $followup->customer_name,
                        'team_id'=> $followup->team_id,
                        'email' => $followup->email,
                        'priority'=> $followup->priority,
                        'status'=> $followup->status,
                        'phone'=> $followup->phone,
                        'agreement'=> $followup-> agreement,
                        'maximum_time'=> $followup->maximum_time,
                        'meeting_schedule'=> $followup->meeting_schedule,
                    ];
                }),
        ]);
    }

    public function create()
    {
        return Inertia::render('Followups/Create');
    }

    public function store()
    {
        Auth::user()->account->followups()->create(
            Request::validate([
                'id' => ['nullable', 'max:50'],
                'title' => ['required', 'max:100'],
                'description' => ['nullable', 'max:300'],
                'customer_name' => ['nullable', 'max:50'],
                'team_id' => ['nullable', 'max:150'],
                'priority' => ['nullable', 'max:2'],
                'status' => ['nullable', 'max:25'],
                'email' => ['nullable', 'max:25'],
                'agreement' => ['nullable', 'max:25'],
                'phone' => ['nullable', 'max:25'],
                'maximum_time' => ['nullable', 'max:25'],
                'meeting_schedule' => ['nullable', 'max:25'],
            ])
        );

        return Redirect::route('followups')->with('success', 'Followups created.');
    }

    public function edit(Followup $followup)
    {
        return Inertia::render('Followups/Edit', [
            'followup' => [
                        'id' => $followup->id,
                        'title' => $followup->title,
                        'description' => $followup->description,
                        'customer_name' => $followup->customer_name,
                        'team_id'=> $followup->team_id,
                        'email' => $followup->email,
                        'priority'=> $followup->priority,
                        'status'=> $followup->status,
                        'phone'=> $followup->phone,
                        'agreement'=> $followup-> agreement,
                        'maximum_time'=> $followup->maximum_time,
                        'meeting_schedule'=> $followup->meeting_schedule,
                //'contacts' => $followup->contacts()->orderByName()->get()->map->only('id', 'title', 'city', 'phone'),
            ],
        ]);
    }

    public function update(Followup $followup)
    {
        $followup->update(
            Request::validate([
                'id' => ['nullable', 'max:50'],
                'title' => ['required', 'max:100'],
                'description' => ['nullable', 'max:300'],
                'customer_name' => ['nullable', 'max:50'],
                'team_id' => ['nullable', 'max:150'],
                'priority' => ['nullable', 'max:2'],
                'status' => ['nullable', 'max:25'],
                'email' => ['nullable', 'max:25'],
                'agreement' => ['nullable', 'max:25'],
                'phone' => ['nullable', 'max:25'],
                'maximum_time' => ['nullable', 'max:25'],
                'meeting_schedule' => ['nullable', 'max:25'],
            ])
        );

        return Redirect::back()->with('success', 'Followup updated.');
    }

    public function destroy(Followup $followup)
    {
        $followup->delete();

        return Redirect::back()->with('success', 'Followup deleted.');
    }

    public function restore(Followup $followup)
    {
        $followup->restore();

        return Redirect::back()->with('success', 'Followup restored.');
    }
}
