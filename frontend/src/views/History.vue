<template>
  <div class="p-8 max-w-7xl mx-auto">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-white mb-2">History</h1>
      <p class="text-slate-400">View your past generations.</p>
    </div>

    <div v-if="loading" class="flex justify-center py-12">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
    </div>

    <div v-else-if="history.length === 0" class="text-center py-12 text-slate-500">
      <p>No history found. Start using tools to see them here.</p>
    </div>

    <div v-else class="space-y-4">
      <div v-for="item in history" :key="item.id" class="bg-slate-800/50 border border-slate-700 rounded-lg p-6">
        <div class="flex justify-between items-start mb-4">
          <div>
            <span class="inline-block px-2 py-1 text-xs font-semibold rounded bg-blue-500/10 text-blue-400 mb-2">
              {{ item.tool?.name || 'Unknown Tool' }}
            </span>
            <p class="text-slate-300 font-medium">{{ item.input_preview }}</p>
          </div>
          <span class="text-slate-500 text-sm">{{ new Date(item.created_at).toLocaleDateString() }}</span>
        </div>
        <div class="bg-slate-900/50 p-4 rounded border border-slate-800 text-slate-400 text-sm">
          {{ item.output_preview }}
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import api from '../services/api';

const history = ref<any[]>([]);
const loading = ref(true);

onMounted(async () => {
  try {
    const response = await api.get('/history');
    // Map response to extract useful previews
    history.value = response.data.map((item: any) => {
        let input = '';
        let output = '';
        try {
             const inputData = JSON.parse(item.input_data);
             input = inputData.prompt || 'Input data';
             const outputData = JSON.parse(item.output_data);
             output = outputData.result || 'Output data';
        } catch (e) {
            input = 'Invalid Data';
            output = 'Invalid Data';
        }
        return {
            ...item,
            input_preview: input,
            output_preview: output
        };
    });
  } catch (error) {
    console.error('Failed to load history', error);
  } finally {
    loading.value = false;
  }
});
</script>
