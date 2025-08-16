<template>
    <div class="container flex flex-col w-full m-auto mb-5">
        <h1 class="text-3xl text-center">Articoli</h1>
        <div id="articles" class="grid grid-cols-4 my-6 gap-6">
            <div id="article" v-for="article in articles" :key="article.id"
                class="relative bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <a href="#">
                    <img class="rounded-t-lg"
                        src="https://img-api.cloud.mediaset.net/api/images/kn/v1/image_main/1200/675/38374717?r=0"
                        alt="" />
                </a>
                <div class="p-5">
                    <a href="#">
                        <h3 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            {{ article.title }}
                        </h3>
                    </a>
                    <a href="#">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            {{ article.subtitle }}
                        </h5>
                    </a>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400 line-clamp-2">
                        {{ article.article }}
                    </p>
                    <div id="readmore">
                        <router-link :to="{ name: 'singlearticle', params: { id: article.id } }">
                            Read more
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </router-link>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";
    export default {
        name: "ArticlesPage",
        data() {
            return {
                articles: [],
            };
        },
        methods: {
            gerArticles() {
                axios.get("http://127.0.0.1:8000/api/articles").then((res) => {
                    this.articles = res.data.result.data;
                    console.log(this.articles);
                });
            }
        },
        mounted() {
            this.gerArticles();
        },
    };
</script>

<style scoped>
    #article {
        width: 350px;
        height: 450px;
        cursor: pointer;
        margin: 0 auto;
    }

    #article:hover {
        transform: scale(1.05);
        border: 1px solid orange;
    }



    #readmore {
        background-color: rgb(252, 252, 252);
        color: orange;
        border: 2px solid orange;
        border-radius: 20px;
        padding: 10px;
        cursor: pointer;
        position: absolute;
        bottom: 10px;
        left: 10px;
    }
</style>
