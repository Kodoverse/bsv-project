<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PartnerInfo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PartnerController extends Controller
{
    // Note: Middleware is now handled in routes/api.php instead of constructor

    /**
     * Get list of partners
     */
    public function index(): JsonResponse
    {
        $partners = User::where('user_role', 'partner')
            ->with('partnerInfo')
            ->get();

        return response()->json($partners);
    }

    /**
     * Create a new partner
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'business_name' => 'required|string|max:255',
            'business_address' => 'nullable|string',
            'contact_phone' => 'nullable|string',
            'redemption_rules' => 'nullable|string',
            'min_points_per_redemption' => 'nullable|integer|min:0',
            'max_points_per_redemption' => 'nullable|integer|gt:min_points_per_redemption'
        ]);

        DB::beginTransaction();

        try {
            // Create user with partner role
            $partner = User::create([
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'user_role' => 'partner'
            ]);

            // Create partner info
            $partnerInfo = $partner->partnerInfo()->create([
                'business_name' => $validated['business_name'],
                'business_address' => $validated['business_address'] ?? null,
                'contact_phone' => $validated['contact_phone'] ?? null,
                'redemption_rules' => $validated['redemption_rules'] ?? null,
                'min_points_per_redemption' => $validated['min_points_per_redemption'] ?? 0,
                'max_points_per_redemption' => $validated['max_points_per_redemption'] ?? null,
                'is_active' => true
            ]);

            DB::commit();

            return response()->json($partner->load('partnerInfo'), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Get a specific partner
     */
    public function show(User $partner): JsonResponse
    {
        if ($partner->user_role !== 'partner') {
            return response()->json(['message' => 'User is not a partner'], 404);
        }

        return response()->json($partner->load('partnerInfo'));
    }

    /**
     * Update a partner
     */
    public function update(Request $request, User $partner): JsonResponse
    {
        if ($partner->user_role !== 'partner') {
            return response()->json(['message' => 'User is not a partner'], 404);
        }

        $validated = $request->validate([
            'email' => 'required|email|unique:users,email,' . $partner->id,
            'password' => 'nullable|min:8',
            'business_name' => 'required|string|max:255',
            'business_address' => 'nullable|string',
            'contact_phone' => 'nullable|string',
            'redemption_rules' => 'nullable|string',
            'min_points_per_redemption' => 'nullable|integer|min:0',
            'max_points_per_redemption' => 'nullable|integer|gt:min_points_per_redemption',
            'is_active' => 'boolean'
        ]);

        DB::beginTransaction();

        try {
            // Update user
            $partner->email = $validated['email'];
            if (isset($validated['password'])) {
                $partner->password = Hash::make($validated['password']);
            }
            $partner->save();

            // Update partner info
            $partner->partnerInfo->update([
                'business_name' => $validated['business_name'],
                'business_address' => $validated['business_address'] ?? null,
                'contact_phone' => $validated['contact_phone'] ?? null,
                'redemption_rules' => $validated['redemption_rules'] ?? null,
                'min_points_per_redemption' => $validated['min_points_per_redemption'] ?? 0,
                'max_points_per_redemption' => $validated['max_points_per_redemption'] ?? null,
                'is_active' => $validated['is_active'] ?? true
            ]);

            DB::commit();

            return response()->json($partner->load('partnerInfo'));
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete a partner
     */
    public function destroy(User $partner): JsonResponse
    {
        if ($partner->user_role !== 'partner') {
            return response()->json(['message' => 'User is not a partner'], 404);
        }

        // Check if partner has any point transactions
        $hasTransactions = $partner->awardedPoints()->exists();
        if ($hasTransactions) {
            return response()->json([
                'message' => 'Cannot delete partner with existing point transactions'
            ], 422);
        }

        DB::beginTransaction();

        try {
            $partner->partnerInfo()->delete();
            $partner->delete();

            DB::commit();

            return response()->json(null, 204);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
