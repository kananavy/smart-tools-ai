<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 py-8 px-4">
    <div class="max-w-6xl mx-auto">
      <!-- Back Button -->
      <button @click="$router.back()" class="mb-6 flex items-center text-slate-400 hover:text-white transition">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Back to Tools
      </button>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Input Section -->
        <div class="bg-slate-800/50 backdrop-blur-xl border border-slate-700/50 rounded-2xl p-6">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold text-white">Input</h2>
            <span v-if="prompt" class="text-sm text-slate-400">{{ prompt.length }} characters</span>
          </div>

          <textarea
            v-model="prompt"
            placeholder="Enter your text here..."
            class="w-full h-64 bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:border-blue-500 focus:outline-none resize-none"
          ></textarea>

          <!-- Advanced Options -->
          <div v-if="toolSlug === 'text-generator'" class="mt-4">
            <label class="block text-slate-400 text-sm mb-2">Tone</label>
            <select v-model="tone" class="w-full bg-slate-900/50 border border-slate-700 rounded-lg px-4 py-2 text-white focus:border-blue-500 focus:outline-none">
              <option value="neutral">Neutral</option>
              <option value="professional">Professional</option>
              <option value="casual">Casual</option>
              <option value="creative">Creative</option>
              <option value="formal">Formal</option>
            </select>
          </div>

          <button
            @click="generate"
            :disabled="!prompt || loading"
            class="w-full mt-4 py-3 bg-gradient-to-r from-blue-500 to-purple-500 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-blue-500/50 transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center"
          >
            <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            {{ loading ? 'Generating...' : 'Generate Content' }}
          </button>

          <!-- Usage Info -->
          <div v-if="remaining !== null" class="mt-4 p-3 bg-slate-900/50 rounded-lg">
            <div class="flex items-center justify-between text-sm">
              <span class="text-slate-400">Remaining this month:</span>
              <span class="text-white font-semibold">{{ remaining === -1 ? 'Unlimited' : remaining }}</span>
            </div>
          </div>
        </div>

        <!-- Output Section -->
        <div class="bg-slate-800/50 backdrop-blur-xl border border-slate-700/50 rounded-2xl p-6">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold text-white">Result</h2>
            <button
              v-if="result"
              @click="copyToClipboard"
              class="px-3 py-1.5 bg-slate-700 hover:bg-slate-600 text-white text-sm rounded-lg transition flex items-center"
            >
              <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
              </svg>
              {{ copied ? 'Copied!' : 'Copy' }}
            </button>
          </div>

          <div v-if="result" class="bg-slate-900/50 border border-slate-700 rounded-xl p-4 min-h-64 max-h-96 overflow-y-auto">
            <p class="text-white whitespace-pre-wrap">{{ result }}</p>
          </div>

          <div v-else-if="error" class="bg-red-500/10 border border-red-500/50 rounded-xl p-4 min-h-64">
            <p class="text-red-400">{{ error }}</p>
          </div>

          <div v-else class="bg-slate-900/50 border border-slate-700 rounded-xl p-4 min-h-64 flex items-center justify-center">
            <p class="text-slate-500 text-center">Your generated content will appear here</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRoute } from 'vue-router';
import { generateContent } from '../services/api';

const route = useRoute();
const toolSlug = route.params.slug as string;

const prompt = ref('');
const tone = ref('neutral');
const result = ref('');
const error = ref('');
const loading = ref(false);
const copied = ref(false);
const remaining = ref<number | null>(null);

const generate = async () => {
  if (!prompt.value) return;

  loading.value = true;
  error.value = '';
  result.value = '';

  try {
    const data = await generateContent(toolSlug, {
      prompt: prompt.value,
      tone: tone.value,
    });
    result.value = data.result;
    remaining.value = data.remaining;
  } catch (err: any) {
    if (err.response?.status === 429) {
      error.value = err.response.data.message || 'Usage limit reached. Please upgrade to Pro.';
    } else {
      error.value = 'Failed to generate content. Please try again.';
    }
  } finally {
    loading.value = false;
  }
};

const copyToClipboard = async () => {
  try {
    await navigator.clipboard.writeText(result.value);
    copied.value = true;
    setTimeout(() => {
      copied.value = false;
    }, 2000);
  } catch (err) {
    console.error('Failed to copy:', err);
  }
};
</script>
