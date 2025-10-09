<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user->isPartner()) {
            return response()->json(['message' => 'Accesso negato'], 403);
        }
        $products = Product::forPartner($user->id)->get();
        //dd($products);
        return view('partner.tabs.products', compact('products', 'user'));

    }

    public function create()
    {
        $products = Product::all();
        return view('products.create');
    }

    public function store(StoreProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        $validated['user_id'] = Auth::id();

        if ($request->hasFile('image_url')) {
            $image_url = $request->file('image_url')->store('product', 'public');
            $validated['image_url'] = $image_url;
        }

        $product->create($validated);
        return redirect()
            ->route('partner.dashboard')
            ->with('success', 'Prodotto creato con successo!');


    }

    //funzioni per modificare, disabilitare ed eliminare prodotti
    public function edit(UpdateProductRequest $request, Product $product)
    {
        $product = $request->validated();
        if ($request->hasFile('image_url')) {
            $image_url = $request->file('image_url')->store('public/img-apart-bnb');
            $validatedData['image_url'] = str_replace('public/', '', $image_url);
            $product->image_cover = $validatedData['image_url'];
        }
    }
}