<template>
  <section class="events-categories">
    <!-- Main Constraint Container -->
    <div class="max-w-[1600px] mx-auto">
      <!-- Header aligned with PhotoWall logic -->
      <div class="header-container">
        <div class="flex items-end justify-between mb-10">
          <div class="title-group">
            <span class="eyebrow">Esplora l'Hub</span>
            <h2 class="wall-title">Categorie Eventi</h2>
            <div class="accent-line"></div>
          </div>

          <!-- Navigation moved here for a tighter, more professional feel -->
          <div class="hidden nav-controls md:flex">
            <button @click="scroll('left')" class="ctrl-btn">←</button>
            <button @click="scroll('right')" class="ctrl-btn">→</button>
          </div>
        </div>
      </div>

      <!-- Scroll wrapper constrained by parent -->
      <div class="overflow-hidden relative-wrapper">
        <div ref="scrollContainer" class="flex-scroll no-scrollbar">
          <div
            v-for="(category, index) in categories"
            :key="category.id"
            @click="navigateToCategory(category.id)"
            class="category-card-wrapper"
          >
            <div
              class="category-card"
              :style="{ marginLeft: index === 0 ? '0' : '-45px' }"
            >
              <div class="shape-bg">
                <div
                  class="w-full h-full"
                  :style="generateShape(category.name)"
                ></div>
              </div>

              <div class="card-body">
                <span class="category-tag">{{ category.name }}</span>
                <h3 class="category-name">{{ generateTitle(category) }}</h3>
                <p class="category-desc">{{ category.description }}</p>
                <button class="btn-brutalist-small">View Events</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
@import url("https://fonts.googleapis.com");

.events-categories {
  background: #000;
  padding: 80px 0; /* Balanced padding */
  color: white;
  font-family: "Archivo", sans-serif;
  width: 100%;
}

.eyebrow {
  color: #ff3e00;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 4px;
  font-size: 0.8rem;
  display: block;
}

.wall-title {
  font-family: "Syne", sans-serif;
  font-size: 4.5rem;
  font-weight: 900;
  line-height: 1;
  margin: 10px 0;
}

.outline {
  -webkit-text-stroke: 1.5px white;
  color: transparent;
}

.accent-line {
  width: 60px;
  height: 5px;
  background: #ff3e00;
}

.flex-scroll {
  display: flex;
  overflow-x: auto;
  padding: 20px 0 40px 0; /* Removed left/right padding to stay in 1600px grid */
  scroll-behavior: smooth;
  gap: 0;
}

.no-scrollbar::-webkit-scrollbar {
  display: none;
}

.category-card-wrapper {
  flex: none;
  width: 380px;
  cursor: pointer;
  z-index: 1;
}

.category-card-wrapper:hover {
  z-index: 10;
}

.category-card {
  position: relative;
  height: 400px;
  background: #080808;
  border: 1px solid rgba(255, 255, 255, 0.05);
  transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
  clip-path: polygon(12% 0, 100% 0, 88% 100%, 0% 100%);
}

.category-card:hover {
  background: #121212;
  transform: translateY(-10px);
  border-color: #ff3e00;
}

.card-body {
  height: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 40px 60px;
  text-align: center;
}

.category-name {
  font-family: "Syne", sans-serif;
  font-size: 2rem;
  font-weight: 800;
  text-transform: uppercase;
  margin: 15px 0;
}

.category-desc {
  font-size: 0.9rem;
  color: #666;
  line-height: 1.5;
  margin-bottom: 25px;
  transition: color 0.3s;
}

.category-card:hover .category-desc {
  color: #aaa;
}

.btn-brutalist-small {
  padding: 10px 24px;
  background: #ff3e00;
  color: #000;
  font-weight: 900;
  font-size: 0.65rem;
  text-transform: uppercase;
  clip-path: polygon(10% 0, 100% 0, 90% 100%, 0% 100%);
  border: none;
  cursor: pointer;
}

.ctrl-btn {
  width: 50px;
  height: 50px;
  border: 1px solid #222;
  background: transparent;
  color: white;
  font-size: 1.2rem;
  transition: all 0.3s;
  cursor: pointer;
}

.ctrl-btn:hover {
  background: #ff3e00;
  border-color: #ff3e00;
  color: #000;
}

