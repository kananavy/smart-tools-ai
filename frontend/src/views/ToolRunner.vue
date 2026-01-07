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

          <!-- File Upload Area (for image analyzer) -->
          <div v-if="toolSlug === 'image-analyzer'" class="mb-4">
            <div 
              @drop.prevent="handleDrop"
              @dragover.prevent
              @dragenter="isDragging = true"
              @dragleave="isDragging = false"
              :class="[
                'border-2 border-dashed rounded-xl p-8 text-center transition',
                isDragging ? 'border-blue-500 bg-blue-500/10' : 'border-slate-600 hover:border-slate-500'
              ]"
            >
              <input
                ref="fileInput"
                type="file"
                accept="image/*"
                @change="handleFileSelect"
                class="hidden"
              />
              
              <div v-if="!uploadedFile">
                <svg class="w-12 h-12 mx-auto text-slate-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                </svg>
                <p class="text-slate-300 mb-2">Drag & drop an image here</p>
                <p class="text-slate-500 text-sm mb-4">or</p>
                <button
                  @click="$refs.fileInput.click()"
                  class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition"
                >
                  Browse Files
                </button>
              </div>

              <div v-else class="relative">
                <img :src="filePreview" alt="Preview" class="max-h-64 mx-auto rounded-lg" />
                <button
                  @click="removeFile"
                  class="absolute top-2 right-2 p-2 bg-red-500 hover:bg-red-600 text-white rounded-full transition"
                >
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
                <p class="text-slate-400 text-sm mt-2">{{ uploadedFile.name }}</p>
              </div>
            </div>
          </div>

          <!-- Text Input -->
          <textarea
            v-model="prompt"
            :placeholder="getPlaceholder()"
            class="w-full h-64 bg-slate-900/50 border border-slate-700 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:border-blue-500 focus:outline-none resize-none"
          ></textarea>

          <!-- Advanced Options -->
          <div v-if="toolSlug === 'text-generator'" class="mt-4 space-y-3">
            <div>
              <label class="block text-slate-400 text-sm mb-2">Tone</label>
              <select v-model="tone" class="w-full bg-slate-900/50 border border-slate-700 rounded-lg px-4 py-2 text-white focus:border-blue-500 focus:outline-none">
                <option value="neutral">Neutral</option>
                <option value="professional">Professional</option>
                <option value="casual">Casual</option>
                <option value="creative">Creative</option>
                <option value="formal">Formal</option>
                <option value="friendly">Friendly</option>
              </select>
            </div>

            <div>
              <label class="block text-slate-400 text-sm mb-2">Length</label>
              <select v-model="length" class="w-full bg-slate-900/50 border border-slate-700 rounded-lg px-4 py-2 text-white focus:border-blue-500 focus:outline-none">
                <option value="short">Short (100-200 words)</option>
                <option value="medium">Medium (200-500 words)</option>
                <option value="long">Long (500+ words)</option>
              </select>
            </div>
          </div>

          <button
            @click="generate"
            :disabled="!canGenerate || loading"
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
              <span class="text-white font-semibold">{{ remaining === -1 ? 'Unlimited ✨' : remaining }}</span>
            </div>
          </div>
        </div>

        <!-- Output Section -->
        <div class="bg-slate-800/50 backdrop-blur-xl border border-slate-700/50 rounded-2xl p-6">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold text-white">Result</h2>
            <div class="flex gap-2">
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

              <!-- Export Button (Pro Feature) -->
              <button
                v-if="result && isPro"
                @click="exportResult"
                class="px-3 py-1.5 bg-gradient-to-r from-purple-500 to-pink-500 hover:shadow-lg hover:shadow-purple-500/50 text-white text-sm rounded-lg transition flex items-center"
              >
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export
              </button>
            </div>
          </div>

          <div v-if="result" class="bg-slate-900/50 border border-slate-700 rounded-xl p-4 min-h-64 max-h-96 overflow-y-auto">
            <p class="text-white whitespace-pre-wrap">{{ result }}</p>
          </div>

          <div v-else-if="error" class="bg-red-500/10 border border-red-500/50 rounded-xl p-4 min-h-64">
            <p class="text-red-400">{{ error }}</p>
            <router-link v-if="error.includes('limit')" to="/dashboard/pricing" class="inline-block mt-4 px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg hover:shadow-lg transition">
              Upgrade to Pro
            </router-link>
          </div>

          <div v-else class="bg-slate-900/50 border border-slate-700 rounded-xl p-4 min-h-64 flex items-center justify-center">
            <div class="text-center">
              <svg class="w-16 h-16 mx-auto text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
              <p class="text-slate-500">Your generated content will appear here</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { useRoute } from 'vue-router';
import { generateContent } from '../services/api';
import api from '../services/api';

const route = useRoute();
const toolSlug = route.params.slug as string;

const prompt = ref('');
const tone = ref('neutral');
const length = ref('medium');
const result = ref('');
const error = ref('');
const loading = ref(false);
const copied = ref(false);
const remaining = ref<number | null>(null);
const isPro = ref(false);

// File upload
const uploadedFile = ref<File | null>(null);
const filePreview = ref('');
const isDragging = ref(false);
const fileInput = ref<HTMLInputElement | null>(null);

const canGenerate = computed(() => {
  if (toolSlug === 'image-analyzer') {
    return uploadedFile.value !== null;
  }
  return prompt.value.trim().length > 0;
});

const getPlaceholder = () => {
  const placeholders: Record<string, string> = {
    'text-generator': 'Enter your prompt here... (e.g., "Write a blog post about AI")',
    'summarizer': 'Paste the text you want to summarize...',
    'image-analyzer': 'Describe what you want to know about the image...',
  };
  return placeholders[toolSlug] || 'Enter your text here...';
};

const handleFileSelect = (event: Event) => {
  const target = event.target as HTMLInputElement;
  if (target.files && target.files[0]) {
    const file = target.files[0];
    uploadedFile.value = file;
    
    const reader = new FileReader();
    reader.onload = (e) => {
      filePreview.value = e.target?.result as string;
    };
    reader.readAsDataURL(file);
  }
};

const handleDrop = (event: DragEvent) => {
  isDragging.value = false;
  if (event.dataTransfer?.files && event.dataTransfer.files[0]) {
    const file = event.dataTransfer.files[0];
    if (file.type.startsWith('image/')) {
      uploadedFile.value = file;
      
      const reader = new FileReader();
      reader.onload = (e) => {
        filePreview.value = e.target?.result as string;
      };
      reader.readAsDataURL(file);
    }
  }
};

const removeFile = () => {
  uploadedFile.value = null;
  filePreview.value = '';
  if (fileInput.value) {
    fileInput.value.value = '';
  }
};

const generate = async () => {
  if (!canGenerate.value) return;

  loading.value = true;
  error.value = '';
  result.value = '';

  try {
    const data = await generateContent(toolSlug, {
      prompt: prompt.value,
      tone: tone.value,
      length: length.value,
      image: filePreview.value, // Base64 image if uploaded
    });
    result.value = data.result;
    remaining.value = data.remaining;
  } catch (err: any) {
    if (err.response?.status === 429) {
      error.value = err.response.data.message || 'Usage limit reached. Please upgrade to Pro for unlimited access.';
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

const exportResult = () => {
  // Create a blob and download
  const blob = new Blob([result.value], { type: 'text/plain' });
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = `smarttools-${toolSlug}-${Date.now()}.txt`;
  document.body.appendChild(a);
  a.click();
  document.body.removeChild(a);
  URL.revokeObjectURL(url);
};

// Check if user is Pro
const checkSubscription = async () => {
  try {
    const response = await api.get('/subscription');
    isPro.value = response.data.plan === 'pro';
  } catch (error) {
    console.error('Failed to check subscription:', error);
  }
};

checkSubscription();
</script>
