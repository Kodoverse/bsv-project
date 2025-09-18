<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
      <div>
        <h2 class="text-2xl font-bold text-white">Partner Management</h2>
        <p class="text-gray-400">Manage partner accounts and business information</p>
      </div>
      <div class="flex gap-4">
        <button @click="showAddPartnerModal = true"
                class="px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-200 flex items-center gap-2">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
          </svg>
          Add Partner
        </button>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6" v-if="stats">
      <div class="bg-gradient-to-br from-blue-800 to-blue-900 border border-blue-700 rounded-2xl p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-blue-300 text-sm font-medium">Total Partners</p>
            <p class="text-3xl font-bold text-white">{{ stats.total_partners || 0 }}</p>
          </div>
          <div class="w-12 h-12 bg-blue-500/20 rounded-full flex items-center justify-center">
            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-gradient-to-br from-green-800 to-green-900 border border-green-700 rounded-2xl p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-green-300 text-sm font-medium">Active Partners</p>
            <p class="text-3xl font-bold text-white">{{ stats.active_partners || 0 }}</p>
          </div>
          <div class="w-12 h-12 bg-green-500/20 rounded-full flex items-center justify-center">
            <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-gradient-to-br from-yellow-800 to-yellow-900 border border-yellow-700 rounded-2xl p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-yellow-300 text-sm font-medium">Pending Approval</p>
            <p class="text-3xl font-bold text-white">{{ stats.pending_partners || 0 }}</p>
          </div>
          <div class="w-12 h-12 bg-yellow-500/20 rounded-full flex items-center justify-center">
            <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-gradient-to-br from-purple-800 to-purple-900 border border-purple-700 rounded-2xl p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-purple-300 text-sm font-medium">Total Products</p>
            <p class="text-3xl font-bold text-white">{{ stats.total_products || 0 }}</p>
          </div>
          <div class="w-12 h-12 bg-purple-500/20 rounded-full flex items-center justify-center">
            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
          </div>
        </div>
      </div>
    </div>

    <!-- Filters -->
    <div class="bg-gray-800/50 border border-gray-700 rounded-2xl p-6">
      <div class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-64">
          <label class="block text-sm font-medium text-gray-300 mb-2">Search Partners</label>
          <input v-model="filters.search" @input="debouncedSearch"
                 type="text" placeholder="Search by name, email, or business..."
                 class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
        </div>
        
        <div class="min-w-48">
          <label class="block text-sm font-medium text-gray-300 mb-2">Status</label>
          <select v-model="filters.status" @change="fetchPartners"
                  class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            <option value="">All Status</option>
            <option value="active">Active</option>
            <option value="pending">Pending</option>
            <option value="suspended">Suspended</option>
          </select>
        </div>

        <div class="min-w-48">
          <label class="block text-sm font-medium text-gray-300 mb-2">Business Category</label>
          <select v-model="filters.category" @change="fetchPartners"
                  class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            <option value="">All Categories</option>
            <option value="cafe">Cafe</option>
            <option value="restaurant">Restaurant</option>
            <option value="bar">Bar</option>
            <option value="supermarket">Supermarket</option>
            <option value="clothing">Clothing</option>
            <option value="electronics">Electronics</option>
            <option value="pharmacy">Pharmacy</option>
            <option value="bookstore">Bookstore</option>
            <option value="sports">Sports</option>
            <option value="beauty">Beauty</option>
            <option value="service">Service</option>
            <option value="other">Other</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Partners Table -->
    <div class="bg-gray-800/50 border border-gray-700 rounded-2xl overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead class="bg-gray-700/50">
            <tr>
              <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Partner</th>
              <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Business</th>
              <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Category</th>
              <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
              <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Products</th>
              <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Joined</th>
              <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-700">
            <tr v-if="loading" class="bg-gray-800/50">
              <td colspan="7" class="px-6 py-12 text-center">
                <div class="flex items-center justify-center">
                  <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-500"></div>
                  <span class="ml-3 text-gray-400">Loading partners...</span>
                </div>
              </td>
            </tr>
            
            <tr v-else-if="partners.length === 0" class="bg-gray-800/50">
              <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                No partners found
              </td>
            </tr>
            
            <tr v-else v-for="partner in partners" :key="partner.id" class="hover:bg-gray-700/30 transition-colors">
              <td class="px-6 py-4">
                <div class="flex items-center">
                  <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-blue-500 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                    {{ getInitials(partner) }}
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-white">{{ partner.name }}</div>
                    <div class="text-sm text-gray-400">{{ partner.email }}</div>
                  </div>
                </div>
              </td>
              
              <td class="px-6 py-4">
                <div v-if="partner.partner_info">
                  <div class="text-sm font-medium text-white">{{ partner.partner_info.business_name || 'N/A' }}</div>
                  <div class="text-sm text-gray-400">{{ partner.partner_info.business_address || 'No address' }}</div>
                </div>
                <div v-else class="text-sm text-gray-400">No business info</div>
              </td>
              
              <td class="px-6 py-4">
                <span v-if="partner.partner_info?.business_category" 
                      class="px-2 py-1 text-xs font-medium rounded-full bg-blue-500/20 text-blue-300 border border-blue-500/30">
                  {{ formatCategory(partner.partner_info.business_category) }}
                </span>
                <span v-else class="text-sm text-gray-400">N/A</span>
              </td>
              
              <td class="px-6 py-4">
                <span :class="getStatusClasses(partner.partner_info?.is_active)">
                  {{ getStatusText(partner.partner_info?.is_active) }}
                </span>
              </td>
              
              <td class="px-6 py-4">
                <div class="text-sm text-white">{{ partner.products_count || 0 }}</div>
                <div class="text-xs text-gray-400">products</div>
              </td>
              
              <td class="px-6 py-4 text-sm text-gray-400">
                {{ formatDate(partner.created_at) }}
              </td>
              
              <td class="px-6 py-4">
                <div class="flex items-center gap-2">
                  <button @click="viewPartner(partner)"
                          class="p-2 text-blue-400 hover:text-blue-300 hover:bg-blue-500/20 rounded-lg transition-colors"
                          title="View Details">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                  </button>
                  
                  <button @click="editPartner(partner)"
                          class="p-2 text-yellow-400 hover:text-yellow-300 hover:bg-yellow-500/20 rounded-lg transition-colors"
                          title="Edit Partner">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                  </button>
                  
                  <button @click="togglePartnerStatus(partner)"
                          :class="partner.partner_info?.is_active ? 
                            'p-2 text-red-400 hover:text-red-300 hover:bg-red-500/20' : 
                            'p-2 text-green-400 hover:text-green-300 hover:bg-green-500/20'"
                          class="rounded-lg transition-colors"
                          :title="partner.partner_info?.is_active ? 'Suspend Partner' : 'Activate Partner'">
                    <svg v-if="partner.partner_info?.is_active" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"/>
                    </svg>
                    <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                  </button>
                  
                  <button @click="deletePartner(partner)"
                          class="p-2 text-red-400 hover:text-red-300 hover:bg-red-500/20 rounded-lg transition-colors"
                          title="Delete Partner">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Pagination -->
    <div v-if="pagination && pagination.last_page > 1" class="flex items-center justify-between">
      <div class="text-sm text-gray-400">
        Showing {{ pagination.from || 0 }} to {{ pagination.to || 0 }} of {{ pagination.total || 0 }} partners
      </div>
      <div class="flex gap-2">
        <button @click="changePage(pagination.current_page - 1)" 
                :disabled="!pagination.prev_page_url"
                class="px-3 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed">
          Previous
        </button>
        <button @click="changePage(pagination.current_page + 1)" 
                :disabled="!pagination.next_page_url"
                class="px-3 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed">
          Next
        </button>
      </div>
    </div>

    <!-- Add Partner Modal -->
    <div v-if="showAddPartnerModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
      <div class="bg-gray-800 border border-gray-700 rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-700">
          <div class="flex items-center justify-between">
            <h3 class="text-xl font-semibold text-white">Add New Partner</h3>
            <button @click="closeModals" class="text-gray-400 hover:text-white">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
        </div>
        
        <form @submit.prevent="submitPartnerForm" class="p-6 space-y-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-2">Name *</label>
              <input v-model="partnerForm.name" type="text" required
                     class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-2">Email *</label>
              <input v-model="partnerForm.email" type="email" required
                     class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-2">Business Name *</label>
              <input v-model="partnerForm.business_name" type="text" required
                     class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-2">Business Category *</label>
              <select v-model="partnerForm.business_category" required
                      class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <option value="">Select Category</option>
                <option value="cafe">Cafe</option>
                <option value="restaurant">Restaurant</option>
                <option value="bar">Bar</option>
                <option value="supermarket">Supermarket</option>
                <option value="clothing">Clothing</option>
                <option value="electronics">Electronics</option>
                <option value="pharmacy">Pharmacy</option>
                <option value="bookstore">Bookstore</option>
                <option value="sports">Sports</option>
                <option value="beauty">Beauty</option>
                <option value="service">Service</option>
                <option value="other">Other</option>
              </select>
            </div>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Business Address *</label>
            <textarea v-model="partnerForm.business_address" rows="3" required
                      class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Business Description</label>
            <textarea v-model="partnerForm.business_description" rows="3"
                      class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-2">Contact Phone</label>
              <input v-model="partnerForm.contact_phone" type="tel"
                     class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-2">Business Email</label>
              <input v-model="partnerForm.business_email" type="email"
                     class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
          </div>
          
          <div class="flex items-center gap-4">
            <label class="flex items-center">
              <input v-model="partnerForm.is_active" type="checkbox"
                     class="w-4 h-4 text-purple-600 bg-gray-700 border-gray-600 rounded focus:ring-purple-500 focus:ring-2">
              <span class="ml-2 text-sm text-gray-300">Active Partner</span>
            </label>
          </div>
          
          <div class="flex justify-end gap-4 pt-4">
            <button type="button" @click="closeModals"
                    class="px-6 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition-colors">
              Cancel
            </button>
            <button type="submit" :disabled="processing"
                    class="px-6 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-200 disabled:opacity-50">
              {{ processing ? 'Creating...' : 'Create Partner' }}
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- View Partner Modal -->
    <div v-if="showViewPartnerModal && selectedPartner" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
      <div class="bg-gray-800 border border-gray-700 rounded-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-700">
          <div class="flex items-center justify-between">
            <h3 class="text-xl font-semibold text-white">Partner Details</h3>
            <button @click="closeModals" class="text-gray-400 hover:text-white">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
        </div>
        
        <div class="p-6 space-y-6">
          <!-- Partner Info -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-700/50 rounded-lg p-4">
              <h4 class="text-lg font-semibold text-white mb-4">Account Information</h4>
              <div class="space-y-3">
                <div>
                  <span class="text-sm text-gray-400">Name:</span>
                  <p class="text-white">{{ selectedPartner.name }}</p>
                </div>
                <div>
                  <span class="text-sm text-gray-400">Email:</span>
                  <p class="text-white">{{ selectedPartner.email }}</p>
                </div>
                <div>
                  <span class="text-sm text-gray-400">Joined:</span>
                  <p class="text-white">{{ formatDate(selectedPartner.created_at) }}</p>
                </div>
                <div>
                  <span class="text-sm text-gray-400">Status:</span>
                  <span :class="getStatusClasses(selectedPartner.partner_info?.is_active)">
                    {{ getStatusText(selectedPartner.partner_info?.is_active) }}
                  </span>
                </div>
              </div>
            </div>
            
            <div class="bg-gray-700/50 rounded-lg p-4">
              <h4 class="text-lg font-semibold text-white mb-4">Business Information</h4>
              <div class="space-y-3">
                <div v-if="selectedPartner.partner_info">
                  <div>
                    <span class="text-sm text-gray-400">Business Name:</span>
                    <p class="text-white">{{ selectedPartner.partner_info.business_name || 'N/A' }}</p>
                  </div>
                  <div>
                    <span class="text-sm text-gray-400">Category:</span>
                    <p class="text-white">{{ formatCategory(selectedPartner.partner_info.business_category) }}</p>
                  </div>
                  <div>
                    <span class="text-sm text-gray-400">Address:</span>
                    <p class="text-white">{{ selectedPartner.partner_info.business_address || 'N/A' }}</p>
                  </div>
                  <div>
                    <span class="text-sm text-gray-400">Phone:</span>
                    <p class="text-white">{{ selectedPartner.partner_info.contact_phone || 'N/A' }}</p>
                  </div>
                </div>
                <div v-else class="text-gray-400">No business information available</div>
              </div>
            </div>
          </div>
          
          <!-- Products -->
          <div v-if="selectedPartner.products && selectedPartner.products.length > 0">
            <h4 class="text-lg font-semibold text-white mb-4">Products ({{ selectedPartner.products.length }})</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
              <div v-for="product in selectedPartner.products" :key="product.id" 
                   class="bg-gray-700/50 rounded-lg p-4">
                <div class="flex items-center gap-3 mb-3">
                  <div v-if="product.image_url" class="w-12 h-12 bg-gray-600 rounded-lg overflow-hidden">
                    <img :src="product.image_url" :alt="product.name" class="w-full h-full object-cover">
                  </div>
                  <div class="flex-1">
                    <h5 class="text-white font-medium">{{ product.name }}</h5>
                    <p class="text-sm text-gray-400">{{ product.points_price }} points</p>
                  </div>
                </div>
                <p class="text-sm text-gray-300">{{ product.description }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'AdminPartnerManagement',
  data() {
    return {
      partners: [],
      stats: null,
      loading: false,
      processing: false,
      pagination: null,
      selectedPartner: null,
      showAddPartnerModal: false,
      showViewPartnerModal: false,
      searchTimeout: null,
      filters: {
        search: '',
        status: '',
        category: ''
      },
      partnerForm: {
        name: '',
        email: '',
        business_name: '',
        business_category: '',
        business_address: '',
        business_description: '',
        contact_phone: '',
        business_email: '',
        is_active: true
      },
      categories: {
        cafe: 'Cafe',
        restaurant: 'Restaurant',
        bar: 'Bar',
        supermarket: 'Supermarket',
        clothing: 'Clothing',
        electronics: 'Electronics',
        pharmacy: 'Pharmacy',
        bookstore: 'Bookstore',
        sports: 'Sports',
        beauty: 'Beauty',
        service: 'Service',
        other: 'Other'
      }
    };
  },
  async mounted() {
    await Promise.all([
      this.fetchPartners(),
      this.fetchStats()
    ]);
  },
  methods: {
    async fetchPartners() {
      try {
        this.loading = true;
        const params = {};
        
        if (this.filters.search && this.filters.search.trim() !== '') {
          params.search = this.filters.search;
        }
        if (this.filters.status && this.filters.status.trim() !== '') {
          params.status = this.filters.status;
        }
        if (this.filters.category && this.filters.category.trim() !== '') {
          params.category = this.filters.category;
        }
        
        const response = await axios.get('/api/admin/partners', { params });
        this.partners = response.data.data || response.data;
        this.pagination = response.data;
      } catch (error) {
        console.error('Error fetching partners:', error);
        console.error('Error details:', error.response?.data);
        this.$toast?.error?.('Failed to fetch partners');
      } finally {
        this.loading = false;
      }
    },
    
    async fetchStats() {
      try {
        const response = await axios.get('/api/admin/partners/stats');
        this.stats = response.data;
      } catch (error) {
        console.error('Error fetching partner stats:', error);
        console.error('Stats error details:', error.response?.data);
      }
    },
    
    debouncedSearch() {
      clearTimeout(this.searchTimeout);
      this.searchTimeout = setTimeout(() => {
        this.fetchPartners();
      }, 500);
    },
    
    changePage(page) {
      if (page >= 1 && page <= this.pagination.last_page) {
        this.fetchPartners();
      }
    },
    
    viewPartner(partner) {
      this.selectedPartner = partner;
      this.showViewPartnerModal = true;
    },
    
    editPartner(partner) {
      // TODO: Implement edit functionality
      this.$toast?.info?.('Edit functionality coming soon');
    },
    
    async togglePartnerStatus(partner) {
      if (!confirm(`Are you sure you want to ${partner.partner_info?.is_active ? 'suspend' : 'activate'} this partner?`)) {
        return;
      }
      
      try {
        this.processing = partner.id;
        await axios.put(`/api/admin/partners/${partner.id}/toggle-status`);
        partner.partner_info.is_active = !partner.partner_info.is_active;
        this.$toast?.success?.(`Partner ${partner.partner_info.is_active ? 'activated' : 'suspended'} successfully`);
        await this.fetchStats();
      } catch (error) {
        console.error('Error toggling partner status:', error);
        this.$toast?.error?.('Failed to update partner status');
      } finally {
        this.processing = false;
      }
    },
    
    async deletePartner(partner) {
      if (!confirm(`Are you sure you want to delete partner "${partner.name}"? This action cannot be undone.`)) {
        return;
      }
      
      try {
        this.processing = partner.id;
        await axios.delete(`/api/admin/partners/${partner.id}`);
        this.partners = this.partners.filter(p => p.id !== partner.id);
        this.$toast?.success?.('Partner deleted successfully');
        await this.fetchStats();
      } catch (error) {
        console.error('Error deleting partner:', error);
        this.$toast?.error?.('Failed to delete partner');
      } finally {
        this.processing = false;
      }
    },
    
    async submitPartnerForm() {
      try {
        this.processing = true;
        await axios.post('/api/admin/partners', this.partnerForm);
        this.$toast?.success?.('Partner created successfully');
        this.closeModals();
        await this.fetchPartners();
        await this.fetchStats();
      } catch (error) {
        console.error('Error creating partner:', error);
        this.$toast?.error?.('Failed to create partner');
      } finally {
        this.processing = false;
      }
    },
    
    closeModals() {
      this.showAddPartnerModal = false;
      this.showViewPartnerModal = false;
      this.selectedPartner = null;
      this.partnerForm = {
        name: '',
        email: '',
        business_name: '',
        business_category: '',
        business_address: '',
        business_description: '',
        contact_phone: '',
        business_email: '',
        is_active: true
      };
    },
    
    getInitials(partner) {
      const name = partner.name || partner.email || 'U';
      return name.split(' ').map(n => n[0]).join('').toUpperCase().slice(0, 2);
    },
    
    getStatusClasses(isActive) {
      if (isActive === true) {
        return 'px-2 py-1 text-xs font-medium rounded-full bg-green-500/20 text-green-300 border border-green-500/30';
      } else if (isActive === false) {
        return 'px-2 py-1 text-xs font-medium rounded-full bg-red-500/20 text-red-300 border border-red-500/30';
      } else {
        return 'px-2 py-1 text-xs font-medium rounded-full bg-yellow-500/20 text-yellow-300 border border-yellow-500/30';
      }
    },
    
    getStatusText(isActive) {
      if (isActive === true) return 'Active';
      if (isActive === false) return 'Suspended';
      return 'Pending';
    },
    
    formatCategory(category) {
      return this.categories[category] || category;
    },
    
    formatDate(dateString) {
      if (!dateString) return '';
      const date = new Date(dateString);
      return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      });
    }
  }
};
</script>
