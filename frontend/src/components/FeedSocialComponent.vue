<template>
  <section class="feed-social">
    <div class="header-container">
      <span
        class="text-orange-600 font-extrabold tracking-[0.2em] uppercase text-sm mb-4 block"
        >Visual Feed</span
      >
      <h2 class="wall-title">Photo Wall</h2>
      <div class="accent-line"></div>
    </div>

    <div class="grid-container">
      <div
        v-for="(img, index) in imageList"
        :key="index"
        :class="['tile', getTileSize(index)]"
        @click="openModal(img)"
      >
        <div class="tile-inner">
          <img :src="img" alt="Social Hub Moment" loading="lazy" />
        </div>
      </div>
    </div>

    <!-- Modal Lightbox -->
    <transition name="modal-fade">
      <div v-if="selectedImage" class="modal-overlay" @click.self="closeModal">
        <button class="close-btn" @click="closeModal">✕</button>
        <div class="modal-content">
          <img :src="selectedImage" class="full-img" />
          <div class="modal-decoration"></div>
        </div>
      </div>
    </transition>

    <div class="clearfix"></div>
  </section>
</template>

<script>
export default {
  name: "FeedSocialComponent",
  data() {
    return {
      selectedImage: null,
      imageList: [
        "https://images.unsplash.com/photo-1528605248644-14dd04022da1?ixid=M3w4MjcwNjd8MHwxfHNlYXJjaHwxfHxzb2NpYWwlMjBldmVudHN8ZW58MHx8fHwxNzcxMjQ4MDQxfDA&ixlib=rb-4.1.0&w=800&fit=max&q=80",
        "https://images.unsplash.com/photo-1519671482749-fd09be7ccebf?ixid=M3w4MjcwNjd8MHwxfHNlYXJjaHwyfHxzb2NpYWwlMjBldmVudHN8ZW58MHx8fHwxNzcxMjQ4MDQxfDA&ixlib=rb-4.1.0&w=800&fit=max&q=80",
        "https://images.unsplash.com/photo-1630192207555-ccefb628b2a7?ixid=M3w4MjcwNjd8MHwxfHNlYXJjaHwzfHxzb2NpYWwlMjBldmVudHN8ZW58MHx8fHwxNzcxMjQ4MDQxfDA&ixlib=rb-4.1.0&w=800&fit=max&q=80",
        "https://images.unsplash.com/photo-1761506829195-f1ebe5c14a7c?ixid=M3w4MjcwNjd8MHwxfHNlYXJjaHw0fHxzb2NpYWwlMjBldmVudHN8ZW58MHx8fHwxNzcxMjQ4MDQxfDA&ixlib=rb-4.1.0&w=800&fit=max&q=80",
        "https://images.unsplash.com/photo-1603501266047-f4a2f093503b?ixid=M3w4MjcwNjd8MHwxfHNlYXJjaHw1fHxzb2NpYWwlMjBldmVudHN8ZW58MHx8fHwxNzcxMjQ4MDQxfDA&ixlib=rb-4.1.0&w=800&fit=max&q=80",
        "https://images.unsplash.com/photo-1511942260412-c7376b468e86?ixid=M3w4MjcwNjd8MHwxfHNlYXJjaHw2fHxzb2NpYWwlMjBldmVudHN8ZW58MHx8fHwxNzcxMjQ4MDQxfDA&ixlib=rb-4.1.0&w=800&fit=max&q=80",
        "https://images.unsplash.com/photo-1586969778481-49d8362091ab?ixid=M3w4MjcwNjd8MHwxfHNlYXJjaHw3fHxzb2NpYWwlMjBldmVudHN8ZW58MHx8fHwxNzcxMjQ4MDQxfDA&ixlib=rb-4.1.0&w=800&fit=max&q=80",
        "https://images.unsplash.com/photo-1586008604829-a16f775eec81?ixid=M3w4MjcwNjd8MHwxfHNlYXJjaHw4fHxzb2NpYWwlMjBldmVudHN8ZW58MHx8fHwxNzcxMjQ4MDQxfDA&ixlib=rb-4.1.0&w=800&fit=max&q=80",
        "https://images.unsplash.com/photo-1712903276015-23668958a2ad?ixid=M3w4MjcwNjd8MHwxfHNlYXJjaHw5fHxzb2NpYWwlMjBldmVudHN8ZW58MHx8fHwxNzcxMjQ4MDQxfDA&ixlib=rb-4.1.0&w=800&fit=max&q=80",
        "https://images.unsplash.com/photo-1614794255021-22d3fc869e17?ixid=M3w4MjcwNjd8MHwxfHNlYXJjaHwxMHx8c29jaWFsJTIwZXZlbnRzfGVufDB8fHx8MTc3MTI0ODA0MXww&ixlib=rb-4.1.0&w=800&fit=max&q=80",
        "https://images.unsplash.com/photo-1584996564514-9a99c942a614?ixid=M3w4MjcwNjd8MHwxfHNlYXJjaHwxMXx8c29jaWFsJTIwZXZlbnRzfGVufDB8fHx8MTc3MTI0ODA0MXww&ixlib=rb-4.1.0&w=800&fit=max&q=80",
        "https://images.unsplash.com/photo-1585063644109-6b98ae6e7bf6?ixid=M3w4MjcwNjd8MHwxfHNlYXJjaHwxMnx8c29jaWFsJTIwZXZlbnRzfGVufDB8fHx8MTc3MTI0ODA0MXww&ixlib=rb-4.1.0&w=800&fit=max&q=80",
        "https://images.unsplash.com/photo-1585968962843-1fd5278a43cf?ixid=M3w4MjcwNjd8MHwxfHNlYXJjaHwxM3x8c29jaWFsJTIwZXZlbnRzfGVufDB8fHx8MTc3MTI0ODA0MXww&ixlib=rb-4.1.0&w=800&fit=max&q=80",
        "https://images.unsplash.com/photo-1712903276252-64687cba790e?ixid=M3w4MjcwNjd8MHwxfHNlYXJjaHwxNHx8c29jaWFsJTIwZXZlbnRzfGVufDB8fHx8MTc3MTI0ODA0MXww&ixlib=rb-4.1.0&w=800&fit=max&q=80",
        "https://images.unsplash.com/photo-1712903276026-9a2381d3b464?ixid=M3w4MjcwNjd8MHwxfHNlYXJjaHwxNXx8c29jaWFsJTIwZXZlbnRzfGVufDB8fHx8MTc3MTI0ODA0MXww&ixlib=rb-4.1.0&w=800&fit=max&q=80",
        "https://images.unsplash.com/photo-1587235044459-f2dc88ab6cf3?ixid=M3w4MjcwNjd8MHwxfHNlYXJjaHwxNnx8c29jaWFsJTIwZXZlbnRzfGVufDB8fHx8MTc3MTI0ODA0MXww&ixlib=rb-4.1.0&w=800&fit=max&q=80",
        "https://images.unsplash.com/photo-1587227172314-8db19c077411?ixid=M3w4MjcwNjd8MHwxfHNlYXJjaHwxN3x8c29jaWFsJTIwZXZlbnRzfGVufDB8fHx8MTc3MTI0ODA0MXww&ixlib=rb-4.1.0&w=800&fit=max&q=80",
        "https://images.unsplash.com/photo-1713783313107-9ef218eb6f88?ixid=M3w4MjcwNjd8MHwxfHNlYXJjaHwxOHx8c29jaWFsJTIwZXZlbnRzfGVufDB8fHx8MTc3MTI0ODA0MXww&ixlib=rb-4.1.0&w=800&fit=max&q=80",
      ],
      // Pattern di dimensioni per simulare Windows 8 senza buchi nella griglia
      sizePatterns: [
        "small",
        "small",
        "wide",
        "small",
        "tall",
        "large",
        "small",
        "wide",
      ],
    };
  },
  methods: {
    getTileSize(index) {
      const totalImages = this.imageList.length;
      const pattern = this.sizePatterns[index % this.sizePatterns.length];

      // Se siamo negli ultimi 4-5 elementi (ultima riga potenziale),
      // forziamo un layout orizzontale o quadrato piccolo
      if (index >= totalImages - 4) {
        if (pattern === "tall" || pattern === "large") {
          return "wide"; // Trasformiamo i blocchi alti in blocchi larghi
        }
      }

      return pattern;
    },
    openModal(img) {
      this.selectedImage = img;
      document.body.style.overflow = "hidden"; // Stop background scrolling
    },
    closeModal() {
      this.selectedImage = null;
      document.body.style.overflow = "auto"; // Restore scrolling
    },
  },
};
</script>

