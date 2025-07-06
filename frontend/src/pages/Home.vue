
<template>
    <div class="flex justify-center w-full">

       <h1 class="text-3xl">HOME</h1>

    </div>
</template>

<script>
import { initFlowbite } from 'flowbite'; 

    export default {
        name: "Home",

        mounted() {
            initFlowbite();
        }
       
    }
</script>

<style scoped></style>