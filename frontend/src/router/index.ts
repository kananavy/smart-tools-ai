import { createRouter, createWebHistory } from 'vue-router';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import Landing from '../views/Landing.vue';

const routes = [
    {
        path: '/',
        name: 'landing',
        component: Landing,
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
    },
    {
        path: '/register',
        name: 'Register',
        component: Register,
    },
    {
        path: '/auth/callback',
        name: 'AuthCallback',
        component: () => import('../views/AuthCallback.vue'),
    },
    {
        path: '/chat/:slug',
        name: 'Chat',
        component: () => import('../views/ChatInterface.vue'),
    },
    {
        path: '/dashboard',
        redirect: '/chat/text-generator'
    },
    {
        path: '/pricing-modal',
        name: 'PricingModal',
        component: () => import('../views/PricingModal.vue'),
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/profile',
        name: 'Profile',
        component: () => import('../views/UserProfile.vue'),
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/upgrade-payment',
        name: 'UpgradePayment',
        component: () => import('../views/UpgradePayment.vue'),
        meta: {
            requiresAuth: true
        }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, _from, next) => {
    const publicPages = ['/login', '/register', '/', '/pricing-modal']; // Ajouter '/pricing-modal' si vous voulez qu'elle soit publique
    const authRequired = !publicPages.includes(to.path);
    const loggedIn = localStorage.getItem('token');

    // Gestion spécifique pour PricingModal si nécessaire
    if (to.meta.requiresAuth && !loggedIn) {
        return next('/login');
    }

    if (authRequired && !loggedIn) {
        return next('/login');
    }

    if ((to.path === '/login' || to.path === '/register') && loggedIn) {
        return next('/dashboard');
    }

    next();
});

export default router;