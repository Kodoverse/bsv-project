<template>
  <h1></h1>
  <h2></h2>
  <div>
    <p></p>
  </div>
</template>
<script>
import axios from "axios";
export default {
  name: "AboutUsPage",
  data() {
    return {
      aboutSection: [],
      test: [],
    };
  },
  methods: {
    getData() {
      this.current_page = this.$route.name;
      axios
        .get("http://127.0.0.1:8000/api/sections", {
          params: {
            title: this.current_page,
          },
        })
        .then((res) => {
          this.aboutSection = res.data.results;
        });
    },
  },
  mounted() {
    this.getData();
  },
};
</script>
<style scoped></style>
