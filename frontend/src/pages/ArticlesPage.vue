<template>
    <div id="articles">
        <h1 class="text-3xl text-center">Articles</h1>
    <div class="d-flex  justify-center">
        <div id="article" class="d-flex flex-col" v-for="article in articles" :key="article.id">
            <h1 class="text-3xl text-center mb-2">{{ article.title }}</h1>
            <h2 class="text-2xl text-center mb-2">{{ article.subtitle }}</h2>
            <p>{{ article.article }}</p>

            <router-link :to="{ name: 'singlearticle', params: { id: article.id } }">
                <button>Read more</button>
            </router-link>
        </div>
    </div>
        
    </div>

</template>


<script>
    import axios from 'axios';
    export default {
        name: "ArticlesPage",
        data() {
            return {
                articles: [],
            }
        },
        methods: {
            gerArticles() {
                axios.get('http://127.0.0.1:8000/api/articles').then((res) => {
                    this.articles = res.data.result.data;
                    console.log(this.articles);
                })
            }
        },
        mounted() {
            this.gerArticles();

        }
    }
</script>

<style scoped>
    #article {
        
        width: 500px;
        aspect-ratio: 1 / 1;
        border: 1px solid rgb(0, 255, 81);
    }

</style>
