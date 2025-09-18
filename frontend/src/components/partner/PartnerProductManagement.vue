<template>
  <div class="space-y-6">
    <!-- Header with Create Button -->
    <div class="flex justify-between items-center">
      <div>
        <h2 class="text-2xl font-bold text-white">Product Management</h2>
        <p class="text-gray-400">Create and manage your point-redemption products</p>
      </div>
      <button @click="showCreateModal = true" 
              class="px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-xl font-semibold hover:from-purple-600 hover:to-pink-600 transition-all duration-300 flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Add Product
      </button>
    </div>

    <!-- Filters -->
    <div class="bg-gray-800 rounded-xl p-4 flex flex-wrap gap-4 items-center">
      <div class="flex-1 min-w-64">
        <input v-model="filters.search" 
               @input="debouncedSearch"
               type="text" 
               placeholder="Search products..."
               class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
      </div>
      <select v-model="filters.category" 
              @change="fetchProducts"
              class="px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
        <option value="">All Categories</option>
        <option value="food">Food</option>
        <option value="beverage">Beverage</option>
        <option value="merchandise">Merchandise</option>
        <option value="service">Service</option>
        <option value="discount">Discount</option>
        <option value="other">Other</option>
      </select>
      <select v-model="filters.status" 
              @change="fetchProducts"
              class="px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
        <option value="">All Status</option>
        <option value="available">Available</option>
        <option value="unavailable">Unavailable</option>
      </select>
    </div>

    <!-- Products Grid -->
    <div v-if="loading" class="text-center py-12">
      <div class="inline-block w-8 h-8 border-4 border-purple-500/30 border-t-purple-500 rounded-full animate-spin"></div>
      <p class="text-gray-400 mt-4">Loading products...</p>
    </div>

    <div v-else-if="products.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-for="product in products" :key="product.id" 
           class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl overflow-hidden hover:scale-105 transition-transform duration-300">
        <!-- Product Image -->
        <div class="h-48 bg-gray-700 relative overflow-hidden">
          <img v-if="product.image_url" 
               :src="product.image_url" 
               :alt="product.name"
               class="w-full h-full object-cover">
          <div v-else class="w-full h-full flex items-center justify-center">
            <svg class="w-16 h-16 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
            </svg>
          </div>
          
          <!-- Status Badge -->
          <div class="absolute top-3 left-3">
            <span :class="[
              'px-3 py-1 rounded-full text-xs font-semibold',
              product.is_available ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30'
            ]">
              {{ product.is_available ? 'Available' : 'Unavailable' }}
            </span>
          </div>

          <!-- Stock Badge -->
          <div class="absolute top-3 right-3">
            <span :class="[
              'px-3 py-1 rounded-full text-xs font-semibold border',
              getStockBadgeClass(product)
            ]">
              {{ getStockText(product) }}
            </span>
          </div>
        </div>

        <!-- Product Info -->
        <div class="p-6">
          <div class="flex justify-between items-start mb-3">
            <h3 class="text-lg font-semibold text-white line-clamp-2">{{ product.name }}</h3>
            <span class="text-purple-400 font-bold text-lg ml-2">{{ product.points_price }} pts</span>
          </div>
          
          <p class="text-gray-400 text-sm mb-4 line-clamp-2">{{ product.description }}</p>
          
          <div class="flex items-center justify-between mb-4">
            <span class="text-xs text-gray-500 bg-gray-700/50 px-2 py-1 rounded-full capitalize">
              {{ product.category }}
            </span>
            <span v-if="product.cash_equivalent" class="text-xs text-gray-500">
              ~${{ product.cash_equivalent }}
            </span>
          </div>

          <!-- Action Buttons -->
          <div class="flex gap-2">
            <button @click="editProduct(product)" 
                    class="flex-1 px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition-colors text-sm">
              Edit
            </button>
            <button @click="toggleAvailability(product)" 
                    :class="[
                      'flex-1 px-4 py-2 rounded-lg transition-colors text-sm',
                      product.is_available 
                        ? 'bg-red-600 hover:bg-red-700 text-white' 
                        : 'bg-green-600 hover:bg-green-700 text-white'
                    ]">
              {{ product.is_available ? 'Disable' : 'Enable' }}
            </button>
            <button @click="deleteProduct(product)" 
                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-else class="text-center py-12">
      <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
      </svg>
      <p class="text-gray-400 text-lg">No products found</p>
      <p class="text-gray-500 text-sm mt-2">Create your first product to start selling with points.</p>
      <button @click="showCreateModal = true" 
              class="mt-4 px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-xl font-semibold hover:from-purple-600 hover:to-pink-600 transition-all duration-300">
        Create Product
      </button>
    </div>

    <!-- Create/Edit Modal -->
    <div v-if="showCreateModal || showEditModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
      <div class="bg-gray-800 rounded-2xl border border-gray-700 w-full max-w-2xl max-h-[90vh] overflow-hidden">
        <!-- Modal Header -->
        <div class="p-6 border-b border-gray-700">
          <div class="flex justify-between items-center">
            <h3 class="text-xl font-bold text-white">
              {{ showCreateModal ? 'Create Product' : 'Edit Product' }}
            </h3>
            <button @click="closeModals" 
                    class="text-gray-400 hover:text-white transition-colors">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
        </div>

        <!-- Modal Body -->
        <form @submit.prevent="submitProductForm" class="p-6 overflow-y-auto max-h-[70vh] space-y-6">
          <!-- Basic Information -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-300 mb-2">Product Name *</label>
              <input v-model="productForm.name" type="text" required
                     class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-2">Points Price *</label>
              <input v-model="productForm.points_price" type="number" min="1" required
                     class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-2">Cash Equivalent</label>
              <input v-model="productForm.cash_equivalent" type="number" step="0.01" min="0"
                     class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                     placeholder="Optional">
            </div>
          </div>

          <!-- Description -->
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Description *</label>
            <textarea v-model="productForm.description" required rows="3"
                      class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                      placeholder="Describe your product..."></textarea>
          </div>

          <!-- Image Upload -->
          <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">Product Image</label>
            <div class="space-y-4">
              <!-- Image Preview -->
              <div v-if="imagePreview" class="relative">
                <img :src="imagePreview" alt="Preview" class="w-full h-48 object-cover rounded-lg">
                <button @click="removeImage" type="button"
                        class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                  </svg>
                </button>
              </div>
              
              <!-- Upload Button -->
              <div class="border-2 border-dashed border-gray-600 rounded-lg p-6 text-center hover:border-purple-500 transition-colors">
                <input ref="imageInput" @change="handleImageUpload" type="file" accept="image/*" class="hidden">
                <button @click="$refs.imageInput.click()" type="button"
                        class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition-colors">
                  {{ imagePreview ? 'Change Image' : 'Upload Image' }}
                </button>
                <p class="text-gray-400 text-sm mt-2">JPEG, PNG, JPG, GIF - Max 2MB</p>
              </div>
            </div>
          </div>

          <!-- Additional Information -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-2">Category *</label>
              <select v-model="productForm.category" required
                      class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                <option value="">Select Category</option>
                <option value="food">Food</option>
                <option value="beverage">Beverage</option>
                <option value="merchandise">Merchandise</option>
                <option value="service">Service</option>
                <option value="discount">Discount</option>
                <option value="other">Other</option>
              </select>
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-300 mb-2">Stock Quantity *</label>
              <input v-model="productForm.stock_quantity" type="number" min="-1" required
                     class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                     placeholder="-1 for unlimited">
            </div>
            
            <div class="flex items-end">
              <label class="flex items-center cursor-pointer">
                <input v-model="productForm.is_available" type="checkbox" class="sr-only">
                <div :class="[
                  'relative w-11 h-6 rounded-full transition-colors duration-200',
                  productForm.is_available ? 'bg-purple-500' : 'bg-gray-600'
                ]">
                  <div :class="[
                    'absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full transition-transform duration-200',
                    productForm.is_available ? 'translate-x-5' : 'translate-x-0'
                  ]"></div>
                </div>
                <span class="ml-3 text-sm font-medium text-gray-300">Available</span>
              </label>
            </div>
          </div>

          <!-- Submit Buttons -->
          <div class="flex gap-4">
            <button type="button" @click="closeModals" 
                    class="flex-1 px-6 py-3 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition-colors">
              Cancel
            </button>
            <button type="submit" :disabled="submitting"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg hover:from-purple-600 hover:to-pink-600 transition-all duration-300 disabled:opacity-50">
              {{ submitting ? 'Saving...' : (showCreateModal ? 'Create Product' : 'Update Product') }}
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
  name: 'PartnerProductManagement',
  data() {
    return {
      loading: true,
      products: [],
      showCreateModal: false,
      showEditModal: false,
      submitting: false,
      selectedImage: null,
      imagePreview: null,
      searchTimeout: null,
      filters: {
        search: '',
        category: '',
        status: ''
      },
      productForm: {
        name: '',
        description: '',
        points_price: '',
        cash_equivalent: '',
        stock_quantity: '',
        category: '',
        is_available: true,
        metadata: null
      }
    };
  },
  async mounted() {
    await this.fetchProducts();
  },
  methods: {
    async fetchProducts() {
      try {
        this.loading = true;
        const params = {
          my_products: true,
          ...this.filters
        };
        
        // Handle availability filter
        if (this.filters.status === 'available') {
          params.is_available = true;
        } else if (this.filters.status === 'unavailable') {
          params.is_available = false;
        }
        delete params.status;

        const response = await axios.get('/api/products', { params });
        this.products = response.data.data || response.data;
        
        console.log('Fetched products:', {
          params: params,
          responseData: response.data,
          productsCount: this.products.length,
          products: this.products
        });
      } catch (error) {
        console.error('Error fetching products:', error);
        this.$toast?.error?.('Failed to fetch products');
      } finally {
        this.loading = false;
      }
    },

    debouncedSearch() {
      clearTimeout(this.searchTimeout);
      this.searchTimeout = setTimeout(() => {
        this.fetchProducts();
      }, 500);
    },

    editProduct(product) {
      this.productForm = {
        id: product.id,
        name: product.name,
        description: product.description,
        points_price: product.points_price,
        cash_equivalent: product.cash_equivalent || '',
        stock_quantity: product.stock_quantity,
        category: product.category,
        is_available: product.is_available,
        metadata: product.metadata
      };
      
      if (product.image_url) {
        this.imagePreview = product.image_url;
      }
      
      this.showEditModal = true;
    },

    async toggleAvailability(product) {
      try {
        await axios.put(`/api/products/${product.id}`, {
          is_available: !product.is_available
        });
        
        product.is_available = !product.is_available;
        this.$toast?.success?.(`Product ${product.is_available ? 'enabled' : 'disabled'} successfully`);
      } catch (error) {
        console.error('Error updating product:', error);
        this.$toast?.error?.('Failed to update product');
      }
    },

    async deleteProduct(product) {
      if (!confirm(`Are you sure you want to delete "${product.name}"? This action cannot be undone.`)) {
        return;
      }

      try {
        await axios.delete(`/api/products/${product.id}`);
        this.products = this.products.filter(p => p.id !== product.id);
        this.$toast?.success?.('Product deleted successfully');
      } catch (error) {
        console.error('Error deleting product:', error);
        this.$toast?.error?.('Failed to delete product');
      }
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
      this.productForm.image_url = '';
      if (this.$refs.imageInput) {
        this.$refs.imageInput.value = '';
      }
    },

    async submitProductForm() {
      try {
        this.submitting = true;
        
        // Get CSRF token
        await axios.get('/sanctum/csrf-cookie');
        
        // Create FormData for file upload
        const formData = new FormData();
        
        // Add all form fields
        Object.keys(this.productForm).forEach(key => {
          if (key !== 'id' && this.productForm[key] !== '' && this.productForm[key] !== null && this.productForm[key] !== undefined) {
            // Handle boolean fields properly
            if (typeof this.productForm[key] === 'boolean') {
              formData.append(key, this.productForm[key] ? '1' : '0');
            } else {
              formData.append(key, this.productForm[key]);
            }
          }
        });
        
        // Ensure is_available is always sent
        formData.append('is_available', this.productForm.is_available ? '1' : '0');
        
        console.log('Submitting product form:', {
          formFields: Object.fromEntries(formData),
          isCreate: this.showCreateModal,
          hasImage: !!this.selectedImage
        });
        
        // Add image if selected
        if (this.selectedImage) {
          formData.append('image', this.selectedImage);
        }
        
        let response;
        if (this.showCreateModal) {
          response = await axios.post('/api/products', formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          });
          this.products.unshift(response.data);
          this.$toast?.success?.('Product created successfully');
        } else {
          // For updates, use POST with _method
          formData.append('_method', 'PUT');
          response = await axios.post(`/api/products/${this.productForm.id}`, formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          });
          
          // Update the product in the list
          const index = this.products.findIndex(p => p.id === this.productForm.id);
          if (index !== -1) {
            this.products[index] = response.data;
          }
          this.$toast?.success?.('Product updated successfully');
        }
        
        this.closeModals();
      } catch (error) {
        console.error('Error saving product:', error);
        this.$toast?.error?.('Failed to save product');
      } finally {
        this.submitting = false;
      }
    },

    closeModals() {
      this.showCreateModal = false;
      this.showEditModal = false;
      this.selectedImage = null;
      this.imagePreview = null;
      this.productForm = {
        name: '',
        description: '',
        points_price: '',
        cash_equivalent: '',
        stock_quantity: '',
        category: '',
        is_available: true,
        metadata: null
      };
      if (this.$refs.imageInput) {
        this.$refs.imageInput.value = '';
      }
    },

    getStockBadgeClass(product) {
      if (product.stock_quantity === -1) {
        return 'bg-blue-500/20 text-blue-400 border-blue-500/30';
      } else if (product.stock_quantity === 0) {
        return 'bg-red-500/20 text-red-400 border-red-500/30';
      } else if (product.stock_quantity <= 5) {
        return 'bg-yellow-500/20 text-yellow-400 border-yellow-500/30';
      }
      return 'bg-green-500/20 text-green-400 border-green-500/30';
    },

    getStockText(product) {
      if (product.stock_quantity === -1) {
        return 'Unlimited';
      } else if (product.stock_quantity === 0) {
        return 'Out of Stock';
      } else if (product.stock_quantity <= 5) {
        return `${product.stock_quantity} left`;
      }
      return 'In Stock';
    }
  }
};
</script>
