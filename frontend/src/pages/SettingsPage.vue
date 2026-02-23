<template>
  <main class="settings-page">
    <div class="max-w-[1200px] mx-auto">
      <!-- Titolo Editoriale -->
      <header class="mb-16">
        <h1 class="title">Impostazioni Hub</h1>
      </header>

      <div class="settings-grid">
        <!-- Sidebar di navigazione interna -->
        <aside class="settings-nav">
          <button
            v-for="tab in tabs"
            :key="tab.id"
            :class="['nav-link', { active: currentTab === tab.id }]"
            @click="currentTab = tab.id"
          >
            {{ tab.label }}
          </button>
        </aside>

        <!-- Contenuto Dinamico -->
        <div class="settings-content">
          <!-- Sezione Account -->
          <div v-if="currentTab === 'account'" class="settings-section">
            <h3 class="syne-font">Dati Personali</h3>
            <div class="input-group">
              <label>Nome Visualizzato</label>
              <input
                type="text"
                v-model="user.displayName"
                placeholder="Inserisci nome"
              />
            </div>
            <div class="input-group">
              <label>Email</label>
              <input
                type="email"
                v-model="user.email"
                disabled
                class="disabled"
              />
            </div>
            <button class="btn-save">Aggiorna Profilo</button>
          </div>

          <!-- Sezione Notifiche (Style Microsoft Rewards) -->
          <div v-if="currentTab === 'notifications'" class="settings-section">
            <h3 class="syne-font">Preferenze Notifiche</h3>
            <div class="toggle-card">
              <div class="info">
                <span class="label">Eventi Suggeriti</span>
                <p>
                  Ricevi avvisi basati sui tuoi interessi (Gaming, Musica,
                  Lingue).
                </p>
              </div>
              <label class="switch">
                <input type="checkbox" v-model="settings.eventAlerts" />
                <span class="slider"></span>
              </label>
            </div>
            <div class="toggle-card">
              <div class="info">
                <span class="label">Badge & Obiettivi</span>
                <p>Notifiche quando sblocchi un nuovo achievement.</p>
              </div>
              <label class="switch">
                <input type="checkbox" v-model="settings.badgeAlerts" />
                <span class="slider"></span>
              </label>
            </div>
          </div>

          <!-- Sezione Privacy -->
          <div v-if="currentTab === 'privacy'" class="settings-section">
            <h3 class="syne-font">Privacy & Visibilità</h3>
            <div class="toggle-card">
              <div class="info">
                <span class="label">Profilo Pubblico</span>
                <p>
                  Permetti agli altri membri di vedere i tuoi badge e la tua
                  posizione in classifica.
                </p>
              </div>
              <label class="switch">
                <input type="checkbox" v-model="settings.publicProfile" />
                <span class="slider"></span>
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  name: "SettingsPage",
  data() {
    return {
      currentTab: "account",
      tabs: [
        { id: "account", label: "Account" },
        { id: "general", label: "General" },
        { id: "notifications", label: "Notifiche" },
        { id: "privacy", label: "Privacy" },
      ],
      user: {
        displayName: "Mario Rossi",
        email: "mario.rossi@gmail.com",
      },
      settings: {
        eventAlerts: true,
        badgeAlerts: true,
        publicProfile: false,
      },
    };
  },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com");

.settings-page {
  background: #000;
  min-height: 100vh;
  padding: 80px 4%;
  color: white;
  font-family: "Archivo", sans-serif;
}

.eyebrow {
  color: #ff3e00;
  font-weight: 800;
  letter-spacing: 3px;
  text-transform: uppercase;
  font-size: 0.8rem;
}
.title {
  font-family: "Syne", sans-serif;
  font-size: 4.5rem;
  font-weight: 800;
  text-transform: uppercase;
  margin: 10px 0;
}
.outline {
  -webkit-text-stroke: 1.5px white;
  color: transparent;
}

.settings-grid {
  display: grid;
  grid-template-columns: 250px 1fr;
  gap: 60px;
  margin-top: 40px;
}

/* Sidebar */
.settings-nav {
  display: flex;
  flex-direction: column;
  gap: 10px;
}
.nav-link {
  text-align: left;
  background: none;
  border: none;
  color: #555;
  font-weight: 900;
  text-transform: uppercase;
  font-size: 0.9rem;
  padding: 15px 0;
  cursor: pointer;
  transition: all 0.3s;
  border-bottom: 1px solid #111;
}
.nav-link.active {
  color: #ff3e00;
  border-bottom: 1px solid #ff3e00;
  padding-left: 10px;
}

/* Content & Cards */
.settings-section h3 {
  font-size: 1.8rem;
  margin-bottom: 30px;
  text-transform: uppercase;
}

.toggle-card {
  background: #0a0a0a;
  border: 1px solid #111;
  padding: 25px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
  clip-path: polygon(3% 0, 100% 0, 97% 100%, 0% 100%);
}

.info .label {
  font-weight: 900;
  text-transform: uppercase;
  display: block;
  margin-bottom: 5px;
}
.info p {
  font-size: 0.85rem;
  color: #666;
  max-width: 400px;
}

/* Custom Inputs */
.input-group {
  margin-bottom: 25px;
}
.input-group label {
  display: block;
  font-weight: 900;
  text-transform: uppercase;
  font-size: 0.75rem;
  color: #ff3e00;
  margin-bottom: 10px;
}
.input-group input {
  width: 100%;
  background: #111;
  border: 1px solid #222;
  color: white;
  padding: 15px;
  font-family: "Archivo";
  outline: none;
}
.input-group input:focus {
  border-color: #ff3e00;
}
.disabled {
  opacity: 0.4;
  cursor: not-allowed;
}

.btn-save {
  background: #ff3e00;
  color: black;
  font-weight: 900;
  text-transform: uppercase;
  padding: 15px 40px;
  border: none;
  cursor: pointer;
  margin-top: 20px;
  clip-path: polygon(10% 0, 100% 0, 90% 100%, 0% 100%);
}

/* Custom Switch */
.switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 24px;
}
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}
.slider {
  position: absolute;
  cursor: pointer;
  inset: 0;
  background-color: #222;
  transition: 0.4s;
  clip-path: polygon(10% 0, 100% 0, 90% 100%, 0% 100%);
}
.slider:before {
  position: absolute;
  content: "";
  height: 16px;
  width: 16px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  transition: 0.4s;
}
input:checked + .slider {
  background-color: #ff3e00;
}
input:checked + .slider:before {
  transform: translateX(26px);
  background-color: black;
}
</style>
