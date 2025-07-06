<template>
  <section class="py-8 antialiased bg-white dark:bg-gray-900 lg:py-16">
    <div class="max-w-2xl px-4 mx-auto">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-bold text-gray-900 lg:text-2xl dark:text-white">
          Discussion ({{ comments.length }})
        </h2>
      </div>
      <form class="mb-6" @submit.prevent="saveComment">
        <div
          class="px-4 py-2 mb-4 bg-white border border-gray-200 rounded-lg rounded-t-lg dark:bg-gray-800 dark:border-gray-700"
        >
          <label for="comment" class="sr-only">Your comment</label>
          <textarea
            id="comment"
            v-model="newComment"
            rows="6"
            class="w-full px-0 text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800"
            placeholder="Write a comment..."
            required
          ></textarea>
        </div>
        <button
          type="submit"
          class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800"
        >
          Post comment
        </button>
      </form>

      <article
        class="p-6 text-base bg-white rounded-lg dark:bg-gray-900"
        v-for="comment in comments"
        :key="comment.id"
      >
        <footer class="flex items-center justify-between mb-2">
          <div class="flex items-center">
            <div
              class="inline-flex items-center mr-2 overflow-hidden text-sm font-semibold text-gray-900 rounded-full dark:text-white"
            >
              <div v-if="comment.user.info.profile_img">
                <img
                  class="w-6 h-6"
                  :src="comment.user.info.profile_img"
                  :alt="comment.user.display_name"
                />
              </div>
              <div
                v-else
                class="flex items-center justify-center w-6 h-6 bg-gray-500"
              >
                {{ comment.user.initials }}
              </div>
            </div>
            <div class="mr-3 font-semibold text-gray-900 dark:text-white">
              {{ comment.user.info.username }}
            </div>

            <p
              v-if="comment.updated_at !== comment.created_at"
              class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400"
            >
              <span
                class="text-xs font-medium text-yellow-600 dark:text-yellow-400"
              >
                comment edited
              </span>
              <span>{{ timeAgo(comment.updated_at) }}</span>
            </p>
            <div v-else class="text-sm text-gray-600 dark:text-gray-400">
              <div>{{ timeAgo(comment.created_at) }}</div>
            </div>
          </div>
        </footer>
        <p
          v-if="editId !== comment.id"
          class="text-gray-500 dark:text-gray-400"
        >
          {{ comment.comment }}
        </p>
        <div v-else>
          <textarea
            id="comment"
            v-model="editOldComment"
            rows="6"
            class="w-full px-0 text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800"
            required
          ></textarea>
          <button
            type="button"
            @click="editComment(comment.id)"
            class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800"
          >
            Save
          </button>
        </div>

        <div class="flex items-center justify-between mt-4 space-x-4">
          <div class="flex items-center space-x-4">
            <button
              type="button"
              class="flex items-center text-sm font-medium text-gray-500 hover:underline dark:text-gray-400"
            >
              <svg
                class="mr-1.5 w-3.5 h-3.5"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 20 18"
              >
                <path
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z"
                />
              </svg>
              Reply
            </button>

            <button
              type="button"
              class="flex items-center text-sm font-medium text-gray-500 hover:underline dark:text-gray-400"
            >
              <svg
                class="mr-1.5 w-3.5 h-3.5"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 20 18"
              >
                <path
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z"
                />
              </svg>
              Like
            </button>

            <!-- button edit and delete... just for user who created the comment -->

            <div
              class="flex items-center space-x-4"
              v-if="currentUser && comment.user.id === currentUser.id"
            >
              <button
                type="button"
                class="flex items-center gap-1 text-sm font-medium text-gray-500 hover:underline dark:text-gray-400"
                @click="showTextArea(comment)"
              >
                <i class="fa-solid fa-pencil" aria-hidden="true"></i>Edit
              </button>
              <button
                type="button"
                class="flex items-center gap-1 text-sm font-medium text-gray-500 hover:underline dark:text-gray-400"
                @click="destroyComment(comment.id)"
              >
                <i class="fa-solid fa-trash-can" aria-hidden="true"></i>Delete
              </button>
            </div>
          </div>

          <div>
            <button
              type="button"
              @click="
                openFlagModal(comment.id, comment.comment, comment.reason)
              "
              class="flex items-center text-sm font-medium text-gray-500 hover:underline dark:text-gray-400"
            >
              <svg
                class="mr-1.5 w-3.5 h-3.5"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 20 18"
              >
                <path
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z"
                />
              </svg>
              Flag
            </button>
          </div>
        </div>
      </article>

      <!-- Modal -->
      <div
        v-if="showModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50"
      >
        <div
          class="w-full max-w-sm p-6 bg-white rounded-lg shadow-lg dark:bg-gray-800"
        >
          <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">
            Flagged Comment
          </h3>
          <p class="mb-4 text-sm text-gray-600 dark:text-gray-300">
            {{ selectedComment }}
          </p>

          <label
            for="reason"
            class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300"
            >Reason</label
          >
          <textarea
            id="reason"
            v-model="selectedReason"
            rows="3"
            class="w-full p-2 mb-4 text-sm border rounded dark:bg-gray-700 dark:text-white"
          ></textarea>

          <div class="flex justify-end space-x-2">
            <button
              @click="submitFlag"
              class="px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700"
            >
              Submit
            </button>
            <button
              @click="closeModal"
              class="px-4 py-2 text-gray-800 bg-gray-300 rounded dark:bg-gray-600 dark:text-white hover:bg-gray-400 dark:hover:bg-gray-500"
            >
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import axios from "axios";
import { formatDistanceToNow } from "date-fns";
import { store } from "../store";

