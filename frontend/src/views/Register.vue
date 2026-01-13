<template>
  <div class="min-h-screen flex items-center justify-center bg-slate-900 border-b border-slate-800">
    <div class="bg-slate-800/50 backdrop-blur-xl p-8 rounded-2xl shadow-2xl border border-slate-700 w-full max-w-md">
      <h2 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500 mb-6 text-center">Join SmartTools</h2>
      
      <form @submit.prevent="handleRegister" class="space-y-4">
        <div>
          <label class="block text-slate-400 mb-1 text-sm">Name</label>
          <input v-model="name" type="text" class="w-full bg-slate-900/50 border border-slate-700 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-blue-500 outline-none transition" required />
        </div>

        <div>
          <label class="block text-slate-400 mb-1 text-sm">Email</label>
          <input v-model="email" type="email" class="w-full bg-slate-900/50 border border-slate-700 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-blue-500 outline-none transition" required />
        </div>
        
        <div>
          <label class="block text-slate-400 mb-1 text-sm">Password</label>
          <input v-model="password" type="password" class="w-full bg-slate-900/50 border border-slate-700 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-blue-500 outline-none transition" required />
        </div>

        <div>
          <label class="block text-slate-400 mb-1 text-sm">Confirm Password</label>
          <input v-model="passwordConfirmation" type="password" class="w-full bg-slate-900/50 border border-slate-700 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-blue-500 outline-none transition" required />
        </div>
        
        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white font-semibold py-3 rounded-lg transition-transform transform active:scale-95 shadow-lg shadow-blue-500/20">
          Create Account
        </button>

        <!-- Social Login Divider -->
        <div class="relative my-6">
          <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-slate-700"></div>
          </div>
          <div class="relative flex justify-center text-sm">
            <span class="px-2 bg-slate-800 text-slate-400">Or continue with</span>
          </div>
        </div>

        <!-- Social Login Buttons -->
        <div class="grid grid-cols-2 gap-4">
          <button @click="handleSocialLogin('google')" type="button" class="flex items-center justify-center gap-2 px-4 py-2.5 border border-slate-700 rounded-lg hover:bg-slate-700/50 transition-colors group">
            <svg class="w-5 h-5 transition-transform group-hover:scale-110" viewBox="0 0 24 24">
              <path fill="#EA4335" d="M5.26620003,9.76451327 C4.59961358,11.1359051 4.22352941,12.6290588 4.22352941,14.2058824 C4.22352941,15.7827059 4.59961358,17.2758596 5.26620003,18.6472514 L5.26620003,18.6472514 L8.98144214,15.760081 C8.73030282,15.2676839 8.58823529,14.7118331 8.58823529,14.2058824 C8.58823529,13.6999316 8.73030282,13.1440808 8.98144214,12.6516837 L5.26620003,9.76451327 Z" />
              <path fill="#34A853" d="M16.0407269,18.0123114 C14.9509167,18.7163016 13.566392,19.1176471 12,19.1176471 C8.91313322,19.1176471 6.3159332,17.1594735 5.26628203,18.6472153 L5.26628203,18.6472153 L8.98152414,15.7600449 C9.68706462,17.2023529 11.2319364,18.2352941 13,18.2352941 C13.7383697,18.2352941 14.4360387,18.0683117 15.0493325,17.7714088 L16.0407269,18.0123114 Z" />
              <path fill="#4A90E2" d="M19.8342754,12.5 C19.9425838,13.0488994 20,13.6205734 20,14.2058824 C20,15.7331561 19.5350303,17.1519455 18.7307221,18.3308375 L18.7307221,18.3308375 L15.0493325,17.7714088 C16.5815121,16.8919637 17.6470588,15.654877 17.6470588,14.2058824 C17.6470588,13.6205734 17.5896426,13.0488994 17.4813342,12.5 L19.8342754,12.5 Z" />
              <path fill="#FBBC05" d="M5.26628203,9.76447833 L5.26628203,9.76447833 L8.98152414,12.6516487 C9.68706462,11.2093407 11.2319364,10.1764706 13,10.1764706 C13.7383697,10.1764706 14.4360387,10.343453 15.0493325,10.6403559 L18.7307221,10.0809272 C17.6256024,8.4559115 15.7418253,7.35294118 13.5294118,7.35294118 C11.2319364,7.35294118 9.20847957,8.2721415 7.74900366,9.75071199 L5.26628203,9.76447833 Z" />
            </svg>
            <span class="text-xs font-medium text-slate-300">Google</span>
          </button>
          
          <button @click="handleSocialLogin('github')" type="button" class="flex items-center justify-center gap-2 px-4 py-2.5 border border-slate-700 rounded-lg hover:bg-slate-700/50 transition-colors group">
            <svg class="w-5 h-5 fill-slate-300 transition-transform group-hover:scale-110" viewBox="0 0 24 24">
              <path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.43.372.823 1.102.823 2.222 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/>
            </svg>
            <span class="text-xs font-medium text-slate-300">GitHub</span>
          </button>
        </div>
      </form>
      
      <p class="mt-6 text-center text-slate-400 text-sm">
        Already have an account? <router-link to="/login" class="text-blue-400 hover:text-blue-300">Sign In</router-link>
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useAuthStore } from '../stores/auth';
import { useRouter } from 'vue-router';

const name = ref('');
const email = ref('');
const password = ref('');
const passwordConfirmation = ref('');

const authStore = useAuthStore();
const router = useRouter();

const handleRegister = async () => {
  try {
    if (password.value !== passwordConfirmation.value) {
      alert('Passwords do not match');
      return;
    }
    await authStore.register({ 
      name: name.value,
      email: email.value, 
      password: password.value,
      password_confirmation: passwordConfirmation.value 
    });
    router.push('/dashboard');
  } catch (error: any) {
    alert(error.response?.data?.message || 'Registration failed');
  }
};

const handleSocialLogin = async (provider: string) => {
  try {
    await authStore.socialLogin(provider);
    router.push('/dashboard');
  } catch (error: any) {
    alert('Social login failed');
  }
};
</script>
