<template>

   <a href="https://wa.me/393491234567"
      class="whatsapp-float"
      target="_blank"
      rel="noopener noreferrer"
      title="Chatta con noi su WhatsApp">
      💬 <p class="whatsapp-text">Chatta con noi</p> 
    </a>
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

.whatsapp-float {
  position: fixed;
  width: 50px;
  height: 50px;
  bottom: 20px;
  right: 20px;
  background-color: #25d366;
  color: white;
  padding: 12px 16px;
  border-radius: 50px;
  font-size: 16px;
  font-weight: bold;
  text-decoration: none;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  z-index: 999;
  overflow: hidden;
  transition: background-color 0.3s ease, width 0.7s ease;
  display: flex;
  align-items: center;
  gap: 10px;
  white-space: nowrap;
}

.whatsapp-float:hover {
  background-color: #128c7e;
  width: 180px;
}

.whatsapp-text {
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.3s ease 0.2s;
}

.whatsapp-float:hover .whatsapp-text {
  opacity: 1;
  visibility: visible;
}

</style>
