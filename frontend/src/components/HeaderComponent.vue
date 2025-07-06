<template>
  <nav class="w-full bg-white border-gray-200 dark:bg-black dark:border-gray-700">
    <div class="flex flex-wrap items-center justify-between w-full p-4">
      <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
        <img src="/biblioteca_logo.png" class="h-8" alt="Logo" />
      </a>
      <button data-collapse-toggle="navbar-dropdown" type="button"
        class="inline-flex items-center justify-center w-10 h-10 p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
        aria-controls="navbar-dropdown" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M1 1h15M1 7h15M1 13h15" />
        </svg>
      </button>
      <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
        <ul
          class="flex items-center flex-col p-4 mt-4 font-medium border border-gray-100 rounded-lg md:p-0 bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-black md:dark:bg-black dark:border-gray-700">
          <li>
            <router-link :to="{ name: 'home' }"
              class="block px-3 py-2 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Home</router-link>
          </li>
          <li>
            <router-link :to="{ name: 'aboutus' }"
              class="block px-3 py-2 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Chi
              siamo</router-link>
          </li>
          <li>
            <a href="#"
              class="block px-3 py-2 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Eventi</a>
          </li>
          <li>
            <router-link :to="{ name: 'articles' }"
              class="block px-3 py-2 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">News</router-link>
          </li>
          <li>
            <a href="#"
              class="block px-3 py-2 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Contatti</a>
          </li>
          <li v-if="!store.isLoggedIn">
            <router-link :to="{ name: 'login' }"
              class="block px-3 py-2 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Login</router-link>
          </li>
          <!-- dropdown -->
          <li v-else class="flex ">
            <div>
              <!-- mostra immagine -->
              <div v-if="store.CurrentUser.info.profile_img" id="userImg" class="overflow-hidden image">
                <img class=" w-100 "
                  :src="store.CurrentUser.info.profile_img"
                  :alt="store.CurrentUser.display_name">
              </div>
              <!-- oppure mostra iniziali -->
              <div v-else>
                <span id="userInitials" class="mr-4 text-2xl font-semibold text-gray-900 dark:text-white">
                  {{ store.CurrentUser.initials }}
                </span>
              </div>
            </div>
            <button id="dropdownNavbarLink" data-dropdown-toggle="menuUser"
              class="flex items-center justify-between w-full px-3 py-2 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent">
              {{ store.CurrentUser.display_name }}
              <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 4 4 4-4" />
              </svg>
            </button>
            <!-- Dropdown menu -->
            <div id="menuUser"
              class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600">
              <ul class="py-2 text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                <li>
                  <a href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                </li>
                <li>
                  <a href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                </li>
                <li>
                  <a href="#"
                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a>
                </li>
              </ul>
              <div class="py-1">
                <div type="button" @click="onLogout"
                  class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                  Sign Out
                </div>
              </div>
            </div>
          </li>
        </ul>
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
  import 'swiper/css';
  import 'swiper/css/navigation';
  import 'swiper/css/pagination';
  import 'swiper/css/scrollbar';
  import { store } from "../store.js";


  export default {
    name: "HeaderComponent",
    components: {
      Swiper,
      SwiperSlide,
    },
    props: [
      'onLogout'
    ],
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
        console.log('slide change');
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
  #userImg,
 #userInitials  {
    border: #df9a04 2px solid;
    border-radius: 100%;
    width: 50px;
    height: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-right: 10px;
  }

  .swiper {
    --swiper-navigation-color: #df9a04;
    --swiper-pagination-color: #df9a04;
    --swiper-navigation-sides-offset: 5%;
    --swiper-navigation-size: 30px;
  }

</style>
