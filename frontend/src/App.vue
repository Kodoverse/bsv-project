<template>
  <div class="wscreen">
    <HeaderComponent v-if="$route.name !== 'login' && $route.name !== 'register'" />
    <div id="separatore">
      <img class="w-full h-16 absolute top-12" src="/BSV-linee.png" alt="separatore" />
    </div>
    <MainComponent />
    <FooterComponent v-if="$route.name !== 'login' && $route.name !== 'register'" />
  </div>
</template>

<script>
import FooterComponent from "./components/FooterComponent.vue";
import HeaderComponent from "./components/HeaderComponent.vue";
import MainComponent from "./components/MainComponent.vue";


export default {
  name: "App",
  components: {
    HeaderComponent,
    MainComponent,
    FooterComponent,
  },
};
</script>

<style scoped>
.logo {
  height: 6em;
  padding: 1.5em;
  will-change: filter;
  transition: filter 300ms;
}

.logo:hover {
  filter: drop-shadow(0 0 2em #646cffaa);
}

.logo.vue:hover {
  filter: drop-shadow(0 0 2em #42b883aa);
}
</style>
