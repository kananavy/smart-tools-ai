import { createRouter, createWebHistory } from 'vue-router';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import Landing from '../views/Landing.vue';
import Dashboard from '../layouts/DashboardLayout.vue';

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
        path: '/chat/:slug',
        name: 'Chat',
        component: () => import('../views/ChatInterface.vue'),
    },
    {
        path: '/dashboard',
        redirect: '/chat/text-generator'
    },
    {
        path: '/dashboard/old', // Kept for reference or transition if needed
        component: Dashboard,
        children: [
            {
                path: '', // Default child route for /dashboard
                redirect: { name: 'Tools' } // Redirect to the 'Tools' route
            },
            {
                path: 'tools',
                name: 'Tools',
                component: () => import('../views/Tools.vue'),
            },

            {
                path: 'history',
                name: 'History',
                component: () => import('../views/History.vue'),
            },
            {
                path: 'profile',
                name: 'Profile',
                component: () => import('../views/Profile.vue'),
            },
            {
                path: 'pricing',
                name: 'Pricing',
                component: () => import('../views/Pricing.vue'),
            }
        ]
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, _from, next) => {
    const publicPages = ['/login', '/register', '/'];
    const authRequired = !publicPages.includes(to.path);
    const loggedIn = localStorage.getItem('token');

    if (authRequired && !loggedIn) {
        return next('/login');
    }

    if ((to.path === '/login' || to.path === '/register') && loggedIn) {
        return next('/dashboard');
    }

    next();
});

export default router;
