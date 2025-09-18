<template>
  <div class="w-full px-4 py-16 bg-black text-white">
    <div class="max-w-7xl mx-auto">
      <!-- Header Section with Animation -->
      <div class="mb-16 opacity-0 animate-fade-in">
        <h2 class="text-7xl font-bold mb-6 tracking-tight">
          <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-pink-500">
            Event Categories
          </span>
        </h2>
        <p class="text-xl text-gray-400 max-w-2xl">
          Discover our diverse range of events and activities designed to inspire, educate, and connect our community.
        </p>
      </div>
      
      <!-- Horizontal Scroll Container -->
      <div class="relative group">
        <div ref="scrollContainer" class="flex overflow-x-auto space-x-8 pb-12 no-scrollbar scroll-smooth">
          <div v-for="(category, index) in categories" :key="category.id"
               @click="navigateToCategory(category.id)"
               class="flex-none w-[400px] group group-card relative overflow-hidden rounded-xl cursor-pointer transform transition-all duration-500 ease-out hover:scale-[1.02]"
               :class="{'opacity-0 translate-y-8': !isVisible}"
               :style="{ 
                 background: generateGradient(category.name),
                 animationDelay: `${index * 100}ms`,
                 animation: 'fade-in-up 0.6s ease-out forwards'
               }">
            
            <!-- Abstract Shape Background -->
            <div class="absolute inset-0 opacity-30 transition-opacity duration-500 group-hover:opacity-50">
              <div class="w-full h-full transform transition-transform duration-700 group-hover:scale-110" 
                   :style="generateShape(category.name)"></div>
            </div>

            <!-- Content -->
            <div class="relative p-8 h-[280px] flex flex-col">
              <!-- Category Label -->
              <div class="inline-flex items-center space-x-2 bg-white/10 rounded-full px-4 py-1 backdrop-blur-sm">
                <span class="w-2 h-2 rounded-full" :style="{ backgroundColor: getCategoryColor(category.name) }"></span>
                <span class="text-sm font-medium">{{ category.name }}</span>
              </div>
              
              <!-- Title -->
              <h3 class="text-3xl font-bold mt-6 mb-4 leading-tight group-hover:text-orange-500 transition-colors duration-300">
                {{ generateTitle(category) }}
              </h3>
              
              <!-- Description -->
              <p class="text-gray-400 text-sm line-clamp-2 mb-6">
                {{ category.description }}
              </p>
              
              <!-- Footer -->
              <div class="mt-auto flex justify-between items-center">
                <p class="text-sm text-gray-400">{{ formatDate() }}</p>
                <button class="text-sm font-semibold flex items-center space-x-2 text-orange-500 group-hover:text-orange-400">
                  <span>View Events</span>
                  <svg class="w-4 h-4 transform transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Navigation Buttons -->
        <button @click="scroll('left')" 
                class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-6 w-12 h-12 bg-black/80 rounded-full flex items-center justify-center backdrop-blur-sm opacity-0 group-hover:opacity-100 group-hover:-translate-x-4 transition-all duration-300 hover:bg-orange-500">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </button>
        <button @click="scroll('right')" 
                class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-6 w-12 h-12 bg-black/80 rounded-full flex items-center justify-center backdrop-blur-sm opacity-0 group-hover:opacity-100 group-hover:translate-x-4 transition-all duration-300 hover:bg-orange-500">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </button>

        <!-- Scroll Progress Bar -->
        <div class="absolute bottom-0 left-0 w-full h-1 bg-gray-800 rounded-full overflow-hidden">
          <div class="h-full bg-orange-500 transition-all duration-300"
               :style="{ width: `${scrollProgress}%` }"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.no-scrollbar {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
.no-scrollbar::-webkit-scrollbar {
  display: none;
}

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

@keyframes fade-in-up {
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
  animation: fade-in 0.6s ease-out forwards;
}

/* Smooth scroll behavior */
.scroll-smooth {
  scroll-behavior: smooth;
}

/* Card hover effects */
.group-card:hover .transform {
  transform: scale(1.02);
}

/* Title gradient animation */
.text-gradient {
  background-size: 200% 200%;
  animation: gradient 4s ease infinite;
}

@keyframes gradient {
  0% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
  100% {
    background-position: 0% 50%;
  }
}
</style>

<script>
import axios from 'axios';

export default {
  name: 'EventCategoryCarousel',
  data() {
    return {
      categories: [],
      isVisible: false,
      scrollProgress: 0,
      gradients: {
        'Cinema': 'linear-gradient(135deg, #FF6B6B, #8E2DE2)',
        'Gaming': 'linear-gradient(135deg, #4158D0, #C850C0)',
        'Languages': 'linear-gradient(135deg, #FF8008, #FFC837)',
        'Workshops': 'linear-gradient(135deg, #0093E9, #80D0C7)',
        'Book Club': 'linear-gradient(135deg, #FC466B, #3F5EFB)',
        'Volunteering': 'linear-gradient(135deg, #11998e, #38ef7d)',
        'default': 'linear-gradient(135deg, #8E2DE2, #4A00E0)'
      },
      shapes: {
        'Cinema': 'radial-gradient(circle at 70% 30%, #FF6B6B 0%, transparent 70%)',
        'Gaming': 'radial-gradient(circle at 30% 70%, #4158D0 0%, transparent 70%)',
        'Languages': 'radial-gradient(circle at 50% 50%, #FFC837 0%, transparent 70%)',
        'Workshops': 'radial-gradient(circle at 20% 80%, #0093E9 0%, transparent 70%)',
        'Book Club': 'radial-gradient(circle at 60% 40%, #FC466B 0%, transparent 70%)',
        'Volunteering': 'radial-gradient(circle at 40% 60%, #11998e 0%, transparent 70%)',
        'default': 'radial-gradient(circle at 50% 50%, #8E2DE2 0%, transparent 70%)'
      },
      categoryColors: {
        'Cinema': '#FF6B6B',
        'Gaming': '#4158D0',
        'Languages': '#FF8008',
        'Workshops': '#0093E9',
        'Book Club': '#FC466B',
        'Volunteering': '#11998e',
        'default': '#8E2DE2'
      }
    };
  },
  methods: {
    async fetchCategories() {
      try {
        const response = await axios.get('/api/event-categories');
        this.categories = response.data;
        setTimeout(() => {
          this.isVisible = true;
        }, 100);
      } catch (error) {
        console.error('Error fetching event categories:', error);
      }
    },
    formatDate() {
      const date = new Date();
      return date.toLocaleDateString('en-US', { 
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });
    },
    generateGradient(categoryName) {
      return this.gradients[categoryName] || this.gradients.default;
    },
    generateShape(categoryName) {
      return {
        background: this.shapes[categoryName] || this.shapes.default
      };
    },
    getCategoryColor(categoryName) {
      return this.categoryColors[categoryName] || this.categoryColors.default;
    },
    generateTitle(category) {
      const titles = {
        'Cinema': 'Discover Movie Magic',
        'Gaming': 'Level Up Your Gaming',
        'Languages': 'Connect Through Language',
        'Workshops': 'Learn and Create Together',
        'Book Club': 'Journey Through Stories',
        'Volunteering': 'Make a Difference'
      };
      return titles[category.name] || `Explore ${category.name}`;
    },
    scroll(direction) {
      const container = this.$refs.scrollContainer;
      const scrollAmount = 420; // Width of one card + gap
      
      if (direction === 'left') {
        container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
      } else {
        container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
      }
    },
    updateScrollProgress() {
      const container = this.$refs.scrollContainer;
      if (!container) return;
      
      const maxScroll = container.scrollWidth - container.clientWidth;
      this.scrollProgress = (container.scrollLeft / maxScroll) * 100;
    },
    navigateToCategory(categoryId) {
      console.log('Navigating to category:', categoryId);
      this.$router.push({
        name: 'category-events',
        params: { id: categoryId.toString() }
      });
    }
  },
  mounted() {
    this.fetchCategories();
    this.$refs.scrollContainer?.addEventListener('scroll', this.updateScrollProgress);
  },
  beforeUnmount() {
    this.$refs.scrollContainer?.removeEventListener('scroll', this.updateScrollProgress);
  }
};
</script>

<style scoped>
.carousel-item {
  transition: transform 0.5s ease-in-out;
}
</style>