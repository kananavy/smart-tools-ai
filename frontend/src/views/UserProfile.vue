<template>
  <div class="min-h-screen bg-[#0a0a0a] text-white flex flex-col items-center">
    <!-- Header/Cover -->
    <div class="w-full h-48 md:h-64 bg-gradient-to-r from-violet-900 via-blue-900 to-violet-900 relative overflow-hidden">
      <!-- Decor -->
      <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(circle_at_50%_50%,rgba(255,255,255,0.1),transparent)] animate-pulse"></div>
      </div>
      
      <div class="max-w-4xl mx-auto h-full relative px-6 flex items-end">
        <button 
          @click="$router.push('/dashboard')" 
          class="absolute top-6 left-6 flex items-center gap-2 px-3 py-2 bg-black/30 hover:bg-black/50 backdrop-blur-md rounded-xl text-sm font-medium transition-all border border-white/5"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          Back to Dashboard
        </button>
      </div>
    </div>

    <!-- Content -->
    <div class="w-full max-w-4xl px-6 -mt-16 md:-mt-20 relative z-10 pb-20">
      <div class="flex flex-col md:flex-row gap-8 items-start">
        
        <!-- Left Column: User Card -->
        <div class="w-full md:w-80 flex-shrink-0">
          <div class="bg-gradient-to-b from-[#1a1a1a] to-[#121212] border border-white/10 rounded-3xl p-6 shadow-2xl relative overflow-hidden group">
            <!-- Glass effect -->
            <div class="absolute inset-0 bg-white/5 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col items-center text-center">
              <!-- Avatar -->
              <div class="w-24 h-24 rounded-3xl bg-gradient-to-br from-violet-500 to-blue-600 flex items-center justify-center text-3xl font-bold text-white shadow-2xl mb-4 transform group-hover:scale-105 transition-transform">
                {{ userInitial }}
                <!-- Pro Badge -->
                <div v-if="isPro" class="absolute -top-2 -right-2 w-8 h-8 bg-black border-2 border-violet-500 rounded-full flex items-center justify-center text-violet-400">
                  <sparkles-icon class="w-4 h-4" />
                </div>
              </div>

              <h2 class="text-2xl font-bold text-white mb-1">{{ userName }}</h2>
              <p class="text-gray-400 text-sm mb-6">{{ userEmail }}</p>

              <div class="w-full pt-6 border-t border-white/5 space-y-4">
                <div class="flex items-center justify-between p-3 bg-white/5 rounded-2xl border border-white/5">
                  <span class="text-xs text-gray-500 font-bold uppercase tracking-wider">Plan</span>
                  <span 
                    class="text-xs font-bold px-3 py-1 rounded-full border"
                    :class="isPro ? 'bg-violet-500/10 text-violet-400 border-violet-500/30' : 'bg-gray-800 text-gray-400 border-gray-700'"
                  >
                    {{ isPro ? 'PRO' : $t('nav.plans.basic').toUpperCase() }}
                  </span>
                </div>
                
                <button 
                  @click="logout"
                  class="w-full py-3 text-sm font-bold text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-2xl transition-all border border-transparent hover:border-red-500/20"
                >
                  Sign Out
                </button>
              </div>
            </div>
          </div>
          
          <!-- Extra Card: Support -->
          <div class="mt-4 p-5 bg-[#1a1a1a] border border-white/10 rounded-3xl">
            <h4 class="text-sm font-bold text-white mb-2">Need help?</h4>
            <p class="text-xs text-gray-500 mb-4 lh-relaxed">Our support team is available 24/7 for Pro members.</p>
            <button class="text-xs font-bold text-blue-400 hover:underline">Contact Support</button>
          </div>
        </div>

        <!-- Right Column: Settings & Usage -->
        <div class="flex-1 w-full space-y-6">
          <!-- Usage Stats Section -->
          <div class="bg-[#1a1a1a] border border-white/10 rounded-3xl p-6 shadow-xl">
            <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
              <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
              Usage Statistics
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
              <div class="p-4 bg-black/20 rounded-2xl border border-white/5">
                <div class="text-sm text-gray-500 mb-1">Monthly Generations</div>
                <div class="flex items-baseline gap-2">
                  <span class="text-2xl font-bold" :class="isPro ? 'text-violet-400' : 'text-white'">
                    {{ isPro ? 'Unlimited' : usageProgress.current }}
                  </span>
                  <span v-if="!isPro" class="text-sm text-gray-600">/ {{ usageProgress.total }}</span>
                </div>
                <div class="w-full h-1.5 bg-gray-800 rounded-full mt-3 overflow-hidden">
                   <div 
                    class="h-full transition-all duration-1000"
                    :class="isPro ? 'bg-gradient-to-r from-violet-500 to-blue-500 w-full animate-pulse' : 'bg-yellow-500'"
                    :style="{ width: isPro ? '100%' : usageProgress.percent + '%' }"
                   ></div>
                </div>
              </div>
              
              <div class="p-4 bg-black/20 rounded-2xl border border-white/5">
                <div class="text-sm text-gray-500 mb-1">Account History</div>
                <div class="text-2xl font-bold text-white">{{ usageCount }}</div>
                <div class="text-xs text-gray-600 mt-1">Total prompts since joining</div>
              </div>
            </div>

            <!-- Detailed Toggles -->
            <div class="space-y-3">
              <div class="flex items-center justify-between p-4 hover:bg-white/5 rounded-2xl transition-colors border border-transparent hover:border-white/5 cursor-pointer group">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 rounded-xl bg-violet-600/10 flex items-center justify-center text-violet-400">
                    <sparkles-icon class="w-5 h-5" />
                  </div>
                  <div>
                    <div class="font-bold text-sm">Advanced AI Analysis</div>
                    <div class="text-xs text-gray-500">Enable deep-reasoning mode by default</div>
                  </div>
                </div>
                <div class="w-10 h-5 bg-violet-600 rounded-full relative">
                  <div class="absolute right-1 top-1 w-3 h-3 bg-white rounded-full"></div>
                </div>
              </div>
            </div>
          </div>

          <!-- Account Security Section -->
          <div class="bg-[#1a1a1a] border border-white/10 rounded-3xl p-6 shadow-xl">
             <h3 class="text-lg font-bold text-white mb-6">Account Settings</h3>
             <div class="space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 border border-white/5 rounded-2xl">
                   <div>
                      <div class="font-bold text-sm">Password</div>
                      <div class="text-xs text-gray-500">Last changed 3 months ago</div>
                   </div>
                   <button class="px-4 py-2 bg-white/5 hover:bg-white/10 rounded-xl text-xs font-bold transition-colors">Change Password</button>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 border border-white/5 rounded-2xl">
                   <div>
                      <div class="font-bold text-sm text-red-500">Delete Account</div>
                      <div class="text-xs text-gray-500">Permanently delete your account and data</div>
                   </div>
                   <button class="px-4 py-2 bg-red-500/10 hover:bg-red-500/20 text-red-500 rounded-xl text-xs font-bold transition-colors">Delete</button>
                </div>
             </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed, onMounted, ref } from 'vue';
import { useAuthStore } from '../stores/auth';
import { useSubscriptionStore } from '../stores/subscription';
import { Sparkles as SparklesIcon, User as UserIcon, LogOut as LogOutIcon } from 'lucide-vue-next';
import { useRouter } from 'vue-router';

const authStore = useAuthStore();
const subscriptionStore = useSubscriptionStore();
const router = useRouter();

const userName = computed(() => authStore.user?.name || 'User');
const userEmail = computed(() => authStore.user?.email || 'email@example.com');
const userInitial = computed(() => userName.value.charAt(0).toUpperCase());

const isPro = computed(() => subscriptionStore.plan === 'pro');
const remaining = computed(() => subscriptionStore.remainingUses);

const usageProgress = computed(() => {
  const current = 40 - (remaining.value ?? 40);
  const total = 40;
  return {
    current,
    total,
    percent: (current / total) * 100
  };
});

// Mock data for demo/source polish
const usageCount = ref(128);

const logout = async () => {
  authStore.logout();
  router.push('/login');
};

onMounted(() => {
  subscriptionStore.fetchSubscription();
});
</script>

<style scoped>
.lh-relaxed {
  line-height: 1.6;
}
</style>
