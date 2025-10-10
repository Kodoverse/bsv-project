import "flowbite";
import "@fortawesome/fontawesome-free/css/all.min.css";

import Alpine from "alpinejs";

const image = document.getElementById("uploadImage");

//funzione per l'anteprima immagine nella create dei prodotti
if (image) {
    image.addEventListener("change", () => {
        const preview = document.getElementById("uploadPreview");
        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);
        oFReader.onload = function (event) {
            preview.src = event.target.result;
        };
    });
}

window.Alpine = Alpine;
Alpine.store("sidebar", {
    open: true,
});
Alpine.start();
