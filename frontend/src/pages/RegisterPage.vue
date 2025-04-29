<template>
  <section class="w-full bg-gray-50 dark:bg-gray-900">
    <div
      class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0"
    >
      <a
        href="#"
        class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white"
      >
        <img class="h-40 mr-2 w-50" src="/biblioteca_logo.png" alt="logo" />
      </a>
      <div
        class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700"
      >
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
          <h1
            class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"
          >
            Create an account
          </h1>
          <form
            class="space-y-4 md:space-y-6"
            method="post"
            @submit.prevent="handleRegister"
          >
            <div>
              <label
                for="user_name"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Your name</label
              >
              <input
                type="text"
                name="user_name"
                id="user_name"
                v-model="formData.user_name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Mario"
                required
              />
            </div>
            <div>
              <label
                for="user_lastname"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Your lastname</label
              >
              <input
                type="text"
                name="user_lastname"
                id="las"
                v-model="formData.user_lastname"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Rossi"
                required
              />
            </div>
            <div>
              <label
                for="birthday"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Your Birthday</label
              >
              <input
                type="date"
                name="birthday"
                id="birthday"
                v-model="formData.birthday"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="01/01/2000"
                required
              />
            </div>
            <div>
              <label
                for="email"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Your email</label
              >
              <input
                type="email"
                name="email"
                id="email"
                v-model="formData.email"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="name@company.com"
                required
              />
            </div>
            <div>
              <label
                for="password"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Password</label
              >
              <input
                type="password"
                name="password"
                id="password"
                placeholder="••••••••"
                v-model="formData.password"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required
              />
            </div>
            <div>
              <label
                for="password_confirmation"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Confirm password</label
              >
              <input
                type="password"
                name="password_confirmation"
                id="password_confirmation"
                v-model="formData.password_confirmation"
                placeholder="••••••••"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                required
              />
            </div>
            <div>
              <label
                for="profile_img"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                >Your image</label
              >
              <input
                type="text"
                name="profile_img"
                id="profile_img"
                v-model="formData.profile_img"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              />
            </div>
            <div class="flex items-start">
              <div class="flex items-center h-5">
                <input
                  id="terms"
                  aria-describedby="terms"
                  type="checkbox"
                  class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800"
                  required
                />
              </div>
              <div class="ml-3 text-sm">
                <label
                  for="terms"
                  class="font-light text-gray-500 dark:text-gray-300"
                  >I accept the
                  <a
                    class="font-medium text-primary-600 hover:underline dark:text-primary-500"
                    href="#"
                    >Terms and Conditions</a
                  ></label
                >
              </div>
            </div>
            <button
              type="submit"
              class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
            >
              Create an account
            </button>
            <p class="text-sm font-light text-gray-500 dark:text-gray-400">
              Already have an account?
              <router-link
                to="/login"
                class="font-medium text-primary-600 hover:underline dark:text-primary-500"
                >Login here</router-link
              >
            </p>
            <div v-if="errorMessage" class="error">{{ errorMessage }}</div>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import axios from "axios";
export default {
  name: "RegisterPage",
  data() {
    return {
      formData: {
        email: "",
        password: "",
        password_confirmation: "",
        user_name: "",
        user_lastname: "",
        birthday: "",
        profile_img: "",
      },
      errorMessage: null,
    };
  },
  methods: {
    async handleRegister() {
      try {
        await axios.get("http://localhost:8000/sanctum/csrf-cookie", {
          withCredentials: true,
        });

        const response = await axios.post(
          "http://localhost:8000/api/register",
          this.formData,
          {
            headers: {
              "Content-Type": "application/json",
            },
          },
          console.log(this.formData)
        );
        if (response.data.success) {
          this.$router.push("/login");
        }
      } catch (error) {
        if (error.response && error.response.data.error) {
          this.errorMessage = error.response.data.error;
        } else {
          this.errorMessage = "Errore nella registrazione. Riprova.";
        }
      }
    },
  },
};
</script>

<style scoped></style>
