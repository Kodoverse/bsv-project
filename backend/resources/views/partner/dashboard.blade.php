 <?php
$tabs = [
    [
        'id' => 'overview',
        'name' => 'Overview',
        'route' => route('partner.dashboard'),
        'icon' => '<svg fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/></svg>',
    ],
    [
        'id' => 'products',
        'name' => 'Products',
        'route' => route('partner.products'),
        'icon' => '<svg fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5"><path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v11a3 3 0 106 0V4a2 2 0 00-2-2H4zM3 15a1 1 0 011-1h1a1 1 0 011 1v1a1 1 0 01-1 1H4a1 1 0 01-1-1v-1zm7-13a1 1 0 011-1h3a1 1 0 011 1v8a1 1 0 01-1 1h-3a1 1 0 01-1-1V2zm2 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>',
    ],
    [
        'id' => 'sales',
        'name' => 'Sales',
        'route' => route('partner.sales'),
        'icon' => '<svg fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/></svg>',
    ],
    [
        'id' => 'redemptions',
        'name' => 'Redemptions',
        'route' => route('partner.redemptions'),
        'icon' => '<svg fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5"><path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/></svg>',
    ],
    [
        'id' => 'profile',
        'name' => 'Profile',
        'route' => route('partner.profile'),
        'icon' => '<svg fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>',
    ],
];

$activeTab = $activeTab ?? 'overview'; // variabile passata dal controller
?>

@extends('layouts.mystyle')

@section('content')
    <div class="min-h-screen bg-gray-900 text-white">

        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-900 via-purple-800 to-purple-900 border-b border-purple-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex justify-between items-center">
                <div>
                    <h1
                        class="text-3xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">
                        Partner Dashboard
                    </h1>
                    <p class="text-purple-300 mt-2">Manage your products and point redemptions</p>
                </div>
                <div class="text-right">
                    <p class="text-purple-300 text-sm">Partner Business</p>
                    <p class="text-xl font-semibold text-white">
                        {{ auth()->user()->partnerInfo->business_name ?? 'Your Business' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Overview -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">

            <div class="max-w-7xl mx-auto sm: lg: py-6">
                <div class="flex space-x-1 bg-gray-800 rounded-xl p-1">
                    @foreach($tabs as $tab)
                        <a href="{{ $tab['route'] }}"
                            class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 flex items-center gap-2
                              {{ $activeTab === $tab['id'] ? 'bg-gradient-to-r from-purple-500 to-pink-500 text-white shadow-lg' : 'bg-transparent text-gray-300 hover:bg-gray-700/50 hover:text-white' }}">
                            {!! $tab['icon'] !!}
                            {{ $tab['name'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl p-6">
                    <p class="text-gray-400 text-sm font-medium">Total Products</p>
                    <p class="text-3xl font-bold">{{ $stats['total_products'] }}</p>
                </div>
                <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl p-6">
                    <p class="text-gray-400 text-sm font-medium">Active Products</p>
                    <p class="text-3xl font-bold">{{ $stats['active_products'] }}</p>
                </div>
                <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl p-6">
                    <p class="text-gray-400 text-sm font-medium">Total Sales</p>
                    <p class="text-3xl font-bold">{{ $stats['total_sales'] }}</p>
                </div>
                <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl p-6">
                    <p class="text-gray-400 text-sm font-medium">Pending Orders</p>
                    <p class="text-3xl font-bold">{{ $stats['pending_orders'] }}</p>
                </div>
            </div>

            <!-- Recent Sales -->
            @if(!empty($recentSales))
                <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl p-6">
                    <h3 class="text-xl font-semibold mb-4">Recent Sales</h3>
                    <div class="space-y-3">
                        @foreach($recentSales as $sale)
                            <div class="flex items-center justify-between p-4 bg-gray-700/50 rounded-lg">
                                <div>
                                    <p class="text-white font-medium">{{ $sale['product']['name'] }}</p>
                                    <p class="text-gray-400 text-sm">{{ $sale['user']['name'] }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-purple-400 font-semibold">{{ $sale['points_spent'] }} pts</p>
                                    <p class="text-gray-500 text-xs">
                                        {{ \Carbon\Carbon::parse($sale['created_at'])->format('M d, H:i') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection