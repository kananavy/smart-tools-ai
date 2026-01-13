import { defineStore } from 'pinia';
import api from '../services/api';
import { useSubscriptionStore } from './subscription';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null as any,
        token: localStorage.getItem('token') || null,
        isAuthenticated: false,
    }),
    actions: {
        async login(credentials: any) {
            const response = await api.post('/login', credentials);
            this.token = response.data.access_token;
            this.user = response.data.user;
            this.isAuthenticated = true;
            localStorage.setItem('token', this.token || '');
        },
        async register(userData: any) {
            const response = await api.post('/register', userData);
            this.token = response.data.access_token;
            this.user = response.data.user;
            this.isAuthenticated = true;
            localStorage.setItem('token', this.token || '');
        },
        async socialLogin(provider: string) {
            const response = await api.get(`/auth/${provider}/redirect`);
            if (response.data) {
                window.location.href = response.data;
            }
        },
        async fetchUser() {
            try {
                const response = await api.get('/user');
                this.user = response.data;
                this.isAuthenticated = true;
            } catch (error) {
                console.error('Failed to fetch user:', error);
                this.user = null;
                this.isAuthenticated = false;
            }
        },
        async logout() {
            const subscriptionStore = useSubscriptionStore();
            if (this.token) {
                try {
                    await api.post('/logout');
                } catch (error) {
                    console.error('Logout failed:', error);
                }
            }
            this.user = null;
            this.token = null;
            this.isAuthenticated = false;
            localStorage.removeItem('token');
            subscriptionStore.reset();
        },
    }
});
