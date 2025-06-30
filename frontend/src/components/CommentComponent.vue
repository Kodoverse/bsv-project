<template>
  <section class="py-8 antialiased bg-white dark:bg-gray-900 lg:py-16">
    <div class="max-w-2xl px-4 mx-auto">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-bold text-gray-900 lg:text-2xl dark:text-white">
          Discussion (20)
        </h2>
      </div>
      <form class="mb-6" @submit.prevent="saveComment">
        <div
          class="px-4 py-2 mb-4 bg-white border border-gray-200 rounded-lg rounded-t-lg dark:bg-gray-800 dark:border-gray-700">
          <label for="comment" class="sr-only">Your comment</label>
          <textarea id="comment" v-model="newComment" rows="6"
            class="w-full px-0 text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800"
            placeholder="Write a comment..." required></textarea>
        </div>
        <button type="submit"
          class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
          Post comment
        </button>
      </form>

      <article class="p-6 text-base bg-white rounded-lg dark:bg-gray-900" v-for="comment in comments" :key="comment.id">
        <footer class="flex items-center justify-between mb-2">
          <div class="flex items-center">
            <p class="inline-flex items-center mr-3 text-sm font-semibold text-gray-900 dark:text-white">
              <img class="w-6 h-6 mr-2 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-2.jpg"
                alt="Michael Gough" />Michael Gough
            </p>
            <p class="text-sm text-gray-600 dark:text-gray-400">
            <div>{{ timeAgo(comment.created_at) }}</div>
            </p>
          </div>
        </footer>
        <p v-if="!isEdit" class="text-gray-500 dark:text-gray-400">{{ comment.comment }}</p>
        <div v-else>
          <textarea id="comment" v-model="newComment" rows="6"
            class="w-full px-0 text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800"
            required> {{ comment.comment }}</textarea>
          <button type="button" @click="editComment(comment.id)"
            class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
            Edit
          </button>

        </div>

        <div class="flex items-center justify-between mt-4 space-x-4">
          <div class="flex items-center space-x-4">
            <button type="button"
              class="flex items-center text-sm font-medium text-gray-500 hover:underline dark:text-gray-400">
              <svg class="mr-1.5 w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 20 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z" />
              </svg>
              Reply
            </button>

            <button type="button"
              class="flex items-center text-sm font-medium text-gray-500 hover:underline dark:text-gray-400">
              <svg class="mr-1.5 w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 20 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z" />
              </svg>
              Like
            </button>

            <button type="button"
              class="flex items-center text-sm font-medium text-gray-500 hover:underline dark:text-gray-400 gap-1"
              @click="showTextarea()">
              <i class="fa-solid fa-pencil" aria-hidden="true"></i>Edit
            </button>
            <button type="button"
              class="flex items-center text-sm font-medium text-gray-500 hover:underline dark:text-gray-400 gap-1"
              @click="destroyComment(comment.id)">
              <i class="fa-solid fa-trash-can" aria-hidden="true"></i>Delete
            </button>

          </div>

          <div>
            <button type="button" @click="
              openFlagModal(comment.id, comment.comment, comment.reason)
              " class="flex items-center text-sm font-medium text-gray-500 hover:underline dark:text-gray-400">
              <svg class="mr-1.5 w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 20 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z" />
              </svg>
              Flag
            </button>
          </div>
        </div>
      </article>

      <!-- Modal -->
      <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="w-full max-w-sm p-6 bg-white rounded-lg shadow-lg dark:bg-gray-800">
          <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">
            Flagged Comment
          </h3>
          <p class="mb-4 text-sm text-gray-600 dark:text-gray-300">
            {{ selectedComment }}
          </p>

          <label for="reason" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Reason</label>
          <textarea id="reason" v-model="selectedReason" rows="3"
            class="w-full p-2 mb-4 text-sm border rounded dark:bg-gray-700 dark:text-white"></textarea>

          <div class="flex justify-end space-x-2">
            <button @click="submitFlag" class="px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700">
              Submit
            </button>
            <button @click="closeModal"
              class="px-4 py-2 text-gray-800 bg-gray-300 rounded dark:bg-gray-600 dark:text-white hover:bg-gray-400 dark:hover:bg-gray-500">
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

  export default {
    name: "CommentComponent",
    props: ["articleId"],

    data() {
      return {
        showModal: false,
        selectedReason: "",
        selectedComment: "",
        selectedCommentId: null,
        newComment: "",
        comments: [],
        isEdit: false,
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
            `http://localhost:8000/api/article/${this.articleId}`
          );
          this.comments = response.data.result.comments;
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
          await axios.post("http://localhost:8000/api/flagcomments", {
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
        if (!confirm('Sei sicuro di voler eliminare questo commento?')) return;

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
            { comment: this.newComment },
            { withCredentials: true }
          );

          console.log("Commento aggiornato:", response.data);
        } catch (error) {
          console.error("Errore nell'aggiornamento:", error);
        }
      },

      showTextarea() {
        this.isEdit = true;
      }
    },
    mounted() {
      this.loadComments();
    },
  };
</script>

<style scoped></style>
