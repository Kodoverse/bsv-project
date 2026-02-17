<!-- <template>
  <div
    class="hero-wrapper relative min-h-[90vh] overflow-hidden bg-slate-950 flex items-center"
  >

    <div
      class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-purple-600/20 blur-[120px] rounded-full animate-pulse"
    ></div>
    <div
      class="absolute bottom-[-10%] right-[-10%] w-[600px] h-[600px] bg-blue-600/20 blur-[150px] rounded-full"
    ></div>

    <div
      class="container z-10 grid items-center gap-12 px-6 mx-auto lg:grid-cols-2"
    >
      <div>
        <span
          class="block mb-4 font-mono text-sm tracking-widest text-blue-400 uppercase"
          >#CommunityHub2026</span
        >
        <h1 class="mb-6 text-6xl font-extrabold leading-tight text-white">
          Libera la tua <br />
          <span
            class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500"
            >Energia Creativa</span
          >
        </h1>
        <p class="max-w-lg mb-8 text-lg text-gray-400">
          Dalla produzione musicale ai tornei gaming, fino ai workshop di
          sensibilizzazione. Il posto dove la cultura incontra l'azione.
        </p>
        <div class="flex gap-4">
          <button
            class="px-8 py-4 font-bold text-black transition-transform bg-white rounded-full hover:scale-105"
          >
            Prenota Sala Gaming
          </button>
          <button
            class="px-8 py-4 text-white transition border border-gray-700 rounded-full hover:bg-white/5 backdrop-blur-sm"
          >
            Esplora Corsi
          </button>
        </div>
      </div>


      <div class="relative group">
        <div
          class="p-8 border shadow-2xl glass-card rounded-3xl border-white/10 bg-white/5 backdrop-blur-md"
        >
          <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-semibold text-white">Prossimi Workshop</h3>
            <span
              class="px-3 py-1 text-xs text-green-400 border rounded-full bg-green-500/20 border-green-500/30"
              >Live Now</span
            >
          </div>
          <ul class="space-y-4">
            <li
              class="flex items-center gap-4 p-3 text-gray-300 transition hover:bg-white/5 rounded-xl"
            >
              <span class="p-2 rounded-lg bg-purple-500/20">🎹</span>
              <span>Mixing & Mastering Workshop — 18:00</span>
            </li>
            <li
              class="flex items-center gap-4 p-3 text-gray-300 transition hover:bg-white/5 rounded-xl"
            >
              <span class="p-2 rounded-lg bg-blue-500/20">🎮</span>
              <span>Torneo Valorant "Comunità" — Domani</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template> -->

<!-- <style scoped></style>

<script>
export default {
  name: "HeroComponent",
  components: {},
  data() {
    return {};
  },
};
</script>

<style scoped>
.glass-card {
  transition: transform 0.3s ease;
}
.glass-card:hover {
  transform: translateY(-10px);
}
#hero {
  font-size: 30px;
  border: 2px solid red;
  width: 100%;
  height: 500px;
}
</style> -->

<template>
  <section
    class="hero-carousel"
    @mouseenter="stopTimer"
    @mouseleave="startTimer"
  >
    <div class="glow-effect"></div>

    <!-- Rimosso mode="out-in" per permettere la sovrapposizione fluida -->
    <transition-group name="fade-slide" tag="div" class="viewport">
      <div
        v-for="(slide, index) in slides"
        v-show="currentIndex === index"
        :key="slide.title"
        class="slide-container"
        :style="{ '--accent': slide.color }"
      >
        <!-- Immagine di Sfondo -->
        <div class="image-wrapper">
          <img :src="slide.image" :alt="slide.title" class="hero-img" />
          <div class="vignette"></div>
        </div>

        <!-- Contenuto Testuale -->
        <div class="content-box">
          <span class="eyebrow">{{ slide.category }}</span>
          <h1 class="title">{{ slide.title }}</h1>
          <p class="description">{{ slide.desc }}</p>

          <div class="actions">
            <button class="btn-main">{{ slide.cta }}</button>
          </div>
        </div>
      </div>
    </transition-group>

    <!-- Navigazione (fuori dalla transizione per non sparire) -->
    <div class="nav-dots-container">
      <div class="nav-dots">
        <span
          v-for="(s, i) in slides"
          :key="i"
          @click="currentIndex = i"
          :class="{ active: currentIndex === i }"
          :style="{ '--dot-color': s.color }"
        ></span>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue";

