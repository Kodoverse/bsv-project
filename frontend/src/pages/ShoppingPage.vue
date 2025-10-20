<template>
  <div class="flex flex-col w-full bg-black text-white h-screen">
    <div class="h-60 pt-12">
      <h1
        class="mb-10 text-center text-4xl font-extrabold tracking-tight leading-none md:text-5xl lg:text-6xl text-orange-500">
        I nostri partners
      </h1>
      <div id="filter" class="w-full max-w-2xl mx-auto grid-cols-3">
        <form class="w-full mx-auto">
          <div class="flex">
            <label for="search-dropdown" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Your
              Email</label>
            <button id="dropdown-button" data-dropdown-toggle="dropdown"
              class="shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600"
              type="button">
              All categories
              <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 4 4 4-4" />
              </svg>
            </button>
            <div id="dropdown"
              class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
              <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-button">
                <li>
                  <button type="button"
                    class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                    Mockups
                  </button>
                </li>
                <li>
                  <button type="button"
                    class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                    Templates
                  </button>
                </li>
                <li>
                  <button type="button"
                    class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                    Design
                  </button>
                </li>
                <li>
                  <button type="button"
                    class="inline-flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                    Logos
                  </button>
                </li>
              </ul>
            </div>
            <div class="relative w-full">
              <input type="search" id="search-dropdown"
                class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-s-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                placeholder="Search Mockups, Logos, Design Templates..." required />
              <button type="submit"
                class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                  viewBox="0 0 20 20">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
                <span class="sr-only">Search</span>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Businesses Grid Sezione delle card dei negozi -->
    <div v-if="loading" class="flex justify-center py-12 h-auto">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-orange-500"></div>
    </div>
    <div v-else-if="businesses.length === 0" class="text-center py-12">
      <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd"
          d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
          clip-rule="evenodd" />
      </svg>
      <p class="text-xl text-gray-400">No businesses found</p>
      <p class="text-gray-500">Try adjusting your search or category filter</p>
    </div>
    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-5 mt-5 h-full">
      <!-- LISTA DEI NEGOZI DI CHIUNQUE -->
      <router-link :to="{ name: 'product-list', params: { id: business.id } }" v-for="business in businesses"
        :key="business.id"
        class="group block rounded-xl border border-gray-700 hover:border-orange-500 transition-all duration-200 cursor-pointer h-[350px] overflow-hidden bg-gray-800">
        <!-- Business Logo / Header -->
        <div :style="{ backgroundImage: `url(http://localhost:8000${business.logo})` }"
          class="h-45 bg-cover bg-center bg-no-repeat shadow-md"></div>

        <!-- Contenuto -->
        <div class="p-3 flex flex-col justify-between h-[calc(300px-8rem)]"> <!-- 32px*2 + padding -->
          <div>
            <div class="flex justify-between">
              <h3 class="text-lg font-semibold text-white group-hover:text-orange-400 transition-colors">
                {{ business.name }}
              </h3>
              <span
                class="inline-block px-2 py-1 bg-orange-600/20 text-orange-400 rounded-full text-sm font-medium capitalize mt-1">
                {{ business.business_category.name }}
              </span>
            </div>

            <p v-if="business.description" class="text-gray-300 text-sm mt-2 line-clamp-2">
              {{ business.description }}
            </p>

            <div class="space-y-1 text-gray-400 text-sm mt-2">
              <div v-if="business.address" class="flex items-center space-x-1">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd"
                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                    clip-rule="evenodd" />
                </svg>
                <span class="truncate">{{ business.address }}</span>
              </div>
              <div v-if="business.contact_phone" class="flex items-center space-x-1">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                  <path
                    d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                </svg>
                <span>{{ business.contact_phone }}</span>
              </div>
            </div>
          </div>

          <!-- Footer: Products count -->
          <div class="flex justify-between items-center pt-2 border-t border-gray-700 text-sm text-gray-400">
            <span>{{ business.products_count || 0 }} {{ business.products_count === 1 ? "product" : "products" }}</span>
            <svg class="w-5 h-5 text-orange-400 group-hover:translate-x-1 transition-transform" fill="currentColor"
              viewBox="0 0 20 20">
              <path fill-rule="evenodd"
                d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                clip-rule="evenodd" />
            </svg>
          </div>
        </div>
      </router-link>
    </div>
  </div>

  <!-- ######################################################## CRIMINALI ########################################################## -->
</template>

<script>
  import { store } from "../store.js";
  import axios from "axios";
  import { useRouter } from "vue-router";

  export default {
    name: "ShoppingPage",
    props: {
      id: String,
    },
    data() {
      return {
        store,
        loading: true,
        productsLoading: false,
        purchaseHistoryLoading: false,
        businesses: [],
        products: [],
        categories: {},
      };
    },
    mounted() {
      // If business ID is provided in route, load that business directly

      this.fetchBusinesses();
    },
    watch: {
      showPurchaseHistory: {
        async handler(newVal) {
          if (newVal && store.isLoggedIn) {
            await this.fetchPurchaseHistory();
          }
        },
        immediate: false,
      },
    },
    methods: {
      // questo va bene
      async fetchBusinesses() {
        try {
          this.loading = true;
          const params = { ...this.businessFilters };

          const response = await axios.get("/api/businesses/negozi", { params });
          this.businesses = response.data.data || response.data;
          console.log(this.businesses);
        } catch (error) {
          console.error("Error fetching businesses:", error);
        } finally {
          this.loading = false;
        }
      },
      /////////////////////////////////////////////////////////////////////////

      formatDate(dateString) {
        return new Date(dateString).toLocaleDateString();
      },

      formatDateTime(dateString) {
        return new Date(dateString).toLocaleString();
      },
    },
  };
</script>

<style scoped>

  .line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
</style>
