import { createApp } from "vue";
import "./style.css";
import "flowbite";
import App from "./App.vue";
import { router } from "./router";
import axios from "axios";

axios.defaults.baseURL = "http://localhost:8000";
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

export default axios;

createApp(App).use(router).mount("#app");
