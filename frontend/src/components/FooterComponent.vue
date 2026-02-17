<template>
  <footer class="footer-custom">
    <!-- Diagonale decorativa superiore per incastro perfetto -->
    <div class="footer-diagonal-edge"></div>

    <div class="container relative z-10 px-8 py-20 mx-auto">
      <div class="grid items-start grid-cols-1 gap-16 md:grid-cols-3">
        <!-- Colonna 1: Location & Hours -->
        <div class="footer-col">
          <div class="col-header">
            <span class="eyebrow">Dove siamo</span>
            <h3 class="text-3xl italic font-black">Villaseta</h3>
          </div>
          <ul class="info-list">
            <li>
              <svg
                class="icon"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-width="2"
                  d="M12 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                />
                <path
                  stroke-width="2"
                  d="M17.8 13.938h-.011a7 7 0 1 0-11.464.144h-.016l.14.171c.1.127.2.251.3.371L12 21l5.13-6.248c.194-.209.374-.429.54-.659l.13-.155Z"
                />
              </svg>
              <p>
                Piazza S. Basilio, <br />
                92100 Agrigento AG
              </p>
            </li>
            <li>
              <svg
                class="icon"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-width="2"
                  d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                />
              </svg>
              <p>
                9:00 - 14:00 <br />
                16:00 - 19:00
              </p>
            </li>
          </ul>
        </div>

        <!-- Colonna 2: Logo & Social (Centro) -->
        <div class="flex flex-col items-center footer-col">
          <div class="p-6 mb-8 clip-path-logo">
            <img src="/biblioteca_logo.png" class="h-20" alt="Logo" />
          </div>
          <div class="flex space-x-6">
            <a
              href="https://www.instagram.com/bibliotecasocialevillaseta"
              class="social-link"
            >
              <i class="text-2xl fa-brands fa-instagram"></i>
            </a>
            <a
              href="https://www.youtube.com/@tttactionaidagrigento"
              class="social-link"
            >
              <i class="text-2xl fa-brands fa-youtube"></i>
            </a>
          </div>
        </div>

        <!-- Colonna 3: Contacts -->
        <div class="footer-col md:items-end">
          <div class="col-header md:text-right">
            <span class="eyebrow">Contatti</span>
            <h3 class="text-3xl italic font-black">Get in Touch</h3>
          </div>
          <ul class="info-list md:items-end md:text-right">
            <li>
              <a href="tel:+39 347 123 4569" class="flex items-center group">
                <p
                  class="order-last transition-colors md:order-first group-hover:text-white"
                >
                  +39 347 123 4569
                </p>
                <svg
                  class="order-first icon md:order-last md:ml-4"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-width="2"
                    d="M18.427 14.768 17.2 13.542a1.733 1.733 0 0 0-2.45 0l-.613.613a1.732 1.732 0 0 1-2.45 0l-1.838-1.84a1.735 1.735 0 0 1 0-2.452l.612-.613a1.735 1.735 0 0 0 0-2.452L9.237 5.572a1.6 1.6 0 0 0-2.45 0c-3.223 3.2-1.702 6.896 1.519 10.117 3.22 3.221 6.914 4.745 10.12 1.535a1.601 1.601 0 0 0 0-2.456Z"
                  />
                </svg>
              </a>
            </li>
            <li>
              <a
                href="mailto:bibliotecavillaseta@gmail.com"
                class="flex items-center group"
              >
                <p
                  class="order-last transition-colors md:order-first group-hover:text-white"
                >
                  bibliotecavillaseta@gmail.com
                </p>
                <svg
                  class="order-first icon md:order-last md:ml-4"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-width="2"
                    d="m3.5 5.5 7.893 6.036a1 1 0 0 0 1.214 0L20.5 5.5M4 19h16a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z"
                  />
                </svg>
              </a>
            </li>
          </ul>
        </div>
      </div>

      <div
        class="mt-20 pt-8 border-t border-white/10 text-center text-xs tracking-[0.3em] uppercase opacity-40"
      >
        © 2026 Biblioteca Sociale Villaseta — Built for Community
      </div>
    </div>
  </footer>
</template>

<style scoped>
@import url("https://fonts.googleapis.com");

.footer-custom {
  background: #000;
  color: white;
  position: relative;
  overflow: hidden;
}

/* Taglio obliquo superiore per continuità col design */
.footer-diagonal-edge {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 60px;
  background: #000;
  clip-path: polygon(0 100%, 100% 0, 100% 100%, 0% 100%);
  transform: translateY(-59px);
}

.eyebrow {
  color: #ff3e00;
  font-weight: 800;
  letter-spacing: 3px;
  font-size: 0.7rem;
  text-transform: uppercase;
  display: block;
  margin-bottom: 5px;
}

.footer-col {
  display: flex;
  flex-direction: column;
}

.col-header {
  margin-bottom: 30px;
}

.info-list {
  list-style: none;
  padding: 0;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.info-list li {
  display: flex;
  align-items: center;
  gap: 15px;
  transition: transform 0.3s ease;
}

.info-list li:hover {
  transform: translateX(10px);
}

.icon {
  width: 24px;
  height: 24px;
  color: #ff3e00;
  flex-shrink: 0;
}

.logo-wrapper {
  transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.clip-path-logo {
  clip-path: polygon(15% 0, 100% 0, 85% 100%, 0% 100%);
}

.social-link {
  width: 50px;
  height: 50px;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px solid rgba(255, 255, 255, 0.1);
  color: #ff3e00;
  transition: all 0.3s ease;
}

.social-link:hover {
  background: #ff3e00;
  color: black;
  transform: translateY(-5px);
}

@media (max-width: 768px) {
  .info-list li:hover {
    transform: none;
  }
  .footer-col {
    items: center !important;
    text-align: center !important;
  }
  .info-list {
    items: center !important;
  }
}
</style>