@media (max-width: 1024px) {
  .wall-title {
    font-size: 2.8rem;
  }
  .category-card {
    clip-path: none;
    margin-left: 0 !important;
    width: 100%;
  }
  .category-card-wrapper {
    width: 300px;
  }
}
</style>

<script>
import axios from "axios";

export default {
  name: "EventCategoryCarousel",
  data() {
    return {
      categories: [],
      isVisible: false,
      scrollProgress: 0,
      gradients: {
        Cinema: "linear-gradient(135deg, #FF6B6B, #8E2DE2)",
        Gaming: "linear-gradient(135deg, #4158D0, #C850C0)",
        Languages: "linear-gradient(135deg, #FF8008, #FFC837)",
        Workshops: "linear-gradient(135deg, #0093E9, #80D0C7)",
        "Book Club": "linear-gradient(135deg, #FC466B, #3F5EFB)",
        Volunteering: "linear-gradient(135deg, #11998e, #38ef7d)",
        default: "linear-gradient(135deg, #8E2DE2, #4A00E0)",
      },
      shapes: {
        Cinema:
          "radial-gradient(circle at 70% 30%, #FF6B6B 0%, transparent 70%)",
        Gaming:
          "radial-gradient(circle at 30% 70%, #4158D0 0%, transparent 70%)",
        Languages:
          "radial-gradient(circle at 50% 50%, #FFC837 0%, transparent 70%)",
        Workshops:
          "radial-gradient(circle at 20% 80%, #0093E9 0%, transparent 70%)",
        "Book Club":
          "radial-gradient(circle at 60% 40%, #FC466B 0%, transparent 70%)",
        Volunteering:
          "radial-gradient(circle at 40% 60%, #11998e 0%, transparent 70%)",
        default:
          "radial-gradient(circle at 50% 50%, #8E2DE2 0%, transparent 70%)",
      },
      categoryColors: {
        Cinema: "#FF6B6B",
        Gaming: "#4158D0",
        Languages: "#FF8008",
        Workshops: "#0093E9",
        "Book Club": "#FC466B",
        Volunteering: "#11998e",
        default: "#8E2DE2",
      },
    };
  },
  methods: {
    async fetchCategories() {
      try {
        const response = await axios.get("/api/event-categories");
        this.categories = response.data;
        setTimeout(() => {
          this.isVisible = true;
        }, 100);
      } catch (error) {
        console.error("Error fetching event categories:", error);
      }
    },
    formatDate() {
      const date = new Date();
      return date.toLocaleDateString("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric",
      });
    },
    generateGradient(categoryName) {
      return this.gradients[categoryName] || this.gradients.default;
    },
    generateShape(categoryName) {
      return {
        background: this.shapes[categoryName] || this.shapes.default,
      };
    },
    getCategoryColor(categoryName) {
      return this.categoryColors[categoryName] || this.categoryColors.default;
    },
    generateTitle(category) {
      const titles = {
        Cinema: "Discover Movie Magic",
        Gaming: "Level Up Your Gaming",
        Languages: "Connect Through Language",
        Workshops: "Learn and Create Together",
        "Book Club": "Journey Through Stories",
        Volunteering: "Make a Difference",
      };
      return titles[category.name] || `Explore ${category.name}`;
    },
    scroll(direction) {
      const container = this.$refs.scrollContainer;
      const scrollAmount = 420; // Width of one card + gap

      if (direction === "left") {
        container.scrollBy({ left: -scrollAmount, behavior: "smooth" });
      } else {
        container.scrollBy({ left: scrollAmount, behavior: "smooth" });
      }
    },
    updateScrollProgress() {
      const container = this.$refs.scrollContainer;
      if (!container) return;

      const maxScroll = container.scrollWidth - container.clientWidth;
      this.scrollProgress = (container.scrollLeft / maxScroll) * 100;
    },
    navigateToCategory(categoryId) {
      console.log("Navigating to category:", categoryId);
      this.$router.push({
        name: "category-events",
        params: { id: categoryId.toString() },
      });
    },
  },
  mounted() {
    this.fetchCategories();
    this.$refs.scrollContainer?.addEventListener(
      "scroll",
      this.updateScrollProgress,
    );
  },
  beforeUnmount() {
    this.$refs.scrollContainer?.removeEventListener(
      "scroll",
      this.updateScrollProgress,
    );
  },
};
</script>

<style scoped>
.carousel-item {
  transition: transform 0.5s ease-in-out;
}
</style>
