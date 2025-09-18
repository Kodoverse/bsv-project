<template>
  <div class="space-y-6">
    <!-- Header with Create Button -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
      <div>
        <h2 class="text-2xl font-bold text-white">Category Management</h2>
        <p class="text-gray-400">Create, edit, and manage event categories</p>
      </div>
      <button
        @click="showCreateModal = true"
        class="px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white rounded-xl font-semibold transition-all duration-300 hover:scale-105 flex items-center gap-2">
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
        </svg>
        Create Category
      </button>
    </div>

    <!-- Search -->
    <div class="max-w-md">
      <input
        v-model="searchQuery"
        @input="debouncedSearch"
        placeholder="Search categories..."
        class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
    </div>

    <!-- Categories List -->
    <div v-if="loading" class="text-center py-12">
      <div class="inline-block w-8 h-8 border-4 border-purple-500/30 border-t-purple-500 rounded-full animate-spin"></div>
      <p class="text-gray-400 mt-4">Loading categories...</p>
    </div>

    <div v-else-if="categories.length === 0" class="text-center py-12">
      <div class="text-6xl mb-4">📁</div>
      <h3 class="text-xl font-semibold text-gray-300 mb-2">No Categories Found</h3>
      <p class="text-gray-400">Create your first category to organize events</p>
    </div>

    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-for="category in categories" :key="category.id"
           class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl p-6 hover:scale-105 transition-all duration-300">
        
        <!-- Category Header -->
        <div class="flex items-start justify-between mb-4">
          <div class="flex-1">
            <h3 class="text-xl font-bold text-white mb-2">{{ category.name }}</h3>
            <p class="text-gray-400 text-sm line-clamp-3">{{ category.description || 'No description provided' }}</p>
          </div>
          <div class="ml-4">
            <div class="w-12 h-12 bg-gradient-to-r from-purple-400 to-pink-400 rounded-xl flex items-center justify-center">
              <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
              </svg>
            </div>
          </div>
        </div>

        <!-- Category Stats -->
        <div class="bg-gray-700/30 rounded-lg p-4 mb-4">
          <div class="flex items-center justify-between text-sm">
            <span class="text-gray-400">Events in this category</span>
            <span class="text-white font-semibold">{{ category.events_count || 0 }}</span>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-2">
          <button
            @click="editCategory(category)"
            class="flex-1 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg text-sm font-medium transition-colors flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
              <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
            </svg>
            Edit
          </button>
          <button
            @click="deleteCategory(category)"
            :disabled="category.events_count > 0"
            :class="[
              'px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center justify-center',
              category.events_count > 0 
                ? 'bg-gray-500 text-gray-300 cursor-not-allowed'
                : 'bg-red-600 hover:bg-red-700 text-white'
            ]">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"/>
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414L8.586 12l-2.293 2.293a1 1 0 101.414 1.414L9 13.414l2.293 2.293a1 1 0 001.414-1.414L10.414 12l2.293-2.293z" clip-rule="evenodd"/>
            </svg>
          </button>
        </div>
        
        <!-- Warning for categories with events -->
        <p v-if="category.events_count > 0" class="text-yellow-400 text-xs mt-2 text-center">
          Cannot delete: {{ category.events_count }} event(s) assigned
        </p>
      </div>
    </div>

    <!-- Create/Edit Category Modal -->
    <div v-if="showCreateModal || showEditModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 z-50">
      <div class="bg-gray-800 rounded-2xl p-6 w-full max-w-md">
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-2xl font-bold text-white">
            {{ showCreateModal ? 'Create New Category' : 'Edit Category' }}
          </h3>
          <button @click="closeModals" class="text-gray-400 hover:text-white">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
          </button>
        </div>

        <form @submit.prevent="submitCategoryForm" class="space-y-6">
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Category Name *</label>
            <input v-model="categoryForm.name" type="text" required
                   class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                   placeholder="Enter category name">
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
            <textarea v-model="categoryForm.description" rows="4"
                      class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                      placeholder="Enter category description (optional)"></textarea>
          </div>

          <!-- Submit Buttons -->
          <div class="flex gap-4 pt-4">
            <button
              type="submit"
              :disabled="submitting"
              class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white rounded-xl font-semibold transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
              <svg v-if="submitting" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 714 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              {{ submitting ? 'Saving...' : (showCreateModal ? 'Create Category' : 'Update Category') }}
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
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'AdminCategoryManagement',
  data() {
    return {
      loading: true,
      submitting: false,
      categories: [],
      searchQuery: '',
      showCreateModal: false,
      showEditModal: false,
      categoryForm: {
        name: '',
        description: ''
      },
      searchTimeout: null
    };
  },
  async mounted() {
    await this.fetchCategories();
  },
  methods: {
    async fetchCategories() {
      try {
        this.loading = true;
        const params = new URLSearchParams();
        
        if (this.searchQuery) {
          params.append('search', this.searchQuery);
        }
        
        const response = await axios.get(`/api/admin/categories?${params.toString()}`);
        this.categories = response.data.data || response.data;
      } catch (error) {
        console.error('Error fetching categories:', error);
        alert('Failed to load categories');
      } finally {
        this.loading = false;
      }
    },

    editCategory(category) {
      this.categoryForm = {
        id: category.id,
        name: category.name,
        description: category.description || ''
      };
      this.showEditModal = true;
    },

    async submitCategoryForm() {
      try {
        this.submitting = true;
        
        // Get CSRF token
        await axios.get('/sanctum/csrf-cookie');
        
        if (this.showCreateModal) {
          await axios.post('/api/admin/categories', this.categoryForm);
          alert('Category created successfully!');
        } else {
          await axios.put(`/api/admin/categories/${this.categoryForm.id}`, this.categoryForm);
          alert('Category updated successfully!');
        }
        
        this.closeModals();
        await this.fetchCategories();
      } catch (error) {
        console.error('Error saving category:', error);
        alert('Failed to save category: ' + (error.response?.data?.message || 'Unknown error'));
      } finally {
        this.submitting = false;
      }
    },

    async deleteCategory(category) {
      if (category.events_count > 0) {
        alert('Cannot delete category with assigned events. Please move or delete the events first.');
        return;
      }
      
      if (!confirm(`Are you sure you want to delete "${category.name}"?`)) {
        return;
      }
      
      try {
        await axios.get('/sanctum/csrf-cookie');
        await axios.delete(`/api/admin/categories/${category.id}`);
        alert('Category deleted successfully!');
        await this.fetchCategories();
      } catch (error) {
        console.error('Error deleting category:', error);
        alert('Failed to delete category: ' + (error.response?.data?.message || 'Unknown error'));
      }
    },

    closeModals() {
      this.showCreateModal = false;
      this.showEditModal = false;
      this.categoryForm = {
        name: '',
        description: ''
      };
    },

    debouncedSearch() {
      clearTimeout(this.searchTimeout);
      this.searchTimeout = setTimeout(() => {
        this.fetchCategories();
      }, 500);
    }
  }
};
</script>

<style scoped>
.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
