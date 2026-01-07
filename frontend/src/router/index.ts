import { createRouter, createWebHistory } from 'vue-router';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import Dashboard from '../layouts/DashboardLayout.vue';
import Tools from '../views/Tools.vue';

const routes = [
    {
        path: '/',
        redirect: '/dashboard',
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
        path: '/dashboard',
        component: Dashboard,
        children: [
            {
                path: '',
                name: 'Tools',
                component: Tools,
            },
            {
                path: 'tools/:slug',
                name: 'ToolRunner',
                component: () => import('../views/ToolRunner.vue'),
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
