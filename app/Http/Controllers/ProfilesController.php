<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ProfilesController extends Controller
{
    public function index()
    {
        return Inertia::render('Profiles/Index', [
            'filters' => Request::all('search', 'trashed'),
            'profiles' => Auth::user()->account->profiles()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($profile) {
                    return [
                        'id' => $profile -> id,
                        'name' => $profile -> name,
                        'phone' => $profile -> phone,
                        'city' => $profile -> city,
                        'job' => $profile -> job,
                        'nationality' => $profile -> nationality,
                        'deleted_at' => $profile->deleted_at,
                   
                    ];
                }),
        ]);
    }

    public function create()
    {
        return Inertia::render('Profiles/Create');
    }

    public function store()
    {
        Auth::user()->account->profiles()->create(
            Request::validate([
                'name' => ['required', 'max:100'],
                'phone' => ['nullable', 'max:50'],
                'city' => ['nullable','max:100'],
                'job' => ['nullable','max:100'],
                'nationality' => ['nullable','max:100']
                
            ])
        );

        return Redirect::route('profiles')->with('success', 'Profiles created.');
    }

    public function edit(Profile $profile)
    {
        return Inertia::render('Profiles/Edit', [
            'profile' => [
                'id' => $profile -> id,
                'name' => $profile -> name,
                'phone' => $profile -> phone,
                'city' => $profile -> city,
                'job' => $profile -> job,
                'nationality' => $profile -> nationality,
                'deleted_at' => $profile -> deleted_at,
                ],
        ]);
    }

    public function update(Profile $profile)
    {
        $profile->update(
            Request::validate([
                'name' => ['required', 'max:100'],
                'phone' => ['nullable', 'max:50'],
                'city' => ['nullable','max:100'],
                'job' => ['nullable','max:100'],
                'nationality' => ['nullable','max:100']
               ])
        
        );

        return Redirect::back()->with('success', 'Profile updated.');
    }

    public function destroy(Profile $profile)
    {
        $profile->delete();

        return Redirect::back()->with('success', 'Profile deleted.');
    }

    public function restore(Profile $profile)
    {
        $profile->restore();

        return Redirect::back()->with('success', 'Profile restored.');
    }
}
