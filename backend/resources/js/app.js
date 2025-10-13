import "flowbite";
import "@fortawesome/fontawesome-free/css/all.min.css";

import Alpine from "alpinejs";
window.Alpine = Alpine;

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

window.productHandler = () => {
    return {
        products: [],
        categories: [],
        selectedCategory: "",
        selectedAvailability: "",
        search: "",
        async fetchFilteredProducts() {
            this.isLoading = true;
            this.errorMessage = "";
            try {
                const params = new URLSearchParams();
                if (this.search) params.append("search", this.search);
                if (this.selectedCategory)
                    params.append("category_id", this.selectedCategory);
                if (this.selectedAvailability)
                    params.append("status", this.selectedAvailability);

                const response = await fetch(
                    `/partner/products?${params.toString()}`,
                    {
                        headers: { Accept: "application/json" },
                    }
                );

                if (!response.ok)
                    throw new Error("Errore caricamento prodotti");

                const result = await response.json();
                this.products = result.products;
                this.products.sort(
                    (a, b) => new Date(b.created_at) - new Date(a.created_at)
                );
                this.categories = result.categories;
            } catch (error) {
                console.error(error);
                this.errorMessage = "Impossibile caricare i prodotti.";
            } finally {
                this.isLoading = false;
            }
        },

        async toggleAvailability(id) {
            const product = this.products.find((p) => p.id === id);
            if (!product) return;

            const url = `/partner/products/${id}/toggle`;

            const response = await fetch(url, {
                method: "PATCH",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    Accept: "application/json",
                },
            });

            if (response.ok) {
                const result = await response.json();
                product.is_available = result.is_available;
                await this.fetchFilteredProducts();
            }
        },

        async deleteProduct(id) {
            if (!confirm("Sei sicuro di voler eliminare questo prodotto?"))
                return;
            const product = this.products.find((p) => p.id === id);
            if (!product) return;

            const url = `/partner/products/${id}`;

            const response = await fetch(url, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    Accept: "application/json",
                },
            });

            if (response.ok) {
                this.products = this.products.filter((p) => p.id !== id);
            }
        },
    };
};

Alpine.store("sidebar", {
    open: true,
});
Alpine.start();
