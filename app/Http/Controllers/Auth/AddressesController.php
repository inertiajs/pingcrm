<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class AddressesController extends Controller
{
    public function index()
    {
        return Inertia::render('Addresses/Index', [
            'filters' => Request::all('search', 'trashed'),
            'addresses' => Auth::user()->account->addresses()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($address) {
                    return [
                        'id' => $address->id,
                        'name' => $address->name,
                        'phone' => $address->phone,
                        'priority' => $address->priority,
                        'status' => $address->status,
                        'deleted_at' => $address->deleted_at,
                    ];
                }),
        ]);
    }

    public function create()
    {
        return Inertia::render('Addresses/Create');
    }

    public function store()
    {
        Auth::user()->account->addresses()->create(
            Request::validate([
                'name' => ['required', 'max:100'],
                'phone' => ['nullable', 'max:20'],
                'status' => ['nullable', 'max:4'],
                'priority' => ['nullable', 'max:4'],
            ])
        );

        return Redirect::route('clients')->with('success', 'Clients created.');
    }

    public function edit(Address $address)
    {
        return Inertia::render('Addresses/Edit', [
            'address' => [
                'id' => $address->id,
                'name' => $address->name,
                'phone' => $address->phone,
                'status' => $address->status,
                'priority' => $address->priority,
                'deleted_at' => $address->deleted_at,
                //'contacts' => $address->contacts()->orderByName()->get()->map->only('id', 'name', 'city', 'phone'),
            ],
        ]);
    }

    public function update(Address $address)
    {
        $address->update(
            Request::validate([
                'name' => ['required', 'max:100'],
                'phone' => ['nullable', 'max:20'],
                'status' => ['nullable', 'max:4'],
                'priority' => ['nullable', 'max:4'],
            ])
        );

        return Redirect::back()->with('success', 'Client updated.');
    }

    public function destroy(Address $address)
    {
        $address->delete();

        return Redirect::back()->with('success', 'Client deleted.');
    }

    public function restore(Address $address)
    {
        $address->restore();

        return Redirect::back()->with('success', 'Client restored.');
    }
}
