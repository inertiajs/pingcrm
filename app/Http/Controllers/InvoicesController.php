<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Contact;
use App\Models\InvoiceItem;
use App\Models\Organization;
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
                ->has('contacts')
                ->get()
                ->map
                ->only('id', 'name'),
            'products' => Product::all(['id', 'name', 'price', 'quantity']),
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
        $request->validate([
            'number' => 'required',
            'amount' => 'required',
            'organization_id' => 'required|exists:organizations,id',
            'contact_id' => 'required|exists:contacts,id',
            'added_products' => 'required|array',
            'added_products.*.id' => 'required|exists:products,id',
            'added_products.*.quantity' => 'required|integer|min:1',
        ]);

        $organization = Organization::findOrFail($request->organization_id);
        $contact = Contact::findOrFail($request->contact_id);

        $invoice = Invoice::create([
            'number' => $request->number,
            'amount' => $request->amount,
            'organization_id' => $request->organization_id,
            'contact_id' => $request->contact_id,
            'organization_name' => $organization->name,
            'contact_first_name' => $contact->first_name,
            'contact_last_name' => $contact->last_name,
        ]);

        foreach ($request->added_products as $productData) {
            $product = Product::findOrFail($productData['id']);
            $product->decrement('quantity', $productData['quantity0']);

            $item = InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $productData['quantity0'],
            ]);
        }

        return redirect()->route('invoices')->with('success', 'Invoice created successfully.');
    }

    public function view(Invoice $invoice): Response
    {
        $invoice = Invoice::with('items')->findOrFail($invoice->id);
        $contact = Contact::findOrFail($invoice->contact_id);
        Log::info($contact);
        return Inertia::render('Invoices/View', [
            'invoice' => $invoice,
            'contact' => $contact,
        ]);
    }
}
