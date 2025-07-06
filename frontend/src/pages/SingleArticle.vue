<template>
  <div class="container flex flex-col w-full m-auto mb-5">
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
        const res = axios.get(
          `http://127.0.0.1:8000/api/articles/${this.$route.params.id}`
        );
        this.article = res.data.result;
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
#single-article {
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
}
</style>
