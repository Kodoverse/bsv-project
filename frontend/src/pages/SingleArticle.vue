<template>
  <div class="flex flex-col w-full container m-auto mb-5">
    <div id="single-article">
      <div>
        <h1 class="text-3xl text-center">{{ article.title }}</h1>
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
    getArticle() {
      axios
        .get(`http://127.0.0.1:8000/api/article/${this.$route.params.id}`)
        .then((res) => {
          this.article = res.data.result;
          console.log(this.article);
        });
    },
  },
  mounted() {
    this.getArticle();
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
