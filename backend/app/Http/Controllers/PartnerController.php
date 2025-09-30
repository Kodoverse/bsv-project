<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PartnerController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->isPartner()) {
            return response()->json(['message' => 'Only partners can view sales stats'], 403);
        }

        $partnerId = Auth::id();

        $stats = [
            'total_products' => Product::forPartner($partnerId)->count(),
            'active_products' => Product::forPartner($partnerId)->where('is_available', true)->count(),
            'total_sales' => Purchase::forPartner($partnerId)->completed()->count(),
            'pending_orders' => Purchase::forPartner($partnerId)->pending()->count(),
            'total_points_earned' => Purchase::forPartner($partnerId)->completed()->sum('points_spent'),
            'recent_sales' => Purchase::with(['user', 'product'])
                ->forPartner($partnerId)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
        ];

        return view('partner.dashboard', compact('stats'));
    }
}