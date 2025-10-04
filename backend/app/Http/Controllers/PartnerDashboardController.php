<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PartnerDashboardController extends Controller
{
    public function PartnerDashboardStats(Request $request)
    {
        $user = Auth::user();

        if (!$user->isPartner()) {
            return response()->json(['message' => 'Only partners can view sales stats'], 403);
        }

        $tabs = [
            ['id' => 'overview', 'name' => 'Overview', 'url' => route('partner.dashboard', ['tab' => 'overview']), 'icon' => '<i class="icon-overview"></i>'],
            ['id' => 'products', 'name' => 'Products', 'url' => route('partner.dashboard', ['tab' => 'products']), 'icon' => '<i class="icon-events"></i>'],
            ['id' => 'sales', 'name' => 'Sales', 'url' => route('partner.dashboard', ['tab' => 'sales']), 'icon' => '<i class="icon-attendance"></i>'],
            ['id' => 'redemptions', 'name' => 'Redemptions', 'url' => route('partner.dashboard', ['tab' => 'redemptions']), 'icon' => '<i class="icon-categories"></i>'],
            ['id' => 'profile', 'name' => 'Profile', 'url' => route('partner.dashboard', ['tab' => 'profile']), 'icon' => '<i class="icon-users"></i>'],
        ];

        $activeTab = $request->query('tab', 'overview');
        $userRole = $user->user_role;
        $roleColorClass = $userRole === 'partner' ? 'text-red-400' : 'text-blue-400';

        // 👇 calcolo i dati SOLO se la tab è "overview"
        $stats = [];
        $dashboardData = [];
        if ($activeTab === 'overview') {
            $partnerId = $user->id;
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


            $dashboardData['recent_registrations'] = Purchase::with(['user.info', 'product'])
                ->forPartner($partnerId)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
                ->toArray();
        }
       // dd($dashboardData);

        return view('partner.dashboard', compact(
            'user',
            'tabs',
            'activeTab',
            'userRole',
            'roleColorClass',
            'stats', // 👈 così overview riceve $stats
            'dashboardData'
        ));
        


    }
}