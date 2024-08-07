<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ReportsController extends Controller
{
    public function index(): Response
    {
        $organizations = Auth::user()->account->organizations()
            ->orderBy('name')
            ->paginate(9)
            ->withQueryString()
            ->through(function ($organization) {
                $contact = $organization->contacts()->first();
                $ownerName = $contact
                    ? ($contact->first_name . ' ' . $contact->last_name)
                    : "N/A";

                return [
                    'id' => $organization->id,
                    'name' => implode(' ', array_slice(explode(' ', $organization->name), 0, 2)),
                    'phone' => $organization->phone,
                    'city' => $organization->city,
                    'deleted_at' => $organization->deleted_at,
                    'owner' => $ownerName,
                ];
            });

        return Inertia::render('Reports/Index', [
            'organizations' => $organizations,
        ]);
    }
}
