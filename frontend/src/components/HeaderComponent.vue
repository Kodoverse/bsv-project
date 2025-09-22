<template>
  <nav
    class="w-full border-b bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 backdrop-blur-sm border-gray-700/30"
  >
    <div class="w-full px-2 sm:px-4 lg:px-6">
      <div class="flex items-center justify-between h-16">
        <a href="#" class="flex items-center space-x-2">
          <img src="/biblioteca_logo.png" class="w-auto h-8" alt="Logo" />
        </a>

        <!-- Mobile menu button -->
        <button
          data-collapse-toggle="navbar-dropdown"
          type="button"
          class="inline-flex items-center justify-center w-10 h-10 p-2 text-gray-400 transition-colors rounded-lg md:hidden hover:bg-gray-700/50 hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-600"
          aria-controls="navbar-dropdown"
          aria-expanded="false"
        >
          <span class="sr-only">Open main menu</span>
          <svg
            class="w-5 h-5"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 17 14"
          >
            <path
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M1 1h15M1 7h15M1 13h15"
            />
          </svg>
        </button>

        <!-- Desktop menu -->
        <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
          <ul class="flex items-center space-x-2">
            <li>
              <router-link
                :to="{ name: 'home' }"
                class="px-2 py-2 font-medium text-gray-300 transition-all duration-200 rounded-lg hover:text-white hover:bg-gray-700/50"
              >
                Home
              </router-link>
            </li>
            <li>
              <router-link
                :to="{ name: 'aboutus' }"
                class="px-2 py-2 font-medium text-gray-300 transition-all duration-200 rounded-lg hover:text-white hover:bg-gray-700/50"
              >
                Chi siamo
              </router-link>
            </li>
            <li>
              <a
                href="#"
                class="px-2 py-2 font-medium text-gray-300 transition-all duration-200 rounded-lg hover:text-white hover:bg-gray-700/50"
              >
                Eventi
              </a>
            </li>
            <li>
              <router-link
                :to="{ name: 'articles' }"
                class="px-2 py-2 font-medium text-gray-300 transition-all duration-200 rounded-lg hover:text-white hover:bg-gray-700/50"
              >
                News
              </router-link>
            </li>
            <li>
              <router-link
                :to="{ name: 'shopping' }"
                class="px-2 py-2 font-medium text-gray-300 transition-all duration-200 rounded-lg hover:text-white hover:bg-gray-700/50"
              >
                Shop
              </router-link>
            </li>
            <li>
              <a
                href="#"
                class="px-2 py-2 font-medium text-gray-300 transition-all duration-200 rounded-lg hover:text-white hover:bg-gray-700/50"
              >
                Contatti
              </a>
            </li>
            <li v-if="!store.isLoggedIn">
              <router-link
                :to="{ name: 'login' }"
                class="px-3 py-2 font-medium text-white transition-all duration-200 rounded-lg shadow-lg bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 hover:shadow-xl"
              >
                Login
              </router-link>
            </li>

            <!-- User dropdown -->
            <li v-else class="relative">
              <div class="flex items-center space-x-2">
                <!-- User avatar -->
                <div
                  v-if="store.CurrentUser?.info?.profile_img"
                  id="userImg"
                  class="overflow-hidden"
                >
                  <img
                    class="object-cover w-8 h-8 rounded-full"
                    :src="store.CurrentUser.info.profile_img"
                    :alt="store.CurrentUser.display_name"
                  />
                </div>
                <div
                  v-else
                  id="userInitials"
                  class="flex items-center justify-center w-8 h-8 text-sm font-semibold text-white rounded-full bg-gradient-to-r from-orange-500 to-red-500"
                >
                  {{ store.CurrentUser.initials }}
                </div>

                <button
                  id="dropdownNavbarLink"
                  data-dropdown-toggle="menuUser"
                  class="flex items-center px-1 py-2 space-x-1 font-medium text-gray-300 transition-all duration-200 rounded-lg hover:text-white hover:bg-gray-700/50"
                >
                  <span>{{ store.CurrentUser.display_name }}</span>
                  <svg
                    class="w-4 h-4"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 10 6"
                  >
                    <path
                      stroke="currentColor"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="m1 1 4 4 4-4"
                    />
                  </svg>
                </button>
              </div>
              <!-- Dropdown menu -->
              <div
                id="menuUser"
                class="absolute right-0 z-50 hidden w-48 mt-2 border border-gray-700 shadow-xl bg-gray-800/95 backdrop-blur-sm rounded-xl"
              >
                <ul
                  class="py-2 text-sm text-gray-300"
                  aria-labelledby="dropdownLargeButton"
                >
                  <li>
                    <router-link
                      :to="{ name: 'profile' }"
                      class="flex items-center px-4 py-3 transition-colors duration-200 hover:bg-gray-700/50 hover:text-white"
                    >
                      <svg
                        class="w-4 h-4 mr-3"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                        />
                      </svg>
                      Profile
                    </router-link>
                  </li>
                  <li v-if="store.hasAdminPrivileges">
                    <router-link
                      :to="{ name: 'admin-dashboard' }"
                      class="flex items-center px-4 py-3 transition-colors duration-200 hover:bg-gray-700/50 hover:text-white"
                    >
                      <svg
                        class="w-4 h-4 mr-3"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                      >
                        <path
                          d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"
                        />
                      </svg>
                      Admin Dashboard
                    </router-link>
                  </li>
                  <li v-if="store.isPartner">
                    <router-link
                      :to="{ name: 'partner-dashboard' }"
                      class="flex items-center px-4 py-3 transition-colors duration-200 hover:bg-gray-700/50 hover:text-white"
                    >
                      <svg
                        class="w-4 h-4 mr-3"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                      >
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                        <path
                          fill-rule="evenodd"
                          d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"
                          clip-rule="evenodd"
                        />
                      </svg>
                      Partner Dashboard
                    </router-link>
                  </li>
                  <li>
                    <a
                      href="#"
                      class="flex items-center px-4 py-3 transition-colors duration-200 hover:bg-gray-700/50 hover:text-white"
                    >
                      <svg
                        class="w-4 h-4 mr-3"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                        />
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                      </svg>
                      Settings
                    </a>
                  </li>
                </ul>
                <div class="py-1 border-t border-gray-700">
                  <button
                    type="button"
                    @click="onLogout"
                    class="flex items-center w-full px-4 py-3 text-sm text-red-400 transition-colors duration-200 hover:bg-red-500/10 hover:text-red-300"
                  >
                    <svg
                      class="w-4 h-4 mr-3"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                      />
                    </svg>
                    Sign Out
                  </button>
                </div>
              </div>
            </li>
          </ul>
        </div>

        <!-- Mobile menu -->
        <div class="md:hidden" id="navbar-dropdown">
          <div
            class="px-2 pt-2 pb-3 mt-2 space-y-1 rounded-lg sm:px-3 bg-gray-800/95 backdrop-blur-sm"
          >
            <router-link
              :to="{ name: 'home' }"
              class="block px-3 py-2 text-gray-300 transition-colors duration-200 rounded-lg hover:text-white hover:bg-gray-700/50"
              >Home</router-link
            >
            <router-link
              :to="{ name: 'aboutus' }"
              class="block px-3 py-2 text-gray-300 transition-colors duration-200 rounded-lg hover:text-white hover:bg-gray-700/50"
              >Chi siamo</router-link
            >
            <a
              href="#"
              class="block px-3 py-2 text-gray-300 transition-colors duration-200 rounded-lg hover:text-white hover:bg-gray-700/50"
              >Eventi</a
            >
            <router-link
              :to="{ name: 'articles' }"
              class="block px-3 py-2 text-gray-300 transition-colors duration-200 rounded-lg hover:text-white hover:bg-gray-700/50"
              >News</router-link
            >
            <router-link
              :to="{ name: 'shopping' }"
              class="block px-3 py-2 text-gray-300 transition-colors duration-200 rounded-lg hover:text-white hover:bg-gray-700/50"
              >Shop</router-link
            >
            <a
              href="#"
              class="block px-3 py-2 text-gray-300 transition-colors duration-200 rounded-lg hover:text-white hover:bg-gray-700/50"
              >Contatti</a
            >
            <div v-if="!store.isLoggedIn" class="pt-2">
              <router-link
                :to="{ name: 'login' }"
                class="block px-3 py-2 font-medium text-center text-white transition-all duration-200 rounded-lg bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600"
                >Login</router-link
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
  <!-- <swiper :modules="modules" :loop="true" :autoplay="{ delay: 3000 }" :slides-per-view="1" :space-between="50"
    navigation :pagination="{ clickable: true }" @swiper="onSwiper" @slideChange="onSlideChange" class="h-96 swiper">
    <swiper-slide><img src=""></swiper-slide>
    <swiper-slide><img src=""></swiper-slide>
    <swiper-slide><img src=""></swiper-slide>
  </swiper> -->
</template>

<script>
// import Swiper core and required modules
import { Navigation, Pagination, A11y, Autoplay } from "swiper/modules";

// Import Swiper Vue.js components
import { Swiper, SwiperSlide } from "swiper/vue";

// Import Swiper styles
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";
import "swiper/css/scrollbar";
import { store } from "../store.js";

export default {
  name: "HeaderComponent",
  components: {
    Swiper,
    SwiperSlide,
  },
  props: ["onLogout"],
  data() {
    return {
      store,
    };
  },

  setup() {
    const onSwiper = (swiper) => {
      console.log(swiper);
    };
    const onSlideChange = () => {
      console.log("slide change");
    };
    return {
      onSwiper,
      onSlideChange,
      modules: [Navigation, Pagination, A11y, Autoplay],
    };
  },
};
</script>

<style scoped>
.swiper {
  --swiper-navigation-color: #df9a04;
  --swiper-pagination-color: #df9a04;
  --swiper-navigation-sides-offset: 5%;
  --swiper-navigation-size: 30px;
}
</style>
