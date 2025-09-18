
<template>
    <div class="flex flex-col w-full bg-black text-white min-h-screen">
        <!-- Event Categories Section -->
        <EventCategoryCarousel />
    </div>
</template>

<script>
import { initFlowbite } from 'flowbite';
import EventCategoryCarousel from '../components/EventCategoryCarousel.vue';

export default {
    name: "Home",
    components: {
        EventCategoryCarousel
    },
    mounted() {
        initFlowbite();
    }
}
</script>

<style scoped>
/* Custom styles can be added here if needed */
</style>