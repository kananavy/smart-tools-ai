<template>
  <div class="p-8 max-w-4xl mx-auto">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-white mb-2">Profile</h1>
      <p class="text-slate-400">Manage your account settings.</p>
    </div>

    <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-8">
      <div class="flex items-center mb-8">
        <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-blue-500 to-purple-500 flex items-center justify-center text-2xl font-bold text-white shadow-lg">
          {{ userInitials }}
        </div>
        <div class="ml-6">
          <h2 class="text-2xl font-bold text-white">{{ user?.name || 'User' }}</h2>
          <p class="text-slate-400">{{ user?.email || 'email@example.com' }}</p>
        </div>
      </div>

      <div class="space-y-6">
        <div>
           <label class="block text-slate-400 mb-2 text-sm">Full Name</label>
           <input :value="user?.name" disabled class="w-full bg-slate-900/50 border border-slate-700 rounded-lg px-4 py-3 text-slate-300 opacity-75 cursor-not-allowed" />
        </div>
        <div>
           <label class="block text-slate-400 mb-2 text-sm">Email Address</label>
           <input :value="user?.email" disabled class="w-full bg-slate-900/50 border border-slate-700 rounded-lg px-4 py-3 text-slate-300 opacity-75 cursor-not-allowed" />
        </div>
      </div>
      
      <div class="mt-8 pt-8 border-t border-slate-700">
        <button class="px-6 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg transition text-sm font-medium">
          Edit Profile (Coming Soon)
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { useAuthStore } from '../stores/auth';

const authStore = useAuthStore();
const user = computed(() => authStore.user);

const userInitials = computed(() => {
  const name = user.value?.name || '';
  return name
    .split(' ')
    .map((n: string) => n[0])
    .slice(0, 2)
    .join('')
    .toUpperCase();
});
</script>
