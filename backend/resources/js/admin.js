import "flowbite";

import Alpine from "alpinejs";

window.Alpine = Alpine;
import { createApp } from "vue";
import Dashboard from "./components/admin/AdminDashboard.vue";

createApp(Dashboard).mount("#admin-dashboard");
Alpine.start();
