<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950 py-16 px-4">
    <div class="max-w-6xl mx-auto">
      <!-- Header -->
      <div class="text-center mb-16">
        <h1 class="text-5xl font-bold text-white mb-4">
          Choose Your <span class="bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">Plan</span>
        </h1>
        <p class="text-slate-400 text-lg">Start free, upgrade when you need more power</p>
      </div>

      <!-- Pricing Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
        <!-- Free Plan -->
        <div class="relative bg-slate-800/50 backdrop-blur-xl border border-slate-700/50 rounded-2xl p-8">
          <div class="mb-6">
            <h3 class="text-2xl font-bold text-white mb-2">Free</h3>
            <div class="flex items-baseline mb-4">
              <span class="text-5xl font-bold text-white">$0</span>
              <span class="text-slate-400 ml-2">/month</span>
            </div>
            <p class="text-slate-400">Perfect for trying out SmartTools AI</p>
          </div>

          <ul class="space-y-4 mb-8">
            <li class="flex items-start">
              <svg class="w-5 h-5 text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              <span class="text-slate-300">50 generations per month</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              <span class="text-slate-300">Basic AI model (Llama 3.3 8B)</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              <span class="text-slate-300">All tool types</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 text-green-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              <span class="text-slate-300">Basic history (last 10)</span>
            </li>
            <li class="flex items-start opacity-50">
              <svg class="w-5 h-5 text-slate-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
              <span class="text-slate-500">No exports</span>
            </li>
            <li class="flex items-start opacity-50">
              <svg class="w-5 h-5 text-slate-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
              <span class="text-slate-500">No API access</span>
            </li>
          </ul>

          <button disabled class="w-full py-3 bg-slate-700 text-slate-400 rounded-xl font-semibold cursor-not-allowed">
            Current Plan
          </button>
        </div>

        <!-- Pro Plan -->
        <div class="relative bg-gradient-to-br from-purple-500/10 to-pink-500/10 border-2 border-purple-500/50 rounded-2xl p-8 shadow-xl shadow-purple-500/20">
          <!-- Popular Badge -->
          <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 px-4 py-1 bg-gradient-to-r from-purple-500 to-pink-500 text-white text-sm font-semibold rounded-full">
            Most Popular
          </div>

          <div class="mb-6">
            <h3 class="text-2xl font-bold text-white mb-2">Pro</h3>
            <div class="flex items-baseline mb-4">
              <span class="text-5xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">$9</span>
              <span class="text-slate-400 ml-2">/month</span>
            </div>
            <p class="text-slate-400">For power users and professionals</p>
          </div>

          <ul class="space-y-4 mb-8">
            <li class="flex items-start">
              <svg class="w-5 h-5 text-purple-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              <span class="text-white font-semibold">Unlimited generations</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 text-purple-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              <span class="text-white font-semibold">Advanced AI (Llama 3.3 70B)</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 text-purple-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              <span class="text-white">Export to PDF, DOCX, TXT</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 text-purple-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              <span class="text-white">Full history with search</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 text-purple-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              <span class="text-white">Priority support</span>
            </li>
            <li class="flex items-start">
              <svg class="w-5 h-5 text-purple-400 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              <span class="text-white">API access</span>
            </li>
          </ul>

          <button @click="upgradeToPro" :disabled="upgrading" class="w-full py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-purple-500/50 transition disabled:opacity-50">
            {{ upgrading ? 'Upgrading...' : 'Upgrade to Pro' }}
          </button>
        </div>
      </div>

      <!-- FAQ Section -->
      <div class="mt-20 max-w-3xl mx-auto">
        <h2 class="text-3xl font-bold text-white text-center mb-8">Frequently Asked Questions</h2>
        <div class="space-y-4">
          <details class="group bg-slate-800/50 backdrop-blur-xl border border-slate-700/50 rounded-xl p-6">
            <summary class="text-white font-semibold cursor-pointer list-none flex justify-between items-center">
              Can I cancel anytime?
              <svg class="w-5 h-5 text-slate-400 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </summary>
            <p class="text-slate-400 mt-4">Yes! You can cancel your Pro subscription at any time. You'll continue to have access until the end of your billing period.</p>
          </details>

          <details class="group bg-slate-800/50 backdrop-blur-xl border border-slate-700/50 rounded-xl p-6">
            <summary class="text-white font-semibold cursor-pointer list-none flex justify-between items-center">
              What payment methods do you accept?
              <svg class="w-5 h-5 text-slate-400 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </summary>
            <p class="text-slate-400 mt-4">We accept all major credit cards through Stripe. Your payment information is secure and encrypted.</p>
          </details>

          <details class="group bg-slate-800/50 backdrop-blur-xl border border-slate-700/50 rounded-xl p-6">
            <summary class="text-white font-semibold cursor-pointer list-none flex justify-between items-center">
              Is there a free trial for Pro?
              <svg class="w-5 h-5 text-slate-400 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </summary>
            <p class="text-slate-400 mt-4">The Free plan is perfect for trying out our service. If you need more, you can upgrade to Pro at any time.</p>
          </details>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import api from '../services/api';

const router = useRouter();
const upgrading = ref(false);

const upgradeToPro = async () => {
  upgrading.value = true;
  try {
    await api.post('/subscription/upgrade');
    alert('Successfully upgraded to Pro! 🎉');
    router.push('/dashboard');
  } catch (error) {
    console.error('Upgrade failed:', error);
    alert('Upgrade failed. Please try again.');
  } finally {
    upgrading.value = false;
  }
};
</script>
