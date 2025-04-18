import { createRouter, createWebHistory } from "vue-router";
import ArticlesPage from "./pages/ArticlesPage.vue";
import Home from "./pages/Home.vue";
import LoginPage from "./pages/LoginPage.vue";
import ProfilePage from "./pages/ProfilePage.vue";

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: "/",
      name: "home",
      component: Home,
    },
    {
      path: "/articles",
      name: "articles",
      component: ArticlesPage,
    },
    {
      path: "/login",
      name: "login",
      component: LoginPage,
    },
    {
      path: "/profile",
      name: "profile",
      component: ProfilePage,
    },
  ],
});

export { router };
