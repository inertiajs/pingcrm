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
                    'address_line1' =>$address -> address_line1,
                    'address_line2' =>$address -> address_line2,
                    
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
                'address line 1' => ['max:200'],
                'address line 2' => ['max:200'],
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
                'address_line1' =>$address -> address_line1,
                'address_line2' =>$address -> address_line2,
                
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
                'address line 1' => ['max:200'],
                'address line 2' => ['max:200'],
            ])
        );

        return Redirect::back()->with('success', 'Address updated.');
    }

    public function destroy(Address $address)
    {
        $address->delete();

        return Redirect::back()->with('success', 'Address deleted.');
    }

    public function restore(Address $address)
    {
        $address->restore();

        return Redirect::back()->with('success', 'Address restored.');
    }
}
