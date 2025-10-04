
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

    <div class="bg-gray-800 p-6 rounded-2xl">
        <h2 class="text-xl font-semibold mb-4">Recent Sales</h2>
        <ul>
            @foreach($stats['recent_sales'] as $sale)
                <li class="mb-2">
                    {{ $sale->product->name ?? 'Unknown Product' }} -
                    {{ $sale->points_spent }} pts
                    
                </li>
            @endforeach
        </ul>
    </div>
</div>
