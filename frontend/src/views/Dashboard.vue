<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950">
    <!-- Hero Section -->
    <div class="relative overflow-hidden">
      <!-- Animated background -->
      <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 via-purple-600/20 to-pink-600/20 animate-pulse"></div>
      
      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Welcome Header -->
        <div class="text-center mb-12">
          <h1 class="text-5xl font-bold text-white mb-4">
            Welcome back, <span class="bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">{{ user?.name }}</span>
          </h1>
          <p class="text-slate-400 text-lg">Your AI-powered productivity hub</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
          <!-- Usage Card -->
          <div class="group relative bg-slate-800/50 backdrop-blur-xl border border-slate-700/50 rounded-2xl p-6 hover:border-blue-500/50 transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/20">
            <div class="flex items-center justify-between mb-4">
              <div class="p-3 bg-blue-500/10 rounded-xl group-hover:bg-blue-500/20 transition">
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
              </div>
              <span v-if="subscription?.plan === 'pro'" class="px-3 py-1 bg-gradient-to-r from-purple-500 to-pink-500 text-white text-xs font-semibold rounded-full">PRO</span>
            </div>
            <h3 class="text-slate-400 text-sm mb-2">Generations This Month</h3>
            <p class="text-3xl font-bold text-white">{{ subscription?.usage_count || 0 }}</p>
            <div class="mt-4">
              <div class="flex justify-between text-xs text-slate-400 mb-2">
                <span>{{ subscription?.plan === 'pro' ? 'Unlimited' : `${subscription?.usage_count || 0} / ${subscription?.monthly_limit || 50}` }}</span>
                <span v-if="subscription?.plan !== 'pro'">{{ remainingGenerations }} left</span>
              </div>
              <div v-if="subscription?.plan !== 'pro'" class="w-full bg-slate-700 rounded-full h-2">
                <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-2 rounded-full transition-all duration-500" :style="{ width: usagePercentage + '%' }"></div>
              </div>
            </div>
          </div>

          <!-- Tools Used Card -->
          <div class="group relative bg-slate-800/50 backdrop-blur-xl border border-slate-700/50 rounded-2xl p-6 hover:border-purple-500/50 transition-all duration-300 hover:shadow-lg hover:shadow-purple-500/20">
            <div class="p-3 bg-purple-500/10 rounded-xl group-hover:bg-purple-500/20 transition mb-4">
              <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
              </svg>
            </div>
            <h3 class="text-slate-400 text-sm mb-2">Tools Used</h3>
            <p class="text-3xl font-bold text-white">{{ toolsUsedCount }}</p>
            <p class="text-xs text-slate-500 mt-2">Across all categories</p>
          </div>

          <!-- Account Status Card -->
          <div class="group relative bg-slate-800/50 backdrop-blur-xl border border-slate-700/50 rounded-2xl p-6 hover:border-pink-500/50 transition-all duration-300 hover:shadow-lg hover:shadow-pink-500/20">
            <div class="p-3 bg-pink-500/10 rounded-xl group-hover:bg-pink-500/20 transition mb-4">
              <svg class="w-6 h-6 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
              </svg>
            </div>
            <h3 class="text-slate-400 text-sm mb-2">Account Status</h3>
            <p class="text-3xl font-bold text-white capitalize">{{ subscription?.plan || 'Free' }}</p>
            <router-link v-if="subscription?.plan !== 'pro'" to="/pricing" class="inline-flex items-center text-xs text-pink-400 hover:text-pink-300 mt-2 group-hover:underline">
              Upgrade to Pro →
            </router-link>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-slate-800/30 backdrop-blur-xl border border-slate-700/50 rounded-2xl p-8">
          <h2 class="text-2xl font-bold text-white mb-6">Quick Actions</h2>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <router-link to="/dashboard/tools" class="group flex items-center p-4 bg-slate-700/30 hover:bg-slate-700/50 rounded-xl transition border border-transparent hover:border-blue-500/50">
              <div class="p-3 bg-blue-500/10 rounded-lg mr-4 group-hover:bg-blue-500/20 transition">
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
              </div>
              <div>
                <h3 class="text-white font-semibold">Browse Tools</h3>
                <p class="text-slate-400 text-sm">Explore AI tools</p>
              </div>
            </router-link>

            <router-link to="/dashboard/history" class="group flex items-center p-4 bg-slate-700/30 hover:bg-slate-700/50 rounded-xl transition border border-transparent hover:border-purple-500/50">
              <div class="p-3 bg-purple-500/10 rounded-lg mr-4 group-hover:bg-purple-500/20 transition">
                <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div>
                <h3 class="text-white font-semibold">View History</h3>
                <p class="text-slate-400 text-sm">Past generations</p>
              </div>
            </router-link>

            <router-link to="/dashboard/profile" class="group flex items-center p-4 bg-slate-700/30 hover:bg-slate-700/50 rounded-xl transition border border-transparent hover:border-pink-500/50">
              <div class="p-3 bg-pink-500/10 rounded-lg mr-4 group-hover:bg-pink-500/20 transition">
                <svg class="w-6 h-6 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
              </div>
              <div>
                <h3 class="text-white font-semibold">My Profile</h3>
                <p class="text-slate-400 text-sm">Account settings</p>
              </div>
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { useAuthStore } from '../stores/auth';
import api from '../services/api';

const authStore = useAuthStore();
const user = computed(() => authStore.user);

const subscription = ref<any>(null);
const toolsUsedCount = ref(0);

const remainingGenerations = computed(() => {
  if (!subscription.value || subscription.value.plan === 'pro') return 0;
  return Math.max(0, subscription.value.monthly_limit - subscription.value.usage_count);
});

const usagePercentage = computed(() => {
  if (!subscription.value || subscription.value.plan === 'pro') return 0;
  return Math.min(100, (subscription.value.usage_count / subscription.value.monthly_limit) * 100);
});

onMounted(async () => {
  try {
    // Fetch subscription info
    const subResponse = await api.get('/subscription');
    subscription.value = subResponse.data;
    
    // Fetch history to count tools used
    const historyResponse = await api.get('/history');
    const uniqueTools = new Set(historyResponse.data.map((item: any) => item.tool_id));
    toolsUsedCount.value = uniqueTools.size;
  } catch (error) {
    console.error('Failed to load dashboard data:', error);
  }
});
</script>
