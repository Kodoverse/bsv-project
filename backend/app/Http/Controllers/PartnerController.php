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
   
  

       public function PartnerDashboardStats(Request $request)
    {
        $user = Auth::user();
        $tabs = [
            ['id' => 'overview', 'name' => 'Overview', 'url' => route('partner.dashboard', ['tab' => 'overview']), 'icon' => '<i class="icon-overview"></i>'],
            ['id' => 'products', 'name' => 'Products', 'url' => route('partner.dashboard', ['tab' => 'products']), 'icon' => '<i class="icon-events"></i>'],
            ['id' => 'sales', 'name' => 'Sales', 'url' => route('partner.dashboard', ['tab' => 'sales']), 'icon' => '<i class="icon-attendance"></i>'],
            ['id' => 'redemptions', 'name' => 'Redemptions', 'url' => route('partner.dashboard', ['tab' => 'redemptions']), 'icon' => '<i class="icon-categories"></i>'],
            ['id' => 'profile', 'name' => 'Profile', 'url' => route('partner.dashboard', ['tab' => 'profile']), 'icon' => '<i class="icon-users"></i>'],
        ];

        $activeTab = $request->query('tab', 'overview');     


        $userRole = $user->user_role;

        // Classe colore per il ruolo (opzionale)
        $roleColorClass = $userRole === 'partner' ? 'text-red-400' : 'text-blue-400';

        return view('partner.dashboard', compact(
            'user',
            'tabs',
            'activeTab',
            'userRole',
            'roleColorClass'
        ));
    }
}