export default {
  name: "CommentComponent",
  props: ["articleId"],

  data() {
    return {
      store,
      showModal: false,
      selectedReason: "",
      selectedComment: "",
      selectedCommentId: null,
      newComment: "", //quando scrivi un nuovo commento
      editOldComment: "", //serve per l'edit. altrimenti la modifica spunta anche nella textarea del new comment.
      comments: [],
      editId: null, //fa aprire la textarea per l'edit in base al suo ID
      currentUser: null, //recupera l'utente loggato...
    };
  },

  methods: {
    async saveComment() {
      try {
        await axios.get("/sanctum/csrf-cookie");

        const response = await axios.post(
          "/comments",
          {
            comment: this.newComment,
            article_id: this.articleId,
          },
          { withCredentials: true }
        );
        console.log(response);
        this.newComment = "";
        console.log("Commento salvato");
        this.loadComments();
      } catch (error) {
        console.error("Errore nel salvataggio:", error);
      }
    },
    async loadComments() {
      try {
        const response = await axios.get(
          `http://localhost:8000/api/articles/${this.articleId}/comments`
        );
        this.comments = response.data.result.comments;
        this.currentUser = response.data.current_user;
        console.log(this.currentUser);
        console.log(this.comments);
      } catch (error) {
        console.error("Errore nel caricamento commenti:", error);
      }
    },

    openFlagModal(commentId, commentText, reason) {
      this.selectedCommentId = commentId;
      this.selectedComment = commentText;
      this.selectedReason = reason || "";
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
      this.selectedReason = "";
      this.selectedComment = "";
      this.selectedCommentId = null;
    },
    async submitFlag() {
      try {
        await axios.post("http://localhost:8000/api/comments/flag", {
          comment_id: this.selectedCommentId,
          reason: this.selectedReason,
        });
        alert("Flag submitted successfully!");
        this.closeModal();
      } catch (error) {
        console.error("Error submitting flag:", error);
        alert("There was an error submitting the flag.");
      }
    },
    timeAgo(date) {
      return formatDistanceToNow(new Date(date), {
        addSuffix: true,
        locale: undefined,
      });
    },
    async destroyComment(commentId) {
      if (!confirm("Sei sicuro di voler eliminare questo commento?")) return;

      try {
        await axios.get("/sanctum/csrf-cookie");

        const response = await axios.delete(`/comments/${commentId}`, {
          withCredentials: true,
        });

        console.log("Commento eliminato:", response.data);
        this.loadComments();
      } catch (error) {
        console.error("Errore durante l'eliminazione:", error);
        alert("Errore durante l'eliminazione del commento");
      }
    },

    async editComment(commentId) {
      try {
        await axios.get("/sanctum/csrf-cookie");

        const response = await axios.put(
          `/comments/${commentId}`,
          { comment: this.editOldComment },
          { withCredentials: true }
        );

        console.log("Commento aggiornato:", response.data);
        this.editId = null;
        this.editOldComment = "";
        this.loadComments();
      } catch (error) {
        console.error("Errore nell'aggiornamento:", error);
      }
    },

    showTextArea(comment) {
      this.editId = comment.id;
      this.editOldComment = comment.comment;
    },
  },
  mounted() {
    this.loadComments();
    console.log(this.comments);
  },
};
</script>

<style scoped></style>
