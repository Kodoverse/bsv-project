<template>
  <div id="hero-event" class="bg-gray-800 next-event-banner">
    <div class="banner-inner">
      <!-- Live Badge -->
      <div class="event-badge">
        <span class="dot"></span>
        Prossimo Evento
      </div>

      <!-- Event Details -->
      <div class="event-info">
        <span class="event-title">Vattelapesca</span>
        <span class="divider">/</span>
        <span class="event-date">20 March 2026</span>
        <span class="divider">/</span>
        <span class="event-time">16:30</span>
        <span class="divider">/</span>
        <span class="event-location">Villaseta, AG</span>
      </div>

      <!-- Action Link -->
      <a href="#" class="details-link">
        Details
        <svg
          class="w-4 h-4"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M17 8l4 4m0 0l-4 4m4-4H3"
          />
        </svg>
      </a>
    </div>
  </div>
</template>

<script>
export default {
  name: "ScheduledEventComponent",
  components: {},
  data() {
    return {};
  },
};
</script>

<style scoped>
.next-event-banner {
  border-bottom: 1px solid #222;
  color: white;
  padding: 12px 0;
  overflow: hidden;
}

.banner-inner {
  max-width: 1600px;
  margin: 0 auto;
  padding: 0 8%;
  display: flex;
  align-items: center;
  gap: 24px;
}

/* Red Live Badge */
.event-badge {
  background: #ff3e00;
  color: #000;
  font-weight: 900;
  font-size: 0.7rem;
  text-transform: uppercase;
  padding: 4px 12px;
  display: flex;
  align-items: center;
  gap: 8px;
  clip-path: polygon(10% 0, 100% 0, 90% 100%, 0% 100%);
}

.dot {
  width: 6px;
  height: 6px;
  background: #000;
  border-radius: 50%;
  animation: pulse 1.5s infinite;
}

/* Event Data Typography */
.event-info {
  font-size: 0.9rem;
  font-weight: 700;
  letter-spacing: 0.5px;
  flex-grow: 1;
}

.event-title {
  color: #fff;
  text-transform: uppercase;
}

.divider {
  margin: 0 10px;
  color: #ff3e00;
  font-weight: 900;
}

.event-date,
.event-time,
.event-location {
  color: #888;
}

/* Link Style */
.details-link {
  color: #ff3e00;
  text-transform: uppercase;
  font-size: 0.75rem;
  font-weight: 900;
  display: flex;
  align-items: center;
  gap: 6px;
  text-decoration: none;
  transition: opacity 0.3s;
}

.details-link:hover {
  opacity: 0.7;
}

@keyframes pulse {
  0% {
    transform: scale(1);
    opacity: 1;
  }
  50% {
    transform: scale(1.4);
    opacity: 0.5;
  }
  100% {
    transform: scale(1);
    opacity: 1;
  }
}

@media (max-width: 900px) {
  .event-info {
    font-size: 0.75rem;
  }
  .divider {
    margin: 0 5px;
  }
  .details-link span {
    display: none;
  } /* Hide text on mobile, keep arrow */
}
</style>
