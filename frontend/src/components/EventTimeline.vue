<template>
  <div class="w-full py-8 overflow-x-hidden">
    <div class="w-full px-3 sm:px-4 md:px-6 lg:px-8 space-y-6 md:space-y-8 max-w-full">
      <!-- Loading State -->
      <div v-if="loading" class="text-center py-12">
        <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-orange-500"></div>
        <p class="mt-4 text-gray-400">Loading events...</p>
      </div>

      <!-- Error State -->
      <div v-else-if="error" class="text-center py-12">
        <div class="bg-red-900/20 rounded-lg p-8 max-w-md mx-auto">
          <h3 class="text-xl font-semibold mb-2 text-red-500">Error Loading Events</h3>
          <p class="text-gray-400 mb-4">{{ error }}</p>
          <button @click="fetchEvents" 
                  class="px-4 py-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors">
            Try Again
          </button>
        </div>
      </div>

      <!-- No Events Message -->
      <div v-else-if="filteredEvents.length === 0" class="text-center py-12">
        <div class="bg-gray-800/50 rounded-lg p-8 max-w-md mx-auto">
          <h3 class="text-xl font-semibold mb-2">No Events Found</h3>
          <p class="text-gray-400">{{ getNoEventsMessage() }}</p>
        </div>
      </div>

      <!-- Events List -->
      <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 w-full max-w-full">
        <div v-for="event in filteredEvents" :key="event.id"
             class="bg-gradient-to-b from-gray-800 to-gray-900 rounded-2xl overflow-hidden transform transition-all duration-500 hover:scale-[1.03] hover:shadow-2xl hover:shadow-orange-500/20 border border-gray-700 hover:border-orange-500/30 group w-full max-w-full">
          
          <!-- Event Image -->
          <div class="h-48 sm:h-52 md:h-56 lg:h-60 overflow-hidden relative">
            <img v-if="event.image_url" :src="event.image_url" 
                 :alt="event.title"
                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                 @error="handleImageError(event)"
                 @load="handleImageLoad(event)">
            <div v-else class="w-full h-full bg-gradient-to-br from-orange-500 via-pink-500 to-purple-600 flex items-center justify-center relative">
              <div class="absolute inset-0 bg-black/20"></div>
              <span class="text-2xl sm:text-3xl md:text-4xl font-bold text-white opacity-90 z-10">{{ event.title.charAt(0) }}</span>
            </div>
            <!-- Overlay gradient -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
          </div>

          <!-- Event Content -->
          <div class="p-5 sm:p-6 md:p-7 lg:p-8 bg-gradient-to-b from-gray-800/50 to-gray-900/50">
            <!-- Status and Registration Count -->
            <div class="flex justify-between items-center mb-3 sm:mb-4">
              <div class="flex items-center gap-2">
                <span :class="[
                  'px-3 py-1.5 rounded-full text-xs font-semibold shadow-lg border',
                  getStatusClass(event.status)
                ]">
                  {{ formatStatus(event.status) }}
                </span>
                <!-- Volunteer Points Badge -->
                <span v-if="event.is_volunteer_event && event.volunteer_points" 
                      class="px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-yellow-500/20 to-amber-500/20 text-yellow-400 border border-yellow-500/30 flex items-center gap-1">
                  <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                  </svg>
                  {{ event.volunteer_points }} pts
                </span>
              </div>
              <div class="flex items-center text-xs sm:text-sm text-gray-300 bg-gray-700/50 px-2 py-1 rounded-full">
                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"/>
                </svg>
                {{ event.registrations_count || 0 }}
              </div>
            </div>

            <!-- Title -->
            <h3 class="text-base sm:text-lg md:text-xl lg:text-2xl font-bold text-white mb-3 line-clamp-2 group-hover:text-orange-400 transition-colors duration-300 break-words">{{ event.title }}</h3>

            <!-- Description -->
            <p class="text-gray-300 text-sm sm:text-base mb-4 line-clamp-3 leading-relaxed break-words">{{ event.description }}</p>

            <!-- Date and Time -->
            <div class="mb-5 bg-gray-700/30 px-4 py-3 rounded-lg border border-gray-600/50 h-16 flex items-center">
              <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-3 text-orange-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
              </svg>
              <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 text-sm sm:text-base text-gray-300">
                  <span class="font-medium truncate">{{ formatDate(event.starts_at) }}</span>
                  <span class="text-gray-500 flex-shrink-0">•</span>
                  <span class="text-xs sm:text-sm text-gray-400 truncate">{{ formatTime(event.starts_at) }} - {{ formatTime(event.ends_at) }}</span>
                </div>
              </div>
            </div>

            <!-- Registration Button -->
            <button v-if="canRegister(event)"
                    @click="registerForEvent(event.id)"
                    :disabled="isRegistering(event.id)"
                    :class="[
                      'w-full px-6 py-4 text-white rounded-xl text-sm sm:text-base font-semibold transition-all duration-300 flex items-center justify-center gap-3 border',
                      isRegistering(event.id) 
                        ? 'bg-gray-500 border-gray-400/20 cursor-not-allowed' 
                        : 'bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 hover:scale-105 hover:shadow-lg hover:shadow-orange-500/30 border-orange-400/20'
                    ]">
              <svg v-if="isRegistering(event.id)" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              <svg v-else class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
              </svg>
              {{ isRegistering(event.id) ? 'Registering...' : 'Register Now' }}
            </button>
              <button v-else-if="isRegistered(event.id)"
                      @click="unregisterFromEvent(event.id)"
                      :disabled="isUnregistering(event.id)"
                      :class="[
                        'w-full flex items-center justify-center gap-3 px-6 py-4 rounded-xl text-sm sm:text-base font-semibold border transition-all duration-300',
                        isUnregistering(event.id)
                          ? 'bg-gray-500/20 text-gray-400 border-gray-500/30 cursor-not-allowed'
                          : 'bg-gradient-to-r from-green-500/20 to-emerald-500/20 text-green-400 border-green-500/30 hover:from-red-500/20 hover:to-red-600/20 hover:text-red-400 hover:border-red-500/30 hover:scale-105'
                      ]">
                <svg v-if="isUnregistering(event.id)" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <svg v-else class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                {{ isUnregistering(event.id) ? 'Cancelling...' : 'Registered - Click to Cancel' }}
              </button>
            <span v-else
                  class="w-full flex items-center justify-center gap-3 px-6 py-4 bg-gradient-to-r from-gray-600/20 to-gray-700/20 text-gray-400 rounded-xl text-sm sm:text-base font-semibold border border-gray-600/30">
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
              </svg>
              {{ getButtonText(event) }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { store } from '../store';

export default {
  name: 'EventTimeline',
  props: {
    categoryId: {
      type: [Number, String],
      required: true
    },
    filter: {
      type: String,
      default: 'all'
    }
  },
  data() {
    return {
      events: [],
      registeredEvents: new Set(),
      loading: true,
      error: null,
      registeringEvents: new Set(),
      unregisteringEvents: new Set()
    };
  },
  computed: {
    filteredEvents() {
      const now = new Date();
      let filtered = this.events.map((event, index) => ({ ...event, index }));

      switch (this.filter) {
        case 'upcoming':
          filtered = filtered.filter(event => new Date(event.starts_at) > now && event.status !== 'cancelled');
          break;
        case 'past':
          filtered = filtered.filter(event => new Date(event.starts_at) < now || event.status === 'cancelled');
          break;
        case 'registered':
          console.log('Filtering registered events. Registered IDs:', Array.from(this.registeredEvents));
          filtered = filtered.filter(event => {
            const isReg = this.isRegistered(event.id);
            console.log(`Event ${event.id} (${event.title}) is registered: ${isReg}`);
            return isReg;
          });
          break;
      }

      return filtered.sort((a, b) => new Date(b.starts_at) - new Date(a.starts_at));
    }
  },
  methods: {
    async fetchEvents() {
      console.log('Fetching events for category:', this.categoryId);
      this.loading = true;
      this.error = null;

      try {
        const url = `/api/events?category_id=${this.categoryId}`;
        console.log('Fetching from URL:', url);
        const response = await axios.get(url);
        console.log('API Response:', response.data);
        
        // Handle paginated response
        this.events = response.data.data || response.data;
        console.log('Processed events:', this.events);
        
        // Debug image URLs
        this.events.forEach(event => {
          if (event.image_url) {
            console.log(`Event ${event.id} (${event.title}) has image:`, event.image_url);
          } else {
            console.log(`Event ${event.id} (${event.title}) has no image`);
          }
        });

        // Emit updated stats
        const now = new Date();
        const stats = {
          upcoming: this.events.filter(e => new Date(e.starts_at) > now && e.status !== 'cancelled').length
        };
        console.log('Emitting stats:', stats);
        this.$emit('update:stats', stats);
        
        // Also fetch user registrations if logged in
        if (store.isLoggedIn) {
          await this.fetchUserRegistrations();
        }
      } catch (error) {
        console.error('Error fetching events:', error);
        this.error = error.response?.data?.message || 'Failed to load events';
      } finally {
        this.loading = false;
      }
    },
    async fetchUserRegistrations() {
      if (!store.isLoggedIn) {
        console.log('User not logged in, clearing registrations');
        this.registeredEvents = new Set();
        return;
      }

      try {
        console.log('Fetching user registrations...');
        console.log('Store login status:', store.isLoggedIn);
        console.log('Current user:', store.CurrentUser);
        
        // Get CSRF token first
        await axios.get('/sanctum/csrf-cookie');
        
        // Test authentication first
        try {
          const authTest = await axios.get('/api/user', {
            withCredentials: true
          });
          console.log('Auth test successful:', authTest.data);
        } catch (authError) {
          console.error('Auth test failed:', authError);
          this.registeredEvents = new Set();
          return;
        }
        
        const response = await axios.get('/api/event-registrations/my-registrations', {
          withCredentials: true
        });
        console.log('User registrations response:', response.data);
        
        // Handle both direct array and paginated response
        const registrations = response.data.data || response.data;
        console.log('Raw registrations data:', registrations);
        
        const eventIds = registrations
          .filter(reg => ['registered', 'attended'].includes(reg.status))
          .map(reg => reg.event_id);
        
        console.log('Registered event IDs:', eventIds);
        this.registeredEvents = new Set(eventIds);
        console.log('Updated registeredEvents set:', this.registeredEvents);
      } catch (error) {
        console.error('Error fetching registrations:', error);
        console.error('Error details:', error.response?.data);
        this.registeredEvents = new Set();
      }
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
      });
    },
    formatTime(date) {
      return new Date(date).toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
      });
    },
    handleImageError(event) {
      console.error(`Failed to load image for event ${event.id}:`, event.image_url);
    },
    handleImageLoad(event) {
      console.log(`Successfully loaded image for event ${event.id}:`, event.image_url);
    },
    getStatusClass(status) {
      const classes = {
        'upcoming': 'bg-gradient-to-r from-green-500/30 to-emerald-500/30 text-green-400 border-green-500/40',
        'ongoing': 'bg-gradient-to-r from-blue-500/30 to-cyan-500/30 text-blue-400 border-blue-500/40',
        'finished': 'bg-gradient-to-r from-gray-500/30 to-slate-500/30 text-gray-400 border-gray-500/40',
        'cancelled': 'bg-gradient-to-r from-red-500/30 to-rose-500/30 text-red-400 border-red-500/40'
      };
      return classes[status] || classes.upcoming;
    },
    formatStatus(status) {
      const statusMap = {
        'upcoming': 'Upcoming',
        'ongoing': 'Ongoing',
        'finished': 'Finished',
        'cancelled': 'Cancelled'
      };
      return statusMap[status] || 'Unknown';
    },
    getEventPointClass(event) {
      if (this.isRegistered(event.id)) return 'bg-green-500';
      if (event.status === 'cancelled') return 'bg-red-500';
      return new Date(event.starts_at) > new Date() ? 'bg-orange-500' : 'bg-gray-600';
    },
    isRegistered(eventId) {
      return this.registeredEvents.has(eventId);
    },
    canRegister(event) {
      const now = new Date();
      return new Date(event.starts_at) > now && 
             ['upcoming', 'ongoing'].includes(event.status) && 
             !this.isRegistered(event.id) &&
             !this.registeringEvents.has(event.id);
    },
    isRegistering(eventId) {
      return this.registeringEvents.has(eventId);
    },
    isUnregistering(eventId) {
      return this.unregisteringEvents.has(eventId);
    },
    getButtonText(event) {
      switch (event.status) {
        case 'cancelled':
          return 'Cancelled';
        case 'finished':
          return 'Event Ended';
        case 'ongoing':
          return 'Event in Progress';
        default:
          return 'Event Ended';
      }
    },
    async registerForEvent(eventId) {
      // Check if user is logged in
      if (!store.isLoggedIn) {
        alert('Please log in to register for events');
        this.$router.push('/login');
        return;
      }

      // Prevent multiple registration attempts
      if (this.registeringEvents.has(eventId)) {
        return;
      }

      this.registeringEvents.add(eventId);

      try {
        console.log('Attempting to register for event:', eventId);
        
        // Get CSRF token first
        await axios.get('/sanctum/csrf-cookie');
        
        const response = await axios.post(`/api/event-registrations/${eventId}/register`);
        console.log('Registration successful:', response.data);
        
        this.registeredEvents.add(eventId);
        
        // Show success message
        if (this.$toast) {
          this.$toast.success('Successfully registered for event!');
        } else {
          alert('Successfully registered for event!');
        }
        
        // Refresh both events and registrations
        await this.fetchEvents(); // Refresh to update stats
        await this.fetchUserRegistrations(); // Refresh registration status
      } catch (error) {
        console.error('Error registering for event:', error);
        
        let errorMessage = 'Failed to register for event';
        
        if (error.response) {
          switch (error.response.status) {
            case 401:
              errorMessage = 'Please log in to register for events';
              this.$router.push('/login');
              break;
            case 422:
              errorMessage = error.response.data?.message || 'Registration failed - event may be full or no longer available';
              break;
            case 500:
              errorMessage = 'Server error - please try again later';
              break;
            default:
              errorMessage = error.response.data?.message || errorMessage;
          }
        }
        
        // Show error message
        if (this.$toast) {
          this.$toast.error(errorMessage);
        } else {
          alert(errorMessage);
        }
      } finally {
        this.registeringEvents.delete(eventId);
      }
    },
    async unregisterFromEvent(eventId) {
      // Check if user is logged in
      if (!store.isLoggedIn) {
        alert('Please log in to manage registrations');
        this.$router.push('/login');
        return;
      }

      // Show confirmation dialog
      const confirmed = confirm('Are you sure you want to cancel your registration for this event?');
      if (!confirmed) {
        return;
      }

      // Prevent multiple unregistration attempts
      if (this.unregisteringEvents.has(eventId)) {
        return;
      }

      this.unregisteringEvents.add(eventId);

      try {
        console.log('Attempting to unregister from event:', eventId);
        
        // Get CSRF token first
        await axios.get('/sanctum/csrf-cookie');
        
        const response = await axios.post(`/api/event-registrations/${eventId}/cancel`);
        console.log('Unregistration successful:', response.data);
        
        this.registeredEvents.delete(eventId);
        
        // Show success message
        if (this.$toast) {
          this.$toast.success('Successfully cancelled registration!');
        } else {
          alert('Successfully cancelled registration!');
        }
        
        // Refresh both events and registrations
        await this.fetchEvents(); // Refresh to update stats
        await this.fetchUserRegistrations(); // Refresh registration status
      } catch (error) {
        console.error('Error unregistering from event:', error);
        
        let errorMessage = 'Failed to cancel registration';
        
        if (error.response) {
          switch (error.response.status) {
            case 401:
              errorMessage = 'Please log in to manage registrations';
              this.$router.push('/login');
              break;
            case 404:
              errorMessage = 'Registration not found - you may not be registered for this event';
              break;
            case 422:
              errorMessage = error.response.data?.message || 'Cannot cancel registration at this time';
              break;
            case 500:
              errorMessage = 'Server error - please try again later';
              break;
            default:
              errorMessage = error.response.data?.message || errorMessage;
          }
        }
        
        // Show error message
        if (this.$toast) {
          this.$toast.error(errorMessage);
        } else {
          alert(errorMessage);
        }
      } finally {
        this.unregisteringEvents.delete(eventId);
      }
    },
    getNoEventsMessage() {
      switch (this.filter) {
        case 'upcoming':
          return 'There are no upcoming events in this category yet.';
        case 'past':
          return 'There are no past events in this category.';
        case 'registered':
          return 'You haven\'t registered for any events in this category.';
        default:
          return 'No events found in this category.';
      }
    }
  },
  watch: {
    categoryId: {
      handler: 'fetchEvents',
      immediate: true
    },
    // Re-fetch registrations when login status changes
    'store.isLoggedIn': {
      handler: async function(isLoggedIn) {
        if (isLoggedIn) {
          await this.fetchUserRegistrations();
        } else {
          this.registeredEvents = new Set();
        }
      }
    }
  },
  async mounted() {
    console.log('EventTimeline mounted - Store status:', {
      isLoggedIn: store.isLoggedIn,
      currentUser: store.CurrentUser
    });
    
    if (store.isLoggedIn) {
      await this.fetchUserRegistrations();
    }
  }
};
</script>

