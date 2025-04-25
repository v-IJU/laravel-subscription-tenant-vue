import { createRouter, createWebHistory } from "vue-router";
import Home from "./components/pages/Home.vue";
import About from "./components/pages/About.vue";
import Contact from "./components/pages/Contact.vue";
import Login from "./components/pages/Login.vue";

const routes = [
    { path: "/", component: Home },
    { path: "/about", component: About },
    { path: "/contact", component: Contact, meta: { requiresAuth: true } }, // Protect this route },
    { path: "/customerlogin", component: Login },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Navigation Guard to Protect Routes
router.beforeEach((to, from, next) => {
    const isAuthenticated = localStorage.getItem("token"); // Check authentication from localStorage

    if (to.meta.requiresAuth && !isAuthenticated) {
        next("/customerlogin"); // Redirect to login if not authenticated
    } else {
        next(); // Proceed as normal
    }
});

export default router;
