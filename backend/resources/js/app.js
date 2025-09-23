import "flowbite";

import Alpine from "alpinejs";

window.Alpine = Alpine;
import { createApp } from "vue";
import Dashboard from "./components/Dashboard.vue";

createApp(Dashboard).mount("#test-vue");
Alpine.start();
