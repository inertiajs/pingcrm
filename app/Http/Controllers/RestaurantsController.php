<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class RestaurantsController extends Controller
{
    public function index()
    {
        return Inertia::render('restaurants/Index', [
            'filters' => Request::all('search', 'trashed'),
            'restaurants' => Auth::user()->account->restaurants()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($restaurant) {
                    return [
                        'id' => $restaurant->id,
                        'title' => $restaurant->title,
                        'description' => $restaurant->description,
                        'user_id' => $restaurant->user_id,
                        'restaurant_id' => $restaurant->restaurant_id,
                    ];
                }),
        ]);
    }

    public function create()
    {
        return Inertia::render('restaurants/Create');
    }

    public function store()
    {
        Auth::user()->account->restaurants()->create(
            Request::validate([
                'id' => ['nullable', 'max:50'],
                'title' => ['required', 'max:100'],
                'description' => ['nullable', 'max:300'],
                'user_id' => ['nullable', 'max:50'],
                'restaurant_id' => ['nullable', 'max:150'],
                
               
               
            ])
        );

        return Redirect::route('restaurants')->with('success', 'restaurants created.');
    }

    public function edit(restaurant $restaurant)
    {
        return Inertia::render('restaurants/Edit', [
            'restaurant' => [
                'id' => $restaurant->id,
                'title' => $restaurant->title,
                'description' => $restaurant->description,
                'user_id' => $restaurant->user_id,
                'restaurant_id' => $restaurant->restaurant_id,
                s()->orderByName()->get()->map->only('id', 'title', 'city', 'phone'),
            ],
        ]);
    }

    public function update(restaurant $restaurant)
    {
        $restaurant->update(
            Request::validate([
                'id' => ['nullable', 'max:50'],
                'title' => ['required', 'max:100'],
                'description' => ['nullable', 'max:300'],
                'user_id' => ['nullable', 'max:50'],
                'restaurant_id' => ['nullable', 'max:150'],
               
            ])
        );

        return Redirect::back()->with('success', 'restaurant updated.');
    }

    public function destroy(restaurant $restaurant)
    {
        $restaurant->delete();

        return Redirect::back()->with('success', 'restaurant deleted.');
    }

    public function restore(restaurant $restaurant)
    {
        $restaurant->restore();

        return Redirect::back()->with('success', 'restaurant restored.');
    }
}
