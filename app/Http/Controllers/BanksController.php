<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class BanksController extends Controller
{
    public function index()
    {
        return Inertia::render('Banks/Index', [
            'filters' => Request::all('search', 'trashed'),
            'banks' => Auth::user()->account->banks()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($bank) {
                    return [
                        'id' => $bank->id,
                        'name' => $bank->name,
                        'phone' => $bank->phone,
                        'account_number' => $bank-> account_number,
                        'ifsc_code' => $bank -> ifsc_code,
                        'deleted_at' => $bank->deleted_at,
                    ];
                }),
        ]);
    }

    public function create()
    {
        return Inertia::render('Banks/Create');
    }

    public function store()
    {
        Auth::user()->account->banks()->create(
            Request::validate([
                'name' => ['required', 'max:100'],
                'email' => ['nullable', 'max:50', 'email'],
                'phone' => ['nullable', 'max:50'],
                'account_number' => ['max:100'],
                'ifsc_code' => ['nullable','max:100'],
                'address' => ['nullable', 'max:150'],
                'city' => ['nullable', 'max:50'],
                'region' => ['nullable', 'max:50'],
                'country' => ['nullable', 'max:2'],
                'postal_code' => ['nullable', 'max:25'],
            ])
        );

        return Redirect::route('banks')->with('success', 'Banks created.');
    }

    public function edit(Bank $bank)
    {
        return Inertia::render('Banks/Edit', [
            'bank' => [
                'id' => $bank->id,
                'name' => $bank->name,
                'email' => $bank->email,
                'phone' => $bank->phone,
                'account_number' => $bank-> account_number,
                'ifsc_code' => $bank -> ifsc_code,
                'address' => $bank->address,
                'city' => $bank->city,
                'region' => $bank->region,
                'country' => $bank->country,
                'postal_code' => $bank->postal_code,
                'deleted_at' => $bank->deleted_at,
               // 'contacts' => $bank->contacts()->orderByName()->get()->map->only('id', 'name', 'city', 'phone'),
            ],
        ]);
    }

    public function update(Bank $bank)
    {
        $bank->update(
            Request::validate([
                'name' => ['required', 'max:100'],
                'email' => ['nullable', 'max:50', 'email'],
                'phone' => ['nullable', 'max:50'],
                'account_number' => ['max:100'],
                'ifsc_code' => ['nullable','max:100'],
                'address' => ['nullable', 'max:150'],
                'city' => ['nullable', 'max:50'],
                'region' => ['nullable', 'max:50'],
                'country' => ['nullable', 'max:2'],
                'postal_code' => ['nullable', 'max:25'],
            ])
        );

        return Redirect::back()->with('success', 'Bank updated.');
    }

    public function destroy(Bank $bank)
    {
        $bank->delete();

        return Redirect::back()->with('success', 'Bank deleted.');
    }

    public function restore(Bank $bank)
    {
        $bank->restore();

        return Redirect::back()->with('success', 'Bank restored.');
    }
}
