<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Inertia\Inertia;

class ReportsController extends Controller
{
    public function index()
    {
        return Inertia::render('Reports/Index', [
            'reports' => function() {
                return $this->reports();
            },
        ]);
    }

    public function show(string $reportDate)
    {
        [$year, $month] = explode('-', $reportDate);

        return Inertia::render('Reports/Index', [
            'reports' => function() {
                return $this->reports();
            },
            'report' => [
                'date' => $reportDate,
                'contacts' => Contact::latest()
                    ->with('organization')
                    ->whereYear('created_at', '=', $year)
                    ->whereMonth('created_at', '=', $month)
                    ->get()
                    ->transform(function ($contact) {
                        return [
                            'id' => $contact->id,
                            'name' => $contact->name,
                            'phone' => $contact->phone,
                            'city' => $contact->city,
                            'region' => $contact->region,
                            'deleted_at' => $contact->deleted_at,
                            'organization' => $contact->organization ? $contact->organization->only('name', 'id') : null,
                        ];
                    }),
            ],
        ]);
    }

    private function reports()
    {
        return Contact::latest()
            ->get()
            ->groupBy(function(Contact $contact) {
                return $contact->created_at->format('Y-m');
            });
    }
}