<style scoped>
.feed-social {
  background: #000;
  padding: 100px 20px;
  color: white;
  /* FIX: Forces the section to contain all floated/grid children */
  display: flow-root;
  position: relative;
  width: 100%;
}

.header-container {
  max-width: 1600px;
  margin: 0 auto 60px auto;
}

.wall-title {
  font-size: 5rem;
  font-weight: 900;
}

.outline {
  -webkit-text-stroke: 1.5px white;
  color: transparent;
}

.accent-line {
  width: 80px;
  height: 6px;
  background: #ff3e00;
  margin-top: 20px;
}

.grid-container {
  display: grid;
  grid-template-columns: repeat(8, 1fr);
  grid-auto-rows: 160px;
  gap: 4px;
  max-width: 1600px;
  margin: 0 auto;
  /* FIX: Ensures grid doesn't collapse */
  overflow: visible;
}

.tile {
  position: relative;
  background: #111;
  overflow: hidden;
  height: 100%; /* Fixes spillover */
}

.tile img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  filter: grayscale(40%) brightness(0.8);
  transition: all 0.5s ease;
}

.tile:hover img {
  filter: grayscale(0%) brightness(1);
  transform: scale(1.05);
}

/* Tile sizes */
.tile.small {
  grid-column: span 1;
  grid-row: span 1;
}
.tile.wide {
  grid-column: span 2;
  grid-row: span 1;
}
.tile.tall {
  grid-column: span 1;
  grid-row: span 2;
}
.tile.large {
  grid-column: span 2;
  grid-row: span 2;
}

