<template>
  <div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
      <div>
        <h2 class="text-2xl font-bold text-white">Business Profile</h2>
        <p class="text-gray-400">Manage your business information and settings</p>
      </div>
      <button
        @click="showForm = !showForm"
        class="px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-200"
      >
        {{ partnerInfo ? 'Edit Profile' : 'Create Profile' }}
      </button>
    </div>

    <!-- Business Info Display -->
    <div v-if="partnerInfo && !showForm" class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 border border-gray-700/50">
      <div class="flex items-start space-x-6">
        <!-- Business Logo -->
        <div class="flex-shrink-0">
          <div v-if="partnerInfo.business_logo" class="w-24 h-24 rounded-xl overflow-hidden">
            <img :src="partnerInfo.business_logo" :alt="partnerInfo.business_name" class="w-full h-full object-cover">
          </div>
          <div v-else class="w-24 h-24 bg-gray-700 rounded-xl flex items-center justify-center">
            <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
            </svg>
          </div>
        </div>

        <!-- Business Details -->
        <div class="flex-1">
          <div class="flex items-center space-x-3 mb-2">
            <h3 class="text-xl font-semibold text-white">{{ partnerInfo.business_name }}</h3>
            <span class="px-3 py-1 bg-blue-600/20 text-blue-400 rounded-full text-sm font-medium capitalize">
              {{ formatCategory(partnerInfo.business_category) }}
            </span>
            <span v-if="partnerInfo.is_active" class="px-3 py-1 bg-green-600/20 text-green-400 rounded-full text-sm font-medium">
              Active
            </span>
          </div>
          
          <p v-if="partnerInfo.business_description" class="text-gray-300 mb-3">
            {{ partnerInfo.business_description }}
          </p>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div v-if="partnerInfo.business_address" class="flex items-center space-x-2">
              <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
              </svg>
              <span class="text-gray-300">{{ partnerInfo.business_address }}</span>
            </div>
            
            <div v-if="partnerInfo.contact_phone" class="flex items-center space-x-2">
              <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
              </svg>
              <span class="text-gray-300">{{ partnerInfo.contact_phone }}</span>
            </div>
            
            <div v-if="partnerInfo.business_email" class="flex items-center space-x-2">
              <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
              </svg>
              <span class="text-gray-300">{{ partnerInfo.business_email }}</span>
            </div>
            
            <div v-if="partnerInfo.business_website" class="flex items-center space-x-2">
              <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.56-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.56.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z" clip-rule="evenodd"/>
              </svg>
              <a :href="partnerInfo.business_website" target="_blank" class="text-blue-400 hover:text-blue-300">
                {{ partnerInfo.business_website }}
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Business Profile Form -->
    <div v-if="showForm" class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 border border-gray-700/50">
      <form @submit.prevent="submitForm" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Business Name -->
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Business Name *</label>
            <input
              v-model="form.business_name"
              type="text"
              required
              class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              placeholder="Enter business name"
            >
          </div>

          <!-- Business Category -->
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Category *</label>
            <select
              v-model="form.business_category"
              required
              class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            >
              <option value="">Select category</option>
              <option v-for="(label, value) in categories" :key="value" :value="value">{{ label }}</option>
            </select>
          </div>

          <!-- Business Address -->
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-300 mb-2">Address</label>
            <input
              v-model="form.business_address"
              type="text"
              class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              placeholder="Enter business address"
            >
          </div>

          <!-- Business Description -->
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
            <textarea
              v-model="form.business_description"
              rows="3"
              class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              placeholder="Describe your business"
            ></textarea>
          </div>

          <!-- Contact Information -->
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Phone</label>
            <input
              v-model="form.contact_phone"
              type="tel"
              class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              placeholder="Phone number"
            >
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
            <input
              v-model="form.business_email"
              type="email"
              class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              placeholder="Business email"
            >
          </div>

          <!-- Website -->
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Website</label>
            <input
              v-model="form.business_website"
              type="url"
              class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
              placeholder="https://your-website.com"
            >
          </div>

          <!-- Business Logo -->
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Business Logo</label>
            <div class="space-y-3">
              <input
                @change="handleLogoUpload"
                type="file"
                accept="image/*"
                ref="logoInput"
                class="hidden"
              >
              <button
                @click="$refs.logoInput.click()"
                type="button"
                class="w-full px-4 py-3 bg-gray-700/50 border border-gray-600 rounded-lg text-gray-300 hover:bg-gray-600/50 transition-colors flex items-center justify-center space-x-2"
              >
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                </svg>
                <span>{{ selectedLogo ? 'Change Logo' : 'Upload Logo' }}</span>
              </button>
              
              <!-- Logo Preview -->
              <div v-if="logoPreview" class="flex items-center space-x-3">
                <img :src="logoPreview" alt="Logo preview" class="w-16 h-16 object-cover rounded-lg">
                <button
                  @click="removeLogo"
                  type="button"
                  class="text-red-400 hover:text-red-300"
                >
                  Remove
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Form Actions -->
        <div class="flex space-x-4 pt-4">
          <button
            type="submit"
            :disabled="loading"
            class="px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
          >
            {{ loading ? 'Saving...' : (partnerInfo ? 'Update Profile' : 'Create Profile') }}
          </button>
          <button
            @click="cancelForm"
            type="button"
            class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors"
          >
            Cancel
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'PartnerProfileManagement',
  data() {
    return {
      showForm: false,
      loading: false,
      partnerInfo: null,
      categories: {},
      selectedLogo: null,
      logoPreview: null,
      form: {
        business_name: '',
        business_category: '',
        business_address: '',
        business_description: '',
        business_email: '',
        contact_phone: '',
        business_website: '',
      }
    };
  },
  async mounted() {
    await this.fetchCategories();
    await this.fetchPartnerInfo();
  },
  methods: {
    async fetchCategories() {
      try {
        const response = await axios.get('/api/businesses/categories');
        this.categories = response.data;
      } catch (error) {
        console.error('Error fetching categories:', error);
      }
    },
    
    async fetchPartnerInfo() {
      try {
        const response = await axios.get('/api/businesses/my/info');
        this.partnerInfo = response.data;
        this.fillForm();
      } catch (error) {
        if (error.response?.status !== 404) {
          console.error('Error fetching partner info:', error);
        }
      }
    },
    
    fillForm() {
      if (this.partnerInfo) {
        this.form = {
          business_name: this.partnerInfo.business_name || '',
          business_category: this.partnerInfo.business_category || '',
          business_address: this.partnerInfo.business_address || '',
          business_description: this.partnerInfo.business_description || '',
          business_email: this.partnerInfo.business_email || '',
          contact_phone: this.partnerInfo.contact_phone || '',
          business_website: this.partnerInfo.business_website || '',
        };
      }
    },
    
    handleLogoUpload(event) {
      const file = event.target.files[0];
      if (file) {
        // Validate file size (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
          alert('Logo must be less than 2MB');
          return;
        }
        
        // Validate file type
        if (!file.type.startsWith('image/')) {
          alert('Please select an image file');
          return;
        }
        
        this.selectedLogo = file;
        
        // Create preview
        const reader = new FileReader();
        reader.onload = (e) => {
          this.logoPreview = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    },
    
    removeLogo() {
      this.selectedLogo = null;
      this.logoPreview = null;
      this.$refs.logoInput.value = '';
    },
    
    async submitForm() {
      try {
        this.loading = true;
        
        // Get CSRF token
        await axios.get('/sanctum/csrf-cookie');
        
        const formData = new FormData();
        
        // Add form fields
        Object.keys(this.form).forEach(key => {
          if (this.form[key] !== '' && this.form[key] !== null && this.form[key] !== undefined) {
            formData.append(key, this.form[key]);
          }
        });
        
        // Add logo if selected
        if (this.selectedLogo) {
          formData.append('business_logo', this.selectedLogo);
        }
        
        const response = await axios.post('/api/businesses/', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });
        
        this.partnerInfo = response.data;
        this.showForm = false;
        this.removeLogo();
        
        alert('Business profile saved successfully!');
        
      } catch (error) {
        console.error('Error saving business profile:', error);
        alert('Error saving business profile. Please try again.');
      } finally {
        this.loading = false;
      }
    },
    
    cancelForm() {
      this.showForm = false;
      this.fillForm();
      this.removeLogo();
    },
    
    formatCategory(category) {
      return this.categories[category] || category;
    }
  }
};
</script>
