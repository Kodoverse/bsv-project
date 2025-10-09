<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateArticleRequest;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PartnerDashboardController extends Controller
{
    public function PartnerDashboardStats(Request $request)
    {
        $user = Auth::user()->load('partnerInfo');

        if (!$user->isPartner()) {
            return response()->json(['message' => 'Accesso negato'], 403);
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

        $partnerId = $user->id;
        $statusFilter = $request->query('status'); // recupera ?status=pending ecc.


        $salesQuery = Purchase::forPartner($partnerId)
            ->with(['user:id,email', 'product:id,name'])
            ->orderByDesc('created_at');

        // Applica il filtro se selezionato
        if ($statusFilter) {
            $salesQuery->where('status', $statusFilter);
        }
        //questo recupera le ultime 5 vendite con i dati dell'utente che ha fatto l'acquisto
        $dashboardData = Purchase::with(['user.info', 'product'])
            ->forPartner($partnerId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();


        //variabile generica presente in tutta la dashboard
        $stats = [
            'total_products' => Product::forPartner($partnerId)->count(),
            'active_products' => Product::forPartner($partnerId)->where('is_available', true)->count(),
            'total_sales' => Purchase::forPartner($partnerId)->count(),
            'pending_orders' => Purchase::forPartner($partnerId)->pending()->count(),
            'total_points_earned' => $dashboardData->map(function ($purchase) {
                return [
                    'user_id' => $purchase->user_id,
                    'user_email' => $purchase->user->email ?? 'Utente sconosciuto',
                    'product_name' => $purchase->product->name ?? 'Prodotto eliminato',
                    'points_spent' => $purchase->points_spent,
                ];
            }),
            'recent_sales' => $salesQuery->paginate(10)->withQueryString(),
            'last_5_purchases' => $dashboardData,
            'status_count' => [
                'pending' => Purchase::forPartner($partnerId)->where('status', 'pending')->count(),
                'confirmed' => Purchase::forPartner($partnerId)->where('status', 'confirmed')->count(),
                'completed' => Purchase::forPartner($partnerId)->where('status', 'completed')->count(),
                'cancelled' => Purchase::forPartner($partnerId)->where('status', 'cancelled')->count(),
            ],
            'total_points_completed' => Purchase::forPartner($partnerId)
                ->completed()
                ->sum('points_spent'),

        ];


        $products = [];
        $categories = [];
        if ($activeTab === 'products') {
            $partnerId = $user->id;
            $products = Product::forPartner($partnerId)->with(['category'])->get();
            $categories = ProductCategory::get();

        };
        //dd($products);

        return view('partner.dashboard', compact(
            'user',
            'tabs',
            'activeTab',
            'userRole',
            'roleColorClass',
            'stats', // 👈 così overview riceve $stats
            'dashboardData',
            'products',
            'categories'
        ));
    }
}