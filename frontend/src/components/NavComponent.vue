<template>
  <nav class="nav-brutalist">
    <div class="w-full px-4 lg:px-12">
      <div class="flex items-center justify-between h-20">
        <!-- Logo -->
        <router-link :to="{ name: 'home' }" class="flex items-center group">
          <img
            src="/biblioteca_logo.png"
            class="w-auto h-10 transition-all"
            alt="Logo"
          />
        </router-link>

        <!-- Navigation Links -->
        <div class="hidden md:block">
          <ul class="flex items-center space-x-1">
            <li v-for="link in navLinks" :key="link.label">
              <router-link :to="link.to" class="nav-item">{{
                link.label
              }}</router-link>
            </li>

            <!-- Login Button -->
            <li v-if="!store.isLoggedIn" class="pl-4">
              <router-link :to="{ name: 'login' }" class="login-btn-brutalist"
                >LOGIN</router-link
              >
            </li>

            <!-- User Dropdown Gestito da Vue -->
            <li v-else class="relative pl-4" @mouseleave="isMenuOpen = false">
              <div
                class="flex items-center py-2 space-x-3 cursor-pointer"
                @mouseenter="isMenuOpen = true"
                @click="isMenuOpen = !isMenuOpen"
              >
                <div class="user-avatar-frame">
                  <img
                    v-if="store.CurrentUser?.info?.profile_img"
                    class="object-cover w-full h-full"
                    :src="store.CurrentUser.info.profile_img"
                  />
                  <span v-else class="initials">{{
                    store.CurrentUser.initials
                  }}</span>
                </div>

                <button
                  class="flex items-center font-black text-sm uppercase tracking-tighter hover:text-[#ff3e00]"
                >
                  <span>{{ store.CurrentUser.display_name }}</span>
                  <!-- Icona che ruota se aperto -->
                  <svg
                    :class="[
                      'w-4 h-4 ml-1 transition-transform',
                      { 'rotate-180': isMenuOpen },
                    ]"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path stroke-width="3" d="m19 9-7 7-7-7" />
                  </svg>
                </button>
              </div>

              <!-- Menu con Transizione Vue -->
              <transition name="dropdown">
                <div v-if="isMenuOpen" class="user-dropdown-menu">
                  <router-link :to="{ name: 'profile' }" class="dropdown-link"
                    >Profile</router-link
                  >
                  <router-link
                    v-if="store.hasAdminPrivileges"
                    :to="{ name: 'admin-dashboard' }"
                    class="dropdown-link"
                    >Admin Dashboard</router-link
                  >
                  <router-link
                    v-if="store.isPartner"
                    :to="{ name: 'partner-dashboard' }"
                    class="dropdown-link"
                    >Partner Dashboard</router-link
                  >
                  <div class="mt-2 border-t border-white/10">
                    <button
                      @click="onLogout"
                      class="w-full text-left text-red-500 dropdown-link hover:bg-red-500 hover:text-white"
                    >
                      Sign Out
                    </button>
                  </div>
                </div>
              </transition>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import { store } from "../store.js";
export default {
  name: "HeaderComponent",
  components: {},
  props: ["onLogout"],
  data() {
    return {
      store,
      isMenuOpen: false,
      navLinks: [
        { label: "Home", to: { name: "home" } },
        { label: "Chi siamo", to: { name: "aboutus" } },
        { label: "Eventi", to: "#" },
        { label: "News", to: { name: "articles" } },
        { label: "Shop", to: { name: "business-detail" } },
        { label: "Contatti", to: "#" },
      ],
    };
  },
};
</script>
<style scoped>
/* Cambiato il font importato */
@import url("https://fonts.googleapis.com");

.nav-brutalist {
  background: rgba(0, 0, 0, 0.9);
  backdrop-filter: blur(15px);
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  position: sticky;
  top: 0;
  z-index: 1000;
  font-family: "Archivo", sans-serif;
}

/* Link Standard - Sostituito @apply con CSS puro */
.nav-item {
  padding: 0.5rem 1rem;
  font-size: 0.75rem;
  font-weight: 900;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: #9ca3af; /* gray-400 */
  transition: all 0.2s;
  display: inline-block;
}

.nav-item:hover,
.router-link-active {
  color: #ffffff;
}

/* Bottone Login Poligonale */
.login-btn-brutalist {
  padding: 0.5rem 1.5rem;
  background-color: #ff3e00;
  color: #000000;
  font-weight: 900;
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  transition: all 0.3s;
  clip-path: polygon(10% 0, 100% 0, 90% 100%, 0% 100%);
  display: inline-block;
}

.login-btn-brutalist:hover {
  background-color: #ffffff;
  transform: scale(1.05);
}

/* Avatar Quadrato */
.user-avatar-frame {
  width: 2rem;
  height: 2rem;
  background-color: #222222;
  overflow: hidden;
  border: 1px solid rgba(255, 255, 255, 0.1);
  clip-path: polygon(10% 0, 100% 0, 90% 100%, 0% 100%);
}

.initials {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 100%;
  font-size: 10px;
  font-weight: 900;
  color: #ff3e00;
}

/* Dropdown Menu */
.user-dropdown-menu {
  position: absolute;
  right: 0;
  top: 100%;
  margin-top: 0.5rem;
  width: 14rem;
  background-color: #111111;
  border: 1px solid rgba(255, 255, 255, 0.1);
  box-shadow: 10px 10px 0px rgba(255, 62, 0, 0.2);
  z-index: 50;
}

.dropdown-link {
  display: block;
  padding: 1rem 1.5rem;
  font-size: 0.75rem;
  font-weight: 900;
  text-transform: uppercase;
  letter-spacing: -0.025em; /* tracking-tighter */
  color: #9ca3af;
  transition: all 0.2s;
  text-align: left;
  width: 100%;
}

.dropdown-link:hover {
  background-color: #ffffff;
  color: #000000;
}

/* Fix per dropdown text-red */
.text-red-500 {
  color: #ef4444;
}
.text-red-500:hover {
  background-color: #ef4444 !important;
  color: white !important;
}
</style>
