<div class="space-y-6">
    <!-- Header with Create Button -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-white">Product Management</h2>
            <p class="text-gray-400">Create and manage your point-redemption products</p>
        </div>
        <a href="{{ route('products.create') }}" 
           class="px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-xl font-semibold hover:from-purple-600 hover:to-pink-600 transition-all duration-300 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Product
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-gray-800 rounded-xl p-4 flex flex-wrap gap-4 items-center">
        <form action="{{ route('products.index') }}" method="GET" class="flex flex-wrap gap-4 w-full">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Search products..."
                   class="flex-1 min-w-64 px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">

            <select name="category" class="px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <option value="">All Categories</option>
                <option value="food" {{ request('category') == 'food' ? 'selected' : '' }}>Food</option>
                <option value="beverage" {{ request('category') == 'beverage' ? 'selected' : '' }}>Beverage</option>
                <option value="merchandise" {{ request('category') == 'merchandise' ? 'selected' : '' }}>Merchandise</option>
                <option value="service" {{ request('category') == 'service' ? 'selected' : '' }}>Service</option>
                <option value="discount" {{ request('category') == 'discount' ? 'selected' : '' }}>Discount</option>
                <option value="other" {{ request('category') == 'other' ? 'selected' : '' }}>Other</option>
            </select>

            <select name="status" class="px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <option value="">All Status</option>
                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                <option value="unavailable" {{ request('status') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
            </select>

            <button type="submit" class="px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition-colors">Filter</button>
        </form>
    </div>

    <!-- Products Grid -->
    @if(isset($products) && $products->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($products as $product)
                <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl overflow-hidden hover:scale-105 transition-transform duration-300">
                    <!-- Product Image -->
                    <div class="h-48 bg-gray-700 relative overflow-hidden">
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        @endif

                        <!-- Status Badge -->
                        <div class="absolute top-3 left-3">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $product->is_available ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' }}">
                                {{ $product->is_available ? 'Available' : 'Unavailable' }}
                            </span>
                        </div>

                        <!-- Stock Badge -->
                        <div class="absolute top-3 right-3">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $product->stock_quantity > 0 ? 'border-green-500 text-green-400' : 'border-red-500 text-red-400' }}">
                                {{ $product->stock_quantity > 0 ? $product->stock_quantity . ' in stock' : ($product->stock_quantity == 0 ? 'Out of stock' : 'Unlimited') }}
                            </span>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-lg font-semibold text-white line-clamp-2">{{ $product->name }}</h3>
                            <span class="text-purple-400 font-bold text-lg ml-2">{{ $product->points_price }} pts</span>
                        </div>

                        <p class="text-gray-400 text-sm mb-4 line-clamp-2">{{ $product->description }}</p>

                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs text-gray-500 bg-gray-700/50 px-2 py-1 rounded-full capitalize">
                                {{ $product->category }}
                            </span>
                            @if($product->cash_equivalent)
                                <span class="text-xs text-gray-500">~${{ $product->cash_equivalent }}</span>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <a href="{{ route('products.edit', $product->id) }}" class="flex-1 px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition-colors text-sm">Edit</a>
                            
                            <form action="{{ route('products.toggleAvailability', $product->id) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 rounded-lg {{ $product->is_available ? 'bg-red-600 hover:bg-red-700 text-white' : 'bg-green-600 hover:bg-green-700 text-white' }}">
                                    {{ $product->is_available ? 'Disable' : 'Enable' }}
                                </button>
                            </form>

                            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <p class="text-gray-400 text-lg">No products found</p>
            <p class="text-gray-500 text-sm mt-2">Create your first product to start selling with points.</p>
            <a href="{{ route('products.create') }}" 
               class="mt-4 px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-xl font-semibold hover:from-purple-600 hover:to-pink-600 transition-all duration-300">
                Create Product
            </a>
        </div>
    @endif
</div>