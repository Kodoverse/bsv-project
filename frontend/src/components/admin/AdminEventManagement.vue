<template>
  <div class="space-y-6">
    <!-- Header with Create Button -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
      <div>
        <h2 class="text-2xl font-bold text-white">Event Management</h2>
        <p class="text-gray-400">Create, edit, and manage events</p>
      </div>
      <button
        @click="showCreateModal = true"
        class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-xl font-semibold transition-all duration-300 hover:scale-105 flex items-center gap-2">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
        </svg>
        Create Event
      </button>
    </div>

    <!-- Filters -->
    <div class="flex flex-wrap gap-4">
      <select v-model="filters.category" @change="fetchEvents" 
              class="px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
        <option value="">All Categories</option>
        <option v-for="category in categories" :key="category.id" :value="category.id">
          {{ category.name }}
        </option>
      </select>
      
      <select v-model="filters.status" @change="fetchEvents"
              class="px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
        <option value="">All Status</option>
        <option value="upcoming">Upcoming</option>
        <option value="ongoing">Ongoing</option>
        <option value="finished">Finished</option>
        <option value="cancelled">Cancelled</option>
      </select>

      <input
        v-model="filters.search"
        @input="debouncedSearch"
        placeholder="Search events..."
        class="px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-orange-500 focus:border-transparent">
    </div>

    <!-- Events List -->
    <div v-if="loading" class="text-center py-12">
      <div class="inline-block w-8 h-8 border-4 border-orange-500/30 border-t-orange-500 rounded-full animate-spin"></div>
      <p class="text-gray-400 mt-4">Loading events...</p>
    </div>

    <div v-else-if="events.length === 0" class="text-center py-12">
      <div class="text-6xl mb-4">📅</div>
      <h3 class="text-xl font-semibold text-gray-300 mb-2">No Events Found</h3>
      <p class="text-gray-400">Create your first event to get started</p>
    </div>

    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-for="event in events" :key="event.id"
           class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl overflow-hidden hover:scale-105 transition-all duration-300">
        
        <!-- Event Image -->
        <div class="h-48 bg-gradient-to-r from-orange-400/20 to-red-400/20 relative">
          <img v-if="event.image_url" :src="event.image_url" :alt="event.title" 
               class="w-full h-full object-cover">
          <div v-else class="w-full h-full flex items-center justify-center">
            <svg class="w-16 h-16 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
            </svg>
          </div>
          
          <!-- Status Badge -->
          <div class="absolute top-4 right-4">
            <span :class="getStatusBadgeClass(event.status)" class="px-3 py-1 rounded-full text-xs font-semibold">
              {{ event.status.charAt(0).toUpperCase() + event.status.slice(1) }}
            </span>
          </div>
        </div>

        <!-- Event Content -->
        <div class="p-6">
          <div class="flex items-center gap-2 text-sm text-gray-400 mb-2">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
              <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
            </svg>
            {{ event.category?.name || 'No Category' }}
          </div>
          
          <h3 class="text-xl font-bold text-white mb-2 line-clamp-2">{{ event.title }}</h3>
          <p class="text-gray-400 text-sm mb-4 line-clamp-3">{{ event.description }}</p>
          
          <div class="space-y-2 text-sm text-gray-300">
            <div class="flex items-center gap-2">
              <svg class="w-4 h-4 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
              </svg>
              {{ formatDateTime(event.starts_at) }}
            </div>
            
            <div class="flex items-center gap-2">
              <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
              </svg>
              {{ event.registrations_count || 0 }}{{ event.max_participants ? ` / ${event.max_participants}` : '' }} registered
            </div>
          </div>
          
          <!-- Action Buttons -->
          <div class="flex gap-2 mt-6">
            <button
              @click="viewEventRegistrations(event)"
              class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
              View Registrations
            </button>
            <button
              @click="editEvent(event)"
              class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg text-sm font-medium transition-colors">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
              </svg>
            </button>
            <button
              @click="deleteEvent(event)"
              class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition-colors">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"/>
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414L8.586 12l-2.293 2.293a1 1 0 101.414 1.414L9 13.414l2.293 2.293a1 1 0 001.414-1.414L10.414 12l2.293-2.293z" clip-rule="evenodd"/>
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Create/Edit Event Modal -->
    <div v-if="showCreateModal || showEditModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 z-50">
      <div class="bg-gray-800 rounded-2xl p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-2xl font-bold text-white">
            {{ showCreateModal ? 'Create New Event' : 'Edit Event' }}
          </h3>
          <button @click="closeModals" class="text-gray-400 hover:text-white">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
          </button>
        </div>

        <form @submit.prevent="submitEventForm" class="space-y-6">
          <!-- Basic Information -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-2">Title *</label>
              <input v-model="eventForm.title" type="text" required
                     class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-2">Category *</label>
              <select v-model="eventForm.category_id" required
                      class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                <option value="">Select Category</option>
                <option v-for="category in categories" :key="category.id" :value="category.id">
                  {{ category.name }}
                </option>
              </select>
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Description *</label>
            <textarea v-model="eventForm.description" rows="4" required
                      class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent"></textarea>
          </div>

          <!-- Image Upload -->
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Event Image</label>
            
            <!-- Image Preview -->
            <div v-if="imagePreview || eventForm.image_url" class="mb-4">
              <img :src="imagePreview || eventForm.image_url" alt="Event preview" 
                   class="w-full h-48 object-cover rounded-lg border border-gray-600">
              <button type="button" @click="removeImage" 
                      class="mt-2 px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-sm">
                Remove Image
              </button>
            </div>
            
            <!-- File Input -->
            <div class="relative">
              <input 
                ref="imageInput"
                type="file" 
                @change="handleImageUpload" 
                accept="image/jpeg,image/png,image/jpg,image/gif"
                class="hidden">
              
              <button type="button" @click="$refs.imageInput.click()"
                      class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-gray-300 hover:bg-gray-600 transition-colors flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                </svg>
                {{ imagePreview || eventForm.image_url ? 'Change Image' : 'Upload Image' }}
              </button>
            </div>
            
            <p class="text-gray-400 text-xs mt-2">
              Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB
            </p>
          </div>

          <!-- Date and Time -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-2">Start Date & Time *</label>
              <input v-model="eventForm.starts_at" type="datetime-local" required
                     class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-2">End Date & Time *</label>
              <input v-model="eventForm.ends_at" type="datetime-local" required
                     class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
            </div>
          </div>

          <!-- Additional Information -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-2">Location</label>
              <input v-model="eventForm.location" type="text"
                     class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-2">Max Participants</label>
              <input v-model="eventForm.max_participants" type="number" min="1"
                     class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-2">Volunteer Points</label>
              <input v-model="eventForm.volunteer_points" type="number" min="1" 
                     :disabled="!eventForm.is_volunteer_event"
                     class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent disabled:opacity-50 disabled:cursor-not-allowed"
                     placeholder="Points awarded for attendance">
            </div>
          </div>

          <!-- Volunteer Event Options -->
          <div class="bg-gray-700/30 rounded-lg p-4">
            <div class="flex items-center gap-4 mb-4">
              <label class="flex items-center cursor-pointer">
                <input v-model="eventForm.is_volunteer_event" type="checkbox" 
                       class="sr-only">
                <div :class="[
                  'relative w-11 h-6 rounded-full transition-colors duration-200',
                  eventForm.is_volunteer_event ? 'bg-orange-500' : 'bg-gray-600'
                ]">
                  <div :class="[
                    'absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full transition-transform duration-200',
                    eventForm.is_volunteer_event ? 'translate-x-5' : 'translate-x-0'
                  ]"></div>
                </div>
                <span class="ml-3 text-sm font-medium text-gray-300">This is a volunteer event</span>
              </label>
            </div>
            
            <div v-if="eventForm.is_volunteer_event" class="text-sm text-gray-400">
              <p class="flex items-center gap-2">
                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                Volunteer events allow attendance confirmation and automatic points awarding.
              </p>
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Status</label>
            <select v-model="eventForm.status"
                    class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-orange-500 focus:border-transparent">
              <option value="upcoming">Upcoming</option>
              <option value="ongoing">Ongoing</option>
              <option value="finished">Finished</option>
              <option value="cancelled">Cancelled</option>
            </select>
          </div>

          <!-- Submit Buttons -->
          <div class="flex gap-4 pt-4">
            <button
              type="submit"
              :disabled="submitting"
              class="flex-1 px-6 py-3 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white rounded-xl font-semibold transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
              <svg v-if="submitting" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              {{ submitting ? 'Saving...' : (showCreateModal ? 'Create Event' : 'Update Event') }}
            </button>
            <button
              type="button"
              @click="closeModals"
              class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-xl font-semibold transition-colors">
              Cancel
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Event Registrations Modal -->
    <div v-if="showRegistrationsModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 z-50">
      <div class="bg-gray-800 rounded-2xl p-6 w-full max-w-4xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-2xl font-bold text-white">
            Event Registrations: {{ selectedEvent?.title }}
          </h3>
          <button @click="showRegistrationsModal = false" class="text-gray-400 hover:text-white">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
          </button>
        </div>

        <div v-if="loadingRegistrations" class="text-center py-12">
          <div class="inline-block w-8 h-8 border-4 border-orange-500/30 border-t-orange-500 rounded-full animate-spin"></div>
          <p class="text-gray-400 mt-4">Loading registrations...</p>
        </div>

        <div v-else-if="eventRegistrations.length === 0" class="text-center py-12">
          <div class="text-6xl mb-4">📝</div>
          <h3 class="text-xl font-semibold text-gray-300 mb-2">No Registrations Yet</h3>
          <p class="text-gray-400">No users have registered for this event</p>
        </div>

        <div v-else class="space-y-4">
          <div v-for="registration in eventRegistrations" :key="registration.id"
               class="flex items-center justify-between p-4 bg-gray-700/30 rounded-xl">
            <div class="flex items-center gap-4">
              <div class="w-12 h-12 bg-gradient-to-r from-orange-400 to-red-400 rounded-full flex items-center justify-center">
                <span class="text-white font-bold">
                  {{ registration.user?.info?.firstname?.charAt(0) || registration.user?.email?.charAt(0) }}{{ registration.user?.info?.lastname?.charAt(0) || '' }}
                </span>
              </div>
              <div>
                <h4 class="text-white font-semibold">
                  {{ registration.user?.info?.firstname }} {{ registration.user?.info?.lastname || registration.user?.email }}
                </h4>
                <p class="text-gray-400 text-sm">{{ registration.user?.email }}</p>
                <p class="text-gray-500 text-xs">
                  Registered: {{ formatDateTime(registration.created_at) }}
                </p>
              </div>
            </div>
            <div class="text-right">
              <span :class="getRegistrationStatusClass(registration.status)" 
                    class="px-3 py-1 rounded-full text-xs font-semibold">
                {{ registration.status.charAt(0).toUpperCase() + registration.status.slice(1) }}
              </span>
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
  name: 'AdminEventManagement',
  data() {
    return {
      loading: true,
      submitting: false,
      loadingRegistrations: false,
      events: [],
      categories: [],
      eventRegistrations: [],
      selectedEvent: null,
      showCreateModal: false,
      showEditModal: false,
      showRegistrationsModal: false,
      filters: {
        category: '',
        status: '',
        search: ''
      },
      eventForm: {
        title: '',
        description: '',
        category_id: '',
        starts_at: '',
        ends_at: '',
        location: '',
        max_participants: '',
        is_volunteer_event: false,
        volunteer_points: '',
        status: 'upcoming',
        image_url: ''
      },
      selectedImage: null,
      imagePreview: null,
      searchTimeout: null
    };
  },
  async mounted() {
    await Promise.all([
      this.fetchEvents(),
      this.fetchCategories()
    ]);
  },
  methods: {
    async fetchEvents() {
      try {
        this.loading = true;
        const params = new URLSearchParams();
        
        if (this.filters.category) params.append('category_id', this.filters.category);
        if (this.filters.status) params.append('status', this.filters.status);
        if (this.filters.search) params.append('search', this.filters.search);
        
        const response = await axios.get(`/api/admin/events?${params.toString()}`, {
          withCredentials: true
        });
        this.events = response.data.data || response.data;
      } catch (error) {
        console.error('Error fetching events:', error);
        alert('Failed to load events');
      } finally {
        this.loading = false;
      }
    },
    
    async fetchCategories() {
      try {
        const response = await axios.get('/api/event-categories');
        this.categories = response.data.data || response.data;
      } catch (error) {
        console.error('Error fetching categories:', error);
      }
    },

    async viewEventRegistrations(event) {
      this.selectedEvent = event;
      this.showRegistrationsModal = true;
      
      try {
        this.loadingRegistrations = true;
        const response = await axios.get(`/api/admin/events/${event.id}/registrations`, {
          withCredentials: true
        });
        this.eventRegistrations = response.data.data || response.data;
      } catch (error) {
        console.error('Error fetching registrations:', error);
        this.eventRegistrations = [];
      } finally {
        this.loadingRegistrations = false;
      }
    },

    editEvent(event) {
      this.eventForm = {
        id: event.id,
        title: event.title,
        description: event.description,
        category_id: event.category_id,
        starts_at: this.formatDateTimeForInput(event.starts_at),
        ends_at: this.formatDateTimeForInput(event.ends_at),
        location: event.location || '',
        max_participants: event.max_participants || '',
        status: event.status,
        image_url: event.image_url || ''
      };
      this.selectedImage = null;
      this.imagePreview = null;
      this.showEditModal = true;
    },

    handleImageUpload(event) {
      const file = event.target.files[0];
      if (file) {
        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
          alert('Image size must be less than 2MB');
          return;
        }

        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
          alert('Only JPEG, PNG, JPG, and GIF files are allowed');
          return;
        }

        this.selectedImage = file;
        
        // Create preview
        const reader = new FileReader();
        reader.onload = (e) => {
          this.imagePreview = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    },

    removeImage() {
      this.selectedImage = null;
      this.imagePreview = null;
      this.eventForm.image_url = '';
      if (this.$refs.imageInput) {
        this.$refs.imageInput.value = '';
      }
    },

    async submitEventForm() {
      try {
        this.submitting = true;
        
        // Get CSRF token
        await axios.get('/sanctum/csrf-cookie');
        
        // Create FormData for file upload
        const formData = new FormData();
        
        // Add all form fields
        Object.keys(this.eventForm).forEach(key => {
          if (key !== 'id' && key !== 'image_url' && this.eventForm[key] !== '') {
            // Handle boolean fields properly
            if (typeof this.eventForm[key] === 'boolean') {
              formData.append(key, this.eventForm[key] ? '1' : '0');
            } else {
              formData.append(key, this.eventForm[key]);
            }
          }
        });
        
        // Ensure is_volunteer_event is always sent (even if false)
        formData.append('is_volunteer_event', this.eventForm.is_volunteer_event ? '1' : '0');
        
        // Add image if selected
        if (this.selectedImage) {
          formData.append('image', this.selectedImage);
        }
        
        const config = {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        };
        
        if (this.showCreateModal) {
          await axios.post('/api/admin/events', formData, config);
          alert('Event created successfully!');
        } else {
          // For updates, we need to use POST with _method=PUT for file uploads
          formData.append('_method', 'PUT');
          await axios.post(`/api/admin/events/${this.eventForm.id}`, formData, config);
          alert('Event updated successfully!');
        }
        
        this.closeModals();
        await this.fetchEvents();
      } catch (error) {
        console.error('Error saving event:', error);
        alert('Failed to save event: ' + (error.response?.data?.message || 'Unknown error'));
      } finally {
        this.submitting = false;
      }
    },

    async deleteEvent(event) {
      if (!confirm(`Are you sure you want to delete "${event.title}"?`)) {
        return;
      }
      
      try {
        await axios.get('/sanctum/csrf-cookie');
        await axios.delete(`/api/admin/events/${event.id}`);
        alert('Event deleted successfully!');
        await this.fetchEvents();
      } catch (error) {
        console.error('Error deleting event:', error);
        alert('Failed to delete event: ' + (error.response?.data?.message || 'Unknown error'));
      }
    },

    closeModals() {
      this.showCreateModal = false;
      this.showEditModal = false;
      this.selectedImage = null;
      this.imagePreview = null;
      this.eventForm = {
        title: '',
        description: '',
        category_id: '',
        starts_at: '',
        ends_at: '',
        location: '',
        max_participants: '',
        is_volunteer_event: false,
        volunteer_points: '',
        status: 'upcoming',
        image_url: ''
      };
      if (this.$refs.imageInput) {
        this.$refs.imageInput.value = '';
      }
    },

    debouncedSearch() {
      clearTimeout(this.searchTimeout);
      this.searchTimeout = setTimeout(() => {
        this.fetchEvents();
      }, 500);
    },

    getStatusBadgeClass(status) {
      const classes = {
        upcoming: 'bg-green-500/20 text-green-400 border border-green-500/30',
        ongoing: 'bg-blue-500/20 text-blue-400 border border-blue-500/30',
        finished: 'bg-gray-500/20 text-gray-400 border border-gray-500/30',
        cancelled: 'bg-red-500/20 text-red-400 border border-red-500/30'
      };
      return classes[status] || classes.upcoming;
    },

    getRegistrationStatusClass(status) {
      const classes = {
        registered: 'bg-green-500/20 text-green-400',
        cancelled: 'bg-red-500/20 text-red-400',
        attended: 'bg-blue-500/20 text-blue-400',
        no_show: 'bg-gray-500/20 text-gray-400'
      };
      return classes[status] || classes.registered;
    },

    formatDateTime(dateString) {
      return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      });
    },

    formatDateTimeForInput(dateString) {
      const date = new Date(dateString);
      const offset = date.getTimezoneOffset();
      const localDate = new Date(date.getTime() - (offset * 60 * 1000));
      return localDate.toISOString().slice(0, 16);
    }
  }
};
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
