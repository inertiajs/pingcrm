<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;


class ProductsController extends Controller
{
    public function index(): Response
    {
        $products = Product::orderBy('name')
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($product) => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'quantity' => $product->quantity,
            ]);

        return Inertia::render('Products/Index', [
            'products' => $products,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Products/Create');
    }

    public function store(): RedirectResponse
    {
        Request::validate([
            'name' => ['required', 'max:50'],
            'description' => ['required', 'max:255'],
            'price' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
        ]);

        Product::create([
            'name' => Request::get('name'),
            'description' => Request::get('description'),
            'price' => Request::get('price'),
            'quantity' => Request::get('quantity'),
        ]);

        return Redirect::route('products')->with('success', 'Product created.');
    }
}
