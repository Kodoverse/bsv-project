<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PartnerInfo;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PartnerInfoController extends Controller
{
    /**
     * Get all businesses with optional filtering
     */
    public function index(Request $request): JsonResponse
    {
        $query = PartnerInfo::with(['user'])
                           ->where('is_active', true);

        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $query->where('business_category', $request->category);
        }

        // Search by business name
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('business_name', 'like', "%{$search}%")
                  ->orWhere('business_description', 'like', "%{$search}%");
            });
        }

        $businesses = $query->orderBy('business_name')
                           ->paginate(12);

        // Transform businesses to include full logo URLs and product count
        $businesses->getCollection()->transform(function ($business) {
            if ($business->business_logo) {
                $business->business_logo = $this->getFullImageUrl($business->business_logo);
            }
            
            // Add product count for this business
            $business->products_count = Product::where('partner_id', $business->user_id)
                                              ->where('is_available', true)
                                              ->count();
            
            return $business;
        });

        return response()->json($businesses);
    }

    /**
     * Get current partner's business info
     */
    public function show(): JsonResponse
    {
        $partnerInfo = PartnerInfo::where('user_id', Auth::id())->first();
        
        if (!$partnerInfo) {
            return response()->json(['message' => 'Partner info not found'], 404);
        }

        if ($partnerInfo->business_logo) {
            $partnerInfo->business_logo = $this->getFullImageUrl($partnerInfo->business_logo);
        }

        return response()->json($partnerInfo);
    }

    /**
     * Get specific business info by ID
     */
    public function showBusiness($id): JsonResponse
    {
        $business = PartnerInfo::with(['user'])
                              ->where('id', $id)
                              ->where('is_active', true)
                              ->first();

        if (!$business) {
            return response()->json(['message' => 'Business not found'], 404);
        }

        if ($business->business_logo) {
            $business->business_logo = $this->getFullImageUrl($business->business_logo);
        }

        // Add product count
        $business->products_count = Product::where('partner_id', $business->user_id)
                                          ->where('is_available', true)
                                          ->count();

        return response()->json($business);
    }

    /**
     * Create or update partner's business info
     */
    public function store(Request $request): JsonResponse
    {
        if (!Auth::user()->isPartner()) {
            return response()->json(['message' => 'Only partners can manage business info'], 403);
        }

        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'business_address' => 'nullable|string|max:500',
            'business_category' => 'required|in:cafe,restaurant,bar,supermarket,clothing,electronics,pharmacy,bookstore,sports,beauty,service,other',
            'business_description' => 'nullable|string|max:1000',
            'business_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'business_website' => 'nullable|url|max:255',
            'business_hours' => 'nullable|json',
            'business_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'redemption_rules' => 'nullable|string|max:1000',
            'min_points_per_redemption' => 'nullable|integer|min:0',
            'max_points_per_redemption' => 'nullable|integer|min:0',
        ]);

        $validated['user_id'] = Auth::id();

        // Handle logo upload
        if ($request->hasFile('business_logo')) {
            $logo = $request->file('business_logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logoPath = $logo->storeAs('business_logos', $logoName, 'public');
            $validated['business_logo'] = '/storage/' . $logoPath;
        }

        // Update or create partner info
        $partnerInfo = PartnerInfo::updateOrCreate(
            ['user_id' => Auth::id()],
            $validated
        );

        if ($partnerInfo->business_logo) {
            $partnerInfo->business_logo = $this->getFullImageUrl($partnerInfo->business_logo);
        }

        return response()->json($partnerInfo, 201);
    }

    /**
     * Get business categories
     */
    public function categories(): JsonResponse
    {
        $categories = [
            'cafe' => 'Café',
            'restaurant' => 'Restaurant',
            'bar' => 'Bar',
            'supermarket' => 'Supermarket',
            'clothing' => 'Clothing',
            'electronics' => 'Electronics',
            'pharmacy' => 'Pharmacy',
            'bookstore' => 'Bookstore',
            'sports' => 'Sports',
            'beauty' => 'Beauty',
            'service' => 'Service',
            'other' => 'Other'
        ];

        return response()->json($categories);
    }

    /**
     * Get full image URL
     */
    private function getFullImageUrl($imageUrl): string
    {
        if (str_starts_with($imageUrl, 'http')) {
            return $imageUrl;
        }
        
        return config('app.url') . $imageUrl;
    }
}