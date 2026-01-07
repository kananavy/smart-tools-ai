<template>
  <div class="p-8 max-w-7xl mx-auto">
    <div class="mb-8">
      <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-purple-500 mb-2">
        AI Tools Suite
      </h1>
      <p class="text-slate-400">Select a tool to enhance your workflow.</p>
    </div>

    <div v-if="loading" class="flex justify-center py-12">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
    </div>

    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div
        v-for="tool in tools"
        :key="tool.id"
        @click="navigateToTool(tool)"
        class="group bg-slate-800/50 backdrop-blur rounded-xl p-6 border border-slate-700 hover:border-blue-500/50 hover:bg-slate-800 cursor-pointer transition-all duration-300"
      >
        <div class="h-12 w-12 rounded-lg bg-blue-500/10 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
          <component :is="getIcon(tool.type)" class="w-6 h-6 text-blue-400" />
        </div>
        <h3 class="text-xl font-semibold mb-2 text-slate-100">{{ tool.name }}</h3>
        <p class="text-slate-400 text-sm leading-relaxed">{{ tool.description }}</p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { getTools, type Tool } from '../services/api';
import { FileTextIcon, ImageIcon, Wand2Icon } from 'lucide-vue-next';

const router = useRouter();
const tools = ref<Tool[]>([]);
const loading = ref(true);

onMounted(async () => {
  try {
    tools.value = await getTools();
  } catch (error) {
    console.error('Failed to load tools:', error);
  } finally {
    loading.value = false;
  }
});

const getIcon = (type: string) => {
  switch (type) {
    case 'generator': return Wand2Icon;
    case 'vision': return ImageIcon;
    case 'analyzer': return FileTextIcon;
    default: return FileTextIcon;
  }
};

const navigateToTool = (tool: Tool) => {
  router.push(`/dashboard/tools/${tool.slug}`);
};
</script>
