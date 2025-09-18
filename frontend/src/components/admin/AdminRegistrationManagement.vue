<template>
  <div class="space-y-6">
    <!-- Header -->
    <div>
      <h2 class="text-2xl font-bold text-white">Registration Management</h2>
      <p class="text-gray-400">View and manage event registrations</p>
    </div>

    <!-- Filters -->
    <div class="flex flex-wrap gap-4">
      <select v-model="filters.event" @change="fetchRegistrations" 
              class="px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
        <option value="">All Events</option>
        <option v-for="event in events" :key="event.id" :value="event.id">
          {{ event.title }}
        </option>
      </select>

      <select v-model="filters.status" @change="fetchRegistrations"
              class="px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
        <option value="">All Status</option>
        <option value="registered">Registered</option>
        <option value="cancelled">Cancelled</option>
        <option value="attended">Attended</option>
        <option value="no_show">No Show</option>
      </select>

      <input
        v-model="filters.search"
        @input="debouncedSearch"
        placeholder="Search by user name or email..."
        class="flex-1 min-w-[300px] px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-orange-500 focus:border-transparent">
    </div>

    <!-- Registration Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-xl p-4">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-400 text-sm">Total Registrations</p>
            <p class="text-2xl font-bold text-white">{{ stats.total || 0 }}</p>
          </div>
          <div class="p-2 bg-blue-500/20 rounded-lg">
            <svg class="w-6 h-6 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-xl p-4">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-400 text-sm">Active</p>
            <p class="text-2xl font-bold text-green-400">{{ stats.registered || 0 }}</p>
          </div>
          <div class="p-2 bg-green-500/20 rounded-lg">
            <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-xl p-4">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-400 text-sm">Attended</p>
            <p class="text-2xl font-bold text-blue-400">{{ stats.attended || 0 }}</p>
          </div>
          <div class="p-2 bg-blue-500/20 rounded-lg">
            <svg class="w-6 h-6 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
            </svg>
          </div>
        </div>
      </div>

      <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-xl p-4">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-400 text-sm">Cancelled</p>
            <p class="text-2xl font-bold text-red-400">{{ stats.cancelled || 0 }}</p>
          </div>
          <div class="p-2 bg-red-500/20 rounded-lg">
            <svg class="w-6 h-6 text-red-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
          </div>
        </div>
      </div>
    </div>

    <!-- Registrations List -->
    <div v-if="loading" class="text-center py-12">
      <div class="inline-block w-8 h-8 border-4 border-orange-500/30 border-t-orange-500 rounded-full animate-spin"></div>
      <p class="text-gray-400 mt-4">Loading registrations...</p>
    </div>

    <div v-else-if="registrations.length === 0" class="text-center py-12">
      <div class="text-6xl mb-4">📋</div>
      <h3 class="text-xl font-semibold text-gray-300 mb-2">No Registrations Found</h3>
      <p class="text-gray-400">No registrations match your search criteria</p>
    </div>

    <div v-else class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl overflow-hidden">
      <!-- Table Header -->
      <div class="px-6 py-4 bg-gray-700/50 border-b border-gray-600">
        <div class="grid grid-cols-12 gap-4 text-sm font-semibold text-gray-300">
          <div class="col-span-3">User</div>
          <div class="col-span-3">Event</div>
          <div class="col-span-2">Status</div>
          <div class="col-span-2">Registered</div>
          <div class="col-span-2">Actions</div>
        </div>
      </div>

      <!-- Table Body -->
      <div class="divide-y divide-gray-700">
        <div v-for="registration in registrations" :key="registration.id" class="px-6 py-4 hover:bg-gray-700/30 transition-colors">
          <div class="grid grid-cols-12 gap-4 items-center">
            <!-- User Info -->
            <div class="col-span-3 flex items-center gap-3">
              <div class="w-10 h-10 bg-gradient-to-r from-orange-400 to-red-400 rounded-full flex items-center justify-center">
                <span class="text-white font-bold text-sm">
                  {{ registration.user?.info?.firstname?.charAt(0) || registration.user?.email?.charAt(0) }}{{ registration.user?.info?.lastname?.charAt(0) || '' }}
                </span>
              </div>
              <div>
                <h4 class="text-white font-semibold text-sm">
                  {{ registration.user?.info?.firstname }} {{ registration.user?.info?.lastname || registration.user?.email }}
                </h4>
                <p class="text-gray-400 text-xs">{{ registration.user?.email }}</p>
              </div>
            </div>

            <!-- Event Info -->
            <div class="col-span-3">
              <h4 class="text-white font-semibold text-sm line-clamp-1">{{ registration.event?.title }}</h4>
              <p class="text-gray-400 text-xs">{{ registration.event?.category?.name }}</p>
              <p class="text-gray-500 text-xs">{{ formatDate(registration.event?.starts_at) }}</p>
            </div>

            <!-- Status -->
            <div class="col-span-2">
              <span :class="getStatusBadgeClass(registration.status)" class="px-2 py-1 rounded-full text-xs font-semibold">
                {{ registration.status.charAt(0).toUpperCase() + registration.status.slice(1) }}
              </span>
            </div>

            <!-- Registration Date -->
            <div class="col-span-2">
              <p class="text-gray-300 text-sm">{{ formatDate(registration.created_at) }}</p>
            </div>

            <!-- Actions -->
            <div class="col-span-2">
              <div class="flex gap-2">
                <button
                  @click="openStatusModal(registration)"
                  class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-medium transition-colors">
                  Update Status
                </button>
                <button
                  @click="viewRegistrationDetails(registration)"
                  class="px-3 py-1 bg-gray-600 hover:bg-gray-700 text-white rounded-lg text-xs font-medium transition-colors">
                  View
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div v-if="pagination.last_page > 1" class="px-6 py-4 bg-gray-700/50 border-t border-gray-600">
        <div class="flex items-center justify-between">
          <p class="text-gray-400 text-sm">
            Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} registrations
          </p>
          <div class="flex gap-2">
            <button
              v-for="page in visiblePages"
              :key="page"
              @click="goToPage(page)"
              :disabled="page === pagination.current_page"
              :class="[
                'px-3 py-1 rounded text-sm font-medium transition-colors',
                page === pagination.current_page
                  ? 'bg-orange-600 text-white'
                  : 'bg-gray-600 text-gray-300 hover:bg-gray-500'
              ]">
              {{ page }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Update Status Modal -->
    <div v-if="showStatusModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 z-50">
      <div class="bg-gray-800 rounded-2xl p-6 w-full max-w-md">
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-2xl font-bold text-white">Update Registration Status</h3>
          <button @click="closeStatusModal" class="text-gray-400 hover:text-white">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
          </button>
        </div>

        <div v-if="selectedRegistration" class="space-y-6">
          <!-- Registration Info -->
          <div class="p-4 bg-gray-700/30 rounded-lg">
            <div class="flex items-center gap-3 mb-3">
              <div class="w-10 h-10 bg-gradient-to-r from-orange-400 to-red-400 rounded-full flex items-center justify-center">
                <span class="text-white font-bold text-sm">
                  {{ selectedRegistration.user?.info?.firstname?.charAt(0) || selectedRegistration.user?.email?.charAt(0) }}{{ selectedRegistration.user?.info?.lastname?.charAt(0) || '' }}
                </span>
              </div>
              <div>
                <h4 class="text-white font-semibold">
                  {{ selectedRegistration.user?.info?.firstname }} {{ selectedRegistration.user?.info?.lastname || selectedRegistration.user?.email }}
                </h4>
                <p class="text-gray-400 text-sm">{{ selectedRegistration.event?.title }}</p>
              </div>
            </div>
            <p class="text-gray-300 text-sm">
              <strong>Current Status:</strong> 
              <span :class="getStatusBadgeClass(selectedRegistration.status)" class="ml-2 px-2 py-1 rounded-full text-xs font-semibold">
                {{ selectedRegistration.status.charAt(0).toUpperCase() + selectedRegistration.status.slice(1) }}
              </span>
            </p>
          </div>

          <form @submit.prevent="updateRegistrationStatus" class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-2">New Status</label>
              <select v-model="newStatus" required
                      class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                <option value="registered">Registered</option>
                <option value="attended">Attended</option>
                <option value="no_show">No Show</option>
                <option value="cancelled">Cancelled</option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-300 mb-2">Notes (Optional)</label>
              <textarea v-model="statusNotes" rows="3"
                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        placeholder="Add any notes about this status change..."></textarea>
            </div>

            <!-- Submit Buttons -->
            <div class="flex gap-4 pt-4">
              <button
                type="submit"
                :disabled="submitting || newStatus === selectedRegistration.status"
                class="flex-1 px-6 py-3 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white rounded-xl font-semibold transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                <svg v-if="submitting" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ submitting ? 'Updating...' : 'Update Status' }}
              </button>
              <button
                type="button"
                @click="closeStatusModal"
                class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-xl font-semibold transition-colors">
                Cancel
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Registration Details Modal -->
    <div v-if="showDetailsModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 z-50">
      <div class="bg-gray-800 rounded-2xl p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-2xl font-bold text-white">Registration Details</h3>
          <button @click="showDetailsModal = false" class="text-gray-400 hover:text-white">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
          </button>
        </div>

        <div v-if="selectedRegistration" class="space-y-6">
          <!-- User and Event Info -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-700/30 rounded-xl p-4">
              <h5 class="text-lg font-semibold text-white mb-3">User Information</h5>
              <div class="flex items-center gap-3 mb-3">
                <div class="w-12 h-12 bg-gradient-to-r from-orange-400 to-red-400 rounded-full flex items-center justify-center">
                  <span class="text-white font-bold">
                    {{ selectedRegistration.user?.info?.firstname?.charAt(0) || selectedRegistration.user?.email?.charAt(0) }}{{ selectedRegistration.user?.info?.lastname?.charAt(0) || '' }}
                  </span>
                </div>
                <div>
                  <h4 class="text-white font-semibold">
                    {{ selectedRegistration.user?.info?.firstname }} {{ selectedRegistration.user?.info?.lastname || selectedRegistration.user?.email }}
                  </h4>
                  <p class="text-gray-400 text-sm">{{ selectedRegistration.user?.email }}</p>
                </div>
              </div>
              <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                  <span class="text-gray-400">User Role:</span>
                  <span class="text-white">{{ selectedRegistration.user?.user_role || 'User' }}</span>
                </div>
              </div>
            </div>

            <div class="bg-gray-700/30 rounded-xl p-4">
              <h5 class="text-lg font-semibold text-white mb-3">Event Information</h5>
              <div class="space-y-2">
                <h4 class="text-white font-semibold">{{ selectedRegistration.event?.title }}</h4>
                <p class="text-gray-400 text-sm">{{ selectedRegistration.event?.description }}</p>
                <div class="space-y-1 text-sm">
                  <div class="flex justify-between">
                    <span class="text-gray-400">Category:</span>
                    <span class="text-white">{{ selectedRegistration.event?.category?.name }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-400">Date:</span>
                    <span class="text-white">{{ formatDate(selectedRegistration.event?.starts_at) }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-400">Location:</span>
                    <span class="text-white">{{ selectedRegistration.event?.location || 'TBD' }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Registration Details -->
          <div class="bg-gray-700/30 rounded-xl p-4">
            <h5 class="text-lg font-semibold text-white mb-3">Registration Details</h5>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
              <div class="flex justify-between">
                <span class="text-gray-400">Registration ID:</span>
                <span class="text-white">{{ selectedRegistration.id }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-400">Status:</span>
                <span :class="getStatusBadgeClass(selectedRegistration.status)" class="px-2 py-1 rounded-full text-xs font-semibold">
                  {{ selectedRegistration.status.charAt(0).toUpperCase() + selectedRegistration.status.slice(1) }}
                </span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-400">Registered At:</span>
                <span class="text-white">{{ formatDate(selectedRegistration.created_at, true) }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-400">Last Updated:</span>
                <span class="text-white">{{ formatDate(selectedRegistration.updated_at, true) }}</span>
              </div>
            </div>
            <div v-if="selectedRegistration.notes" class="mt-4">
              <span class="text-gray-400 text-sm">Notes:</span>
              <p class="text-white mt-1">{{ selectedRegistration.notes }}</p>
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
  name: 'AdminRegistrationManagement',
  data() {
    return {
      loading: true,
      submitting: false,
      registrations: [],
      events: [],
      pagination: {},
      stats: {},
      selectedRegistration: null,
      showStatusModal: false,
      showDetailsModal: false,
      newStatus: '',
      statusNotes: '',
      filters: {
        event: '',
        status: '',
        search: ''
      },
      searchTimeout: null
    };
  },
  computed: {
    visiblePages() {
      const pages = [];
      const current = this.pagination.current_page;
      const last = this.pagination.last_page;
      
      // Always show first page
      if (current > 3) pages.push(1);
      if (current > 4) pages.push('...');
      
      // Show pages around current
      for (let i = Math.max(1, current - 2); i <= Math.min(last, current + 2); i++) {
        pages.push(i);
      }
      
      // Always show last page
      if (current < last - 3) pages.push('...');
      if (current < last - 2) pages.push(last);
      
      return pages;
    }
  },
  async mounted() {
    await Promise.all([
      this.fetchRegistrations(),
      this.fetchEvents(),
      this.fetchStats()
    ]);
  },
  methods: {
    async fetchRegistrations(page = 1) {
      try {
        this.loading = true;
        const params = new URLSearchParams();
        
        if (this.filters.event) params.append('event_id', this.filters.event);
        if (this.filters.status) params.append('status', this.filters.status);
        if (this.filters.search) params.append('search', this.filters.search);
        params.append('page', page);
        
        const response = await axios.get(`/api/event-registrations?${params.toString()}`);
        this.registrations = response.data.data;
        this.pagination = {
          current_page: response.data.current_page,
          last_page: response.data.last_page,
          from: response.data.from,
          to: response.data.to,
          total: response.data.total
        };
      } catch (error) {
        console.error('Error fetching registrations:', error);
        alert('Failed to load registrations');
      } finally {
        this.loading = false;
      }
    },

    async fetchEvents() {
      try {
        const response = await axios.get('/api/events');
        this.events = response.data.data || response.data;
      } catch (error) {
        console.error('Error fetching events:', error);
      }
    },

    async fetchStats() {
      try {
        const response = await axios.get('/api/admin/dashboard-stats');
        // Calculate stats from response
        this.stats = {
          total: response.data.total_registrations || 0,
          registered: response.data.total_registrations || 0, // Assuming these are active
          attended: 0, // Would need separate endpoint for this
          cancelled: 0 // Would need separate endpoint for this
        };
      } catch (error) {
        console.error('Error fetching stats:', error);
      }
    },

    async goToPage(page) {
      if (page !== '...' && page !== this.pagination.current_page) {
        await this.fetchRegistrations(page);
      }
    },

    openStatusModal(registration) {
      this.selectedRegistration = registration;
      this.newStatus = registration.status;
      this.statusNotes = registration.notes || '';
      this.showStatusModal = true;
    },

    closeStatusModal() {
      this.showStatusModal = false;
      this.selectedRegistration = null;
      this.newStatus = '';
      this.statusNotes = '';
    },

    async updateRegistrationStatus() {
      try {
        this.submitting = true;
        
        // Get CSRF token
        await axios.get('/sanctum/csrf-cookie');
        
        await axios.put(`/api/event-registrations/${this.selectedRegistration.id}/status`, {
          status: this.newStatus,
          notes: this.statusNotes
        });
        
        alert('Registration status updated successfully!');
        this.closeStatusModal();
        await this.fetchRegistrations(this.pagination.current_page);
        await this.fetchStats();
      } catch (error) {
        console.error('Error updating registration status:', error);
        alert('Failed to update registration status: ' + (error.response?.data?.message || 'Unknown error'));
      } finally {
        this.submitting = false;
      }
    },

    viewRegistrationDetails(registration) {
      this.selectedRegistration = registration;
      this.showDetailsModal = true;
    },

    debouncedSearch() {
      clearTimeout(this.searchTimeout);
      this.searchTimeout = setTimeout(() => {
        this.fetchRegistrations(1);
      }, 500);
    },

    getStatusBadgeClass(status) {
      const classes = {
        registered: 'bg-green-500/20 text-green-400',
        cancelled: 'bg-red-500/20 text-red-400',
        attended: 'bg-blue-500/20 text-blue-400',
        no_show: 'bg-gray-500/20 text-gray-400'
      };
      return classes[status] || classes.registered;
    },

    formatDate(dateString, includeTime = false) {
      const options = {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      };
      
      if (includeTime) {
        options.hour = '2-digit';
        options.minute = '2-digit';
      }
      
      return new Date(dateString).toLocaleDateString('en-US', options);
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
</style>
