<template>
    <main>

        <router-view></router-view>
       
    </main>
</template>

<script>
  import { router } from '../router';
    export default {
        name: "MainComponent",
       
    }
</script>


<style scoped>

    h1 {
        color: rgb(255, 0, 0);
    }


  

</style>