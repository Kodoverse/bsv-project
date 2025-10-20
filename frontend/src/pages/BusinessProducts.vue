<template>
    <section class="bg-white dark:bg-gray-900 relative mt-[50px]">
        <div :style="{ backgroundImage: `url(http://localhost:8000${business.logo})`, opacity: 0.3 }"
            class="h-[400px] py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 bg-cover bg-center bg-no-repeat shadow-md absolute inset-0">
        </div>
        <div
            class="h-[400px] py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 bg-cover bg-center bg-no-repeat shadow-md absolute inset-0">
            <h1
                class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                {{ business.name }}
            </h1>
        </div>
    </section>

    <div class="container mx-auto px-4 py-4 pt-[450px]">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mx-auto">
            <div v-for="product in products" :key="product.id"
                class="w-full max-w-sm bg-gray-800 border border-gray-700 rounded-lg shadow-sm overflow-hidden">
                <!-- Product Image -->
                <img v-if="product.image_url" :src="`http://localhost:8000/storage/${product.image_url}`"
                    :alt="product.name" class="p-4 rounded-t-lg object-cover w-full h-48" />
                <div v-else class="h-48 bg-gray-700 flex items-center justify-center text-gray-400">
                    No Image
                </div>

                <!-- Product Info -->
                <div class="px-5 pb-5">
                    <h5 class="text-lg font-semibold text-white mb-2">{{ product.name }}</h5>
                    <p class="text-gray-300 text-sm mb-3 line-clamp-2">
                        {{ product.description || "No description available" }}
                    </p>

                    <!-- Stock & Price -->
                    <div class="flex items-center justify-between mb-3">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold"> </span>
                        <span class="text-orange-400 font-bold text-lg">
                            {{ product.points_price }} pts
                        </span>
                    </div>

                    <div v-if="product.cash_equivalent" class="text-gray-400 text-sm mb-3">
                        ~${{ product.cash_equivalent }}
                    </div>

                    <!-- Crea QrCode -->
                    <button type="button" @click="buyProduct(product.id)"
                        class="w-full bg-orange-600 text-white rounded-lg py-2 hover:bg-orange-700 transition-colors text-sm font-medium"
                        :disabled="product.stock_quantity === 0">
                        {{ product.stock_quantity === 0 ? "Non disponibile" : "Acquista" }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modale QR Code -->
    <div v-if="qrCodeModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div @click.self="qrCodeModal = false"
            class="bg-white rounded-lg p-6 w-4/5 max-w-3xl relative shadow-xl flex flex-col">

            <!-- Titolo -->
            <h3 class="text-xl font-semibold mb-4 text-center text-black">
                Congratulazioni per il tuo acquisto!
            </h3>

            <!-- Contenuto principale: QR + istruzioni -->
            <div class="flex flex-1 gap-6">

                <!-- QR code a sinistra -->
                <div class="flex-shrink-0 w-1/3 bg-gray-100 p-4 rounded-lg flex items-center justify-center">
                    <img :src="qrCodeData.image" alt="QR Code"
                        class="w-64 h-64 object-contain border-4 border-orange-400 rounded-2xl bg-white p-3" />
                </div>

                <!-- Istruzioni a destra -->
                <div class="flex-1 flex flex-col justify-center text-left text-gray-700 space-y-4">
                    <p>Mostra questo QR code al momento del riscatto presso il negozio.</p>
                    <p>Il tuo codice sarà sempre disponibile nella sezione <strong>"I miei acquisti"</strong> del tuo
                        account.</p>
                    <p>Grazie per aver dato il tuo prezioso contributo!</p>
                </div>

            </div>

            <!-- Chiudi modale -->
            <button @click="qrCodeModal = false"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 font-bold text-xl">
                &times;
            </button>
        </div>
    </div>


</template>
<script>
    import axios from "axios";
    export default {
        name: "BusinessProducts",
        data() {
            return {
                business: [],
                products: [],
                productsLoading: true,
                qrCodeModal: false,
                qrCodeData: null,
            };
        },
        async mounted() {
            const businessId = this.$route.params.id;

            // fallback: se refresh della pagina diretta
            if (businessId) {
                await this.fetchBusiness(businessId);
                console.log(businessId);
            }

            await this.fetchProducts(businessId);
        },
        methods: {
            async fetchBusiness(id) {
                try {
                    const response = await axios.get("/api/businesses/negozi");
                    const businesses = Array.isArray(response.data)
                        ? response.data
                        : response.data.data;
                    this.business = businesses.find((business) => business.id == id);

                    console.log(this.business);
                } catch (error) {
                    console.error("Errore caricamento business:", error);
                }
            },
            async fetchProducts(businessId) {
                try {
                    const response = await axios.get(
                        `/api/businesses/business/${businessId}/products`
                    );
                    this.products = response.data;
                    console.log(this.products);
                } catch (error) {
                    console.error("Errore caricamento prodotti:", error);
                } finally {
                    this.productsLoading = false;
                }
            },


            async buyProduct(productID, quantity = 1) {
                try {

                    await axios.get("http://localhost:8000/sanctum/csrf-cookie", {
                        withCredentials: true,
                    });
                    // Creo la purchase
                    const response = await axios.post('/api/purchases/buy',
                        {
                            product_id: productID,
                            quantity: quantity
                        },
                        {
                            withCredentials: true,
                        }
                    );

                    const purchase = response.data;
                    console.log('Purchase created:', purchase);

                    await this.QrCodeGenerate(purchase.id);




                    // 3. Mostro la modale
                    this.qrCodeModal = true;



                } catch (error) {
                    console.error('Error creating purchase:', error.response?.data || error);
                }
            },

            async QrCodeGenerate(purchaseID) {
                try {
                    const response = await axios.post(`/api/qrcode/generate/${purchaseID}`);
                    console.log('QR Code generated:', response.data);

                    const qrResponse = response.data;


                    this.qrCodeData = {
                        image: qrResponse.qr_image_base64,
                        code: qrResponse.qr_code.code
                    };
                    console.log(this.qrCodeData);
                    this.qrCodeModal = true;
                } catch (error) {
                    console.error("Errore generazione QR Code:", error.response?.data || error);
                }
            },
        },
    };
</script>
