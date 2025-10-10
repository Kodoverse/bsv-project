<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\ProductCategory;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Requests\Product\StoreProductRequest;
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

    public static function create()
    {
        $products = Product::all();
        $categories = ProductCategory::all();
        return view('products.create', compact('products', 'categories'));
    }

    public static function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        // Trasforma la virgola in punto per i decimali
        if (isset($validated['cash_equivalent'])) {
            $validated['cash_equivalent'] = str_replace(',', '.', $validated['cash_equivalent']);
        }

        // Assegna l'utente loggato come partner
        $validated['partner_id'] = Auth::id();

        // Gestione immagine
        if ($request->hasFile('image_url')) {
            $image_url = $request->file('image_url')->store('product', 'public');
            $validated['image_url'] = $image_url;
        }

        // Salva il prodotto
        Product::create($validated);
       // dd($validated);

        return redirect()
            ->route('partner.dashboard', ['tab' => 'products'])
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