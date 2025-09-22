<template>
  <div id="replies" class="m-9 border-2 rounded p-3" v-for="reply in replies" :key="reply.id">
    <div class="flex items-center">
      <div
        class="inline-flex items-center mr-2 overflow-hidden text-sm font-semibold text-gray-900 rounded-full dark:text-white">
        <div v-if="reply.user && reply.user.info">
          <img class="w-6 h-6" :src="reply.user.info.profile_img" :alt="reply.user.display_name" />
        </div>
        <div v-else class="flex items-center justify-center w-6 h-6 bg-gray-500">
          {{ reply.user?.initials || "??" }}
        </div>
      </div>
      <div class="mr-3 font-semibold text-gray-900 dark:text-white">
        {{ reply.user?.info.username }}
      </div>
      <p v-if="reply.updated_at !== reply.created_at"
        class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
        <span class="text-xs font-medium text-yellow-600 dark:text-yellow-400">
          comment edited
        </span>
        <span>{{ timeAgo(reply.updated_at) }}</span>
      </p>
      <div v-else class="text-sm text-gray-600 dark:text-gray-400">
        <div>{{ timeAgo(reply.created_at) }}</div>
      </div>
    </div>

    <p class="text-red-500 dark:text-red-400">
      {{ reply.reply }}
    </p>
  </div>

  <!-- form creazione risposte -->
  <form class="m-9" id="replies" @submit.prevent="postReplies" v-if="store.isLoggedIn">
    <div
      class="px-4 py-2 mb-4 bg-white border border-gray-200 rounded-lg rounded-t-lg dark:bg-gray-800 dark:border-gray-700">
      <textarea id="replies" v-model="textReplies" rows="6"
        class="w-full px-0 text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800"
        placeholder="Write a reply..." required></textarea>
    </div>
    <button  type="submit"
      class="w-34 my-10 flex items-center hover:underline dark:text-gray-400 focus:outline-none text-white bg-orange-700 hover:bg-purple-800 focus:ring-4 focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-orange-600 dark:hover:bg-purple-700 dark:focus:ring-orange-900">
      Post reply
    </button>
  </form>
</template>

<script>
  import { store } from "../store";
  import { formatDistanceToNow } from "date-fns";
  import axios from "axios";

  export default {
    name: "RepliesComponent",
    props: {
      commentId: { type: Number, required: true },

    },

    data() {
      return {
        store,
        textReplies: "",
        replies: [],
      };
    },
    methods: {

      async getReplies(commentId) {
        try {
          const { data } = await axios.get(`/api/comments/${this.commentId}/replies`);
          this.replies = data.data; // perché le resource ritornano { data: [...] }
        } catch (err) {
          console.error(err);
        }

      },


      async postReplies() {
        if (!this.textReplies) return;

        try {
          await axios.get("/sanctum/csrf-cookie");

          const response = await axios.post(`/replies`, {
            comment_id: this.commentId,
            reply: this.textReplies,
          });

          this.replies.push(response.data.data);

          this.textReplies = "";
        } catch (err) {
          console.error(err);
        }
      },

      timeAgo(date) {
        if (!date) return "no date";
        return formatDistanceToNow(new Date(date), {
          addSuffix: true,
        });
      }
    },
    

    mounted() {
      this.getReplies();
      console.log(this.replies)
    }
  };
</script>

<style scoped></style>
