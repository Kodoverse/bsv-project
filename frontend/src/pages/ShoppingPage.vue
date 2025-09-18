<template>
  <div class="min-h-screen bg-gray-900 text-white">
    <!-- Header -->
    <div class="bg-gradient-to-r from-orange-900 via-orange-800 to-orange-900 border-b border-orange-700">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center">
          <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-orange-400 to-yellow-400 bg-clip-text text-transparent">
              {{ currentBusiness ? currentBusiness.business_name : 'Partner Businesses' }}
            </h1>
            <p class="text-orange-300 mt-2">
              {{ currentBusiness 
                ? `Browse products from ${currentBusiness.business_name}` 
                : 'Discover local businesses and redeem your points' 
              }}
            </p>
          </div>
          <div v-if="store.isLoggedIn" class="text-right">
            <p class="text-orange-300 text-sm">Your Points</p>
            <p class="text-2xl font-semibold text-white">{{ userPoints || 0 }} pts</p>
          </div>
        </div>
        
        <!-- Navigation Buttons -->
        <div class="mt-6 flex flex-wrap gap-4 justify-center">
          <div v-if="currentBusiness">
            <button 
              @click="goBackToBusinesses"
              class="inline-flex items-center px-6 py-3 bg-gray-800/50 text-white rounded-lg hover:bg-gray-700/50 transition-colors"
            >
              <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
              </svg>
              Back to All Businesses
            </button>
          </div>
          
          <div v-if="store.isLoggedIn && !showPurchaseHistory && !currentBusiness">
            <button 
              @click="showPurchaseHistory = true"
              class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:from-purple-700 hover:to-blue-700 transition-colors"
            >
              <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              My Purchases
            </button>
          </div>
          
          <div v-if="showPurchaseHistory">
            <button 
              @click="closePurchaseHistory"
              class="inline-flex items-center px-6 py-3 bg-gray-800/50 text-white rounded-lg hover:bg-gray-700/50 transition-colors"
            >
              <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10.707 3.293a1 1 0 010 1.414L6.414 9H17a1 1 0 110 2H6.414l4.293 4.293a1 1 0 11-1.414 1.414l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 0z" clip-rule="evenodd"/>
              </svg>
              Back to Shop
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Purchase History View -->
      <div v-if="showPurchaseHistory">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
          <div>
            <h2 class="text-2xl font-bold text-white">My Purchase History</h2>
            <p class="text-gray-400">Track your orders and redemption codes</p>
          </div>
        </div>

        <!-- Purchase Filters -->
        <div class="bg-gray-800 rounded-xl p-4 mb-8">
          <div class="flex flex-wrap gap-4 items-center">
            <div>
              <select v-model="purchaseFilters.status" 
                      @change="fetchPurchaseHistory"
                      class="px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-orange-500">
                <option value="">All Orders</option>
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
              </select>
            </div>
            
            <div class="text-sm text-gray-400">
              Total: {{ purchaseHistory.length }} orders
            </div>
          </div>
        </div>

        <!-- Purchase History List -->
        <div v-if="purchaseHistoryLoading" class="flex justify-center py-12">
          <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-orange-500"></div>
        </div>

        <div v-else-if="purchaseHistory.length === 0" class="text-center py-12">
          <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
          </svg>
          <p class="text-xl text-gray-400">No purchases yet</p>
          <p class="text-gray-500">Start shopping to see your order history here</p>
        </div>

        <div v-else class="space-y-6">
          <div v-for="purchase in purchaseHistory" :key="purchase.id" 
               class="bg-gray-800 rounded-xl p-6 border border-gray-700">
            
            <!-- Purchase Header -->
            <div class="flex justify-between items-start mb-4">
              <div class="flex items-center space-x-4">
                <!-- Product Image -->
                <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-700 flex-shrink-0">
                  <img v-if="purchase.product?.image_url" 
                       :src="purchase.product.image_url" 
                       :alt="purchase.product.name"
                       class="w-full h-full object-cover">
                  <div v-else class="w-full h-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                    </svg>
                  </div>
                </div>
                
                <!-- Purchase Details -->
                <div>
                  <h3 class="text-lg font-semibold text-white">{{ purchase.product?.name || 'Product' }}</h3>
                  <p class="text-gray-400 text-sm">{{ purchase.partner?.name || 'Unknown Business' }}</p>
                  <div class="flex items-center space-x-4 mt-1 text-sm text-gray-500">
                    <span>Qty: {{ purchase.quantity }}</span>
                    <span>{{ purchase.points_spent }} points</span>
                    <span>{{ formatDate(purchase.created_at) }}</span>
                  </div>
                </div>
              </div>
              
              <!-- Status Badge -->
              <div>
                <span :class="[
                  'px-3 py-1 rounded-full text-sm font-semibold border',
                  getStatusBadgeClass(purchase.status)
                ]">
                  {{ formatStatus(purchase.status) }}
                </span>
              </div>
            </div>

            <!-- Redemption Code Section (Prominent Display) -->
            <div class="bg-gradient-to-r from-orange-900/20 to-yellow-900/20 border border-orange-500/30 rounded-xl p-4 mb-4">
              <div>
                <p class="text-orange-300 text-sm font-medium mb-1">Redemption Code</p>
                <div class="flex items-center space-x-3">
                  <code class="text-2xl font-mono font-bold text-white bg-gray-900/50 px-4 py-2 rounded-lg border border-gray-600">
                    {{ purchase.redemption_code }}
                  </code>
                  <button @click="copyToClipboard(purchase.redemption_code)" 
                          class="p-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors"
                          title="Copy to clipboard">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"/>
                      <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z"/>
                    </svg>
                  </button>
                </div>
              </div>
              
              <!-- Instructions -->
              <div class="mt-3 text-sm text-orange-200">
                <div v-if="purchase.status === 'pending'">
                  💡 <strong>Next step:</strong> Show this code to {{ purchase.partner?.name || 'the business' }} to redeem your order
                </div>
                <div v-else-if="purchase.status === 'confirmed'">
                  ✅ <strong>Order confirmed:</strong> Your order is being prepared
                </div>
                <div v-else-if="purchase.status === 'completed'">
                  🎉 <strong>Order completed:</strong> Thank you for your purchase!
                </div>
                <div v-else-if="purchase.status === 'cancelled'">
                  ❌ <strong>Order cancelled:</strong> Your points have been refunded
                </div>
              </div>
            </div>

            <!-- Order Timeline -->
            <div class="border-l-2 border-gray-600 pl-4 space-y-2 text-sm">
              <div class="flex items-center space-x-2 text-gray-400">
                <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>Order placed: {{ formatDateTime(purchase.created_at) }}</span>
              </div>
              
              <div v-if="purchase.confirmed_at" class="flex items-center space-x-2 text-gray-400">
                <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>Order confirmed: {{ formatDateTime(purchase.confirmed_at) }}</span>
              </div>
              
              <div v-if="purchase.completed_at" class="flex items-center space-x-2 text-gray-400">
                <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>Order completed: {{ formatDateTime(purchase.completed_at) }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Business View -->
      <div v-if="!currentBusiness && !showPurchaseHistory">
        <!-- Category Filter -->
        <div class="bg-gray-800 rounded-xl p-4 mb-8">
          <div class="flex flex-wrap gap-4 items-center">
            <div class="flex-1 min-w-64">
              <input v-model="businessFilters.search" 
                     @input="debouncedBusinessSearch"
                     type="text" 
                     placeholder="Search businesses..."
                     class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
            </div>
            
            <div>
              <select v-model="businessFilters.category" 
                      @change="fetchBusinesses"
                      class="px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-orange-500">
                <option value="">All Categories</option>
                <option v-for="(label, value) in categories" :key="value" :value="value">{{ label }}</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Businesses Grid -->
        <div v-if="loading" class="flex justify-center py-12">
          <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-orange-500"></div>
        </div>

        <div v-else-if="businesses.length === 0" class="text-center py-12">
          <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
          </svg>
          <p class="text-xl text-gray-400">No businesses found</p>
          <p class="text-gray-500">Try adjusting your search or category filter</p>
        </div>

        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div v-for="business in businesses" :key="business.id" 
               @click="viewBusiness(business)"
               class="bg-gray-800 rounded-xl p-6 border border-gray-700 hover:border-orange-500 transition-all duration-200 cursor-pointer group">
            
            <!-- Business Logo -->
            <div class="flex items-center space-x-4 mb-4">
              <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0">
                <img v-if="business.business_logo" 
                     :src="business.business_logo" 
                     :alt="business.business_name"
                     class="w-full h-full object-cover">
                <div v-else class="w-full h-full bg-gray-700 flex items-center justify-center">
                  <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                  </svg>
                </div>
              </div>
              
              <div class="flex-1">
                <h3 class="text-lg font-semibold text-white group-hover:text-orange-400 transition-colors">
                  {{ business.business_name }}
                </h3>
                <span class="inline-block px-3 py-1 bg-orange-600/20 text-orange-400 rounded-full text-sm font-medium capitalize mt-1">
                  {{ formatCategory(business.business_category) }}
                </span>
              </div>
            </div>

            <!-- Business Description -->
            <p v-if="business.business_description" class="text-gray-300 text-sm mb-4 line-clamp-2">
              {{ business.business_description }}
            </p>

            <!-- Business Details -->
            <div class="space-y-2 text-sm text-gray-400 mb-4">
              <div v-if="business.business_address" class="flex items-center space-x-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                </svg>
                <span class="truncate">{{ business.business_address }}</span>
              </div>
              
              <div v-if="business.contact_phone" class="flex items-center space-x-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                </svg>
                <span>{{ business.contact_phone }}</span>
              </div>
            </div>

            <!-- Products Count -->
            <div class="flex justify-between items-center pt-4 border-t border-gray-700">
              <span class="text-sm text-gray-400">
                {{ business.products_count || 0 }} {{ business.products_count === 1 ? 'product' : 'products' }}
              </span>
              <svg class="w-5 h-5 text-orange-400 group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
              </svg>
            </div>
          </div>
        </div>
      </div>

      <!-- Products View (when business is selected) -->
      <div v-else-if="currentBusiness && !showPurchaseHistory">
        <!-- Business Info Header -->
        <div class="bg-gray-800 rounded-xl p-6 mb-8 border border-gray-700">
          <div class="flex items-start space-x-6">
            <!-- Business Logo -->
            <div class="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0">
              <img v-if="currentBusiness.business_logo" 
                   :src="currentBusiness.business_logo" 
                   :alt="currentBusiness.business_name"
                   class="w-full h-full object-cover">
              <div v-else class="w-full h-full bg-gray-700 flex items-center justify-center">
                <svg class="w-10 h-10 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                </svg>
              </div>
            </div>
            
            <!-- Business Details -->
            <div class="flex-1">
              <div class="flex items-center space-x-3 mb-2">
                <h2 class="text-2xl font-bold text-white">{{ currentBusiness.business_name }}</h2>
                <span class="px-3 py-1 bg-orange-600/20 text-orange-400 rounded-full text-sm font-medium capitalize">
                  {{ formatCategory(currentBusiness.business_category) }}
                </span>
              </div>
              
              <p v-if="currentBusiness.business_description" class="text-gray-300 mb-3">
                {{ currentBusiness.business_description }}
              </p>
              
              <div class="flex flex-wrap gap-4 text-sm text-gray-400">
                <div v-if="currentBusiness.business_address" class="flex items-center space-x-2">
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                  </svg>
                  <span>{{ currentBusiness.business_address }}</span>
                </div>
                
                <div v-if="currentBusiness.contact_phone" class="flex items-center space-x-2">
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                  </svg>
                  <span>{{ currentBusiness.contact_phone }}</span>
                </div>
                
                <div v-if="currentBusiness.business_website" class="flex items-center space-x-2">
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.56-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.56.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z" clip-rule="evenodd"/>
                  </svg>
                  <a :href="currentBusiness.business_website" target="_blank" class="text-orange-400 hover:text-orange-300">
                    Visit Website
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Product Filters -->
        <div class="bg-gray-800 rounded-xl p-4 mb-8 flex flex-wrap gap-4 items-center">
          <div class="flex-1 min-w-64">
            <input v-model="productFilters.search" 
                   @input="debouncedProductSearch"
                   type="text" 
                   placeholder="Search products..."
                   class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
          </div>
          
          <div>
            <select v-model="productFilters.category" 
                    @change="fetchProducts"
                    class="px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-orange-500">
              <option value="">All Categories</option>
              <option value="food">Food</option>
              <option value="beverage">Beverage</option>
              <option value="merchandise">Merchandise</option>
              <option value="service">Service</option>
              <option value="discount">Discount</option>
              <option value="other">Other</option>
            </select>
          </div>
        </div>

        <!-- Products Grid -->
        <div v-if="productsLoading" class="flex justify-center py-12">
          <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-orange-500"></div>
        </div>

        <div v-else-if="products.length === 0" class="text-center py-12">
          <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
          </svg>
          <p class="text-xl text-gray-400">No products available</p>
          <p class="text-gray-500">This business hasn't added any products yet</p>
        </div>

        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
          <div v-for="product in products" :key="product.id" 
               class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden hover:border-orange-500 transition-all duration-200">
            
            <!-- Product Image -->
            <div class="h-48 bg-gray-700 overflow-hidden relative">
              <img v-if="product.image_url" 
                   :src="product.image_url" 
                   :alt="product.name"
                   class="w-full h-full object-cover">
              <div v-else class="w-full h-full flex items-center justify-center">
                <svg class="w-12 h-12 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                </svg>
              </div>
              
              <!-- Stock Badge -->
              <div class="absolute top-2 right-2">
                <span :class="[
                  'px-2 py-1 rounded-full text-xs font-semibold',
                  product.stock_quantity === -1 ? 'bg-green-600 text-white' :
                  product.stock_quantity > 5 ? 'bg-green-600 text-white' :
                  product.stock_quantity > 0 ? 'bg-yellow-600 text-white' :
                  'bg-red-600 text-white'
                ]">
                  {{ product.stock_quantity === -1 ? 'Unlimited' :
                     product.stock_quantity > 5 ? 'In Stock' :
                     product.stock_quantity > 0 ? 'Low Stock' :
                     'Out of Stock' }}
                </span>
              </div>
            </div>

            <!-- Product Info -->
            <div class="p-4">
              <div class="flex justify-between items-start mb-2">
                <h3 class="text-lg font-semibold text-white line-clamp-1">{{ product.name }}</h3>
                <span class="text-orange-400 font-bold text-lg ml-2">{{ product.points_price }} pts</span>
              </div>
              
              <p class="text-gray-400 text-sm mb-4 line-clamp-2">{{ product.description }}</p>
              
              <div class="flex items-center justify-between mb-4">
                <span class="text-xs text-gray-500 bg-gray-700 px-2 py-1 rounded-full capitalize">
                  {{ product.category }}
                </span>
                <span v-if="product.cash_equivalent" class="text-xs text-gray-500">
                  ~${{ product.cash_equivalent }}
                </span>
              </div>

              <!-- Purchase Actions -->
              <div class="flex items-center space-x-2">
                <div class="flex items-center space-x-1 flex-1">
                  <button @click="decreaseQuantity(product.id)" 
                          :disabled="!quantities[product.id] || quantities[product.id] <= 1"
                          class="w-8 h-8 rounded-full bg-gray-700 text-white disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-600 transition-colors">
                    -
                  </button>
                  <input v-model.number="quantities[product.id]" 
                         type="number" 
                         min="1" 
                         :max="product.stock_quantity === -1 ? 999 : product.stock_quantity"
                         class="w-16 text-center bg-gray-700 border border-gray-600 rounded text-white text-sm">
                  <button @click="increaseQuantity(product.id)" 
                          :disabled="product.stock_quantity !== -1 && quantities[product.id] >= product.stock_quantity"
                          class="w-8 h-8 rounded-full bg-gray-700 text-white disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-600 transition-colors">
                    +
                  </button>
                </div>
                
                <button @click="purchaseProduct(product)" 
                        :disabled="!canPurchase(product) || purchasing.has(product.id)"
                        class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors text-sm font-medium">
                  {{ purchasing.has(product.id) ? 'Buying...' : 'Buy Now' }}
                </button>
              </div>
              
              <!-- Insufficient Points Warning -->
              <div v-if="getTotalCost(product) > userPoints" class="mt-2">
                <p class="text-red-400 text-xs">
                  Insufficient points (need {{ getTotalCost(product) - userPoints }} more)
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { store } from '../store.js';
import axios from 'axios';

