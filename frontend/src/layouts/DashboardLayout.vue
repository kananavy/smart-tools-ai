<template>
  <div class="flex h-screen bg-slate-900 text-slate-100 overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-slate-800/50 backdrop-blur border-r border-slate-700 flex flex-col">
      <div class="p-6">
        <h1 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-500">
          SmartTools
        </h1>
      </div>

      <nav class="flex-1 px-4 space-y-2">
        <router-link to="/dashboard" class="flex items-center px-4 py-3 rounded-lg hover:bg-slate-700/50 transition" :class="{ 'bg-blue-600/20 text-blue-400': $route.path === '/dashboard' }">
          <GalleryVerticalEndIcon class="w-5 h-5 mr-3" />
          Dashboard
        </router-link>
        <router-link to="/dashboard/history" class="flex items-center px-4 py-3 rounded-lg hover:bg-slate-700/50 transition">
          <HistoryIcon class="w-5 h-5 mr-3" />
          History
        </router-link>
        <div class="mt-8 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Settings</div>
        <router-link to="/dashboard/profile" class="flex items-center px-4 py-3 rounded-lg hover:bg-slate-700/50 transition" :class="{ 'bg-blue-600/20 text-blue-400': $route.path === '/dashboard/profile' }">
          <UserIcon class="w-5 h-5 mr-3" />
          Profile
        </router-link>
      </nav>

      <div class="p-4 border-t border-slate-700">
        <button @click="logout" class="flex items-center w-full px-4 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition">
          <LogOutIcon class="w-5 h-5 mr-3" />
          Sign Out
        </button>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
      <header class="h-16 flex items-center justify-between px-8 bg-slate-800/30 backdrop-blur border-b border-slate-700 sticky top-0 z-10">
        <h2 class="text-lg font-medium">Dashboard</h2>
        <div class="flex items-center space-x-4">
          <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-blue-500 to-purple-500 flex items-center justify-center text-xs font-bold">
            KV
          </div>
        </div>
      </header>

      <div class="p-8">
        <router-view />
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { GalleryVerticalEndIcon, HistoryIcon, UserIcon, LogOutIcon } from 'lucide-vue-next';
import { useAuthStore } from '../stores/auth';
import { useRouter } from 'vue-router';

const authStore = useAuthStore();
const router = useRouter();

const logout = async () => {
  await authStore.logout();
  router.push('/login');
};
</script>
