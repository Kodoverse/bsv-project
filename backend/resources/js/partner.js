import "flowbite";

import Alpine from "alpinejs";

window.Alpine = Alpine;
import { createApp } from "vue";
import Dashboard from "./components/partner/PartnerDashboard.vue";

createApp(Dashboard).mount("#partner-dashboard");
Alpine.start();
