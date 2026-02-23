<template>
  <main class="min-h-screen p-6 text-white bg-black profile-page lg:p-12">
    <!-- TOP BAR: Settings & Notifications -->
    <div class="max-w-[1600px] mx-auto flex justify-end gap-4 mb-8">
      <button class="action-icon-btn">
        <svg
          class="w-6 h-6"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-width="2"
            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
          />
        </svg>
      </button>
      <button class="action-icon-btn">
        <router-link :to="{ name: 'settings' }">
          <svg
            class="w-6 h-6"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-width="2"
              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
            />
            <circle cx="12" cy="12" r="3" stroke-width="2" />
          </svg>
        </router-link>
      </button>
    </div>

    <div class="max-w-[1600px] mx-auto grid grid-cols-1 lg:grid-cols-12 gap-6">
      <!-- HEADER CARD (Span 8) -->
      <div
        class="lg:col-span-8 bg-[#111] p-8 flex items-center gap-8 border border-white/5 clip-path-brutalist"
      >
        <div class="relative">
          <img
            :src="user.avatar"
            class="w-32 h-32 object-cover border-4 border-[#ff3e00] clip-path-brutalist"
          />
          <div
            class="absolute -bottom-2 -right-2 bg-[#ff3e00] text-black font-black px-2 py-1 text-xs"
          >
            LVL 12
          </div>
        </div>
        <div>
          <h1 class="text-5xl font-black uppercase syne-font">
            {{ user.name }}
          </h1>
          <p class="text-[#ff3e00] font-bold tracking-widest mt-2 uppercase">
            Membro dal 2024
          </p>
        </div>
      </div>

      <!-- CREDITS CARD (Span 4) -->
      <div
        class="lg:col-span-4 bg-[#ff3e00] p-8 text-black flex flex-col justify-between clip-path-brutalist"
      >
        <span class="text-xs font-bold tracking-widest uppercase"
          >Crediti Disponibili</span
        >
        <div class="flex items-baseline gap-2">
          <span class="font-black text-7xl syne-font">{{ user.credits }}</span>
          <span class="italic font-black uppercase">PTS</span>
        </div>
        <button
          class="w-full py-3 mt-4 text-xs font-black text-white uppercase transition-all bg-black hover:bg-white hover:text-black"
        >
          Riscatta Ora
        </button>
      </div>

      <!-- FUTURE EVENTS (Span 5) -->
      <div class="lg:col-span-5 bg-[#111] p-6 border border-white/5">
        <h3
          class="pb-2 mb-6 text-xl font-black uppercase border-b syne-font border-white/10"
        >
          Prossimi Eventi
        </h3>
        <div class="space-y-4">
          <div
            v-for="event in user.futureEvents"
            :key="event.id"
            class="flex items-center justify-between p-4 transition-all cursor-pointer bg-white/5 hover:bg-white/10"
          >
            <div>
              <p class="text-sm font-black uppercase">{{ event.name }}</p>
              <p class="text-xs italic text-gray-500">
                {{ event.date }} @ {{ event.time }}
              </p>
            </div>
            <div class="text-[#ff3e00] text-xl">→</div>
          </div>
        </div>
      </div>

      <!-- LEADERBOARD (Span 4) -->
      <div class="lg:col-span-4 bg-[#111] p-6 border border-white/5">
        <h3
          class="pb-2 mb-6 text-xl font-black uppercase border-b syne-font border-white/10"
        >
          Classifica Hub
        </h3>
        <div class="space-y-2">
          <div
            v-for="(player, index) in leaderboard"
            :key="index"
            :class="[
              'flex justify-between p-2 text-sm',
              player.isMe
                ? 'bg-[#ff3e00] text-black font-black'
                : 'text-gray-400',
            ]"
          >
            <span>{{ index + 1 }}. {{ player.name }}</span>
            <span>{{ player.eventsCount }} Ev.</span>
          </div>
          <!-- Separator if user not in top 10 -->
          <div v-if="!isUserInTop10" class="py-2 text-center opacity-30">
            •••
          </div>
          <div
            v-if="!isUserInTop10"
            class="flex justify-between p-2 text-sm bg-[#ff3e00] text-black font-black"
          >
            <span>{{ user.rank }}. {{ user.name }}</span>
            <span>{{ user.eventsCount }} Ev.</span>
          </div>
        </div>
      </div>

      <!-- BADGES (Span 3) -->
      <div
        class="lg:col-span-3 bg-[#111] p-6 border border-white/5 flex flex-col"
      >
        <h3
          class="pb-2 mb-6 text-xl font-black uppercase border-b syne-font border-white/10"
        >
          Badges
        </h3>
        <div class="grid grid-cols-2 gap-4">
          <div
            v-for="badge in user.badges"
            :key="badge.name"
            class="relative flex flex-col items-center group"
          >
            <div
              class="w-16 h-16 bg-[#222] flex items-center justify-center text-3xl grayscale group-hover:grayscale-0 transition-all border border-white/10 clip-path-brutalist"
            >
              {{ badge.icon }}
            </div>
            <span
              class="text-[10px] mt-2 uppercase font-bold text-center leading-tight"
              >{{ badge.name }}</span
            >
          </div>
        </div>
      </div>

      <!-- REWARDS SHOP (Full Width) -->
      <div class="mt-4 lg:col-span-12">
        <div class="flex items-end justify-between mb-6">
          <h3 class="text-3xl font-black uppercase syne-font">
            Premi Riscattabili
          </h3>
          <button
            class="text-[#ff3e00] font-black uppercase text-xs border-b-2 border-[#ff3e00]"
          >
            Mostra Tutto
          </button>
        </div>
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
          <div
            v-for="reward in rewards"
            :key="reward.id"
            class="bg-[#111] group overflow-hidden border border-white/5"
          >
            <div class="h-40 overflow-hidden">
              <img
                :src="reward.img"
                class="object-cover w-full h-full transition-all duration-500 group-hover:scale-110"
              />
            </div>
            <div class="p-4">
              <h4 class="mb-1 text-sm font-black uppercase">
                {{ reward.name }}
              </h4>
              <p class="text-[#ff3e00] font-black italic">
                {{ reward.cost }} PTS
              </p>
              <button
                class="w-full py-2 mt-4 text-xs font-black uppercase transition-all border border-white/10 hover:bg-white hover:text-black"
              >
                Riscatta
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  name: "ProfilePage",
  data() {
    return {
      user: {
        name: "Mario Rossi",
        avatar: "https://images.unsplash.com",
        credits: 1450,
        eventsCount: 12,
        rank: 42,
        badges: [
          { name: "Assiduo", icon: "🔥", desc: "5 eventi partecipati" },
          { name: "Ecologico", icon: "🌿", desc: "10 eventi ambiente" },
          { name: "Musicista", icon: "🎸", desc: "Primo record studio" },
          { name: "Pro Gamer", icon: "🎮", desc: "Vinto un torneo" },
        ],
        futureEvents: [
          {
            id: 1,
            name: "Workshop Ableton Live",
            date: "22 Mar",
            time: "16:30",
          },
          {
            id: 2,
            name: "Torneo Street Fighter VI",
            date: "28 Mar",
            time: "20:00",
          },
        ],
      },
      leaderboard: [
        { name: "User_Alpha", eventsCount: 45 },
        { name: "Gamer99", eventsCount: 42 },
        { name: "Luca_V", eventsCount: 38 },
        { name: "BetaTest", eventsCount: 35 },
        { name: "LibraryLover", eventsCount: 30 },
        { name: "M. Bianchi", eventsCount: 28 },
        { name: "S. Verde", eventsCount: 25 },
        { name: "K. Rosso", eventsCount: 22 },
        { name: "J. Doe", eventsCount: 20 },
        { name: "MusicMaker", eventsCount: 18 },
      ],
      rewards: [
        {
          id: 1,
          name: "1 Ora Sala Gaming",
          cost: 500,
          img: "https://images.unsplash.com",
        },
        {
          id: 2,
          name: "Stampa 3D Custom",
          cost: 800,
          img: "https://images.unsplash.com",
        },
        {
          id: 3,
          name: "Libro in Omaggio",
          cost: 1200,
          img: "https://images.unsplash.com",
        },
        {
          id: 4,
          name: "Sessione Studio Mix",
          cost: 2000,
          img: "https://images.unsplash.com",
        },
      ],
    };
  },
  computed: {
    isUserInTop10() {
      return this.leaderboard.some((p) => p.isMe);
    },
  },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com");

.syne-font {
  font-family: "Syne", sans-serif;
}
.profile-page {
  font-family: "Archivo", sans-serif;
}

.clip-path-brutalist {
  clip-path: polygon(5% 0, 100% 0, 95% 100%, 0% 100%);
}

.action-icon-btn {
  @apply p-3 bg-[#111] border border-white/5 text-white hover:bg-[#ff3e00] hover:text-black transition-all;
  clip-path: polygon(15% 0, 100% 0, 85% 100%, 0% 100%);
}

/* Custom scrollbar per la classifica o liste lunghe */
::-webkit-scrollbar {
  width: 4px;
}
::-webkit-scrollbar-track {
  background: #000;
}
::-webkit-scrollbar-thumb {
  background: #ff3e00;
}
</style>
