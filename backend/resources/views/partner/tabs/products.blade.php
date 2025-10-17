<div x-data="productHandler()" x-init="fetchFilteredProducts()" class="space-y-6">
    <!-- Header with Create Button -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-white">Gestione dei prodotti</h2>
            <p class="text-gray-400">Qui puoi creare e gestire i tuoi prodotti</p>
        </div>
        <a href="{{ route('partner.products.create') }}"
            class="px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-xl font-semibold hover:from-purple-600 hover:to-pink-600 transition-all duration-300 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Nuovo Prodotto
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-gray-800 rounded-xl p-4 flex flex-wrap gap-4 items-center" x-data>
        <!-- 🔍 Search -->
        <input type="text" x-model="search" @input.debounce.300ms="fetchFilteredProducts()"
            placeholder="Cerca per nome..." class="flex-1 min-w-64 px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white 
               focus:ring-2 focus:ring-purple-500 focus:border-transparent">

        <!-- 🏷️ Category Filter -->
        <select x-model="selectedCategory" @change="fetchFilteredProducts()" class="px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white 
               focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            <option value="">Tutte le categorie</option>
            <template x-for="category in categories" :key="category.id">
                <option :value="category.id" x-text="category.name"></option>
            </template>
        </select>

        <!-- ⚙️ Status Filter -->
        <select x-model="selectedAvailability" @change="fetchFilteredProducts()" class="px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white 
               focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            <option value="">Tutti</option>
            <option value="available">Disponibile</option>
            <option value="unavailable">Non disponibile</option>
        </select>
    </div>

    <!-- Products Grid -->
    <div id="cardProduct" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <template x-for="product in products" :key="product.id">


            <div
                class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl overflow-hidden hover:scale-105 transition-transform duration-300">
                <!-- Product Image -->
                <div class="h-48 bg-gray-700 relative overflow-hidden">
                    <template x-if="product.image">
                        <img :src="product.image" :alt="product.name" class="w-full h-full object-contain">
                    </template>
                    <template x-if="!product.image">
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </template>

                    <!-- Status Badge -->
                    <div class="absolute top-3 left-3">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold "
                            x-text="product.is_available ? 'Disponibile' : 'Non disponibile'" :class="product.is_available 
                            ? 'bg-green-600 text-white' 
                            : 'bg-red-600 text-white'">
                    </div>

                    <!-- Stock Badge -->
                    <div class="absolute top-3 right-3">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold border"
                            x-text="product.stock_quantity > 0 ? 'In stock' : 'Out of stock'"
                            :class="product.stock_quantity > 0 ? 'border-green-500 text-green-400' : 'border-red-500 text-red-400'">
                        </span>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="p-6">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="text-lg font-semibold text-white line-clamp-2" x-text="product.name"></h3>
                        <span class="text-purple-400 font-bold text-lg ml-2"
                            x-text="product.points_price + 'pts'"></span>
                    </div>

                    <p class="text-gray-400 text-sm mb-4 line-clamp-2" x-text="product.description"></p>

                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm text-gray-500 bg-gray-700/50 px-2 py-1 rounded-full capitalize"
                            x-text="product.category">

                        </span>
                        <template x-if="product.cash_equivalent">
                            <span class="text-xs text-gray-500" x-text="'~$' + product.cash_equivalent"></span>
                        </template>
                    </div>

                    <!-- Action Buttons -->

                    <!-- EDIT -->
                    <div class="flex gap-2">
                        <a :href="`/partner/products/${product.id}/edit`"
                            class="flex-1 px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition-colors text-sm">Edit</a>

                        <!-- DISABLE -->
                        <button @click="toggleAvailability(product.id)" type="button"
                            class="flex-1 px-3 py-1 rounded text-white text-sm transition-colors " :class="product.is_available 
                            ? 'bg-red-600 hover:bg-red-700' 
                            : 'bg-green-600 hover:bg-green-700'"
                            x-text="product.is_available ? 'Non disponibile' : 'Disponibile'">
                        </button>

                        <button type="button" @click="deleteProduct(product.id)"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>