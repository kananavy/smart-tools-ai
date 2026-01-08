<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 py-12 px-4">
    <div class="max-w-7xl mx-auto">
      <!-- Header -->
      <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-white mb-4">AI-Powered Tools</h1>
        <p class="text-slate-400 text-lg">Choose from our collection of powerful AI tools</p>
      </div>

      <!-- Tools Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <router-link
          v-for="tool in tools"
          :key="tool.id"
          :to="`/dashboard/tools/${tool.slug}`"
          class="group relative bg-slate-800/50 backdrop-blur-xl border border-slate-700/50 rounded-2xl p-6 hover:border-blue-500/50 transition-all duration-300 hover:shadow-xl hover:shadow-blue-500/20 hover:-translate-y-1"
        >
          <!-- Pro Badge -->
          <div v-if="tool.isPro" class="absolute top-4 right-4 px-3 py-1 bg-gradient-to-r from-purple-500 to-pink-500 text-white text-xs font-semibold rounded-full">
            PRO
          </div>

          <!-- Icon -->
          <div class="mb-4 p-4 bg-gradient-to-br from-blue-500/10 to-purple-500/10 rounded-xl w-fit group-hover:from-blue-500/20 group-hover:to-purple-500/20 transition">
            <component :is="getIcon(tool.icon)" class="w-8 h-8 text-blue-400" />
          </div>

          <!-- Content -->
          <h3 class="text-xl font-bold text-white mb-2 group-hover:text-blue-400 transition">
            {{ tool.name }}
          </h3>
          <p class="text-slate-400 text-sm mb-4">{{ tool.description }}</p>

          <!-- Type Badge -->
          <div class="flex items-center justify-between">
            <span class="px-3 py-1 bg-slate-700/50 text-slate-300 text-xs rounded-full capitalize">
              {{ tool.type }}
            </span>
            <svg class="w-5 h-5 text-slate-500 group-hover:text-blue-400 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
          </div>
        </router-link>
      </div>

      <!-- Upgrade CTA for Free Users -->
      <div v-if="subscription?.plan !== 'pro'" class="mt-12 bg-gradient-to-r from-purple-500/10 to-pink-500/10 border border-purple-500/20 rounded-2xl p-8 text-center">
        <h2 class="text-2xl font-bold text-white mb-2">Unlock All Features</h2>
        <p class="text-slate-400 mb-6">Upgrade to Pro for unlimited generations and advanced AI models</p>
        <router-link to="/pricing" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-purple-500/50 transition">
          View Pricing →
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Zap, FileText, Image, Sparkles } from 'lucide-vue-next';
import { getTools } from '../services/api';
import api from '../services/api';

const tools = ref<any[]>([]);
const subscription = ref<any>(null);

const getIcon = (iconName: string) => {
  const icons: any = {
    'zap': Zap,
    'file-text': FileText,
    'image': Image,
    'sparkles': Sparkles,
  };
  return icons[iconName] || Zap;
};

onMounted(async () => {
  try {
    tools.value = await getTools();
    const subResponse = await api.get('/subscription');
    subscription.value = subResponse.data;
  } catch (error) {
    console.error('Failed to load tools:', error);
  }
});
</script>
