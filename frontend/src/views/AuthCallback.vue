<template>
  <div class="min-h-screen flex items-center justify-center bg-slate-900 border-b border-slate-800">
    <div class="text-center">
      <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-blue-500 border-t-transparent mb-4"></div>
      <p class="text-slate-400 text-lg">Authenticating...</p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const route = useRoute();
const router = useRouter();
const authStore = useAuthStore();

onMounted(async () => {
  const token = route.query.token as string;
  
  if (token) {
    authStore.token = token;
    authStore.isAuthenticated = true;
    localStorage.setItem('token', token);
    
    // Fetch user details to populate store
    try {
      await authStore.fetchUser();
      router.push('/dashboard');
    } catch (error) {
      console.error('Failed to fetch user after OAuth:', error);
      router.push('/login?error=auth_failed');
    }
  } else {
    router.push('/login?error=no_token');
  }
});
</script>
