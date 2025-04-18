<template>
    <div>
<h1 class="text-3xl">Articles</h1>
<div id="articles" class="" v-for="article in articles" :key="article.id">
    <h1 class="text-3xl text-center mb-2">{{ article.title }}</h1>
    <h2 class="text-2xl text-center mb-2">{{ article.subtitle }}</h2>
    <p>{{ article.article }}</p>
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

#articles {
    width: 500px;
    aspect-ratio: 1 / 1;
    border: 1px solid rgb(0, 255, 81);
}

</style>
