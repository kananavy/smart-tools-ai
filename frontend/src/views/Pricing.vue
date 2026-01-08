<template>
  <div class="min-h-screen bg-[#0a0a0a] flex items-center justify-center p-4 sm:p-6 lg:p-8">
    <!-- Background Accents -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
      <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-violet-600/10 rounded-full blur-[120px]"></div>
      <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-blue-600/10 rounded-full blur-[120px]"></div>
    </div>

    <div class="max-w-4xl w-full relative z-10">
      <div class="text-center mb-10">
        <h1 class="text-4xl font-bold text-white mb-3 tracking-tight">
          Upgrade to <span class="bg-gradient-to-r from-violet-400 to-blue-400 bg-clip-text text-transparent">SmartTools Pro</span>
        </h1>
        <p class="text-gray-400 text-lg">Unlock the full power of advanced AI models and unlimited usage.</p>
      </div>

      <div class="grid md:grid-cols-2 bg-[#171717] rounded-[32px] overflow-hidden border border-white/5 shadow-2xl">
        <!-- Plan Details -->
        <div class="p-8 md:p-12 bg-gradient-to-br from-violet-600/5 to-transparent">
          <div class="mb-8">
            <div class="inline-flex items-center px-3 py-1 bg-violet-500/10 border border-violet-500/20 rounded-full text-[10px] font-bold text-violet-400 uppercase tracking-widest mb-4">
              Premium Plan
            </div>
            <div class="flex items-baseline gap-1">
              <span class="text-6xl font-extrabold text-white tracking-tighter">$9</span>
              <span class="text-gray-500 text-xl font-medium">/month</span>
            </div>
          </div>

          <ul class="space-y-5">
            <li v-for="feature in features" :key="feature" class="flex items-start gap-3">
              <div class="mt-1 w-5 h-5 rounded-full bg-violet-500/20 flex items-center justify-center flex-shrink-0">
                <svg class="w-3.5 h-3.5 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
              </div>
              <span class="text-gray-300 font-medium">{{ feature }}</span>
            </li>
          </ul>

          <div class="mt-12 pt-8 border-t border-white/5">
            <div class="flex items-center gap-4">
              <div class="w-12 h-12 bg-white/5 rounded-2xl flex items-center justify-center">
                 <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
              </div>
              <div>
                <div class="text-sm font-semibold text-white">Secure Checkout</div>
                <div class="text-xs text-gray-500">Encrypted payments via Stripe</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Payment Card Interface -->
        <div class="p-8 md:p-12 bg-[#1a1a1a] border-l border-white/5">
          <div class="space-y-6">
            <div class="space-y-2">
              <label class="text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Card Information</label>
              <div class="space-y-[-1px]">
                <div class="bg-black/20 border border-white/10 rounded-t-xl p-4 flex items-center transition-all focus-within:border-violet-500/50 focus-within:z-10">
                  <input type="text" placeholder="Card number" class="bg-transparent border-0 focus:ring-0 w-full text-white placeholder-gray-600" />
                  <div class="flex gap-2">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" class="h-4 opacity-50" />
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" class="h-4 opacity-50" />
                  </div>
                </div>
                <div class="grid grid-cols-2 gap-[-1px]">
                  <div class="bg-black/20 border border-white/10 rounded-bl-xl p-4 transition-all focus-within:border-violet-500/50 focus-within:z-10">
                    <input type="text" placeholder="MM / YY" class="bg-transparent border-0 focus:ring-0 w-full text-white placeholder-gray-600" />
                  </div>
                  <div class="bg-black/20 border border-white/10 rounded-br-xl p-4 transition-all focus-within:border-violet-500/50 focus-within:z-10">
                    <input type="text" placeholder="CVC" class="bg-transparent border-0 focus:ring-0 w-full text-white placeholder-gray-600" />
                  </div>
                </div>
              </div>
            </div>

            <div class="space-y-2 pt-2">
              <label class="text-xs font-bold text-gray-500 uppercase tracking-widest pl-1">Billing Location</label>
              <div class="bg-black/20 border border-white/10 rounded-xl p-4">
                <select class="bg-transparent border-0 focus:ring-0 w-full text-white appearance-none cursor-pointer">
                  <option>United States</option>
                  <option>France</option>
                  <option>United Kingdom</option>
                </select>
              </div>
            </div>

            <div class="pt-6">
              <button 
                @click="upgradeToPro" 
                :disabled="upgrading"
                class="w-full py-4 bg-gradient-to-r from-violet-600 to-blue-600 text-white font-bold rounded-2xl shadow-xl shadow-violet-500/20 hover:shadow-violet-500/40 transform active:scale-[0.98] transition-all disabled:opacity-50 disabled:scale-100"
              >
                <div class="flex items-center justify-center gap-2">
                  <span v-if="upgrading">Processing...</span>
                  <span v-else>Pay $9.00 & Upgrade</span>
                  <svg v-if="!upgrading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                </div>
              </button>
              <p class="text-center text-[11px] text-gray-600 mt-4 leading-relaxed">
                By clicking "Pay", you agree to our Terms of Service. You will be charged $9.00 monthly until you cancel.
              </p>
            </div>
          </div>
        </div>
      </div>

      <div class="text-center mt-12">
        <button @click="router.back()" class="text-gray-500 hover:text-white transition-colors text-sm font-medium">
          ← Cancel and go back
        </button>
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

const features = [
  'Unlimited generations',
  'Advanced AI (Llama 3.3 70B)',
  'Export to PDF, DOCX, TXT',
  'Full history with search',
  'Priority support',
  'API access'
];

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
