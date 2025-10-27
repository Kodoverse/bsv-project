<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\PartnerInfo;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user->isPartner()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }



        $categories = ProductCategory::all();
        // 📦 Query di base sui prodotti di quel business
        $productsQuery = Product::forPartner($user->id)
            ->with('category');



        if ($request->filled('search')) {
            $productsQuery->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('category_id')) {
            $productsQuery->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $productsQuery->where('is_available', $request->status === 'available' ? 1 : 0);
        }

        $products = $productsQuery->orderBy('created_at', 'desc')->get();

        // ✅ Ritorna JSON con tutti i dati necessari per Alpine
        return response()->json([
            'success' => true,
            'categories' => $categories,
            'products' => $products->map(fn($p) => [
                'id' => $p->id,
                'name' => $p->name,
                'description' => $p->description,
                'image' => $p->image_url ? Storage::url($p->image_url) : null,
                'points_price' => $p->points_price,
                'is_available' => (bool) $p->is_available,
                'stock_quantity' => $p->stock_quantity,
                'category' => $p->category->name ?? 'N/A',
                'cash_equivalent' => $p->cash_equivalent,
            ]),
        ]);
    }

    // la nostra index non c'è perchè abbiamo il file products.blade.php nelle tabs... quindi è gestito nel PartnerDashboardController

    public function create()
    {
        $user = Auth::user();

        $business = $user->business;
        $categories = ProductCategory::all();

        return view('products.create', [
            'business' => $business,
            'categories' => $categories,
        ]);

    }

    public function store(StoreProductRequest $request)
    {
        // Validazione
        $validated = $request->validated();

        // Trasforma la virgola in punto per i decimali
        if (isset($validated['cash_equivalent'])) {
            $validated['cash_equivalent'] = str_replace(',', '.', $validated['cash_equivalent']);
        }

        // Recupera il business del partner loggato
        $user = Auth::user();

        if (!$user->business || !$user->business->products) {
            return redirect()
                ->back()
                ->with('error', 'Nessuna attività associata al partner.');
        }

        $validated['business_id'] = $user->business->id;

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

    // funzioni per modificare, disabilitare ed eliminare prodotti
    public function edit(Product $product)
    {
        $categories = ProductCategory::all();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $user = Auth::user();

        if (!$user->isPartner()) {
            return response()->json(['message' => 'Accesso negato'], 403);
        }

        $validatedData = $request->validated();

        // Gestione immagine
        if ($request->hasFile('image_url')) {
            if ($product->image_url) {
                Storage::disk('public')->delete($product->image_url);
            }
            $image_url = $request->file('image_url')->store('product', 'public');
            $validatedData['image_url'] = $image_url;
        }

        // Aggiorna il prodotto
        $product->update($validatedData);

        return redirect()->route('partner.dashboard', ['tab' => 'products'])
            ->with('success', 'Prodotto aggiornato con successo!');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['success' => true]);
    }

    public function toggleAvailability(Product $product)
    {
        $product->is_available = !$product->is_available;
        $product->save();

        return response()->json([
            'success' => true,
            'is_available' => $product->is_available,
        ]);
    }
}
