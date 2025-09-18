<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
      <div>
        <h2 class="text-2xl font-bold text-white">Sales Management</h2>
        <p class="text-gray-400">View and manage your sales transactions</p>
      </div>
      <div class="flex gap-4">
        <select v-model="filters.status" @change="fetchSales"
                class="px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
          <option value="">All Status</option>
          <option value="pending">Pending</option>
          <option value="confirmed">Confirmed</option>
          <option value="completed">Completed</option>
          <option value="cancelled">Cancelled</option>
        </select>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6" v-if="stats">
      <div class="bg-gradient-to-br from-blue-800 to-blue-900 border border-blue-700 rounded-2xl p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-blue-300 text-sm font-medium">Total Sales</p>
            <p class="text-2xl font-bold text-white">{{ stats.total_sales || 0 }}</p>
          </div>
          <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center">
            <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
            </svg>
          </div>
        </div>
      </div>
      
      <div class="bg-gradient-to-br from-yellow-800 to-yellow-900 border border-yellow-700 rounded-2xl p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-yellow-300 text-sm font-medium">Pending Orders</p>
            <p class="text-2xl font-bold text-white">{{ stats.pending_orders || 0 }}</p>
          </div>
          <div class="w-10 h-10 bg-yellow-500/20 rounded-lg flex items-center justify-center">
            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
            </svg>
          </div>
        </div>
      </div>
      
      <div class="bg-gradient-to-br from-green-800 to-green-900 border border-green-700 rounded-2xl p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-green-300 text-sm font-medium">Completed</p>
            <p class="text-2xl font-bold text-white">{{ stats.completed_orders || 0 }}</p>
          </div>
          <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center">
            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
            </svg>
          </div>
        </div>
      </div>
      
      <div class="bg-gradient-to-br from-purple-800 to-purple-900 border border-purple-700 rounded-2xl p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-purple-300 text-sm font-medium">Points Earned</p>
            <p class="text-2xl font-bold text-white">{{ stats.total_points_earned || 0 }}</p>
          </div>
          <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center">
            <svg class="w-5 h-5 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
          </div>
        </div>
      </div>
    </div>

    <!-- Sales List -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl overflow-hidden">
      <div class="p-6 border-b border-gray-700">
        <h3 class="text-xl font-semibold text-white">Recent Sales</h3>
      </div>
      
      <div v-if="loading" class="p-12 text-center">
        <div class="inline-block w-8 h-8 border-4 border-purple-500/30 border-t-purple-500 rounded-full animate-spin"></div>
        <p class="text-gray-400 mt-4">Loading sales...</p>
      </div>
      
      <div v-else-if="sales.length > 0" class="divide-y divide-gray-700">
        <div v-for="sale in sales" :key="sale.id" 
             class="p-6 hover:bg-gray-700/30 transition-colors">
          <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
              <!-- Customer Avatar -->
              <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center text-white font-semibold">
                {{ getInitials(sale.user) }}
              </div>
              
              <!-- Sale Details -->
              <div>
                <div class="flex items-center gap-3 mb-1">
                  <h4 class="text-white font-medium">{{ sale.product.name }}</h4>
                  <span v-if="sale.quantity > 1" class="text-gray-400 text-sm">x{{ sale.quantity }}</span>
                </div>
                <p class="text-gray-400 text-sm">{{ getUserName(sale.user) }}</p>
                <p class="text-gray-500 text-xs">{{ formatDate(sale.created_at) }}</p>
              </div>
            </div>
            
            <!-- Sale Info -->
            <div class="text-right">
              <div class="flex items-center gap-3 mb-2">
                <span class="text-purple-400 font-semibold">{{ sale.points_spent }} pts</span>
                <span :class="[
                  'px-3 py-1 rounded-full text-xs font-semibold border',
                  getStatusBadgeClass(sale.status)
                ]">
                  {{ getStatusText(sale.status) }}
                </span>
              </div>
              
              <!-- Action Buttons -->
              <div class="flex gap-2">
                <button v-if="sale.status === 'pending'" 
                        @click="confirmSale(sale)"
                        :disabled="processing === sale.id"
                        class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm disabled:opacity-50">
                  {{ processing === sale.id ? '...' : 'Confirm' }}
                </button>
                
                <button v-if="sale.status === 'confirmed'" 
                        @click="completeSale(sale)"
                        :disabled="processing === sale.id"
                        class="px-3 py-1 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm disabled:opacity-50">
                  {{ processing === sale.id ? '...' : 'Complete' }}
                </button>
                
                <button v-if="['pending', 'confirmed'].includes(sale.status)" 
                        @click="cancelSale(sale)"
                        :disabled="processing === sale.id"
                        class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm disabled:opacity-50">
                  {{ processing === sale.id ? '...' : 'Cancel' }}
                </button>
              </div>
            </div>
          </div>
          
          <!-- Transaction Info -->
          <div class="mt-4 p-3 bg-gray-800/50 rounded-lg">
            <p class="text-gray-400 text-sm">
              <span class="font-medium">Transaction ID:</span>
              <span class="ml-2 font-mono text-purple-400">#{{ sale.id }}</span>
            </p>
          </div>
          
          <!-- Notes -->
          <div v-if="sale.notes" class="mt-3 p-3 bg-gray-800/50 rounded-lg">
            <p class="text-gray-300 text-sm">
              <span class="text-gray-400 font-medium">Notes:</span> {{ sale.notes }}
            </p>
          </div>
        </div>
      </div>
      
      <!-- Empty State -->
      <div v-else class="p-12 text-center">
        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <p class="text-gray-400 text-lg">No sales yet</p>
        <p class="text-gray-500 text-sm mt-2">Sales will appear here when customers purchase your products.</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'PartnerSalesManagement',
  data() {
    return {
      loading: true,
      sales: [],
      stats: null,
      processing: null,
      filters: {
        status: ''
      }
    };
  },
  async mounted() {
    await Promise.all([
      this.fetchSales(),
      this.fetchStats()
    ]);
  },
  methods: {
    async fetchSales() {
      try {
        this.loading = true;
        const params = {
          partner_view: true
        };
        
        // Only add status filter if it's not empty
        if (this.filters.status && this.filters.status.trim() !== '') {
          params.status = this.filters.status;
        }
        
        const response = await axios.get('/api/purchases', { params });
        this.sales = response.data.data || response.data;
      } catch (error) {
        console.error('Error fetching sales:', error);
        this.$toast?.error?.('Failed to fetch sales');
      } finally {
        this.loading = false;
      }
    },

    async fetchStats() {
      try {
        const response = await axios.get('/api/purchases/stats');
        this.stats = response.data;
      } catch (error) {
        console.error('Error fetching stats:', error);
      }
    },

    async confirmSale(sale) {
      try {
        this.processing = sale.id;
        await axios.post(`/api/purchases/${sale.id}/confirm`);
        sale.status = 'confirmed';
        this.$toast?.success?.('Sale confirmed successfully');
        await this.fetchStats();
      } catch (error) {
        console.error('Error confirming sale:', error);
        this.$toast?.error?.('Failed to confirm sale');
      } finally {
        this.processing = null;
      }
    },

    async completeSale(sale) {
      try {
        this.processing = sale.id;
        await axios.post(`/api/purchases/${sale.id}/complete`);
        sale.status = 'completed';
        this.$toast?.success?.('Sale completed successfully');
        await this.fetchStats();
      } catch (error) {
        console.error('Error completing sale:', error);
        this.$toast?.error?.('Failed to complete sale');
      } finally {
        this.processing = null;
      }
    },

    async cancelSale(sale) {
      if (!confirm('Are you sure you want to cancel this sale? This will refund the points to the customer.')) {
        return;
      }

      try {
        this.processing = sale.id;
        await axios.post(`/api/purchases/${sale.id}/cancel`);
        sale.status = 'cancelled';
        this.$toast?.success?.('Sale cancelled and points refunded');
        await this.fetchStats();
      } catch (error) {
        console.error('Error cancelling sale:', error);
        this.$toast?.error?.('Failed to cancel sale');
      } finally {
        this.processing = null;
      }
    },

    formatDate(dateString) {
      if (!dateString) return '';
      const date = new Date(dateString);
      return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      });
    },

    getUserName(user) {
      if (!user) return 'Unknown User';
      if (user.info?.first_name && user.info?.last_name) {
        return `${user.info.first_name} ${user.info.last_name}`;
      }
      return user.name || user.email || 'Unknown User';
    },

    getInitials(user) {
      const name = this.getUserName(user);
      const parts = name.split(' ');
      if (parts.length >= 2) {
        return `${parts[0][0]}${parts[1][0]}`.toUpperCase();
      }
      return name[0]?.toUpperCase() || 'U';
    },

    getStatusBadgeClass(status) {
      switch (status) {
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

    getStatusText(status) {
      switch (status) {
        case 'pending':
          return 'Pending';
        case 'confirmed':
          return 'Confirmed';
        case 'completed':
          return 'Completed';
        case 'cancelled':
          return 'Cancelled';
        default:
          return 'Unknown';
      }
    }
  }
};
</script>