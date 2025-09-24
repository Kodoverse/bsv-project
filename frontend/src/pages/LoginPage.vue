<template>
  <section class="w-full bg-gray-50 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
        <img class="h-40 mr-2 w-50" src="/biblioteca_logo.png" alt="logo" />
      </a>
      <div
        class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
          <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
            Sign in to your account
          </h1>
          <form class="space-y-4 md:space-y-6" method="post" @submit.prevent="handleLogin">
            <div>
              <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
              <input type="email" name="email" id="email" v-model="email"
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="name@company.com" required="" />
            </div>
            <div>
              <label for="password"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
              <input type="password" name="password" id="password" v-model="password" placeholder="••••••••"
                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required="" />
            </div>
            <div class="flex items-center justify-between">
              <div class="flex items-start">
                <div class="flex items-center h-5">
                  <input id="remember" aria-describedby="remember" type="checkbox"
                    class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" />
                </div>
                <div class="ml-3 text-sm">
                  <label for="remember" class="text-gray-500 dark:text-gray-300">Remember me</label>
                </div>
              </div>
              <a href="#" class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">Forgot
                password?</a>
            </div>
            <button type="submit"
              class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
              Sign in
            </button>
            <p v-if="error" class="text-sm text-red-600 dark:text-red-500 mt-2">{{ error }}</p>
            <p class="text-sm font-light text-gray-500 dark:text-gray-400">
              Don't have an account yet?
              <router-link to="/register"
                class="font-medium text-primary-600 hover:underline dark:text-primary-500">Register</router-link>
            </p>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
  import axios from "axios";
  import { store } from "../store.js";
  import { router } from "../router.js";
  export default {
    name: "LoginPage",
    data() {
      return {
        email: "",
        password: "",
        error: "",
      };
    },
    methods: {
      async handleLogin() {
        try {
          // Ottieni CSRF cookie
          await axios.get("http://localhost:8000/sanctum/csrf-cookie", {
            withCredentials: true,
          });

          // Login
          const response = await axios.post(
            "http://localhost:8000/api/login",
            {
              email: this.email,
              password: this.password,
            },
            {
              withCredentials: true,
            }
          );

          if (response.status === 200) {
            store.isLoggedIn = true;
            localStorage.setItem("isLoggedIn", "true");

            //chiamata per ottenere i dati utente
            const userResponse = await axios.get("http://localhost:8000/api/user", {
              withCredentials: true,
            });

            // ricevi i dati dell'utente
            store.CurrentUser = userResponse.data;
            localStorage.setItem('CurrentUser', JSON.stringify(userResponse.data));
            console.log("Utente loggato:", store.CurrentUser);

            // Redirect based on user role
            const userRole = store.CurrentUser.user_role;
            console.log("User role:", userRole);
            
            if (userRole === 'admin' || userRole === 'librarian') {
              router.push("/admin"); // Admin dashboard
            } else if (userRole === 'partner') {
              router.push("/partner"); // Partner dashboard
            } else {
              router.push("/"); // Home page for regular users
            }
          } else {
            this.error = "Errore durante il login";
          }
        } catch (err) {
          if (err.response) {
            if (err.response.status === 401) {
              this.error = "Credenziali non valide";
            } else {
              this.error = `Errore: ${err.response.status}`;
            }
          } else {
            this.error = "Errore durante la connessione al server";
          }
        }
      }
    },
    mounted() {
     
    },
  };
</script>

<style scoped></style>
