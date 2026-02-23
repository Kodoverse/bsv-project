<template>
  <main class="min-h-screen text-white bg-black about-page">
    <!-- HERO SECTION: La Visione -->
    <section
      class="py-24 px-6 lg:px-12 max-w-[1600px] mx-auto grid lg:grid-cols-2 gap-16 items-center"
    >
      <div class="header-box">
        <span class="eyebrow">Dietro le quinte</span>
        <h1 class="font-black leading-none uppercase text-7xl syne-font">
          Chi Siamo <br />
          <span class="outline">e perché</span>
        </h1>
        <div class="accent-line w-32 h-2 bg-[#ff3e00] mt-8"></div>
      </div>
      <div class="description-box">
        <p class="text-xl italic leading-relaxed text-gray-400">
          "Non siamo solo una collezione di libri, ma un generatore di
          possibilità. Villaseta Hub nasce per trasformare il tempo libero in
          crescita collettiva."
        </p>
      </div>
    </section>

    <!-- TEAM SECTION: Le Persone -->
    <section class="py-20 bg-[#080808] border-y border-white/5">
      <div class="max-w-[1600px] mx-auto px-6 lg:px-12">
        <h2 class="mb-12 text-4xl font-black uppercase syne-font">
          Il Team <span class="text-[#ff3e00]">Core</span>
        </h2>

        <div class="grid gap-12 md:grid-cols-2">
          <!-- Person 1 -->
          <div class="flex items-start gap-8 team-card">
            <div
              class="w-48 h-64 flex-none bg-[#111] overflow-hidden clip-path-diagonal border border-white/10"
            >
              <img
                src="https://images.unsplash.com"
                class="object-cover w-full h-full transition-all duration-500 grayscale hover:grayscale-0"
              />
            </div>
            <div>
              <h3 class="text-3xl font-black uppercase syne-font">Marco S.</h3>
              <span
                class="text-[#ff3e00] font-bold text-xs uppercase tracking-widest"
                >Coordinatore Hub</span
              >
              <p class="mt-4 text-sm leading-relaxed text-gray-500">
                Appassionato di innovazione sociale e musica. Marco coordina le
                attività dello studio di registrazione e i rapporti con la
                comunità.
              </p>
            </div>
          </div>

          <!-- Person 2 -->
          <div class="flex items-start gap-8 team-card">
            <div
              class="w-48 h-64 flex-none bg-[#111] overflow-hidden clip-path-diagonal border border-white/10"
            >
              <img
                src="https://images.unsplash.com"
                class="object-cover w-full h-full transition-all duration-500 grayscale hover:grayscale-0"
              />
            </div>
            <div>
              <h3 class="text-3xl font-black uppercase syne-font">Elena G.</h3>
              <span
                class="text-[#ff3e00] font-bold text-xs uppercase tracking-widest"
                >Responsabile Workshop</span
              >
              <p class="mt-4 text-sm leading-relaxed text-gray-500">
                Esperta di comunicazione e linguaggi digitali. Si occupa della
                programmazione dei corsi e della gestione dell'area gaming.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- MAP SECTION: Dove trovarci -->
    <section
      class="py-24 max-w-[1600px] mx-auto px-6 lg:px-12 grid lg:grid-cols-12 gap-12 items-center"
    >
      <div class="lg:col-span-4">
        <h2 class="mb-6 text-5xl font-black leading-none uppercase syne-font">
          Vieni a <br />
          <span class="text-[#ff3e00]">Trovarci</span>
        </h2>
        <ul class="space-y-4 text-gray-400">
          <li>Piazza S. Basilio, 92100 Agrigento AG</li>
          <li class="font-bold tracking-widest text-white uppercase">
            Aperti Mar - Sab / 09:00 - 19:00
          </li>
        </ul>
        <button
          class="mt-8 px-10 py-4 bg-[#ff3e00] text-black font-black uppercase text-xs clip-path-btn hover:bg-white transition-all"
        >
          Apri in Google Maps
        </button>
      </div>

      <!-- Map Placeholder -->
      <div
        class="lg:col-span-8 h-[450px] bg-[#111] relative overflow-hidden clip-path-diagonal border border-white/5"
      >
        <div
          class="absolute inset-0 opacity-40 bg-[url('https://www.google.com')] bg-cover"
        ></div>
        <div
          class="absolute inset-0 flex items-center justify-center pointer-events-none"
        >
          <div
            class="w-20 h-20 bg-[#ff3e00]/20 rounded-full flex items-center justify-center animate-pulse"
          >
            <div class="w-6 h-6 bg-[#ff3e00] rounded-full"></div>
          </div>
        </div>
        <div
          class="absolute bottom-0 right-0 p-4 bg-black/80 text-[10px] uppercase font-bold tracking-widest"
        >
          Hub Location / Interactive Map Placeholder
        </div>
      </div>
    </section>
  </main>
</template>

<style scoped>
@import url("https://fonts.googleapis.com");

.syne-font {
  font-family: "Syne", sans-serif;
}
.about-page {
  font-family: "Archivo", sans-serif;
}

.outline {
  -webkit-text-stroke: 1.5px white;
  color: transparent;
}

.eyebrow {
  color: #ff3e00;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 4px;
  font-size: 0.8rem;
  display: block;
}

.clip-path-diagonal {
  clip-path: polygon(15% 0, 100% 0, 85% 100%, 0% 100%);
}

.clip-path-btn {
  clip-path: polygon(10% 0, 100% 0, 90% 100%, 0% 100%);
}

.team-card {
  transition: transform 0.4s ease;
}

.team-card:hover {
  transform: translateX(10px);
}
</style>

<script>
import axios from "axios";
export default {
  name: "AboutUsPage",
  data() {
    return {
      aboutSection: [],
      test: [],
    };
  },
  methods: {
    getData() {
      this.current_page = this.$route.name;
      axios
        .get("http://127.0.0.1:8000/api/sections", {
          params: {
            title: this.current_page,
          },
        })
        .then((res) => {
          this.aboutSection = res.data.results;
        });
    },
  },
  mounted() {
    this.getData();
  },
};
</script>
