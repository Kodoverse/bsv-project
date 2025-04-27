import { createRouter, createWebHistory } from "vue-router";
import ArticlesPage from "./pages/ArticlesPage.vue";
import Home from "./pages/Home.vue";
import LoginPage from "./pages/LoginPage.vue";
import RegisterPage from "./pages/RegisterPage.vue";  
import ProfilePage from "./pages/ProfilePage.vue";
import AboutUsPage from "./pages/AboutUsPage.vue";
import axios from "axios";

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
      path: "/register",
      name: "register",
      component: RegisterPage,
    },
    {
      path: "/aboutus",
      name: "aboutus",
      component: AboutUsPage,
    },
    {
      path: "/profile",
      name: "profile",
      component: ProfilePage,
      meta: { requiresAuth: true },
    },
  ],
});

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth) {
    axios
      .get("http://localhost:8000/api/user", { withCredentials: true })
      .then((response) => {
        if (response.status === 200) {
          next();
        } else {
          next("/login");
        }
      })
      .catch(() => {
        next("/login");
      });
  } else {
    next();
  }
});

export { router };
