<template>
  <div id="about-us" class="container flex flex-col w-full m-auto mb-5">
    <div class="text-center">
      <h1 class="text-3xl m-auto">Chi Siamo</h1>
    </div>
    <div id="org-chart">
      <div class="flex flex-col w-full m-auto mb-5 mt-5">
        <div @click="modalToggle" id="CEO" class="people">Tano</div>
        <div>
          <div class="flex justify-center gap-20">
            <div class="people"></div>
            <div class="people"></div>
          </div>
        </div>
      </div>
    </div>
  </div>


<transition name="modal">
  <div id="modal" v-if="modalFlag">
    <button class="btn" id="close-modal" @click="closeModal">CLOSE</button>
  </div>
</transition>
</template>
<script>
import axios from "axios";


export default {
  name: "AboutUsPage",
  components: {
   
  },
  data() {
    return {
      aboutSection: [],
      test: [],
      modalFlag: false,
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

    modalToggle() {
      this.modalFlag = !this.modalFlag

    },

    closeModal() {
      this.modalFlag = false
    }
  },
  mounted() {
    this.getData();
  },
};
</script>

<style scoped>
#about-us {
  height: 100%;
  width: 100%;
  margin-bottom: 100px;
}

#org-chart {
  height: 100%;
  width: 100%;
}

.people {
  height: 200px;
  width: 200px;
  border-radius: 50px;
  border: 3px solid red;
  margin-bottom: 50px;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
}

#CEO {
  margin: auto;
  margin-bottom: 50px;
}

#modal {
  position: absolute;
  top: 5%;
  left: 5%;
  height: 90%;
  width: 90%;
  background-color: rgba(255, 255, 255, 0.91);

}

#close-modal {
  background-color: gray;
  cursor: pointer;
}

.modal-enter-active,
.modal-leave-active {
  transition: all 0.8s ease;
}
.modal-enter-from,
.modal-leave-to {
  transform: scale(0.8);
  opacity: 0;
}
.modal-enter-to,
.modal-leave-from {
  transform: scale(1);
  opacity: 1;
}
</style>
