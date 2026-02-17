<template>
  <div class="flex flex-col w-full min-h-screen text-white bg-black">
    <HeroComponent />
    <EventCategoryCarousel />
    <FeedSocialComponent />
    <OurMission />
    <ActivitiesComponent />
    <BookSession />
  </div>
</template>

<script>
import { initFlowbite } from "flowbite";
import EventCategoryCarousel from "../components/EventCategoryCarousel.vue";
import FeedSocialComponent from "../components/FeedSocialComponent.vue";
import OurMission from "../components/OurMission.vue";
import ActivitiesComponent from "../components/ActivitiesComponent.vue";
import BookSession from "../components/BookSession.vue";
import HeroComponent from "../components/HeroComponent.vue";
export default {
  name: "Home",
  components: {
    EventCategoryCarousel,
    FeedSocialComponent,
    OurMission,
    ActivitiesComponent,
    BookSession,
    HeroComponent,
  },
  mounted() {
    initFlowbite();
  },
};
</script>

<style scoped>
/* Custom styles can be added here if needed */
</style>
