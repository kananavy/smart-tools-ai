<template>
  <div class="h-full flex flex-col p-6 max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
      <div class="flex items-center space-x-4">
        <button @click="router.back()" class="p-2 hover:bg-slate-800 rounded-lg transition text-slate-400 hover:text-white">
          <ArrowLeftIcon class="w-5 h-5" />
        </button>
        <div>
          <h1 class="text-2xl font-bold text-white mb-1">{{ toolName }}</h1>
          <p class="text-slate-400 text-sm">Fill in the details below to generate content.</p>
        </div>
      </div>
    </div>

    <div class="flex-1 grid grid-cols-1 lg:grid-cols-2 gap-8 min-h-0">
      <!-- Input Section -->
      <div class="flex flex-col bg-slate-800/50 backdrop-blur border border-slate-700 rounded-xl overflow-hidden">
        <div class="p-4 border-b border-slate-700 bg-slate-800/80">
          <h2 class="font-medium text-slate-200">Input</h2>
        </div>
        <div class="p-6 flex-1 flex flex-col">
          <label class="block text-sm font-medium text-slate-400 mb-2">Prompt</label>
          <textarea
            v-model="prompt"
            class="flex-1 w-full bg-slate-900/50 border border-slate-700 rounded-lg p-4 text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition resize-none mb-4"
            placeholder="Enter your prompt here..."
          ></textarea>
          
          <div v-if="error" class="mb-4 p-3 bg-red-500/10 border border-red-500/20 text-red-400 rounded-lg text-sm">
            {{ error }}
          </div>

          <button
            @click="handleGenerate"
            :disabled="loading || !prompt"
            class="w-full py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-500 hover:to-purple-500 text-white font-medium rounded-lg transition-all shadow-lg hover:shadow-blue-500/20 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center"
          >
            <Loader2Icon v-if="loading" class="w-5 h-5 mr-2 animate-spin" />
            <span v-else>Generate Content</span>
            <SparklesIcon v-if="!loading" class="w-5 h-5 ml-2" />
          </button>
        </div>
      </div>

      <!-- Output Section -->
      <div class="flex flex-col bg-slate-800/50 backdrop-blur border border-slate-700 rounded-xl overflow-hidden">
        <div class="p-4 border-b border-slate-700 bg-slate-800/80 flex justify-between items-center">
          <h2 class="font-medium text-slate-200">Result</h2>
          <button
             v-if="result"
             @click="copyToClipboard"
             class="text-xs flex items-center text-slate-400 hover:text-white transition"
          >
            <CopyIcon class="w-4 h-4 mr-1" />
            {{ copied ? 'Copied!' : 'Copy' }}
          </button>
        </div>
        <div class="flex-1 p-6 overflow-y-auto bg-slate-900/30">
          <div v-if="loading" class="h-full flex flex-col items-center justify-center text-slate-500 animate-pulse">
            <BotIcon class="w-12 h-12 mb-4 opacity-50" />
            <p>Processing your request...</p>
          </div>
          
          <div v-else-if="result" class="prose prose-invert max-w-none">
            {{ result }}
          </div>
          
          <div v-else class="h-full flex flex-col items-center justify-center text-slate-600">
            <CommandIcon class="w-12 h-12 mb-4 opacity-20" />
            <p>Output will appear here</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { generateContent, getTools, type Tool } from '../services/api';
import { 
  ArrowLeftIcon, 
  SparklesIcon, 
  Loader2Icon, 
  CopyIcon,
  BotIcon,
  CommandIcon
} from 'lucide-vue-next';

const route = useRoute();
const router = useRouter();

const prompt = ref('');
const result = ref('');
const loading = ref(false);
const error = ref('');
const copied = ref(false);

const toolSlug = computed(() => route.params.slug as string);
const toolName = computed(() => {
  // Simple formatting for demo, optimally fetched from tool details
  return toolSlug.value.split('-').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
});

const handleGenerate = async () => {
  if (!prompt.value) return;
  
  loading.value = true;
  error.value = '';
  result.value = '';
  
  try {
    const response = await generateContent(toolSlug.value, { prompt: prompt.value });
    result.value = response.result;
  } catch (err) {
    console.error(err);
    error.value = 'Failed to generate content. Please try again.';
  } finally {
    loading.value = false;
  }
};

const copyToClipboard = async () => {
  if (result.value) {
    await navigator.clipboard.writeText(result.value);
    copied.value = true;
    setTimeout(() => copied.value = false, 2000);
  }
};
</script>