.clearfix {
  clear: both;
  height: 1px;
}

@media (max-width: 1200px) {
  .grid-container {
    grid-template-columns: repeat(4, 1fr);
  }
  .wall-title {
    font-size: 3rem;
  }
}

/* Modal Styling */
.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.95);
  backdrop-filter: blur(10px);
  z-index: 9999;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 40px;
}

.modal-content {
  position: relative;
  max-width: 90%;
  max-height: 90vh;
  box-shadow: 0 0 50px rgba(255, 62, 0, 0.2);
}

.full-img {
  max-width: 100%;
  max-height: 85vh;
  object-fit: contain;
  border: 1px solid rgba(255, 255, 255, 0.1);
}

.modal-decoration {
  position: absolute;
  bottom: -10px;
  right: -10px;
  width: 100px;
  height: 100px;
  background: #ff3e00;
  z-index: -1;
  clip-path: polygon(20% 0, 100% 0, 100% 100%, 0% 100%);
}

.close-btn {
  position: absolute;
  top: 30px;
  right: 30px;
  background: none;
  border: none;
  color: white;
  font-size: 2rem;
  cursor: pointer;
  transition: transform 0.3s;
}

.close-btn:hover {
  transform: rotate(90deg) scale(1.2);
  color: #ff3e00;
}

/* Modal Transitions */
.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: opacity 0.4s ease;
}
.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
}

.modal-fade-enter-active .modal-content {
  animation: zoomIn 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
}

@keyframes zoomIn {
  from {
    transform: scale(0.9);
    opacity: 0;
  }
  to {
    transform: scale(1);
    opacity: 1;
  }
}
</style>
