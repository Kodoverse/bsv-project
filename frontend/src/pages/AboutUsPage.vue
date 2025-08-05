<template>
  <div id="about-us" class="container flex flex-col w-full m-auto mb-5">
    <div class="text-center">
      <h1 class="text-3xl m-auto">Chi Siamo</h1>
    </div>

    <!-- ORG CHART -->
    <div id="org-chart" class="flex flex-col items-center gap-6 mt-10">
      <div class="grid gap-6">
        <div
          v-for="employee in employees"
          :key="employee.id"
          class="people"
          @click="openModal(employee)"
        >
        <div>
            <img class="w-40 rounded-full" :src="employee.image" :alt="employee.name" />
        </div>
        
          {{ employee.name }}
          <hr>
          {{ employee.role }}
        </div>
      </div>
    </div>
  </div>

  <transition name="modal">
    <div id="modal" v-if="modalVisible">
      <button class="btn" id="close-modal" @click="closeModal">CLOSE</button>
      <div id="modal-content">
        <div id="photo" class="flex justify-center">
          <img :src="selectedEmployee.image" :alt="selectedEmployee.name" />
        </div>
        <div class="p-3">
          <h2 class="text-2xl text-center my-4">{{ selectedEmployee.name }}</h2>
          <p class="text-center my-4">{{ selectedEmployee.role }}</p>
          <p class="text-center my-4">{{ selectedEmployee.description }}</p>
        </div>
      </div>
    </div>
  </transition>
</template>
<script>
import axios from "axios";

export default {
  name: "AboutUsPage",
  components: {},
  data() {
    return {
      aboutSection: [],
      test: [],
      modalVisible: false,
      selectedEmployee: null,
      employees: [
        {
          id: 1,
          name: "Tano",
          role: "CEO",
          description: "Fondatore e guida visionaria.",
          image: "/TANU.jpeg",
        },
        {
          id: 2,
          name: "Luca",
          role: "CTO",
          description: "Responsabile tecnico.",
          image: "https://i.pravatar.cc/100?u=cto",
        },
        {
          id: 3,
          name: "Anna",
          role: "Developer",
          description: "Sviluppatrice front-end.",
          image: "https://i.pravatar.cc/100?u=dev",
        },
      ],
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

    openModal(employee) {
      this.selectedEmployee = employee;
      this.modalVisible = true;
    },
    closeModal() {
      this.modalVisible = false;
    },
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

  margin-bottom: 50px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  cursor: pointer;
}



#modal {
  position: absolute;
  top: 5%;
  left: 5%;
  height: 90%;
  width: 90%;
  background-color: rgba(108, 108, 108, 0.971);
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
