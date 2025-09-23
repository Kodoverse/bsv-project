import "flowbite";

import { createApp } from "vue";
import Dashboard from "./partner/pages/PartnerDashboard.vue";
import router from "./partner/router";

const app = createApp(Dashboard);
app.use(router);
app.mount("#partner-dashboard");
