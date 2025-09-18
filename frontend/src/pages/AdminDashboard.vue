<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
    <!-- Header -->
    <div class="bg-gradient-to-r from-orange-500/10 to-red-500/10 border-b border-gray-700/50 backdrop-blur-sm">
      <div class="px-4 sm:px-6 md:px-8 lg:px-12 py-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
          <div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-black">
              <span class="text-transparent bg-clip-text bg-gradient-to-r from-white via-orange-100 to-orange-300">
                Admin
              </span>
              <span class="block text-2xl md:text-3xl lg:text-4xl font-bold text-orange-400 mt-2">
                Dashboard
              </span>
            </h1>
            <div class="w-20 h-1 bg-gradient-to-r from-orange-400 to-red-400 mt-4"></div>
          </div>
          
          <!-- Admin Role Display -->
          <div class="text-right">
            <p class="text-gray-300 text-sm">Admin Dashboard</p>
            <p class="text-xl font-bold" :class="roleColorClass">
              {{ store.userRole.charAt(0).toUpperCase() + store.userRole.slice(1) }} Access
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="px-4 sm:px-6 md:px-8 lg:px-12 py-6">
      <div class="flex flex-wrap gap-2">
        <button
          v-for="tab in tabs"
          :key="tab.id"
          @click="activeTab = tab.id"
          :class="[
            'px-6 py-3 rounded-xl font-semibold transition-all duration-300 flex items-center gap-2',
            activeTab === tab.id
              ? 'bg-gradient-to-r from-orange-500 to-red-500 text-white shadow-lg'
              : 'bg-gray-800/50 text-gray-300 hover:bg-gray-700/50 hover:text-white'
          ]">
          <component :is="tab.icon" class="w-5 h-5" />
          {{ tab.name }}
        </button>
      </div>
    </div>

    <!-- Content Area -->
    <div class="px-4 sm:px-6 md:px-8 lg:px-12 pb-12">
      <!-- Dashboard Stats -->
      <div v-if="activeTab === 'overview'" class="space-y-8">
        <div v-if="loading" class="text-center py-12">
          <div class="inline-block w-8 h-8 border-4 border-orange-500/30 border-t-orange-500 rounded-full animate-spin"></div>
          <p class="text-gray-400 mt-4">Loading dashboard...</p>
        </div>
        
        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div v-for="stat in stats" :key="stat.title" 
               class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl p-6 hover:scale-105 transition-transform duration-300">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-400 text-sm font-medium">{{ stat.title }}</p>
                <p class="text-3xl font-bold text-white mt-2">{{ stat.value }}</p>
              </div>
              <div :class="['p-3 rounded-xl', stat.bgColor]">
                <component :is="stat.icon" class="w-6 h-6 text-white" />
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Registrations -->
        <div v-if="dashboardData?.recent_registrations?.length" class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl p-6">
          <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
            <svg class="w-6 h-6 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
            </svg>
            Recent Registrations
          </h3>
          <div class="space-y-3">
            <div v-for="registration in dashboardData.recent_registrations" :key="registration.id"
                 class="flex items-center justify-between p-4 bg-gray-700/30 rounded-xl">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-r from-orange-400 to-red-400 rounded-full flex items-center justify-center">
                  <span class="text-white font-bold text-sm">
                    {{ registration.user?.info?.firstname?.charAt(0) || registration.user?.email?.charAt(0) }}{{ registration.user?.info?.lastname?.charAt(0) || '' }}
                  </span>
                </div>
                <div>
                  <p class="text-white font-semibold">
                    {{ registration.user?.info?.firstname }} {{ registration.user?.info?.lastname || registration.user?.email }}
                  </p>
                  <p class="text-gray-400 text-sm">{{ registration.event?.title }}</p>
                </div>
              </div>
              <div class="text-right">
                <p class="text-green-400 text-sm font-medium">Registered</p>
                <p class="text-gray-500 text-xs">{{ formatDate(registration.created_at) }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Events Management Tab -->
      <AdminEventManagement v-if="activeTab === 'events'" />

      <!-- Attendance Management Tab -->
      <AdminAttendanceManagement v-if="activeTab === 'attendance'" />

      <!-- Categories Management Tab -->
      <AdminCategoryManagement v-if="activeTab === 'categories'" />

      <!-- Users Management Tab -->
      <AdminUserManagement v-if="activeTab === 'users'" />

      <!-- Registrations Tab -->
      <AdminRegistrationManagement v-if="activeTab === 'registrations'" />

      <!-- Partners Tab -->
      <AdminPartnerManagement v-if="activeTab === 'partners'" />
    </div>
  </div>
</template>

<script>
import { store } from '../store.js';
import axios from 'axios';

// Import admin components (will create these next)
import AdminEventManagement from '../components/admin/AdminEventManagement.vue';
import AdminAttendanceManagement from '../components/admin/AdminAttendanceManagement.vue';
import AdminCategoryManagement from '../components/admin/AdminCategoryManagement.vue';
import AdminUserManagement from '../components/admin/AdminUserManagement.vue';
import AdminRegistrationManagement from '../components/admin/AdminRegistrationManagement.vue';
import AdminPartnerManagement from '../components/admin/AdminPartnerManagement.vue';

// Icon components as inline templates
const DashboardIcon = {
  template: `<svg fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/></svg>`
};

const EventIcon = {
  template: `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>`
};

const CategoryIcon = {
  template: `<svg fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/></svg>`
};

const CheckIcon = {
  template: `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>`
};

const UserIcon = {
  template: `<svg fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/></svg>`
};

const RegistrationIcon = {
  template: `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>`
};

const PartnerIcon = {
  template: `<svg fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/></svg>`
};

const CalendarIcon = {
  template: `<svg fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>`
};

export default {
  name: 'AdminDashboard',
  components: {
    AdminEventManagement,
    AdminAttendanceManagement,
    AdminCategoryManagement,
    AdminUserManagement,
    AdminRegistrationManagement,
    AdminPartnerManagement,
    DashboardIcon,
    EventIcon,
    CategoryIcon,
    CheckIcon,
    UserIcon,
    RegistrationIcon,
    PartnerIcon,
    CalendarIcon
  },
  data() {
    return {
      store,
      loading: true,
      activeTab: 'overview',
      dashboardData: null,
      tabs: [
        {
          id: 'overview',
          name: 'Overview',
          icon: 'DashboardIcon'
        },
        {
          id: 'events',
          name: 'Events',
          icon: 'EventIcon'
        },
        {
          id: 'attendance',
          name: 'Attendance',
          icon: 'CheckIcon'
        },
        {
          id: 'categories',
          name: 'Categories',
          icon: 'CategoryIcon'
        },
        {
          id: 'users',
          name: 'Users',
          icon: 'UserIcon'
        },
        {
          id: 'registrations',
          name: 'Registrations',
          icon: 'RegistrationIcon'
        },
        {
          id: 'partners',
          name: 'Partners',
          icon: 'PartnerIcon'
        }
      ]
    };
  },
  computed: {
    roleColorClass() {
      switch (this.store.userRole) {
        case 'admin':
          return 'text-red-400';
        case 'librarian':
          return 'text-blue-400';
        case 'partner':
          return 'text-purple-400';
        default:
          return 'text-green-400';
      }
    },
    stats() {
      if (!this.dashboardData) return [];
      
      return [
        {
          title: 'Total Users',
          value: this.dashboardData.total_users || 0,
          icon: 'UserIcon',
          bgColor: 'bg-gradient-to-r from-blue-500 to-blue-600'
        },
        {
          title: 'Total Events',
          value: this.dashboardData.total_events || 0,
          icon: 'EventIcon',
          bgColor: 'bg-gradient-to-r from-green-500 to-green-600'
        },
        {
          title: 'Upcoming Events',
          value: this.dashboardData.upcoming_events || 0,
          icon: 'CalendarIcon',
          bgColor: 'bg-gradient-to-r from-orange-500 to-orange-600'
        },
        {
          title: 'Active Registrations',
          value: this.dashboardData.total_registrations || 0,
          icon: 'RegistrationIcon',
          bgColor: 'bg-gradient-to-r from-purple-500 to-purple-600'
        }
      ];
    }
  },
  async mounted() {
    // Check admin access
    if (!this.store.hasAdminPrivileges) {
      this.$router.push('/');
      return;
    }
    
    await this.fetchDashboardStats();
  },
  methods: {
    async fetchDashboardStats() {
      try {
        this.loading = true;
        const response = await axios.get('/api/admin/dashboard-stats');
        this.dashboardData = response.data;
      } catch (error) {
        console.error('Error fetching dashboard stats:', error);
      } finally {
        this.loading = false;
      }
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      });
    }
  }
};
</script>
