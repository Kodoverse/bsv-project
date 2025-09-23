import "flowbite";

import Alpine from "alpinejs";

window.Alpine = Alpine;
import { createApp } from "vue";
import Dashboard from "./pages/AdminDashboard.vue";
import router from "./admin/router";

const app = createApp(Dashboard);
app.use(router);
app.mount("#admin-dashboard");
Alpine.start();
