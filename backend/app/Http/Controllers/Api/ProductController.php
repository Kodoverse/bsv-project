<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Get all available products or partner's products
     */
    public function index(Request $request): JsonResponse
    {
        // Debug logging
        \Log::info('ProductController@index called', [
            'user_id' => Auth::id(),
            'user_role' => Auth::user()?->user_role,
            'is_partner' => Auth::user()?->isPartner(),
            'has_my_products' => $request->has('my_products'),
            'request_params' => $request->all()
        ]);

        // If partner is viewing, show their products, otherwise show all available
        if ($request->has('my_products') && Auth::user()->isPartner()) {
            // Simplified approach - just get the products directly
            $products = Product::where('partner_id', Auth::id())
                              ->with(['partner.partnerInfo'])
                              ->orderBy('created_at', 'desc')
                              ->paginate(12);
            \Log::info('Filtering for partner products', ['partner_id' => Auth::id()]);
        } else {
            $query = Product::where('is_available', true)
                            ->where(function($q) {
                                $q->where('stock_quantity', '>', 0)
                                  ->orWhere('stock_quantity', -1);
                            });
            \Log::info('Filtering for available products');
            
            // Filter by category
            if ($request->has('category') && !empty($request->category)) {
                $query->where('category', $request->category);
            }

            // Filter by partner
            if ($request->has('partner_id') && !empty($request->partner_id)) {
                $query->where('partner_id', $request->partner_id);
            }

            // Search
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }

            $products = $query->with(['partner.partnerInfo'])
                             ->orderBy('created_at', 'desc')
                             ->paginate(12);
        }

        // Additional debugging
        $allProducts = Product::all(['id', 'name', 'partner_id']);
        $partnerProducts = Product::where('partner_id', Auth::id())->get(['id', 'name', 'partner_id']);
        
        \Log::info('Query results', [
            'total_products' => $products->total(),
            'products_on_page' => $products->count(),
            'products' => $products->pluck('name', 'id')->toArray(),
            'all_products_in_db' => $allProducts->toArray(),
            'partner_products_direct' => $partnerProducts->toArray(),
            'auth_id' => Auth::id()
        ]);

        // Transform products to include full image URLs
        $products->getCollection()->transform(function ($product) {
            if ($product->image_url) {
                $product->image_url = $this->getFullImageUrl($product->image_url);
            }
            return $product;
        });

        return response()->json($products);
    }

    /**
     * Store a new product (Partner only)
     */
    public function store(Request $request): JsonResponse
    {
        \Log::info('Product store method called', [
            'user_id' => Auth::id(),
            'user_role' => Auth::user()?->user_role,
            'is_partner' => Auth::user()?->isPartner(),
            'request_data' => $request->all()
        ]);

        if (!Auth::user()->isPartner()) {
            \Log::warning('Non-partner user tried to create product', [
                'user_id' => Auth::id(),
                'user_role' => Auth::user()?->user_role
            ]);
            return response()->json(['message' => 'Only partners can create products'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'points_price' => 'required|integer|min:1',
            'cash_equivalent' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:-1', // -1 for unlimited
            'category' => 'required|in:food,beverage,merchandise,service,discount,other',
            'metadata' => 'nullable|json'
        ]);

        $validated['partner_id'] = Auth::id();

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('products', $imageName, 'public');
            $validated['image_url'] = '/storage/' . $imagePath;
        }

        $product = Product::create($validated);
        $product->load(['partner.partnerInfo']);

        \Log::info('Product created successfully', [
            'product_id' => $product->id,
            'product_name' => $product->name,
            'partner_id' => $product->partner_id
        ]);

        // Transform image URL
        if ($product->image_url) {
            $product->image_url = $this->getFullImageUrl($product->image_url);
        }

        return response()->json($product, 201);
    }

    /**
     * Show a specific product
     */
    public function show(Product $product): JsonResponse
    {
        $product->load(['partner.partnerInfo']);

        // Transform image URL
        if ($product->image_url) {
            $product->image_url = $this->getFullImageUrl($product->image_url);
        }

        return response()->json($product);
    }

    /**
     * Update a product (Partner only - own products)
     */
    public function update(Request $request, Product $product): JsonResponse
    {
        if (!Auth::user()->isPartner() || $product->partner_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'points_price' => 'sometimes|required|integer|min:1',
            'cash_equivalent' => 'nullable|numeric|min:0',
            'stock_quantity' => 'sometimes|required|integer|min:-1',
            'is_available' => 'sometimes|boolean',
            'category' => 'sometimes|required|in:food,beverage,merchandise,service,discount,other',
            'metadata' => 'nullable|json'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image_url) {
                $oldImagePath = str_replace('/storage/', '', $product->image_url);
                Storage::disk('public')->delete($oldImagePath);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('products', $imageName, 'public');
            $validated['image_url'] = '/storage/' . $imagePath;
        }

        $product->update($validated);
        $product->load(['partner.partnerInfo']);

        // Transform image URL
        if ($product->image_url) {
            $product->image_url = $this->getFullImageUrl($product->image_url);
        }

        return response()->json($product);
    }

    /**
     * Delete a product (Partner only - own products)
     */
    public function destroy(Product $product): JsonResponse
    {
        if (!Auth::user()->isPartner() || $product->partner_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Delete image if exists
        if ($product->image_url) {
            $imagePath = str_replace('/storage/', '', $product->image_url);
            Storage::disk('public')->delete($imagePath);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }

    /**
     * Get partner's sales statistics
     */
    

    /**
     * Get full image URL
     */
    private function getFullImageUrl($imageUrl)
    {
        if (!$imageUrl) {
            return null;
        }
        if (str_starts_with($imageUrl, 'http')) {
            return $imageUrl;
        }
        if (str_starts_with($imageUrl, '/storage')) {
            return url($imageUrl);
        }
        return url('/storage/' . $imageUrl);
    }
}