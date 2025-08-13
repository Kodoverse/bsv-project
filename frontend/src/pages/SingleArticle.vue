<template>
  <div class="container flex flex-col w-full m-auto mb-5 py-8 antialiased bg-white dark:bg-gray-900 lg:py-16">
    <div id="single-article">
      <div>
        <h1 class="text-3xl text-center">{{ article.title }}</h1>
        <p v-if="article.user" class="text-center">
          by {{ article.user.display_name }}
        </p>
      </div>

      <div class="my-3">
        <h2 class="text-2xl text-center">
          {{ article.subtitle }}
        </h2>
      </div>

      <div>
        <p>
          {{ article.article }}
        </p>
      </div>
    </div>
    <button type="button" @click="toggleLikeArticle(article.id) ,console.log(article)"
      class="w-26 m-10 flex items-center text-sm font-medium text-gray-500 hover:underline dark:text-gray-400 focus:outline-none text-white bg-orange-700 hover:bg-purple-800 focus:ring-4 focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-orange-600 dark:hover:bg-purple-700 dark:focus:ring-orange-900">
      <svg class="mr-1.5 w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 20 18">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z" />
      </svg>
      Like ({{ article.like }})

    </button>
    <hr class="my-6">
    <div id="comments">
      <CommentComponent :articleId="$route.params.id" />
    </div>
  </div>
</template>

<script>
  import CommentComponent from "../components/CommentComponent.vue";
  import axios from "axios";
  export default {
    name: "SingleArticle",
    components: {
      CommentComponent,
    },
    data() {
      return {
        article: [],
      };
    },
    methods: {
      async getArticle() {
        try {
          const res = await axios.get(
            `http://127.0.0.1:8000/api/articles/${this.$route.params.id}`
          );
          this.article = res.data.result;
          console.log(this.article);
        } catch (err) {
          this.error = "Errore nel caricamento dell'articolo";
        }
      },
      async getComments() {
        try {
          const res = await axios.get(
            `/api/articles/${this.$route.params.id}/comments`
          );
          this.comments = res.data.data;
        } catch (err) {
          this.error = "Errore nel caricamento dei commenti.";
          console.error(err);
        }
      },

      async toggleLikeArticle(articleId) {
        try {
          // prima prendi il cookie CSRF
          await axios.get('/sanctum/csrf-cookie');

          // poi fai la chiamata POST con autenticazione cookie e CSRF
          const response = await axios.post(`/articles/${articleId}/like`);

          const article = this.article.find(c => c.id === articleId);
          if (article) {
            // aggiorna solo il numero di like
            article.like = response.data.like_count;
            // Vue farà il rendering solo del valore aggiornato nel DOM
          }
          console.log(response.data.like_count)
        } catch (error) {
          // gestione errori
        }
      }
    },
    async mounted() {
      this.loading = true;
      await this.getArticle();
      await this.getComments();
      this.loading = false;
    },
  };
</script>

<style scoped>
  /* #single-article {
  height: 100%;
  width: 100%;
  border: 3px solid red;
  padding: 0px 20px;
  margin-bottom: 100px;
}

#comments {
  height: 100%;
  width: 100%;
  border: 3px solid green;
} */
</style>
