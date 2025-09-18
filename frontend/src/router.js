import { createRouter, createWebHistory } from "vue-router";
import ArticlesPage from "./pages/ArticlesPage.vue";
import Home from "./pages/Home.vue";
import LoginPage from "./pages/LoginPage.vue";
import RegisterPage from "./pages/RegisterPage.vue";  
import ProfilePage from "./pages/ProfilePage.vue";
import AboutUsPage from "./pages/AboutUsPage.vue";
import SingleArticle from "./pages/SingleArticle.vue";
import CategoryEvents from "./pages/CategoryEvents.vue";
import AdminDashboard from "./pages/AdminDashboard.vue";
import PartnerDashboard from "./pages/PartnerDashboard.vue";
import ShoppingPage from "./pages/ShoppingPage.vue";
import axios from "axios";
import { store } from "./store.js";

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
    {
      path: "/article/:id",
      name: "singlearticle",
      component: SingleArticle,
    },
    {
      path: "/category/:id/events",
      name: "category-events",
      component: CategoryEvents,
    },
    {
      path: "/admin",
      name: "admin-dashboard",
      component: AdminDashboard,
      meta: { requiresAuth: true, requiresAdmin: true },
    },
    {
      path: "/partner",
      name: "partner-dashboard",
      component: PartnerDashboard,
      meta: { requiresAuth: true, requiresPartner: true },
    },
  {
    path: "/shop",
    name: "shopping",
    component: ShoppingPage,
  },
  {
    path: "/business/:id",
    name: "business-detail",
    component: ShoppingPage,
    props: true,
  },
  ],
});

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth) {
    axios
      .get("http://localhost:8000/api/user", { withCredentials: true })
      .then((response) => {
        if (response.status === 200) {
          // Update store with user data
          store.CurrentUser = response.data;
          store.isLoggedIn = true;
          
          // Check admin access for admin routes
          if (to.meta.requiresAdmin && !store.hasAdminPrivileges) {
            next("/");
            return;
          }
          
          // Check partner access for partner routes
          if (to.meta.requiresPartner && !store.isPartner) {
            next("/");
            return;
          }
          
          next();
        } else {
          next("/login");
        }
      })
      .catch(() => {
        store.isLoggedIn = false;
        store.CurrentUser = null;
        next("/login");
      });
  } else {
    next();
  }
});

export { router };
