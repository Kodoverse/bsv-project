<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Point;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Get user's purchase history or partner's sales
     */
    public function index(Request $request): JsonResponse
    {
        $query = Purchase::with(['product', 'user', 'partner']);

        // If partner is viewing, show their sales, otherwise show user's purchases
        if ($request->has('partner_view') && Auth::user()->isPartner()) {
            $query->forPartner(Auth::id());
        } else {
            $query->forUser(Auth::id());
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $purchases = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json($purchases);
    }

    /**
     * Create a purchase (User buys product with points)
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $product = Product::findOrFail($validated['product_id']);

        // Check if product is available
        if (!$product->canBePurchased()) {
            return response()->json(['message' => 'Product is not available for purchase'], 422);
        }

        // Check stock
        if ($product->stock_quantity !== -1 && $product->stock_quantity < $validated['quantity']) {
            return response()->json(['message' => 'Insufficient stock'], 422);
        }

        $totalPoints = $product->points_price * $validated['quantity'];

        // Check user's point balance
        $userBalance = Point::where('user_id', Auth::id())->sum('points');
        if ($userBalance < $totalPoints) {
            return response()->json(['message' => 'Insufficient points balance'], 422);
        }

        DB::beginTransaction();
        try {
            // Create purchase
            $purchase = Purchase::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'partner_id' => $product->partner_id,
                'quantity' => $validated['quantity'],
                'points_spent' => $totalPoints,
                'points_per_item' => $product->points_price,
                'status' => 'pending'
            ]);

            // Deduct points
            Point::create([
                'user_id' => Auth::id(),
                'points' => -$totalPoints,
                'reason' => "Purchase: {$product->name} (x{$validated['quantity']})",
                'type' => 'redemption',
                'partner_id' => $product->partner_id,
                'redemption_reference' => $purchase->redemption_code,
                'awarded_by' => $product->partner_id
            ]);

            // Decrease stock
            $product->decreaseStock($validated['quantity']);

            DB::commit();

            $purchase->load(['product', 'partner']);
            return response()->json($purchase, 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to create purchase'], 500);
        }
    }

    /**
     * Show a specific purchase
     */
    public function show(Purchase $purchase): JsonResponse
    {
        // Check authorization
        if ($purchase->user_id !== Auth::id() && 
            (!Auth::user()->isPartner() || $purchase->partner_id !== Auth::id())) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $purchase->load(['product', 'user', 'partner']);
        return response()->json($purchase);
    }

    /**
     * Confirm a purchase (Partner only)
     */
    public function confirm(Request $request, Purchase $purchase): JsonResponse
    {
        if (!Auth::user()->isPartner() || $purchase->partner_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if (!$purchase->isPending()) {
            return response()->json(['message' => 'Purchase cannot be confirmed'], 422);
        }

        $validated = $request->validate([
            'notes' => 'nullable|string|max:500'
        ]);

        $purchase->confirm();
        if (isset($validated['notes'])) {
            $purchase->update(['notes' => $validated['notes']]);
        }

        $purchase->load(['product', 'user']);
        return response()->json($purchase);
    }

    /**
     * Complete a purchase (Partner only)
     */
    public function complete(Request $request, Purchase $purchase): JsonResponse
    {
        if (!Auth::user()->isPartner() || $purchase->partner_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if (!$purchase->isConfirmed()) {
            return response()->json(['message' => 'Purchase must be confirmed before completion'], 422);
        }

        $validated = $request->validate([
            'notes' => 'nullable|string|max:500'
        ]);

        $purchase->complete();
        if (isset($validated['notes'])) {
            $purchase->update(['notes' => $validated['notes']]);
        }

        $purchase->load(['product', 'user']);
        return response()->json($purchase);
    }

    /**
     * Cancel a purchase
     */
    public function cancel(Request $request, Purchase $purchase): JsonResponse
    {
        // User can cancel their own pending purchases, partners can cancel any of their sales
        $canCancel = ($purchase->user_id === Auth::id() && $purchase->isPending()) ||
                     (Auth::user()->isPartner() && $purchase->partner_id === Auth::id() && !$purchase->isCompleted());

        if (!$canCancel) {
            return response()->json(['message' => 'Cannot cancel this purchase'], 403);
        }

        $validated = $request->validate([
            'reason' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();
        try {
            // Refund points
            Point::create([
                'user_id' => $purchase->user_id,
                'points' => $purchase->points_spent,
                'reason' => "Refund: {$purchase->product->name} (cancelled)",
                'type' => 'award',
                'partner_id' => $purchase->partner_id,
                'redemption_reference' => $purchase->redemption_code . '_REFUND',
                'awarded_by' => Auth::id()
            ]);

            // Cancel purchase
            $purchase->cancel();
            if (isset($validated['reason'])) {
                $purchase->update(['notes' => $validated['reason']]);
            }

            DB::commit();

            $purchase->load(['product', 'user', 'partner']);
            return response()->json($purchase);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Failed to cancel purchase'], 500);
        }
    }

    /**
     * Verify a redemption code (Partner only)
     */
    public function verify(Request $request): JsonResponse
    {
        if (!Auth::user()->isPartner()) {
            return response()->json(['message' => 'Only partners can verify redemption codes'], 403);
        }

        $validated = $request->validate([
            'redemption_code' => 'required|string'
        ]);

        $purchase = Purchase::with(['product', 'user'])
            ->where('redemption_code', $validated['redemption_code'])
            ->forPartner(Auth::id())
            ->first();

        if (!$purchase) {
            return response()->json(['message' => 'Invalid redemption code'], 404);
        }

        return response()->json([
            'purchase' => $purchase,
            'can_confirm' => $purchase->isPending(),
            'can_complete' => $purchase->isConfirmed()
        ]);
    }

    /**
     * Get purchase statistics for partner
     */
    public function partnerStats(Request $request): JsonResponse
    {
        if (!Auth::user()->isPartner()) {
            return response()->json(['message' => 'Only partners can view sales stats'], 403);
        }

        $partnerId = Auth::id();
        
        $stats = [
            'total_sales' => Purchase::forPartner($partnerId)->count(),
            'pending_orders' => Purchase::forPartner($partnerId)->pending()->count(),
            'confirmed_orders' => Purchase::forPartner($partnerId)->confirmed()->count(),
            'completed_orders' => Purchase::forPartner($partnerId)->completed()->count(),
            'cancelled_orders' => Purchase::forPartner($partnerId)->where('status', 'cancelled')->count(),
            'total_points_earned' => Purchase::forPartner($partnerId)->whereIn('status', ['confirmed', 'completed'])->sum('points_spent'),
            'today_sales' => Purchase::forPartner($partnerId)->whereDate('created_at', today())->count(),
            'this_month_sales' => Purchase::forPartner($partnerId)->whereMonth('created_at', now()->month)->count()
        ];

        return response()->json($stats);
    }
}