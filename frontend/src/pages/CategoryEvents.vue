<template>
  <div class="min-h-screen bg-black text-white overflow-x-hidden w-full max-w-full">
    <!-- Hero Section -->
    <div class="w-full px-3 sm:px-4 md:px-6 lg:px-8 py-8 md:py-16 bg-gradient-to-b from-gray-900 to-black">
      <div class="w-full">
        <!-- Breadcrumb -->
        <div class="flex items-center space-x-2 text-sm text-gray-400 mb-6 md:mb-8 overflow-x-auto">
          <router-link to="/" class="hover:text-orange-500 whitespace-nowrap">Home</router-link>
          <span>/</span>
          <span class="whitespace-nowrap">Events</span>
          <span>/</span>
          <span class="text-orange-500 whitespace-nowrap">{{ category?.name || 'Loading...' }}</span>
        </div>

        <!-- Header Content -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-8">
          <div class="w-full lg:w-auto flex-grow">
            <div class="mb-4">
              <h1 class="text-5xl md:text-6xl lg:text-7xl font-black mb-4 leading-tight">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-white via-orange-100 to-orange-300">
                  {{ category?.name || 'Loading...' }}
                </span>
                <span class="block text-3xl md:text-4xl lg:text-5xl font-bold text-orange-400 mt-2">
                  Events
                </span>
              </h1>
              <div class="w-24 h-1 bg-gradient-to-r from-orange-400 to-red-400 rounded-full mb-6"></div>
            </div>
            <div class="max-w-2xl">
              <p class="text-xl md:text-2xl text-gray-300 leading-relaxed font-light">
                {{ category?.description || 'Loading category details...' }}
              </p>
              <div class="mt-4 flex items-center gap-3 text-orange-300">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-base font-medium">{{ upcomingCount }} upcoming events available</span>
              </div>
            </div>
          </div>
          
          <!-- Stats -->
          <div class="lg:flex-shrink-0">
            <div class="bg-gradient-to-br from-orange-500/20 to-red-500/20 border border-orange-500/30 rounded-2xl p-6 lg:p-8 backdrop-blur-sm shadow-lg shadow-orange-500/10">
              <div class="text-center">
                <div class="text-5xl md:text-6xl lg:text-7xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-red-400 mb-2">
                  {{ upcomingCount }}
                </div>
                <div class="text-base md:text-lg font-semibold text-orange-300 uppercase tracking-wider">
                  Upcoming Events
                </div>
                <div class="mt-3 w-12 h-1 bg-gradient-to-r from-orange-400 to-red-400 mx-auto rounded-full"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Filters -->
    <div class="w-full border-y border-gray-800 sticky top-0 z-10 bg-black/95 backdrop-blur-sm">
      <div class="w-full px-3 sm:px-4 md:px-6 lg:px-8 py-3 md:py-4">
        <div class="flex items-center gap-2 md:gap-4 overflow-x-auto no-scrollbar">
          <button v-for="filter in filters" 
                  :key="filter.value"
                  @click="applyFilter(filter.value)"
                  :class="[
                    'px-4 py-2 rounded-full text-sm font-medium transition-colors whitespace-nowrap',
                    currentFilter === filter.value 
                      ? 'bg-orange-500 text-white' 
                      : 'bg-gray-800 text-gray-400 hover:bg-gray-700'
                  ]">
            {{ filter.label }}
          </button>
        </div>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="loading" class="w-full py-12 flex justify-center items-center">
      <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-orange-500"></div>
    </div>

    <!-- Error State -->
    <div v-else-if="error" class="w-full py-12 px-4 text-center">
      <div class="bg-red-500/10 rounded-lg p-6">
        <p class="text-red-500 mb-2">{{ error }}</p>
        <button @click="fetchCategory" class="text-sm text-white bg-red-500 px-4 py-2 rounded-full hover:bg-red-600">
          Try Again
        </button>
      </div>
    </div>

    <!-- Timeline -->
    <EventTimeline v-else 
                  :category-id="categoryId" 
                  :filter="currentFilter" 
                  @update:stats="updateStats" />
  </div>
</template>

<script>
import EventTimeline from '../components/EventTimeline.vue';
import axios from 'axios';

export default {
  name: 'CategoryEvents',
  components: {
    EventTimeline
  },
  data() {
    return {
      category: null,
      upcomingCount: 0,
      currentFilter: 'all',
      loading: true,
      error: null,
      filters: [
        { label: 'All Events', value: 'all' },
        { label: 'Upcoming', value: 'upcoming' },
        { label: 'Past Events', value: 'past' },
        { label: 'My Registrations', value: 'registered' }
      ]
    };
  },
  computed: {
    categoryId() {
      const id = this.$route.params.id;
      console.log('Route params:', this.$route.params);
      console.log('Category ID from route:', id);
      return id;
    }
  },
  methods: {
    async fetchCategory() {
      this.loading = true;
      this.error = null;
      
      try {
        const response = await axios.get(`/api/event-categories/${this.categoryId}`);
        this.category = response.data;
        
        // Calculate initial stats
        const events = response.data.events || [];
        this.updateStats({
          upcoming: events.filter(e => e.status === 'upcoming').length
        });
      } catch (error) {
        console.error('Error fetching category:', error);
        this.error = error.response?.data?.message || 'Failed to load category details. Please try again.';
      } finally {
        this.loading = false;
      }
    },
    updateStats({ upcoming }) {
      this.upcomingCount = upcoming;
    },
    applyFilter(filter) {
      this.currentFilter = filter;
    }
  },
  watch: {
    // Re-fetch when route changes (different category)
    categoryId: {
      handler: 'fetchCategory',
      immediate: true
    }
  }
};
</script>
