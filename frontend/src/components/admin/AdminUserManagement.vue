<template>
  <div class="space-y-6">
    <!-- Header -->
    <div>
      <h2 class="text-2xl font-bold text-white">User Management</h2>
      <p class="text-gray-400">Manage user accounts and roles</p>
    </div>

    <!-- Filters -->
    <div class="flex flex-wrap gap-4">
      <select v-model="filters.role" @change="fetchUsers" 
              class="px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        <option value="">All Roles</option>
        <option value="user">User</option>
        <option value="admin">Admin</option>
        <option value="librarian">Librarian</option>
        <option value="partner">Partner</option>
      </select>

      <input
        v-model="filters.search"
        @input="debouncedSearch"
        placeholder="Search users..."
        class="flex-1 min-w-[300px] px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
    </div>

    <!-- Users List -->
    <div v-if="loading" class="text-center py-12">
      <div class="inline-block w-8 h-8 border-4 border-blue-500/30 border-t-blue-500 rounded-full animate-spin"></div>
      <p class="text-gray-400 mt-4">Loading users...</p>
    </div>

    <div v-else-if="users.length === 0" class="text-center py-12">
      <div class="text-6xl mb-4">👥</div>
      <h3 class="text-xl font-semibold text-gray-300 mb-2">No Users Found</h3>
      <p class="text-gray-400">No users match your search criteria</p>
    </div>

    <div v-else class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl overflow-hidden">
      <!-- Table Header -->
      <div class="px-6 py-4 bg-gray-700/50 border-b border-gray-600">
        <div class="grid grid-cols-12 gap-4 text-sm font-semibold text-gray-300">
          <div class="col-span-4">User</div>
          <div class="col-span-2">Role</div>
          <div class="col-span-2">Registered</div>
          <div class="col-span-2">Events</div>
          <div class="col-span-2">Actions</div>
        </div>
      </div>

      <!-- Table Body -->
      <div class="divide-y divide-gray-700">
        <div v-for="user in users" :key="user.id" class="px-6 py-4 hover:bg-gray-700/30 transition-colors">
          <div class="grid grid-cols-12 gap-4 items-center">
            <!-- User Info -->
            <div class="col-span-4 flex items-center gap-3">
              <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full flex items-center justify-center">
                <span class="text-white font-bold text-sm">
                  {{ user.info?.firstname?.charAt(0) || user.email?.charAt(0) }}{{ user.info?.lastname?.charAt(0) || '' }}
                </span>
              </div>
              <div>
                <h4 class="text-white font-semibold">
                  {{ user.info?.firstname }} {{ user.info?.lastname || user.email }}
                </h4>
                <p class="text-gray-400 text-sm">{{ user.email }}</p>
              </div>
            </div>

            <!-- Role -->
            <div class="col-span-2">
              <span :class="getRoleBadgeClass(user.user_role)" class="px-3 py-1 rounded-full text-xs font-semibold">
                {{ user.user_role.charAt(0).toUpperCase() + user.user_role.slice(1) }}
              </span>
            </div>

            <!-- Registration Date -->
            <div class="col-span-2">
              <p class="text-gray-300 text-sm">{{ formatDate(user.created_at) }}</p>
            </div>

            <!-- Events Count -->
            <div class="col-span-2">
              <div class="text-center">
                <p class="text-white font-semibold">{{ user.event_registrations_count || 0 }}</p>
                <p class="text-gray-400 text-xs">Registrations</p>
              </div>
            </div>

            <!-- Actions -->
            <div class="col-span-2">
              <div class="flex gap-2">
                <button
                  @click="openRoleModal(user)"
                  class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-medium transition-colors">
                  Change Role
                </button>
                <button
                  @click="viewUserDetails(user)"
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
            Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }} users
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
                  ? 'bg-blue-600 text-white'
                  : 'bg-gray-600 text-gray-300 hover:bg-gray-500'
              ]">
              {{ page }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Change Role Modal -->
    <div v-if="showRoleModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 z-50">
      <div class="bg-gray-800 rounded-2xl p-6 w-full max-w-md">
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-2xl font-bold text-white">Change User Role</h3>
          <button @click="closeRoleModal" class="text-gray-400 hover:text-white">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
          </button>
        </div>

        <div v-if="selectedUser" class="space-y-6">
          <!-- User Info -->
          <div class="flex items-center gap-3 p-4 bg-gray-700/30 rounded-lg">
            <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full flex items-center justify-center">
              <span class="text-white font-bold text-sm">
                {{ selectedUser.info?.firstname?.charAt(0) || selectedUser.email?.charAt(0) }}{{ selectedUser.info?.lastname?.charAt(0) || '' }}
              </span>
            </div>
            <div>
              <h4 class="text-white font-semibold">
                {{ selectedUser.info?.firstname }} {{ selectedUser.info?.lastname || selectedUser.email }}
              </h4>
              <p class="text-gray-400 text-sm">{{ selectedUser.email }}</p>
            </div>
          </div>

          <form @submit.prevent="updateUserRole" class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-2">New Role</label>
              <select v-model="newRole" required
                      class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="user">User</option>
                <option value="admin">Admin</option>
                <option value="librarian">Librarian</option>
                <option value="partner">Partner</option>
              </select>
            </div>

            <div class="p-4 bg-yellow-500/10 border border-yellow-500/30 rounded-lg">
              <p class="text-yellow-400 text-sm">
                <strong>Current Role:</strong> {{ selectedUser.user_role.charAt(0).toUpperCase() + selectedUser.user_role.slice(1) }}
              </p>
              <p class="text-yellow-300 text-xs mt-1">
                Changing roles will affect the user's permissions immediately.
              </p>
            </div>

            <!-- Submit Buttons -->
            <div class="flex gap-4 pt-4">
              <button
                type="submit"
                :disabled="submitting || newRole === selectedUser.user_role"
                class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl font-semibold transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                <svg v-if="submitting" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                {{ submitting ? 'Updating...' : 'Update Role' }}
              </button>
              <button
                type="button"
                @click="closeRoleModal"
                class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-xl font-semibold transition-colors">
                Cancel
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- User Details Modal -->
    <div v-if="showDetailsModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 z-50">
      <div class="bg-gray-800 rounded-2xl p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-2xl font-bold text-white">User Details</h3>
          <button @click="showDetailsModal = false" class="text-gray-400 hover:text-white">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
          </button>
        </div>

        <div v-if="selectedUser" class="space-y-6">
          <!-- User Profile -->
          <div class="flex items-center gap-4 p-6 bg-gray-700/30 rounded-xl">
            <div class="w-16 h-16 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full flex items-center justify-center">
              <span class="text-white font-bold text-lg">
                {{ selectedUser.info?.firstname?.charAt(0) || selectedUser.email?.charAt(0) }}{{ selectedUser.info?.lastname?.charAt(0) || '' }}
              </span>
            </div>
            <div>
              <h4 class="text-2xl font-bold text-white">
                {{ selectedUser.info?.firstname }} {{ selectedUser.info?.lastname || selectedUser.email }}
              </h4>
              <p class="text-gray-400">{{ selectedUser.email }}</p>
              <span :class="getRoleBadgeClass(selectedUser.user_role)" class="inline-block px-3 py-1 rounded-full text-xs font-semibold mt-2">
                {{ selectedUser.user_role.charAt(0).toUpperCase() + selectedUser.user_role.slice(1) }}
              </span>
            </div>
          </div>

          <!-- User Stats -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gray-700/30 rounded-xl p-4 text-center">
              <div class="text-2xl font-bold text-blue-400">{{ selectedUser.event_registrations_count || 0 }}</div>
              <div class="text-gray-400 text-sm">Event Registrations</div>
            </div>
            <div class="bg-gray-700/30 rounded-xl p-4 text-center">
              <div class="text-2xl font-bold text-green-400">{{ selectedUser.created_events_count || 0 }}</div>
              <div class="text-gray-400 text-sm">Events Created</div>
            </div>
            <div class="bg-gray-700/30 rounded-xl p-4 text-center">
              <div class="text-2xl font-bold text-purple-400">{{ formatDate(selectedUser.created_at, true) }}</div>
              <div class="text-gray-400 text-sm">Member Since</div>
            </div>
          </div>

          <!-- Additional Info -->
          <div class="bg-gray-700/30 rounded-xl p-4">
            <h5 class="text-lg font-semibold text-white mb-3">Account Information</h5>
            <div class="space-y-2 text-sm">
              <div class="flex justify-between">
                <span class="text-gray-400">User ID:</span>
                <span class="text-white">{{ selectedUser.id }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-400">Email Verified:</span>
                <span :class="selectedUser.email_verified_at ? 'text-green-400' : 'text-red-400'">
                  {{ selectedUser.email_verified_at ? 'Yes' : 'No' }}
                </span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-400">Account Created:</span>
                <span class="text-white">{{ formatDate(selectedUser.created_at) }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-400">Last Updated:</span>
                <span class="text-white">{{ formatDate(selectedUser.updated_at) }}</span>
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
  name: 'AdminUserManagement',
  data() {
    return {
      loading: true,
      submitting: false,
      users: [],
      pagination: {},
      selectedUser: null,
      showRoleModal: false,
      showDetailsModal: false,
      newRole: '',
      filters: {
        role: '',
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
    await this.fetchUsers();
  },
  methods: {
    async fetchUsers(page = 1) {
      try {
        this.loading = true;
        const params = new URLSearchParams();
        
        if (this.filters.role) params.append('role', this.filters.role);
        if (this.filters.search) params.append('search', this.filters.search);
        params.append('page', page);
        
        const response = await axios.get(`/api/admin/users?${params.toString()}`);
        this.users = response.data.data;
        this.pagination = {
          current_page: response.data.current_page,
          last_page: response.data.last_page,
          from: response.data.from,
          to: response.data.to,
          total: response.data.total
        };
      } catch (error) {
        console.error('Error fetching users:', error);
        alert('Failed to load users');
      } finally {
        this.loading = false;
      }
    },

    async goToPage(page) {
      if (page !== '...' && page !== this.pagination.current_page) {
        await this.fetchUsers(page);
      }
    },

    openRoleModal(user) {
      this.selectedUser = user;
      this.newRole = user.user_role;
      this.showRoleModal = true;
    },

    closeRoleModal() {
      this.showRoleModal = false;
      this.selectedUser = null;
      this.newRole = '';
    },

    async updateUserRole() {
      try {
        this.submitting = true;
        
        // Get CSRF token
        await axios.get('/sanctum/csrf-cookie');
        
        await axios.put(`/api/admin/users/${this.selectedUser.id}/role`, {
          role: this.newRole
        });
        
        alert('User role updated successfully!');
        this.closeRoleModal();
        await this.fetchUsers(this.pagination.current_page);
      } catch (error) {
        console.error('Error updating user role:', error);
        alert('Failed to update user role: ' + (error.response?.data?.message || 'Unknown error'));
      } finally {
        this.submitting = false;
      }
    },

    viewUserDetails(user) {
      this.selectedUser = user;
      this.showDetailsModal = true;
    },

    debouncedSearch() {
      clearTimeout(this.searchTimeout);
      this.searchTimeout = setTimeout(() => {
        this.fetchUsers(1);
      }, 500);
    },

    getRoleBadgeClass(role) {
      const classes = {
        admin: 'bg-red-500/20 text-red-400',
        librarian: 'bg-blue-500/20 text-blue-400',
        partner: 'bg-purple-500/20 text-purple-400',
        user: 'bg-green-500/20 text-green-400'
      };
      return classes[role] || classes.user;
    },

    formatDate(dateString, shortYear = false) {
      const options = {
        year: shortYear ? '2-digit' : 'numeric',
        month: 'short',
        day: 'numeric'
      };
      return new Date(dateString).toLocaleDateString('en-US', options);
    }
  }
};
</script>