const currentIndex = ref(0);
let timer = null;

const slides = [
  {
    category: "MUSIC & RECORDING",
    title: "Il tuo suono, senza compromessi.",
    desc: "Studio di registrazione professionale e sala prove attrezzata per band e producer.",
    cta: "Prenota lo Studio",
    color: "#ff3e00",
    image:
      "https://www.bdrecords.it/wp-content/uploads/2025/06/IMG_4507-scaled.jpeg",
  },
  {
    category: "GAMING ARENA",
    title: "Sfida la tua community.",
    desc: "Postazioni PC high-end, console next-gen e tornei eSports ogni weekend.",
    cta: "Riserva un Posto",
    color: "#00f7ff",
    image:
      "https://www.lowillsound.it/wp-content/uploads/2023/06/pexels-yan-krukau-9072216-min.jpg",
  },
  {
    category: "WORKSHOPS & CULTURE",
    title: "Cresci con noi.",
    desc: "Corsi di lingue, laboratori creativi e incontri dedicati alla sensibilizzazione sociale.",
    cta: "Scopri i Corsi",
    color: "#a2ff00",
    image:
      "https://www.duffield.cornell.edu/wp-content/uploads/2025/03/Inclusive-Excellence-Academic-Excellence-Workshop-Students-Peer-02.jpg",
  },
];

const startTimer = () => {
  stopTimer(); // Pulisce eventuali timer residui
  timer = setInterval(() => {
    currentIndex.value = (currentIndex.value + 1) % slides.length;
  }, 5000); // 5 secondi è un tempo standard per leggere
};

const stopTimer = () => {
  if (timer) clearInterval(timer);
};

onMounted(() => {
  startTimer();
});

onUnmounted(() => {
  stopTimer();
});
</script>

<style scoped>
.hero-carousel {
  width: 1600px;
  margin: auto;
  position: relative;
  background-color: #000;
  height: 85vh;
  color: white;
  overflow: hidden;
}

.viewport {
  position: relative;
  height: 100%;
}

.slide-container {
  position: absolute; /* Fondamentale per la sovrapposizione durante il cambio */
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
}

.image-wrapper {
  position: absolute;
  top: 0;
  right: 0;
  width: 60%;
  height: 100%;
  clip-path: polygon(15% 0, 100% 0, 100% 100%, 0% 100%);
  z-index: 1;
}

.hero-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  filter: grayscale(20%) brightness(0.6);
}

.content-box {
  position: relative;
  z-index: 2;
  max-width: 650px;
}

.eyebrow {
  color: var(--accent);
  font-weight: 800;
  letter-spacing: 3px;
  font-size: 0.9rem;
  transition: color 0.8s ease; /* Sfumatura colore */
}

.title {
  font-size: 4.5rem;
  font-weight: 900;
  line-height: 1.1;
  margin: 15px 0;
}

.btn-main {
  background: var(--accent);
  color: #000;
  padding: 18px 40px;
  font-weight: bold;
  border: none;
  cursor: pointer;
  clip-path: polygon(10% 0, 100% 0, 90% 100%, 0% 100%);
  transition:
    background 0.8s ease,
    transform 0.2s;
}

.nav-dots-container {
  position: absolute;
  bottom: 10%;
  z-index: 10;
}

.nav-dots {
  display: flex;
  gap: 12px;
}

.nav-dots span {
  width: 40px;
  height: 4px;
  background: rgba(255, 255, 255, 0.2);
  cursor: pointer;
  transition: all 0.3s ease;
}

.nav-dots span.active {
  background: var(--dot-color);
}

/* Transizione fluida */
.fade-slide-enter-active,
.fade-slide-leave-active {
  transition:
    opacity 1.2s cubic-bezier(0.4, 0, 0.2, 1),
    transform 1.2s ease;
}

.fade-slide-enter-from {
  opacity: 0;
  transform: translateX(50px);
}

.fade-slide-leave-to {
  opacity: 0;
  transform: translateX(-50px);
}
</style>
