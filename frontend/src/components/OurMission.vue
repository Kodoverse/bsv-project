<template>
  <section class="mission-diagonal">
    <div class="max-w-[1600px] mx-auto mb-6">
      <div class="">
        <span
          class="text-orange-600 font-extrabold tracking-[0.2em] uppercase text-sm mb-4 block"
          >La nostra Visione</span
        >
        <h2 class="title">Tre Pilastri, Un Futuro</h2>
      </div>

      <div class="mission-grid">
        <!-- Card 1: Inclusione (Icona: Community/Global) -->
        <div class="mission-card card-orange">
          <div class="card-bg"></div>
          <div class="card-content">
            <div class="icon-wrapper">
              <svg
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.5"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
              </svg>
            </div>
            <h3>Inclusione</h3>
            <p>
              Uno spazio aperto a tutti, dove le barriere digitali e culturali
              vengono abbattute ogni giorno.
            </p>
          </div>
        </div>

        <!-- Card 2: Connessione (Icona: Link/Network) -->
        <div class="mission-card card-cyan">
          <div class="card-bg"></div>
          <div class="card-content">
            <div class="icon-wrapper">
              <svg
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.5"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <path
                  d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"
                ></path>
                <path
                  d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"
                ></path>
              </svg>
            </div>
            <h3>Connessione</h3>
            <p>
              Creiamo legami tra generazioni, trasformando lo studio in
              un'esperienza collettiva e sociale.
            </p>
          </div>
        </div>

        <!-- Card 3: Innovazione (Icona: Zap/Energy) -->
        <div class="mission-card card-lime">
          <div class="card-bg"></div>
          <div class="card-content">
            <div class="icon-wrapper">
              <svg
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.5"
                stroke-linecap="round"
                stroke-linejoin="round"
              >
                <polygon
                  points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"
                ></polygon>
              </svg>
            </div>
            <h3>Innovazione</h3>
            <p>
              Portiamo il futuro nel presente con strumenti all'avanguardia per
              la musica, il gaming e le lingue.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.mission-diagonal {
  background: #000;
  padding: 120px 0;
  color: white;
}

.mission-header {
  padding: 0 8% 80px 8%;
}
.title {
  font-size: 4.5rem;
  font-weight: 900;
  line-height: 1.1;
  margin: 0;
}
.outline {
  -webkit-text-stroke: 1.5px white;
  color: transparent;
}

.mission-grid {
  display: flex;
  height: 500px;
  padding: 0 8%;
  /* Fix: Usiamo flex-row e allineamento per evitare glitch */
  align-items: stretch;
}

.mission-card {
  position: relative;
  flex: 1;
  margin: 0 -2%; /* Sovrapposizione per i tagli */
  transition: flex 0.8s cubic-bezier(0.23, 1, 0.32, 1);
  cursor: pointer;
  z-index: 1;
  /* Taglio fisso: non cambia forma se la card si allarga */
  clip-path: polygon(100px 0, 100% 0, calc(100% - 100px) 100%, 0 100%);
}

.mission-card:hover {
  flex: 1.8; /* Si allarga sensibilmente */
  z-index: 5;
}

.card-bg {
  position: absolute;
  inset: 0;
  background: #111;
  border-left: 4px solid var(--accent);
  transition: background 0.4s;
}

.mission-card:hover .card-bg {
  background: #181818;
}

.card-orange {
  --accent: #ff3e00;
}
.card-cyan {
  --accent: #00f7ff;
}
.card-lime {
  --accent: #a2ff00;
}

.card-content {
  position: relative;
  z-index: 10;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
  padding: 40px;
  /* Impedisce al testo di "saltare" durante l'allargamento */
  min-width: 400px;
  left: 50%;
  transform: translateX(-50%);
}

.icon-wrapper {
  width: 60px;
  height: 60px;
  color: var(--accent);
  margin-bottom: 20px;
  transition: transform 0.6s ease;
}

.mission-card:hover .icon-wrapper {
  transform: scale(1.2);
  filter: drop-shadow(0 0 10px var(--accent));
}

h3 {
  font-size: 2.2rem;
  font-weight: 900;
  margin-bottom: 15px;
}
p {
  font-size: 1.1rem;
  color: #888;
  max-width: 300px;
  transition: color 0.4s;
}
.mission-card:hover p {
  color: #fff;
}

@media (max-width: 1000px) {
  .mission-grid {
    flex-direction: column;
    height: auto;
  }
  .mission-card {
    clip-path: none;
    margin: 10px 0;
  }
}
</style>
