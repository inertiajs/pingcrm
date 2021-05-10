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
        return Inertia::render('Restaurants/Index', [
            'filters' => Request::all('search', 'trashed'),
            'restaurants' => Auth::user()->account->restaurants()
                ->orderBy('id')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($restaurant) {
                    return [
                        'id' => $restaurant->id,
                        'title' => $restaurant->title,
                        'description' => $restaurant->description,
                        'custmer_name' => $restaurant->custmer_name,
                        'phone' => $restaurant->phone,
                        'custmer_order' => $restaurant->custmer_order,
                        'custmer_address' => $restaurant->custmer_address,
                        'restaurant_name' => $restaurant->restaurant_name,
                        'bill_no' => $restaurant->bill_no,
                        'feedback' => $restaurant->feedback,
                        'payment_method' =>  $restaurant->payment_method,
        

                    ];
                }),
        ]);
    }

    public function create()
    {
        return Inertia::render('Restaurants/Create');
    }

    public function store()
    {
        Auth::user()->account->restaurants()->create(
            Request::validate([
                'id' => ['nullable', 'max:50'],
                'title' => ['required', 'max:100'],
                'description' => ['nullable', 'max:300'],
                'custmer_name' => ['nullable', 'max:50'],
                'phone' => ['nullable', 'max:50'],
                'custmer_order' => ['nullable', 'max:100'],
                'custmer_address' => ['nullable', 'max:100'],
                'restaurant_name' => ['nullable', 'max:100'],
                'bill_no' => ['nullable', 'max:50'],
                'feedback' => ['nullable', 'max:50'],
                'payment_method' => ['nullable', 'max:50'],

               
               
            ])
        );

        return Redirect::route('restaurants')->with('success', 'Restaurants created.');
    }

    public function edit(Restaurant $restaurant)
    {
        return Inertia::render('Restaurants/Edit', [
            'restaurant' => [
                'id' => $restaurant->id,
                        'title' => $restaurant->title,
                        'description' => $restaurant->description,
                        'custmer_name' => $restaurant->custmer_name,
                        'phone' => $restaurant->phone,
                        'custmer_order' => $restaurant->custmer_order,
                        'custmer_address' => $restaurant->custmer_address,
                        'restaurant_name' => $restaurant->restaurant_name,
                        'bill_no' => $restaurant->bill_no,
                        'feedback' => $restaurant->feedback,
                        'payment_method' =>  $restaurant->payment_method,
            ],
        ]);
    }

    public function update(Restaurant $restaurant)
    {
        $restaurant->update(
            Request::validate([
                'id' => ['nullable', 'max:50'],
                'title' => ['required', 'max:100'],
                'description' => ['nullable', 'max:300'],
                'custmer_name' => ['nullable', 'max:50'],
                'phone' => ['nullable', 'max:50'],
                'custmer_order' => ['nullable', 'max:100'],
                'custmer_address' => ['nullable', 'max:100'],
                'restaurant_name' => ['nullable', 'max:100'],
                'bill_no' => ['nullable', 'max:50'],
                'feedback' => ['nullable', 'max:50'],
                'payment_method' => ['nullable', 'max:50'],
               
            ])
        );

        return Redirect::back()->with('success', 'Restaurant updated.');
    }

    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();

        return Redirect::back()->with('success', 'Restaurant deleted.');
    }

    public function restore(Restaurant $restaurant)
    {
        $restaurant->restore();

        return Redirect::back()->with('success', 'Restaurant restored.');
    }
}