export default {
  name: 'ShoppingPage',
  props: {
    id: String
  },
  data() {
    return {
      store,
      loading: true,
      productsLoading: false,
      purchaseHistoryLoading: false,
      businesses: [],
      products: [],
      purchaseHistory: [],
      currentBusiness: null,
      categories: {},
      userPoints: 0,
      quantities: {},
      purchasing: new Set(),
      showPurchaseHistory: false,
      businessFilters: {
        search: '',
        category: ''
      },
      productFilters: {
        search: '',
        category: ''
      },
      purchaseFilters: {
        status: ''
      },
      searchTimeout: null
    };
  },
  async mounted() {
    await this.fetchCategories();
    
    // If business ID is provided in route, load that business directly
    if (this.id) {
      await this.loadBusinessById(this.id);
    } else {
      await this.fetchBusinesses();
    }
    
    if (store.isLoggedIn) {
      await this.fetchUserPoints();
    }
  },
  watch: {
    showPurchaseHistory: {
      async handler(newVal) {
        if (newVal && store.isLoggedIn) {
          await this.fetchPurchaseHistory();
        }
      },
      immediate: false
    }
  },
  methods: {
    async fetchCategories() {
      try {
        const response = await axios.get('/api/businesses/categories');
        this.categories = response.data;
      } catch (error) {
        console.error('Error fetching categories:', error);
      }
    },
    
    async loadBusinessById(businessId) {
      try {
        this.loading = true;
        const response = await axios.get(`/api/businesses/${businessId}`);
        this.currentBusiness = response.data;
        await this.fetchProducts();
      } catch (error) {
        console.error('Error loading business:', error);
        // Fallback to businesses list
        await this.fetchBusinesses();
      } finally {
        this.loading = false;
      }
    },
    
    async fetchBusinesses() {
      try {
        this.loading = true;
        const params = {
          ...this.businessFilters
        };
        
        const response = await axios.get('/api/businesses', { params });
        this.businesses = response.data.data || response.data;
      } catch (error) {
        console.error('Error fetching businesses:', error);
      } finally {
        this.loading = false;
      }
    },
    
    async fetchProducts() {
      if (!this.currentBusiness) return;
      
      try {
        this.productsLoading = true;
        const params = {
          partner_id: this.currentBusiness.user_id,
          ...this.productFilters
        };
        
        const response = await axios.get('/api/products', { params });
        this.products = response.data.data || response.data;
        
        // Initialize quantities
        this.products.forEach(product => {
          if (!this.quantities[product.id]) {
            this.quantities[product.id] = 1;
          }
        });
      } catch (error) {
        console.error('Error fetching products:', error);
      } finally {
        this.productsLoading = false;
      }
    },
    
    async fetchUserPoints() {
      try {
        const response = await axios.get('/api/points/my-points');
        this.userPoints = response.data.total_points || 0;
      } catch (error) {
        console.error('Error fetching user points:', error);
      }
    },
    
    async viewBusiness(business) {
      this.currentBusiness = business;
      this.productFilters = { search: '', category: '' };
      await this.fetchProducts();
    },
    
    goBackToBusinesses() {
      this.currentBusiness = null;
      this.products = [];
      this.productFilters = { search: '', category: '' };
    },
    
    debouncedBusinessSearch() {
      clearTimeout(this.searchTimeout);
      this.searchTimeout = setTimeout(() => {
        this.fetchBusinesses();
      }, 300);
    },
    
    debouncedProductSearch() {
      clearTimeout(this.searchTimeout);
      this.searchTimeout = setTimeout(() => {
        this.fetchProducts();
      }, 300);
    },
    
    increaseQuantity(productId) {
      const current = this.quantities[productId] || 1;
      this.quantities[productId] = current + 1;
    },
    
    decreaseQuantity(productId) {
      const current = this.quantities[productId] || 1;
      if (current > 1) {
        this.quantities[productId] = current - 1;
      }
    },
    
    getTotalCost(product) {
      const quantity = this.quantities[product.id] || 1;
      return product.points_price * quantity;
    },
    
    canPurchase(product) {
      if (!store.isLoggedIn) return false;
      if (product.stock_quantity === 0) return false;
      
      const totalCost = this.getTotalCost(product);
      return totalCost <= this.userPoints;
    },
    
    async purchaseProduct(product) {
      if (!this.canPurchase(product)) return;
      
      try {
        this.purchasing.add(product.id);
        
        const quantity = this.quantities[product.id] || 1;
        
        const response = await axios.post('/api/purchases', {
          product_id: product.id,
          quantity: quantity
        });
        
        // Update user points
        await this.fetchUserPoints();
        
        // Reset quantity
        this.quantities[product.id] = 1;
        
        // Refresh products to update stock
        await this.fetchProducts();
        
        // Refresh purchase history if currently viewing it
        if (this.showPurchaseHistory) {
          await this.fetchPurchaseHistory();
        }
        
        alert(`Successfully purchased ${quantity}x ${product.name}! Redemption code: ${response.data.redemption_code}`);
        
      } catch (error) {
        console.error('Error purchasing product:', error);
        alert('Error purchasing product. Please try again.');
      } finally {
        this.purchasing.delete(product.id);
      }
    },
    
    formatCategory(category) {
      return this.categories[category] || category;
    },
    
    // Purchase History Methods
    async fetchPurchaseHistory() {
      if (!store.isLoggedIn) return;
      
      try {
        this.purchaseHistoryLoading = true;
        const params = {};
        
        // Only add status filter if it's not empty
        if (this.purchaseFilters.status && this.purchaseFilters.status.trim() !== '') {
          params.status = this.purchaseFilters.status;
        }
        
        const response = await axios.get('/api/purchases', { params });
        this.purchaseHistory = response.data.data || response.data;
      } catch (error) {
        console.error('Error fetching purchase history:', error);
      } finally {
        this.purchaseHistoryLoading = false;
      }
    },
    
    closePurchaseHistory() {
      this.showPurchaseHistory = false;
      this.currentBusiness = null;
      this.products = [];
    },
    
    async copyToClipboard(text) {
      try {
        await navigator.clipboard.writeText(text);
        alert(`Redemption code ${text} copied to clipboard!`);
      } catch (error) {
        console.error('Failed to copy to clipboard:', error);
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        alert(`Redemption code ${text} copied to clipboard!`);
      }
    },
    
    getStatusBadgeClass(status) {
      switch(status) {
        case 'pending':
          return 'bg-yellow-500/20 text-yellow-400 border-yellow-500/30';
        case 'confirmed':
          return 'bg-blue-500/20 text-blue-400 border-blue-500/30';
        case 'completed':
          return 'bg-green-500/20 text-green-400 border-green-500/30';
        case 'cancelled':
          return 'bg-red-500/20 text-red-400 border-red-500/30';
        default:
          return 'bg-gray-500/20 text-gray-400 border-gray-500/30';
      }
    },
    
    formatStatus(status) {
      switch(status) {
        case 'pending':
          return 'Pending';
        case 'confirmed':
          return 'Confirmed';
        case 'completed':
          return 'Completed';
        case 'cancelled':
          return 'Cancelled';
        default:
          return status;
      }
    },
    
    formatDate(dateString) {
      return new Date(dateString).toLocaleDateString();
    },
    
    formatDateTime(dateString) {
      return new Date(dateString).toLocaleString();
    }
  }
};
</script>

<style scoped>
.line-clamp-1 {
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>