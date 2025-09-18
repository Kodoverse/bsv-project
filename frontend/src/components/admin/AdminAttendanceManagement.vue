<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-gray-800 to-gray-900 border border-gray-700 rounded-2xl p-6">
      <h2 class="text-2xl font-bold text-white mb-4 flex items-center gap-3">
        <svg class="w-8 h-8 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
        </svg>
        Attendance Management
      </h2>
      <p class="text-gray-300">Confirm attendance for volunteer events and award points automatically.</p>
    </div>

    <!-- Volunteer Events List -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl p-6">
      <!-- Loading State -->
      <div v-if="loading" class="text-center py-12">
        <div class="inline-block w-8 h-8 border-4 border-orange-500/30 border-t-orange-500 rounded-full animate-spin"></div>
        <p class="text-gray-400 mt-4">Loading volunteer events...</p>
      </div>

      <!-- Events Grid -->
      <div v-else-if="volunteerEvents.length > 0" class="space-y-4">
        <h3 class="text-xl font-semibold text-white mb-4">Volunteer Events</h3>
        
        <div class="grid gap-4">
          <div v-for="event in volunteerEvents" :key="event.id" 
               class="bg-gray-700/50 border border-gray-600 rounded-xl p-6 hover:bg-gray-700/70 transition-colors">
            <div class="flex justify-between items-start mb-4">
              <div class="flex-1">
                <h4 class="text-lg font-semibold text-white mb-2">{{ event.title }}</h4>
                <p class="text-gray-400 text-sm mb-2">{{ formatDate(event.starts_at) }}</p>
                <div class="flex items-center gap-4 text-sm">
                  <span class="flex items-center gap-1 text-yellow-400">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    {{ event.volunteer_points || 0 }} points
                  </span>
                  <span class="text-gray-400">
                    {{ event.registrations_count || 0 }} registered
                  </span>
                </div>
              </div>
              <button @click="selectEvent(event)" 
                      class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-colors">
                Manage Attendance
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- No Events State -->
      <div v-else class="text-center py-12">
        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <p class="text-gray-400 text-lg">No volunteer events found</p>
        <p class="text-gray-500 text-sm mt-2">Create volunteer events to manage attendance and award points.</p>
      </div>
    </div>

    <!-- Attendance Management Modal -->
    <div v-if="showAttendanceModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-gray-800 rounded-2xl border border-gray-700 w-full max-w-4xl max-h-[90vh] overflow-hidden">
        <!-- Modal Header -->
        <div class="p-6 border-b border-gray-700">
          <div class="flex justify-between items-center">
            <div>
              <h3 class="text-xl font-bold text-white">{{ selectedEvent?.title }}</h3>
              <p class="text-gray-400 text-sm mt-1">Attendance Management</p>
            </div>
            <button @click="closeAttendanceModal" 
                    class="text-gray-400 hover:text-white transition-colors">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
        </div>

        <!-- Modal Body -->
        <div class="p-6 overflow-y-auto max-h-[70vh]">
          <!-- Loading State -->
          <div v-if="loadingAttendance" class="text-center py-12">
            <div class="inline-block w-8 h-8 border-4 border-orange-500/30 border-t-orange-500 rounded-full animate-spin"></div>
            <p class="text-gray-400 mt-4">Loading attendance data...</p>
          </div>

          <!-- Attendance Summary -->
          <div v-else-if="attendanceData" class="space-y-6">
            <!-- Summary Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
              <div class="bg-blue-500/20 border border-blue-500/30 rounded-lg p-4">
                <p class="text-blue-400 text-sm font-medium">Total Registered</p>
                <p class="text-2xl font-bold text-white">{{ attendanceData.summary.total_registered }}</p>
              </div>
              <div class="bg-green-500/20 border border-green-500/30 rounded-lg p-4">
                <p class="text-green-400 text-sm font-medium">Attended</p>
                <p class="text-2xl font-bold text-white">{{ attendanceData.summary.attended }}</p>
              </div>
              <div class="bg-red-500/20 border border-red-500/30 rounded-lg p-4">
                <p class="text-red-400 text-sm font-medium">No Show</p>
                <p class="text-2xl font-bold text-white">{{ attendanceData.summary.no_show }}</p>
              </div>
              <div class="bg-yellow-500/20 border border-yellow-500/30 rounded-lg p-4">
                <p class="text-yellow-400 text-sm font-medium">Pending</p>
                <p class="text-2xl font-bold text-white">{{ attendanceData.summary.pending }}</p>
              </div>
            </div>

            <!-- Event Info -->
            <div class="bg-gray-700/30 rounded-lg p-4 flex items-center justify-between">
              <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <span class="text-white font-medium">Points per attendance: {{ selectedEvent?.volunteer_points || 0 }}</span>
              </div>
              <div class="text-sm text-gray-400">
                {{ formatDate(selectedEvent?.starts_at) }}
              </div>
            </div>

            <!-- Bulk Actions -->
            <div class="flex gap-4 mb-6">
              <button @click="bulkMarkAttended" 
                      :disabled="bulkUpdating"
                      class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors disabled:opacity-50">
                {{ bulkUpdating ? 'Processing...' : 'Mark All Attended' }}
              </button>
              <button @click="bulkMarkNoShow" 
                      :disabled="bulkUpdating"
                      class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors disabled:opacity-50">
                {{ bulkUpdating ? 'Processing...' : 'Mark All No Show' }}
              </button>
            </div>

            <!-- Participants List -->
            <div class="space-y-3">
              <h4 class="text-lg font-semibold text-white">Participants</h4>
              
              <div v-for="registration in attendanceData.registrations" :key="registration.id" 
                   class="bg-gray-700/50 border border-gray-600 rounded-lg p-4">
                <div class="flex items-center justify-between">
                  <div class="flex-1">
                    <div class="flex items-center gap-3">
                      <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center text-white font-semibold">
                        {{ getInitials(registration.user) }}
                      </div>
                      <div>
                        <p class="text-white font-medium">{{ getUserName(registration.user) }}</p>
                        <p class="text-gray-400 text-sm">{{ registration.user.email }}</p>
                        <p class="text-gray-500 text-xs">Registered: {{ formatDate(registration.created_at) }}</p>
                      </div>
                    </div>
                  </div>
                  
                  <div class="flex items-center gap-3">
                    <!-- Status Badge -->
                    <span :class="[
                      'px-3 py-1 rounded-full text-xs font-semibold',
                      registration.status === 'attended' ? 'bg-green-500/20 text-green-400 border border-green-500/30' :
                      registration.status === 'no_show' ? 'bg-red-500/20 text-red-400 border border-red-500/30' :
                      'bg-yellow-500/20 text-yellow-400 border border-yellow-500/30'
                    ]">
                      {{ registration.status === 'registered' ? 'Pending' : 
                         registration.status === 'attended' ? 'Attended' : 'No Show' }}
                    </span>
                    
                    <!-- Points Status -->
                    <span v-if="registration.points_awarded" 
                          class="px-2 py-1 bg-yellow-500/20 text-yellow-400 rounded-full text-xs flex items-center gap-1">
                      <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                      </svg>
                      {{ registration.potential_points }}
                    </span>
                    
                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                      <button @click="markAttended(registration)" 
                              :disabled="updatingRegistration === registration.id"
                              :class="[
                                'px-3 py-1 rounded-lg text-sm font-medium transition-colors',
                                registration.status === 'attended' 
                                  ? 'bg-green-500 text-white' 
                                  : 'bg-gray-600 text-gray-300 hover:bg-green-500 hover:text-white'
                              ]">
                        {{ updatingRegistration === registration.id ? '...' : 'Present' }}
                      </button>
                      <button @click="markNoShow(registration)" 
                              :disabled="updatingRegistration === registration.id"
                              :class="[
                                'px-3 py-1 rounded-lg text-sm font-medium transition-colors',
                                registration.status === 'no_show' 
                                  ? 'bg-red-500 text-white' 
                                  : 'bg-gray-600 text-gray-300 hover:bg-red-500 hover:text-white'
                              ]">
                        {{ updatingRegistration === registration.id ? '...' : 'Absent' }}
                      </button>
                    </div>
                  </div>
                </div>
                
                <!-- Notes -->
                <div v-if="registration.notes" class="mt-3 p-3 bg-gray-800/50 rounded-lg">
                  <p class="text-gray-300 text-sm">
                    <span class="text-gray-400 font-medium">Notes:</span> {{ registration.notes }}
                  </p>
                </div>
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
  name: 'AdminAttendanceManagement',
  data() {
    return {
      loading: true,
      volunteerEvents: [],
      showAttendanceModal: false,
      selectedEvent: null,
      attendanceData: null,
      loadingAttendance: false,
      updatingRegistration: null,
      bulkUpdating: false
    };
  },
  async mounted() {
    await this.fetchVolunteerEvents();
  },
  methods: {
    async fetchVolunteerEvents() {
      try {
        this.loading = true;
        const response = await axios.get('/api/admin/events', {
          params: {
            is_volunteer_event: true,
            status: 'upcoming,finished' // Include both upcoming and finished events
          }
        });
        
        console.log('API Response:', response.data);
        console.log('Volunteer Events Found:', response.data.data || response.data);
        
        this.volunteerEvents = response.data.data || response.data;
        
        if (Array.isArray(this.volunteerEvents)) {
          console.log('Total volunteer events:', this.volunteerEvents.length);
          this.volunteerEvents.forEach(event => {
            console.log(`Event: ${event.title}, Volunteer: ${event.is_volunteer_event}, Points: ${event.volunteer_points}`);
          });
        }
      } catch (error) {
        console.error('Error fetching volunteer events:', error);
        this.$toast?.error?.('Failed to fetch volunteer events');
      } finally {
        this.loading = false;
      }
    },

    async selectEvent(event) {
      this.selectedEvent = event;
      this.showAttendanceModal = true;
      await this.fetchAttendanceData(event.id);
    },

    async fetchAttendanceData(eventId) {
      try {
        this.loadingAttendance = true;
        const response = await axios.get(`/api/admin/events/${eventId}/attendance`);
        this.attendanceData = response.data;
      } catch (error) {
        console.error('Error fetching attendance data:', error);
        this.$toast?.error?.('Failed to fetch attendance data');
      } finally {
        this.loadingAttendance = false;
      }
    },

    async markAttended(registration) {
      try {
        this.updatingRegistration = registration.id;
        
        await axios.post(`/api/admin/events/${this.selectedEvent.id}/attendance`, {
          user_id: registration.user_id,
          attended: true
        });

        // Update local state
        registration.status = 'attended';
        registration.points_awarded = true;
        
        // Update summary
        this.attendanceData.summary.attended++;
        if (registration.status === 'registered') {
          this.attendanceData.summary.pending--;
        } else if (registration.status === 'no_show') {
          this.attendanceData.summary.no_show--;
        }

        this.$toast?.success?.(`${this.getUserName(registration.user)} marked as attended`);
      } catch (error) {
        console.error('Error marking attendance:', error);
        this.$toast?.error?.('Failed to mark attendance');
      } finally {
        this.updatingRegistration = null;
      }
    },

    async markNoShow(registration) {
      try {
        this.updatingRegistration = registration.id;
        
        await axios.post(`/api/admin/events/${this.selectedEvent.id}/attendance`, {
          user_id: registration.user_id,
          attended: false
        });

        // Update local state
        const previousStatus = registration.status;
        registration.status = 'no_show';
        registration.points_awarded = false;
        
        // Update summary
        this.attendanceData.summary.no_show++;
        if (previousStatus === 'registered') {
          this.attendanceData.summary.pending--;
        } else if (previousStatus === 'attended') {
          this.attendanceData.summary.attended--;
        }

        this.$toast?.success?.(`${this.getUserName(registration.user)} marked as no show`);
      } catch (error) {
        console.error('Error marking no show:', error);
        this.$toast?.error?.('Failed to mark no show');
      } finally {
        this.updatingRegistration = null;
      }
    },

    async bulkMarkAttended() {
      if (!confirm('Mark all participants as attended? This will award points to all registered users.')) {
        return;
      }

      try {
        this.bulkUpdating = true;
        const attendances = this.attendanceData.registrations.map(reg => ({
          user_id: reg.user_id,
          attended: true
        }));

        await axios.post(`/api/admin/events/${this.selectedEvent.id}/attendance/bulk`, {
          attendances
        });

        // Refresh attendance data
        await this.fetchAttendanceData(this.selectedEvent.id);
        this.$toast?.success?.('All participants marked as attended');
      } catch (error) {
        console.error('Error bulk updating attendance:', error);
        this.$toast?.error?.('Failed to update attendance');
      } finally {
        this.bulkUpdating = false;
      }
    },

    async bulkMarkNoShow() {
      if (!confirm('Mark all participants as no show? This will remove any awarded points.')) {
        return;
      }

      try {
        this.bulkUpdating = true;
        const attendances = this.attendanceData.registrations.map(reg => ({
          user_id: reg.user_id,
          attended: false
        }));

        await axios.post(`/api/admin/events/${this.selectedEvent.id}/attendance/bulk`, {
          attendances
        });

        // Refresh attendance data
        await this.fetchAttendanceData(this.selectedEvent.id);
        this.$toast?.success?.('All participants marked as no show');
      } catch (error) {
        console.error('Error bulk updating attendance:', error);
        this.$toast?.error?.('Failed to update attendance');
      } finally {
        this.bulkUpdating = false;
      }
    },

    closeAttendanceModal() {
      this.showAttendanceModal = false;
      this.selectedEvent = null;
      this.attendanceData = null;
    },

    formatDate(dateString) {
      if (!dateString) return '';
      const date = new Date(dateString);
      return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
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
