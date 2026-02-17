<template>
  <section class="quick-booking">
    <div class="max-w-[1600px] px-6 mx-auto">
      <!-- Section Header -->
      <div class="mb-16">
        <span class="eyebrow">Action Center</span>
        <h2 class="title">Prendi il tuo <span class="">Posto</span></h2>
      </div>

      <div class="booking-grid">
        <!-- Action 1: Room Booking -->
        <div class="action-card card-dark" @click="handleAction('booking')">
          <div class="card-overlay"></div>
          <div class="card-content">
            <div class="icon-box">🎮</div>
            <h3>Prenota una Sala</h3>
            <p>
              Gaming Arena o Studio di Registrazione? Riserva la tua sessione in
              pochi secondi.
            </p>
            <span class="action-link">Vai alla Prenotazione →</span>
          </div>
        </div>

        <!-- Action 2: Event Registration -->
        <div class="action-card card-accent" @click="handleAction('events')">
          <div class="card-overlay"></div>
          <div class="card-content">
            <div class="icon-box">📅</div>
            <h3>Iscriviti a un Evento</h3>
            <p>
              Assicurati un posto per i prossimi workshop, tornei o corsi di
              lingua.
            </p>
            <span class="text-black action-link">Vedi Calendario →</span>
          </div>
        </div>
      </div>

      <!-- Login Hint (Visible only if not logged in) -->
      <div class="w-full text-center">
        <p v-if="!isLoggedIn" class="login-warning">
          * Devi essere loggato per procedere con la prenotazione.
        </p>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "BookingSession",
  data() {
    return {
      isLoggedIn: false,
    };
  },
  methods: {
    handleAction(target) {
      if (!this.isLoggedIn) {
        this.$router.push({ name: "login" });
      } else {
        const route = target === "booking" ? "booking-page" : "events-list";
        this.$router.push({ name: route });
      }
    },
  },
};
</script>

<style scoped>
.quick-booking {
  background: #000;
  padding: 120px 0;
  color: white;
}

.eyebrow {
  color: #ff3e00;
  font-weight: 800;
  letter-spacing: 3px;
  text-transform: uppercase;
  display: block;
}

.title {
  font-size: 4.5rem;
  font-weight: 900;
  line-height: 1;
}

.outline {
  -webkit-text-stroke: 1.5px white;
  color: transparent;
}

/* The Grid */
.booking-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  margin-top: 60px;
}

.action-card {
  position: relative;
  height: 400px;
  padding: 60px;
  cursor: pointer;
  overflow: hidden;
  transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
  /* Matching the Hero/Mission cut */
  clip-path: polygon(10% 0, 100% 0, 90% 100%, 0% 100%);
}

.card-dark {
  background: #111;
  border: 1px solid #222;
}
.card-accent {
  background: #ff3e00;
  color: black;
}

.card-overlay {
  position: absolute;
  inset: 0;
  background: white;
  opacity: 0;
  transition: opacity 0.3s;
}

.action-card:hover .card-overlay {
  opacity: 0.05;
}

.action-card:hover {
  transform: translateY(-10px) scale(1.02);
}

.icon-box {
  font-size: 3rem;
  margin-bottom: 20px;
}

h3 {
  font-size: 2.5rem;
  font-weight: 900;
  text-transform: uppercase;
  margin-bottom: 15px;
}

p {
  font-size: 1.1rem;
  opacity: 0.7;
  margin-bottom: 40px;
}

.action-link {
  font-weight: 900;
  text-transform: uppercase;
  letter-spacing: 2px;
  font-size: 0.8rem;
  color: #ff3e00;
}

.card-accent .action-link {
  color: black;
  border-bottom: 2px solid black;
}

.login-warning {
  margin-top: 40px;
  text-align: center;
  color: #444;
  font-size: 0.8rem;
  text-transform: uppercase;
  letter-spacing: 1px;
}

@media (max-width: 1024px) {
  .booking-grid {
    grid-template-columns: 1fr;
  }
  .title {
    font-size: 2.5rem;
  }
  .action-card {
    clip-path: none;
    padding: 40px;
    height: auto;
  }
}
</style>
