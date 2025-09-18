<template>
  <div class="min-h-screen bg-gray-900 text-white">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-900 via-purple-800 to-purple-900 border-b border-purple-700">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center">
          <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">
              Partner Dashboard
            </h1>
            <p class="text-purple-300 mt-2">Manage your products and point redemptions</p>
          </div>
          <div class="text-right">
            <p class="text-purple-300 text-sm">Partner Business</p>
            <p class="text-xl font-semibold text-white">{{ store.currentUser?.partnerInfo?.business_name || 'Your Business' }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
      <div class="flex space-x-1 bg-gray-800 rounded-xl p-1">
        <button
          v-for="tab in tabs"
          :key="tab.id"
          @click="activeTab = tab.id"
          :class="[
            'px-6 py-3 rounded-xl font-semibold transition-all duration-300 flex items-center gap-2',
            activeTab === tab.id
              ? 'bg-gradient-to-r from-purple-500 to-pink-500 text-white shadow-lg'
              : 'bg-transparent text-gray-300 hover:bg-gray-700/50 hover:text-white'
          ]">
          <component :is="tab.icon" class="w-5 h-5" />
          {{ tab.name }}
        </button>
      </div>
    </div>

    <!-- Content Area -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
      <!-- Dashboard Overview -->
      <div v-if="activeTab === 'overview'" class="space-y-8">
        <div v-if="loading" class="text-center py-12">
          <div class="inline-block w-8 h-8 border-4 border-purple-500/30 border-t-purple-500 rounded-full animate-spin"></div>
          <p class="text-gray-400 mt-4">Loading dashboard...</p>
        </div>
        
        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div v-for="stat in stats" :key="stat.title" 
               class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl p-6 hover:scale-105 transition-transform duration-300">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-400 text-sm font-medium">{{ stat.title }}</p>
                <p class="text-3xl font-bold text-white mt-2">{{ stat.value }}</p>
                <p v-if="stat.subtitle" class="text-gray-500 text-xs mt-1">{{ stat.subtitle }}</p>
              </div>
              <div :class="[
                'w-12 h-12 rounded-lg flex items-center justify-center',
                stat.bgColor || 'bg-gray-700'
              ]">
                <component :is="stat.icon" class="w-6 h-6 text-white" />
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Sales -->
        <div v-if="recentSales?.length > 0" class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl p-6">
          <h3 class="text-xl font-semibold text-white mb-4">Recent Sales</h3>
          <div class="space-y-3">
            <div v-for="sale in recentSales" :key="sale.id" 
                 class="flex items-center justify-between p-4 bg-gray-700/50 rounded-lg">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center text-white font-semibold">
                  {{ getInitials(sale.user) }}
                </div>
                <div>
                  <p class="text-white font-medium">{{ sale.product.name }}</p>
                  <p class="text-gray-400 text-sm">{{ getUserName(sale.user) }}</p>
                </div>
              </div>
              <div class="text-right">
                <p class="text-purple-400 font-semibold">{{ sale.points_spent }} pts</p>
                <p class="text-gray-500 text-xs">{{ formatDate(sale.created_at) }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Products Tab -->
      <PartnerProductManagement v-if="activeTab === 'products'" />

      <!-- Sales Tab -->
      <PartnerSalesManagement v-if="activeTab === 'sales'" />

      <!-- Redemptions Tab -->
      <PartnerRedemptionInterface v-if="activeTab === 'redemptions'" @switch-tab="activeTab = $event" />

      <!-- Profile Tab -->
      <PartnerProfileManagement v-if="activeTab === 'profile'" />
    </div>
  </div>
</template>

<script>
import { store } from '../store.js';
import axios from 'axios';
import PartnerProductManagement from '../components/partner/PartnerProductManagement.vue';
import PartnerSalesManagement from '../components/partner/PartnerSalesManagement.vue';
import PartnerRedemptionInterface from '../components/partner/PartnerRedemptionInterface.vue';
import PartnerProfileManagement from '../components/partner/PartnerProfileManagement.vue';

// Icon components
const DashboardIcon = {
  template: `<svg fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/></svg>`
};

const ProductIcon = {
  template: `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v11a3 3 0 106 0V4a2 2 0 00-2-2H4zM3 15a1 1 0 011-1h1a1 1 0 011 1v1a1 1 0 01-1 1H4a1 1 0 01-1-1v-1zm7-13a1 1 0 011-1h3a1 1 0 011 1v8a1 1 0 01-1 1h-3a1 1 0 01-1-1V2zm2 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>`
};

const SalesIcon = {
  template: `<svg fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/></svg>`
};

const RedemptionIcon = {
  template: `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/></svg>`
};

const StatsIcon = {
  template: `<svg fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/></svg>`
};

const UserIcon = {
  template: `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>`
};

export default {
  name: 'PartnerDashboard',
  components: {
    PartnerProductManagement,
    PartnerSalesManagement,
    PartnerRedemptionInterface,
    PartnerProfileManagement,
    DashboardIcon,
    ProductIcon,
    SalesIcon,
    RedemptionIcon,
    StatsIcon,
    UserIcon
  },
  data() {
    return {
      store,
      loading: true,
      activeTab: 'overview',
      dashboardData: null,
      recentSales: [],
      tabs: [
        {
          id: 'overview',
          name: 'Overview',
          icon: 'DashboardIcon'
        },
        {
          id: 'products',
          name: 'Products',
          icon: 'ProductIcon'
        },
        {
          id: 'sales',
          name: 'Sales',
          icon: 'SalesIcon'
        },
        {
          id: 'redemptions',
          name: 'Redemptions',
          icon: 'RedemptionIcon'
        },
        {
          id: 'profile',
          name: 'Profile',
          icon: 'UserIcon'
        }
      ]
    };
  },
  computed: {
    stats() {
      if (!this.dashboardData) return [];
      
      return [
        {
          title: 'Total Products',
          value: this.dashboardData.total_products || 0,
          icon: 'ProductIcon',
          bgColor: 'bg-gradient-to-r from-blue-500 to-blue-600'
        },
        {
          title: 'Active Products',
          value: this.dashboardData.active_products || 0,
          icon: 'StatsIcon',
          bgColor: 'bg-gradient-to-r from-green-500 to-green-600'
        },
        {
          title: 'Total Sales',
          value: this.dashboardData.total_sales || 0,
          icon: 'SalesIcon',
          bgColor: 'bg-gradient-to-r from-purple-500 to-purple-600'
        },
        {
          title: 'Pending Orders',
          value: this.dashboardData.pending_orders || 0,
          icon: 'RedemptionIcon',
          bgColor: 'bg-gradient-to-r from-yellow-500 to-orange-500'
        },
        {
          title: 'Points Earned',
          value: this.dashboardData.total_points_earned || 0,
          subtitle: 'Total points from sales',
          icon: 'StatsIcon',
          bgColor: 'bg-gradient-to-r from-pink-500 to-purple-600'
        }
      ];
    }
  },
  async mounted() {
    await this.fetchDashboardStats();
  },
  methods: {
    async fetchDashboardStats() {
      try {
        this.loading = true;
        const response = await axios.get('/api/products/partner/stats');
        this.dashboardData = response.data;
        this.recentSales = response.data.recent_sales || [];
      } catch (error) {
        console.error('Error fetching dashboard stats:', error);
        this.$toast?.error?.('Failed to fetch dashboard statistics');
      } finally {
        this.loading = false;
      }
    },

    formatDate(dateString) {
      if (!dateString) return '';
      const date = new Date(dateString);
      return date.toLocaleDateString('en-US', {
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
    }
  }
};
</script>
