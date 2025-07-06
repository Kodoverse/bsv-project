<template>
  <div class="wscreen">
    <HeaderComponent v-if="$route.name !== 'login' && $route.name !== 'register'" :onLogout="handleLogout" />
    <MainComponent />
    <FooterComponent v-if="$route.name !== 'login' && $route.name !== 'register'" />
  </div>
</template>

<script>
  import HeaderComponent from "./components/HeaderComponent.vue";
  import FooterComponent from "./components/FooterComponent.vue";
  import MainComponent from "./components/MainComponent.vue";
  import { store } from "./store.js";
  import axios from "axios";
 

  export default {
    name: "App",
    components: {
      HeaderComponent,
      MainComponent,
      FooterComponent,
    },
    data() {
      return {
        store,
      };
    },

    methods: {

      handleLogout() {
        axios.get("http://localhost:8000/sanctum/csrf-cookie", { withCredentials: true })
          .then(() => {
            return axios.post("http://localhost:8000/api/logout", {}, { withCredentials: true });
          })
          .then(() => {
            store.isLoggedIn = false;
            localStorage.setItem("isLoggedIn", "false");
            this.$router.push("/");
          })
          .catch((error) => {
            console.error("Errore durante il logout", error);
          });
      }
    },
    mounted() {
      const savedUser = localStorage.getItem('CurrentUser');
      if (savedUser) {
        store.CurrentUser = JSON.parse(savedUser);
      }

      const storedLoginStatus = localStorage.getItem("isLoggedIn");
      if (storedLoginStatus === "true") {
        store.isLoggedIn = true;
      }
      console.log("refreshed");
    }

  };
</script>

<style scoped>
  .logo {
    height: 6em;
    padding: 1.5em;
    will-change: filter;
    transition: filter 300ms;
  }

  .logo:hover {
    filter: drop-shadow(0 0 2em #646cffaa);
  }

  .logo.vue:hover {
    filter: drop-shadow(0 0 2em #42b883aa);
  }
</style>
