<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PartnerInfo;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminPartnerController extends Controller
{
    /**
     * Get all partners with their business information
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = User::where('user_role', 'partner')
                ->with(['partnerInfo', 'products'])
                ->withCount('products');

            // Search filter
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhereHas('partnerInfo', function($subQ) use ($search) {
                          $subQ->where('business_name', 'like', "%{$search}%")
                               ->orWhere('business_address', 'like', "%{$search}%");
                      });
                });
            }

            // Status filter
            if ($request->has('status') && !empty($request->status)) {
                if ($request->status === 'active') {
                    $query->whereHas('partnerInfo', function($q) {
                        $q->where('is_active', true);
                    });
                } elseif ($request->status === 'pending') {
                    $query->whereDoesntHave('partnerInfo');
                } elseif ($request->status === 'suspended') {
                    $query->whereHas('partnerInfo', function($q) {
                        $q->where('is_active', false);
                    });
                }
            }

            // Category filter
            if ($request->has('category') && !empty($request->category)) {
                $query->whereHas('partnerInfo', function($q) use ($request) {
                    $q->where('business_category', $request->category);
                });
            }

            $partners = $query->orderBy('created_at', 'desc')->paginate(15);

            return response()->json($partners);
        } catch (\Exception $e) {
            \Log::error('Error fetching partners: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch partners'], 500);
        }
    }

    /**
     * Get partner statistics
     */
    public function stats(): JsonResponse
    {
        try {
            $totalPartners = User::where('user_role', 'partner')->count();
            $activePartners = User::where('user_role', 'partner')
                ->whereHas('partnerInfo', function($q) {
                    $q->where('is_active', true);
                })->count();
            $pendingPartners = User::where('user_role', 'partner')
                ->whereDoesntHave('partnerInfo')
                ->count();
            $totalProducts = Product::count();

            return response()->json([
                'total_partners' => $totalPartners,
                'active_partners' => $activePartners,
                'pending_partners' => $pendingPartners,
                'total_products' => $totalProducts
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching partner stats: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch partner statistics'], 500);
        }
    }

    /**
     * Create a new partner
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'business_name' => 'required|string|max:255',
                'business_category' => 'required|string|in:cafe,restaurant,bar,supermarket,clothing,electronics,pharmacy,bookstore,sports,beauty,service,other',
                'business_address' => 'required|string',
                'business_description' => 'nullable|string',
                'contact_phone' => 'nullable|string|max:20',
                'business_email' => 'nullable|email',
                'is_active' => 'boolean'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Create user with partner role
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('password123'), // Default password
                'user_role' => 'partner',
                'email_verified_at' => now()
            ]);

            // Create partner info
            PartnerInfo::create([
                'user_id' => $user->id,
                'business_name' => $request->business_name,
                'business_category' => $request->business_category,
                'business_address' => $request->business_address,
                'business_description' => $request->business_description,
                'contact_phone' => $request->contact_phone,
                'business_email' => $request->business_email,
                'is_active' => $request->is_active ?? true,
                'redemption_rules' => 'Standard redemption rules apply.',
                'min_points_per_redemption' => 10,
                'max_points_per_redemption' => 1000
            ]);

            $user->load(['partnerInfo', 'products']);

            return response()->json([
                'message' => 'Partner created successfully',
                'partner' => $user
            ], 201);
        } catch (\Exception $e) {
            \Log::error('Error creating partner: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create partner'], 500);
        }
    }

    /**
     * Get specific partner details
     */
    public function show(User $partner): JsonResponse
    {
        try {
            if ($partner->user_role !== 'partner') {
                return response()->json(['error' => 'User is not a partner'], 404);
            }

            $partner->load(['partnerInfo', 'products']);

            return response()->json($partner);
        } catch (\Exception $e) {
            \Log::error('Error fetching partner: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch partner details'], 500);
        }
    }

    /**
     * Update partner information
     */
    public function update(Request $request, User $partner): JsonResponse
    {
        try {
            if ($partner->user_role !== 'partner') {
                return response()->json(['error' => 'User is not a partner'], 404);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|string|max:255',
                'email' => ['sometimes', 'email', Rule::unique('users', 'email')->ignore($partner->id)],
                'business_name' => 'sometimes|string|max:255',
                'business_category' => 'sometimes|string|in:cafe,restaurant,bar,supermarket,clothing,electronics,pharmacy,bookstore,sports,beauty,service,other',
                'business_address' => 'sometimes|string',
                'business_description' => 'nullable|string',
                'contact_phone' => 'nullable|string|max:20',
                'business_email' => 'nullable|email',
                'is_active' => 'sometimes|boolean'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Update user information
            $userData = $request->only(['name', 'email']);
            if (!empty($userData)) {
                $partner->update($userData);
            }

            // Update or create partner info
            $partnerInfoData = $request->only([
                'business_name', 'business_category', 'business_address',
                'business_description', 'contact_phone', 'business_email', 'is_active'
            ]);

            if (!empty($partnerInfoData)) {
                if ($partner->partnerInfo) {
                    $partner->partnerInfo->update($partnerInfoData);
                } else {
                    PartnerInfo::create(array_merge($partnerInfoData, [
                        'user_id' => $partner->id,
                        'redemption_rules' => 'Standard redemption rules apply.',
                        'min_points_per_redemption' => 10,
                        'max_points_per_redemption' => 1000
                    ]));
                }
            }

            $partner->load(['partnerInfo', 'products']);

            return response()->json([
                'message' => 'Partner updated successfully',
                'partner' => $partner
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating partner: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update partner'], 500);
        }
    }

    /**
     * Toggle partner active status
     */
    public function toggleStatus(User $partner): JsonResponse
    {
        try {
            if ($partner->user_role !== 'partner') {
                return response()->json(['error' => 'User is not a partner'], 404);
            }

            if (!$partner->partnerInfo) {
                return response()->json(['error' => 'Partner has no business information'], 400);
            }

            $partner->partnerInfo->update([
                'is_active' => !$partner->partnerInfo->is_active
            ]);

            return response()->json([
                'message' => 'Partner status updated successfully',
                'is_active' => $partner->partnerInfo->is_active
            ]);
        } catch (\Exception $e) {
            \Log::error('Error toggling partner status: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update partner status'], 500);
        }
    }

    /**
     * Delete partner
     */
    public function destroy(User $partner): JsonResponse
    {
        try {
            if ($partner->user_role !== 'partner') {
                return response()->json(['error' => 'User is not a partner'], 404);
            }

            // Delete related data
            $partner->partnerInfo?->delete();
            $partner->products()->delete();
            $partner->sales()->delete();
            
            // Delete user
            $partner->delete();

            return response()->json(['message' => 'Partner deleted successfully']);
        } catch (\Exception $e) {
            \Log::error('Error deleting partner: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete partner'], 500);
        }
    }
}