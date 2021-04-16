<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ClientsController extends Controller
{
    public function index()
    {
        return Inertia::render('Clients/Index', [
            'filters' => Request::all('search', 'trashed'),
            'clients' => Auth::user()->account->clients()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($client) {
                    return [
                        'id' => $client->id,
                        'name' => $client->name,
                        'phone' => $client->phone,
                        'priority' => $client->priority,
                        'status' => $client->status,
                        'deleted_at' => $client->deleted_at,
                    ];
                }),
        ]);
    }

    public function create()
    {
        return Inertia::render('Clients/Create');
    }

    public function store()
    {
        Auth::user()->account->clients()->create(
            Request::validate([
                'name' => ['required', 'max:100'],
                'phone' => ['nullable', 'max:20'],
                'status' => ['nullable', 'max:4'],
                'priority' => ['nullable', 'max:4'],
            ])
        );

        return Redirect::route('clients')->with('success', 'Clients created.');
    }

    public function edit(Client $client)
    {
        return Inertia::render('Clients/Edit', [
            'client' => [
                'id' => $client->id,
                'name' => $client->name,
                'phone' => $client->phone,
                'status' => $client->status,
                'priority' => $client->priority,
                'deleted_at' => $client->deleted_at,
                //'contacts' => $client->contacts()->orderByName()->get()->map->only('id', 'name', 'city', 'phone'),
            ],
        ]);
    }

    public function update(Client $client)
    {
        $client->update(
            Request::validate([
                'name' => ['required', 'max:100'],
                'phone' => ['nullable', 'max:20'],
                'status' => ['nullable', 'max:4'],
                'priority' => ['nullable', 'max:4'],
            ])
        );

        return Redirect::back()->with('success', 'Client updated.');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return Redirect::back()->with('success', 'Client deleted.');
    }

    public function restore(Client $client)
    {
        $client->restore();

        return Redirect::back()->with('success', 'Client restored.');
    }
}
