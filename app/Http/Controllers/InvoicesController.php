<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Contact;
use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InvoicesController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::query();

        if ($request->has('search') && $search = $request->input('search')) {
            $query->where('number', 'like', "%{$search}%");
        }

        $invoices = $query->paginate(10);

        $invoices->appends(['search' => $request->input('search')]);

        return Inertia::render('Invoices/Index', [
            'invoices' => $invoices,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Invoices/Create', [
            'organizations' => Auth::user()->account->organizations()
                ->get()
                ->map
                ->only('id', 'name'),
            'products' => Product::all(['id', 'name', 'price']),
        ]);
    }

    public function getContacts($organizationId)
    {
        $contacts = Contact::where('organization_id', $organizationId)->get(['id', 'first_name', 'last_name', 'phone', 'email']);
        Log::info($contacts);
        return response()->json($contacts);
    }

    public function store(Request $request)
    {
        $invoice = Invoice::create([
            'number' => $request->number,
            'amount' => $request->amount,
            'organization_id' => $request->organization_id,
            'contact_id' => $request->contact_id,
        ]);

        return redirect()->route('invoices')->with('success', 'Invoice created.');
    }
}
