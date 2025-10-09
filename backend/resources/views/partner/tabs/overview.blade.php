<div class="min-h-screen bg-gray-900 text-white p-8">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-gray-800 p-6 rounded-2xl">
            <p class="text-gray-400">Total Products</p>
            <p class="text-3xl font-bold">{{ $stats['total_products'] }}</p>
        </div>

        <div class="bg-gray-800 p-6 rounded-2xl">
            <p class="text-gray-400">Active Products</p>
            <p class="text-3xl font-bold">{{ $stats['active_products'] }}</p>
        </div>

        <div class="bg-gray-800 p-6 rounded-2xl">
            <p class="text-gray-400">Total Sales</p>
            <p class="text-3xl font-bold">{{ $stats['total_sales'] }}</p>
        </div>

        <div class="bg-gray-800 p-6 rounded-2xl">
            <p class="text-gray-400">Pending Orders</p>
            <p class="text-3xl font-bold">{{ $stats['pending_orders'] }}</p>
        </div>
    </div>

    <div class="px-4 pb-12 sm:px-6 md:px-8 lg:px-12">
        @if (($activeTab ?? 'overview') === 'overview')
            <!-- Dashboard Stats -->
            @if ($loading ?? false)
                <div class="py-12 text-center">
                    <div
                        class="inline-block w-8 h-8 border-4 rounded-full border-orange-500/30 border-t-orange-500 animate-spin">
                    </div>
                    <p class="mt-4 text-gray-400">Loading dashboard...</p>
                </div>
            @else

                <!-- Recent Sales -->
                @if (!empty($stats['last_5_purchases']))
                    <div class="p-6 border border-gray-700 bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl">
                        <h3 class="flex items-center gap-2 mb-4 text-xl font-bold text-white">
                            <!-- Icon -->
                            <svg class="w-6 h-6 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                    clip-rule="evenodd" />
                            </svg>
                            Recent Sales
                        </h3>
                        <div class="space-y-3">
                            @foreach ($stats['last_5_purchases'] as $purchases)
                                <div class="flex items-center justify-between p-4 bg-gray-700/30 rounded-xl">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-r from-orange-400 to-red-400">
                                            <span class="text-sm font-bold text-white">
                                                {{ strtoupper(substr($purchases->user->info->firstname ?? $purchases->user->email, 0, 1)) }}
                                                {{ strtoupper(substr($purchases->user->info->lastname ?? '', 0, 1)) }}
                                            </span>
                                        </div>

                                        <div class="flex flex-col">
                                            <p class="font-semibold text-white">
                                                {{ $purchases->user->info->firstname ?? '' }}
                                                {{ $purchases->user->info->lastname ?? $purchases->user->email }}
                                            </p>
                                            <p class="text-sm text-gray-400">
                                                {{ $purchases->product->name ?? 'Prodotto eliminato' }}
                                            </p>
                                            <p class="text-sm text-gray-300">
                                                Punti spesi: {{ $purchases->points_spent }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="text-right">
                                        <p
                                            class="text-sm text-center font-medium px-2 py-1 rounded-lg border {{ $purchases->status_badge_class }}">
                                            {{ $purchases->formatted_status }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $purchases->created_at ? $purchases->created_at->format('M d, Y H:i') : '' }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
        @endif

        

    </div>
</div>