<template>
  <section class="activities-explorer">
    <div class="max-w-[1600px] mx-auto">
      <div class="header-flex">
        <div class="title-group">
          <span class="eyebrow">Esplora le Attività</span>
          <h2 class="main-title">Cosa Facciamo</h2>
        </div>
        <p class="header-desc">
          Dalla tecnologia all'arte, creiamo percorsi su misura per ogni
          passione.
        </p>
      </div>

      <div class="activities-list">
        <div
          v-for="(act, i) in activities"
          :key="i"
          class="activity-item"
          @mouseenter="activeImg = act.img"
        >
          <div class="activity-link">
            <span class="act-num">0{{ i + 1 }}</span>
            <h3 class="act-name">{{ act.name }}</h3>
            <span class="act-tags">{{ act.tags }}</span>
            <div class="act-arrow">
              <svg
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
              >
                <path d="M7 17L17 7M17 7H7M17 7V17" />
              </svg>
            </div>
          </div>

          <!-- Immagine che appare in hover (Stile Ghost) -->
          <div
            class="hover-image"
            :style="{ backgroundImage: `url(${act.img})` }"
          ></div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "ActivitiesComponent",
  data() {
    return {
      activeImg: "",
      activities: [
        {
          name: "Gaming Arena",
          tags: "eSports / Coaching / Tournaments",
          img: "https://images.unsplash.com",
        },
        {
          name: "Recording Studio",
          tags: "Podcasting / Mixing / Production",
          img: "https://images.unsplash.com",
        },
        {
          name: "Language Lab",
          tags: "English / Spanish / Italian for foreigners",
          img: "https://images.unsplash.com",
        },
        {
          name: "Creative Workshop",
          tags: "Sensibilizzazione / Arte / Sociale",
          img: "https://images.unsplash.com",
        },
      ],
    };
  },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com");

.activities-explorer {
  background: #000;
  padding: 120px 0;
  color: white;
  overflow: hidden;
}

.header-flex {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
  margin-bottom: 80px;
  padding: 0 4%;
}

.main-title {
  font-size: 5rem;
  font-weight: 800;
  line-height: 0.9;
}

.outline {
  -webkit-text-stroke: 1.5px white;
  color: transparent;
}

.header-desc {
  max-width: 350px;
  color: #666;
  font-size: 1.1rem;
  margin-bottom: 10px;
}

.activities-list {
  border-top: 1px solid #222;
}

.activity-item {
  position: relative;
  border-bottom: 1px solid #222;
  transition: all 0.4s ease;
}

.activity-link {
  display: grid;
  grid-template-columns: 80px 1.5fr 1fr 100px;
  align-items: center;
  padding: 40px 4%;
  cursor: pointer;
  position: relative;
  z-index: 10;
}

.act-num {
  font-family: "Syne", sans-serif;
  color: #ff3e00;
  font-size: 1.2rem;
}

.act-name {
  font-family: "Syne", sans-serif;
  font-size: 2.5rem;
  transition: transform 0.4s ease;
}

.act-tags {
  font-size: 0.8rem;
  letter-spacing: 2px;
  color: #444;
  transition: color 0.4s ease;
}

.act-arrow {
  width: 40px;
  height: 40px;
  color: #ff3e00;
  opacity: 0;
  transform: rotate(-45deg);
  transition: all 0.4s ease;
}

/* Hover Effects */
.activity-item:hover {
  background: rgba(255, 62, 0, 0.02);
}

.activity-item:hover .act-name {
  transform: translateX(20px);
}

.activity-item:hover .act-tags {
  color: #fff;
}

.activity-item:hover .act-arrow {
  opacity: 1;
  transform: rotate(0deg);
}

/* Background Image Hover (The Magic Part) */
.hover-image {
  position: absolute;
  top: 50%;
  left: 60%;
  transform: translate(-50%, -50%) scale(0.8);
  width: 400px;
  height: 250px;
  background-size: cover;
  background-position: center;
  opacity: 0;
  pointer-events: none;
  z-index: 5;
  transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
  clip-path: polygon(15% 0, 100% 0, 85% 100%, 0% 100%); /* Il nostro taglio! */
}

.activity-item:hover .hover-image {
  opacity: 0.6;
  transform: translate(-50%, -50%) scale(1);
  left: 55%;
}

@media (max-width: 1024px) {
  .activity-link {
    grid-template-columns: 50px 1fr;
    gap: 10px;
  }
  .act-tags,
  .act-arrow,
  .hover-image {
    display: none;
  }
  .act-name {
    font-size: 1.5rem;
  }
}
</style>
