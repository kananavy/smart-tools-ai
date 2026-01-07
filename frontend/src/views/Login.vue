<template>
  <div class="min-h-screen flex items-center justify-center bg-slate-900 border-b border-slate-800">
    <div class="bg-slate-800/50 backdrop-blur-xl p-8 rounded-2xl shadow-2xl border border-slate-700 w-full max-w-md">
      <h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500 mb-6 text-center">SmartTools AI</h2>
      
      <form @submit.prevent="handleLogin" class="space-y-4">
        <div>
          <label class="block text-slate-400 mb-1 text-sm">Email</label>
          <input v-model="email" type="email" class="w-full bg-slate-900/50 border border-slate-700 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-blue-500 outline-none transition" required />
        </div>
        
        <div>
          <label class="block text-slate-400 mb-1 text-sm">Password</label>
          <input v-model="password" type="password" class="w-full bg-slate-900/50 border border-slate-700 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-blue-500 outline-none transition" required />
        </div>
        
        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white font-semibold py-3 rounded-lg transition-transform transform active:scale-95 shadow-lg shadow-blue-500/20">
          Sign In
        </button>
      </form>
      
      <p class="mt-6 text-center text-slate-400 text-sm">
        Don't have an account? <router-link to="/register" class="text-blue-400 hover:text-blue-300">Register</router-link>
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useAuthStore } from '../stores/auth';
import { useRouter } from 'vue-router';

const email = ref('');
const password = ref('');
const authStore = useAuthStore();
const router = useRouter();

const handleLogin = async () => {
  try {
    await authStore.login({ email: email.value, password: password.value });
    router.push('/dashboard');
  } catch (error: any) {
    alert(error.response?.data?.message || 'Login failed');
  }
};
</script>
