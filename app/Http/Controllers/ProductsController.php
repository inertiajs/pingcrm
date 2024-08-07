<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;


class ProductsController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Product::query();

        if ($request->has('search') && $search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $products = $query->paginate(10);

        // Manually add query string to pagination links
        $products->appends(['search' => $request->input('search')]);

        return Inertia::render('Products/Index', [
            'products' => $products,
        ]);
    }


    public function create(): Response
    {
        return Inertia::render('Products/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validateData = $request->validate([
            'name' => ['required', 'max:50'],
            'description' => ['required', 'max:255'],
            'price' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
        ]);

        Product::create($validateData);

        return Redirect::route('products')->with('success', 'Product created.');
    }

    public function edit(Product $product): Response
    {
        return Inertia::render('Products/Edit', [
            'product' => $product,
        ]);
    }

    public function update(Product $product): RedirectResponse
    {
        $validateData = request()->validate([
            'name' => ['required', 'max:50'],
            'description' => ['required', 'max:255'],
            'price' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
        ]);

        $product->update($validateData);

        return Redirect::back()->with('success', 'Product updated.');
    }
}
