import "flowbite";
import "@fortawesome/fontawesome-free/css/all.min.css";

import Alpine from "alpinejs";

window.Alpine = Alpine;
Alpine.store("sidebar", {
    open: true,
});
Alpine.start();