<style scoped>
@keyframes fade-in {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in {
  animation: fade-in 0.5s ease-out forwards;
}

.no-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}

.no-scrollbar::-webkit-scrollbar {
  display: none;
}

/* Timeline specific styles */
.timeline-line {
  @apply absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-gray-800;
}

.timeline-point {
  @apply absolute left-1/2 transform -translate-x-1/2 w-4 h-4 rounded-full;
}

.timeline-card {
  @apply bg-gray-900 rounded-xl p-6 transform transition-all duration-300;
}

.timeline-card:hover {
  @apply scale-[1.02] bg-gray-800;
}

/* Prevent horizontal scroll */
* {
  box-sizing: border-box;
}

.grid {
  width: 100%;
  max-width: 100%;
}

.grid > * {
  min-width: 0;
  max-width: 100%;
}

/* Enhanced card animations */
.group:hover .group-hover\:scale-110 {
  transform: scale(1.1);
}

.group:hover .group-hover\:text-orange-400 {
  color: #fb923c;
}

/* Custom gradient animations */
@keyframes shimmer {
  0% {
    background-position: -200% center;
  }
  100% {
    background-position: 200% center;
  }
}

.group:hover {
  animation: shimmer 2s ease-in-out infinite;
  background-size: 200% 100%;
}

/* Pulse effect for register button */
@keyframes pulse-glow {
  0%, 100% {
    box-shadow: 0 0 0 0 rgba(251, 146, 60, 0.4);
  }
  50% {
    box-shadow: 0 0 0 10px rgba(251, 146, 60, 0);
  }
}

button:hover {
  animation: pulse-glow 1.5s infinite;
}

/* Mobile styles */
@media (max-width: 768px) {
  .timeline-line {
    @apply hidden;
  }
  
  .timeline-card {
    @apply w-full;
  }
}
</style>
