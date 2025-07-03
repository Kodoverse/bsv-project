<template>
    <div id="articles">
        <h1 class="text-3xl text-center">Articles</h1>
        <div class="d-flex  justify-center">
            <div id="article" class="d-flex flex-col" v-for="article in articles" :key="article.id">
                <h1 class="text-3xl text-center mb-2">{{ article.title }}</h1>
                <h2 class="text-2xl text-center mb-2">{{ article.subtitle }}</h2>
                <h3>AUTORE: {{ article.user.info.firstname }} {{ article.user.info.lastname }}</h3>
                <h3>NICKNAME: {{ article.user.info.username }}</h3>
                <p class="my-3">{{ article.article }}</p>
              
                    <router-link :to="{ name: 'singlearticle', params: { id: article.id } }">
                        <button id="readmore">Read more</button>
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

    #readmore {
        background-color: rgb(252, 252, 252);
        color: orange;
        border: 2px solid orange;
        border-radius: 20px;
        padding: 10px;
        cursor: pointer;
        
    }

</style>
