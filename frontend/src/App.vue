<template>
  <div class="wscreen">
    <HeaderComponent v-if="$route.name !== 'login' && $route.name !== 'register'" />
   <router-view></router-view>
    <FooterComponent v-if="$route.name !== 'login' && $route.name !== 'register'" />
 
 
  </div>
</template>

<script>

import FooterComponent from './components/FooterComponent.vue';
import HeaderComponent from './components/HeaderComponent.vue';
import MainComponent from './components/MainComponent.vue';
import { router } from './router';


  export default {
    name: 'App',
    components: {
      HeaderComponent,
      MainComponent,
      FooterComponent
    }
   

  }
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
