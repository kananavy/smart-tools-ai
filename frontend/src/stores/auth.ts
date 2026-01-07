import { defineStore } from 'pinia';
import api from '../services/api';

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
        async logout() {
            if (this.token) {
                try {
                    await api.post('/logout', {}, {
                        headers: { Authorization: `Bearer ${this.token}` }
                    });
                } catch (e) {
                    console.error(e);
                }
            }
            this.user = null;
            this.token = null;
            this.isAuthenticated = false;
            localStorage.removeItem('token');
        }
    }
});
