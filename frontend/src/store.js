import { reactive } from "vue";
import axios from "axios";

export const store = reactive({
  isLoggedIn: false,
  CurrentUser: null,
  comments: [],
  articleId: null,

  async loadComments(articleId) {
    try {
      const response = await axios.get(
        `http://localhost:8000/api/articles/${articleId}/comments`
      );
      store.comments = response.data.result.comments;
    } catch (error) {
      console.error("Errore nel caricamento commenti:", error);
    }
  },
});
