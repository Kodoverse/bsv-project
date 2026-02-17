<template>
  <div id="header">
    <NavComponent />
    <ScheduledEventComponent />
  </div>
</template>

<script>
import ScheduledEventComponent from "./ScheduledEventComponent.vue";
import HeroComponent from "./HeroComponent.vue";
import NavComponent from "./NavComponent.vue";
export default {
  name: "HeaderComponent",
  components: {
    NavComponent,
    ScheduledEventComponent,
    HeroComponent,
  },
  props: ["onLogout"],
  data() {
    return {};
  },
};
</script>

<style scoped></style>
