<template>
  <div class="space-y-6">
    <!-- Header -->
    <div>
      <h2 class="text-2xl font-bold text-white">Customer Redemption Verification</h2>
      <p class="text-gray-400">Verify customer redemption codes and complete orders securely</p>
    </div>

    <!-- Redemption Code Verification -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl p-6">
      <h3 class="text-xl font-semibold text-white mb-4">Verify Redemption Code</h3>
      
      <div class="flex gap-4 mb-6">
        <div class="flex-1">
          <input v-model="redemptionCode" 
                 @keyup.enter="verifyCode"
                 type="text" 
                 placeholder="Enter redemption code"
                 class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent uppercase font-mono">
        </div>
        <button @click="verifyCode" 
                :disabled="!redemptionCode || verifying"
                class="px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg hover:from-purple-600 hover:to-pink-600 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
          {{ verifying ? 'Verifying...' : 'Verify' }}
        </button>
      </div>

      <!-- Verification Result -->
      <div v-if="verificationResult" class="mt-6">
        <div v-if="verificationResult.purchase" class="bg-gray-700/50 rounded-xl p-6">
          <div class="flex items-center justify-between mb-4">
            <h4 class="text-lg font-semibold text-white">Redemption Details</h4>
            <span :class="[
              'px-3 py-1 rounded-full text-xs font-semibold border',
              getStatusBadgeClass(verificationResult.purchase.status)
            ]">
              {{ getStatusText(verificationResult.purchase.status) }}
            </span>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Customer Info -->
            <div>
              <h5 class="text-purple-400 font-medium mb-2">Customer</h5>
              <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center text-white font-semibold">
                  {{ getInitials(verificationResult.purchase.user) }}
                </div>
                <div>
                  <p class="text-white font-medium">{{ getUserName(verificationResult.purchase.user) }}</p>
                  <p class="text-gray-400 text-sm">{{ verificationResult.purchase.user.email }}</p>
                </div>
              </div>
            </div>
            
            <!-- Product Info -->
            <div>
              <h5 class="text-purple-400 font-medium mb-2">Product</h5>
              <p class="text-white font-medium">{{ verificationResult.purchase.product.name }}</p>
              <p class="text-gray-400 text-sm mb-2">{{ verificationResult.purchase.product.description }}</p>
              <div class="flex items-center gap-4 text-sm">
                <span class="text-purple-400">{{ verificationResult.purchase.points_spent }} points</span>
                <span class="text-gray-400">Qty: {{ verificationResult.purchase.quantity }}</span>
              </div>
            </div>
          </div>
          
          <!-- Purchase Date -->
          <div class="mt-4 pt-4 border-t border-gray-600">
            <p class="text-gray-400 text-sm">
              <span class="font-medium">Purchased:</span> {{ formatDate(verificationResult.purchase.created_at) }}
            </p>
          </div>
          
          <!-- Action Buttons -->
          <div class="flex gap-3 mt-6">
            <button v-if="verificationResult.can_confirm || verificationResult.can_complete" 
                    @click="confirmAndCompleteOrder(verificationResult.purchase)"
                    :disabled="processing"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:from-green-700 hover:to-emerald-700 transition-all duration-200 disabled:opacity-50 font-semibold">
              {{ processing ? 'Processing...' : 'Confirm & Complete Order' }}
            </button>
            
            <button v-if="verificationResult.purchase.status === 'completed'" 
                    disabled
                    class="flex-1 px-6 py-3 bg-gray-600 text-white rounded-lg opacity-50 cursor-not-allowed">
              ✅ Order Completed
            </button>
            
            <button v-if="verificationResult.purchase.status !== 'completed' && verificationResult.purchase.status !== 'cancelled'" 
                    @click="cancelRedemption(verificationResult.purchase)"
                    :disabled="processing"
                    class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors disabled:opacity-50">
              {{ processing ? 'Processing...' : 'Cancel' }}
            </button>
          </div>
        </div>
        
        <!-- Error State -->
        <div v-else class="bg-red-900/20 border border-red-500/30 rounded-xl p-6">
          <div class="flex items-center gap-3 text-red-400">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="font-medium">Invalid Redemption Code</p>
          </div>
          <p class="text-red-300 text-sm mt-2">This redemption code was not found or does not belong to your business.</p>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Manual Entry -->
      <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl p-6 text-center">
        <div class="w-16 h-16 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
          </svg>
        </div>
        <h3 class="text-white font-semibold mb-2">Enter Code</h3>
        <p class="text-gray-400 text-sm mb-4">Type redemption code in the field above</p>
        <button @click="focusCodeInput" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
          Focus Input
        </button>
      </div>
      
      <!-- View Sales History -->
      <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl p-6 text-center">
        <div class="w-16 h-16 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
          </svg>
        </div>
        <h3 class="text-white font-semibold mb-2">Sales Analytics</h3>
        <p class="text-gray-400 text-sm mb-4">View completed transactions and earnings</p>
        <button @click="$emit('switch-tab', 'sales')" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
          View Sales History
        </button>
      </div>
    </div>

    <!-- Instructions for Partners -->
    <div class="bg-gradient-to-br from-blue-900/20 to-purple-900/20 border border-blue-500/30 rounded-2xl p-6">
      <h3 class="text-xl font-semibold text-white mb-4">How to Process Redemptions</h3>
      
      <div class="space-y-3 text-gray-300">
        <div class="flex items-start gap-3">
          <span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-semibold mt-0.5">1</span>
          <p>Customer provides their <strong>redemption code</strong> to you</p>
        </div>
        <div class="flex items-start gap-3">
          <span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-semibold mt-0.5">2</span>
          <p>Enter the code above and click <strong>"Verify"</strong></p>
        </div>
        <div class="flex items-start gap-3">
          <span class="bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-semibold mt-0.5">3</span>
          <p>Review the order details and click <strong>"Confirm & Complete Order"</strong></p>
        </div>
        <div class="flex items-start gap-3">
          <span class="bg-green-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-semibold mt-0.5">4</span>
          <p>Provide the product/service to the customer</p>
        </div>
      </div>
      
      <div class="mt-4 p-4 bg-yellow-900/20 border border-yellow-500/30 rounded-lg">
        <p class="text-yellow-200 text-sm">
          <strong>🔒 Security Note:</strong> Only valid redemption codes from your customers will work. 
          Each code can only be used once and expires after completion.
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'PartnerRedemptionInterface',
  emits: ['switch-tab'],
  data() {
    return {
      redemptionCode: '',
      verifying: false,
      processing: false,
      verificationResult: null
    };
  },
  mounted() {
    // Component ready
  },
  methods: {
    async verifyCode() {
      if (!this.redemptionCode) return;
      
      try {
        this.verifying = true;
        this.verificationResult = null;
        
        const response = await axios.post('/api/purchases/verify', {
          redemption_code: this.redemptionCode.toUpperCase()
        });
        
        this.verificationResult = response.data;
      } catch (error) {
        console.error('Error verifying code:', error);
        this.verificationResult = { purchase: null };
        this.$toast?.error?.('Invalid redemption code');
      } finally {
        this.verifying = false;
      }
    },

    async confirmAndCompleteOrder(purchase) {
      try {
        this.processing = true;
        
        // If order is pending, confirm it first, then complete
        if (purchase.status === 'pending') {
          await axios.post(`/api/purchases/${purchase.id}/confirm`);
        }
        
        // Complete the order
        await axios.post(`/api/purchases/${purchase.id}/complete`);
        
        // Update local data
        purchase.status = 'completed';
        this.verificationResult.can_confirm = false;
        this.verificationResult.can_complete = false;
        
        // Clear the form
        this.redemptionCode = '';
        this.verificationResult = null;
        
        alert('✅ Order completed successfully! Product has been redeemed.');
        
      } catch (error) {
        console.error('Error processing redemption:', error);
        alert('❌ Failed to process redemption. Please try again.');
      } finally {
        this.processing = false;
      }
    },


    async cancelRedemption(purchase) {
      if (!confirm('Are you sure you want to cancel this redemption? Points will be refunded to the customer.')) {
        return;
      }

      try {
        this.processing = true;
        await axios.post(`/api/purchases/${purchase.id}/cancel`, {
          reason: 'Cancelled by partner during redemption'
        });
        
        // Update local data
        purchase.status = 'cancelled';
        
        alert('❌ Redemption cancelled and points refunded to customer.');
        
        // Clear the form
        this.redemptionCode = '';
        this.verificationResult = null;
      } catch (error) {
        console.error('Error cancelling redemption:', error);
        this.$toast?.error?.('Failed to cancel redemption');
      } finally {
        this.processing = false;
      }
    },


    focusCodeInput() {
      this.$nextTick(() => {
        const input = this.$el.querySelector('input[type="text"]');
        if (input) {
          input.focus();
        }
      });
    },

    formatDate(dateString) {
      if (!dateString) return '';
      const date = new Date(dateString);
      return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      });
    },

    formatTime(dateString) {
      if (!dateString) return '';
      const date = new Date(dateString);
      return date.toLocaleTimeString('en-US', {
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
    },

    getStatusBadgeClass(status) {
      switch (status) {
        case 'pending':
          return 'bg-yellow-500/20 text-yellow-400 border-yellow-500/30';
        case 'confirmed':
          return 'bg-blue-500/20 text-blue-400 border-blue-500/30';
        case 'completed':
          return 'bg-green-500/20 text-green-400 border-green-500/30';
        case 'cancelled':
          return 'bg-red-500/20 text-red-400 border-red-500/30';
        default:
          return 'bg-gray-500/20 text-gray-400 border-gray-500/30';
      }
    },

    getStatusText(status) {
      switch (status) {
        case 'pending':
          return 'Pending';
        case 'confirmed':
          return 'Confirmed';
        case 'completed':
          return 'Completed';
        case 'cancelled':
          return 'Cancelled';
        default:
          return 'Unknown';
      }
    }
  }
};
</script>