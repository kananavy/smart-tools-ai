<template>
  <div class="min-h-screen bg-gradient-to-br from-[#0a0a0a] via-[#121212] to-[#0a0a0a] text-white">
    <!-- Header -->
    <div class="container mx-auto px-4 py-8 max-w-6xl">
      <div class="mb-8">
        <button
          @click="router.back()"
          class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition-colors mb-8"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          <span>Back to Dashboard</span>
        </button>
        
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Upgrade to SmartTools Pro</h1>
        <p class="text-xl text-gray-400">Unlock unlimited AI power, priority processing, and advanced features</p>
      </div>

      <!-- Plans Grid -->
      <div class="grid md:grid-cols-3 gap-6 mb-12">
        <!-- Free Plan -->
        <div class="bg-[#1a1a1a] border border-white/10 rounded-2xl p-6">
          <div class="mb-6">
            <h3 class="text-2xl font-bold text-white mb-2">Free</h3>
            <div class="flex items-baseline gap-1 mb-3">
              <span class="text-4xl font-bold text-white">$0</span>
              <span class="text-gray-500">/forever</span>
            </div>
            <p class="text-gray-400 text-sm">See what AI can do</p>
            
            <!-- Current Plan Badge -->
            <div v-if="currentPlan === 'free'" class="mt-4 px-4 py-2 bg-gray-800 text-gray-300 rounded-lg inline-block">
              Your current plan
            </div>
          </div>

          <div class="space-y-3 mb-8">
            <div v-for="(feature, idx) in freeFeatures" :key="idx" class="flex items-start gap-3">
              <div class="mt-0.5">
                <component 
                  :is="feature.included ? CheckIcon : XIcon" 
                  class="w-5 h-5" 
                  :class="feature.included ? 'text-green-500' : 'text-gray-600'" 
                />
              </div>
              <span :class="feature.included ? 'text-gray-300' : 'text-gray-600'">{{ feature.text }}</span>
            </div>
          </div>

          <button
            @click="selectPlan('free')"
            :class="[
              'w-full py-3 rounded-lg font-medium transition-all',
              currentPlan === 'free'
                ? 'bg-gray-800 text-gray-400 cursor-not-allowed'
                : 'bg-white/10 text-white hover:bg-white/20'
            ]"
          >
            {{ currentPlan === 'free' ? 'Current Plan' : 'Continue with Free' }}
          </button>
        </div>

        <!-- Pro Plan -->
        <div class="relative bg-gradient-to-b from-violet-900/20 to-transparent border-2 border-violet-500 rounded-2xl p-6">
          <!-- Popular Badge -->
          <div class="absolute -top-3 left-1/2 -translate-x-1/2">
            <div class="px-4 py-1 bg-gradient-to-r from-violet-600 to-blue-600 text-white text-xs font-bold rounded-full">
              Most Popular
            </div>
          </div>

          <div class="mb-6">
            <h3 class="text-2xl font-bold text-white mb-2">Pro</h3>
            <div class="flex items-baseline gap-1 mb-3">
              <span class="text-4xl font-bold text-white">$9</span>
              <span class="text-gray-500">/month</span>
            </div>
            <p class="text-gray-400 text-sm">Do more with smarter AI</p>
            
            <!-- Current Plan Badge -->
            <div v-if="currentPlan === 'pro'" class="mt-4 px-4 py-2 bg-gray-800 text-gray-300 rounded-lg inline-block">
              Your current plan
            </div>
          </div>

          <div class="space-y-3 mb-8">
            <div v-for="(feature, idx) in proFeatures" :key="idx" class="flex items-start gap-3">
              <div class="mt-0.5">
                <CheckIcon class="w-5 h-5 text-green-500" />
              </div>
              <span class="text-gray-300">{{ feature }}</span>
            </div>
          </div>

          <button
            @click="selectPlan('pro')"
            :class="[
              'w-full py-3 rounded-lg font-medium transition-all',
              currentPlan === 'pro'
                ? 'bg-gray-800 text-gray-400 cursor-not-allowed'
                : 'bg-gradient-to-r from-violet-600 to-blue-600 text-white hover:from-violet-700 hover:to-blue-700'
            ]"
          >
            {{ currentPlan === 'pro' ? 'Current Plan' : 'Upgrade to Pro' }}
          </button>
          
          <!-- Trial Notice -->
          <div v-if="currentPlan !== 'pro'"   class="mt-4 text-center">
            <p class="text-sm text-gray-500">7-day free trial included</p>
          </div>
        </div>

        <!-- Business Plan -->
        <div class="bg-[#1a1a1a] border border-white/10 rounded-2xl p-6">
          <div class="mb-6">
            <h3 class="text-2xl font-bold text-amber-400 mb-2">Business</h3>
            <div class="flex items-baseline gap-1 mb-3">
              <span class="text-4xl font-bold text-white">$29</span>
              <span class="text-gray-500">/month</span>
            </div>
            <p class="text-gray-400 text-sm">For teams and enterprises</p>
          </div>

          <div class="space-y-3 mb-8">
            <div v-for="(feature, idx) in businessFeatures" :key="idx" class="flex items-start gap-3">
              <div class="mt-0.5">
                <CheckIcon class="w-5 h-5 text-amber-500" />
              </div>
              <span class="text-gray-300">{{ feature }}</span>
            </div>
          </div>

          <button
            @click="selectPlan('business')"
            class="w-full py-3 bg-gradient-to-r from-amber-600 to-orange-600 text-white rounded-lg font-medium hover:from-amber-700 hover:to-orange-700 transition-all"
          >
            Contact Sales
          </button>
        </div>
      </div>

      <!-- FAQ Section -->
      <div class="mb-12">
        <h3 class="text-2xl font-bold text-white mb-6">Frequently Asked Questions</h3>
        <div class="space-y-4">
          <div 
            v-for="(faq, index) in faqs" 
            :key="index"
            class="bg-white/5 border border-white/10 rounded-xl overflow-hidden"
          >
            <button
              @click="toggleFaq(index)"
              class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-white/5 transition-colors"
            >
              <span class="font-medium text-white">{{ faq.question }}</span>
              <svg 
                class="w-5 h-5 text-gray-400 transition-transform duration-300"
                :class="{ 'rotate-180': openFaqs.includes(index) }"
                fill="none" stroke="currentColor" viewBox="0 0 24 24"
              >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div 
              v-if="openFaqs.includes(index)"
              class="px-6 pb-4 pt-2 border-t border-white/5"
            >
              <p class="text-gray-400">{{ faq.answer }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Security Section -->
      <div class="grid md:grid-cols-3 gap-4 mb-12">
        <div class="flex items-center gap-3 p-4 bg-white/5 rounded-xl">
          <ShieldIcon class="w-6 h-6 text-blue-400" />
          <div>
            <p class="text-white font-medium">Secure Payment</p>
            <p class="text-gray-500 text-sm">256-bit encryption</p>
          </div>
        </div>
        <div class="flex items-center gap-3 p-4 bg-white/5 rounded-xl">
          <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
          </svg>
          <div>
            <p class="text-white font-medium">30-Day Guarantee</p>
            <p class="text-gray-500 text-sm">Full refund if unsatisfied</p>
          </div>
        </div>
        <div class="flex items-center gap-3 p-4 bg-white/5 rounded-xl">
          <CreditCardIcon class="w-6 h-6 text-purple-400" />
          <div>
            <p class="text-white font-medium">Cancel Anytime</p>
            <p class="text-gray-500 text-sm">No hidden fees</p>
          </div>
        </div>
      </div>

      <!-- CTA -->
      <div class="text-center p-8 bg-gradient-to-r from-violet-900/20 to-blue-900/20 border border-white/10 rounded-2xl">
        <h3 class="text-2xl font-bold text-white mb-4">Ready to unlock unlimited AI power?</h3>
        <p class="text-gray-400 mb-6 max-w-2xl mx-auto">
          Join thousands of professionals using SmartTools Pro
        </p>
        <button
          @click="selectPlan('pro')"
          class="px-8 py-3 bg-gradient-to-r from-violet-600 to-blue-600 text-white font-medium rounded-lg hover:from-violet-700 hover:to-blue-700 transition-all"
        >
          Start 7-Day Free Trial
        </button>
        <p class="text-gray-500 text-sm mt-4">No credit card required</p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { 
  X as XIcon, 
  Check as CheckIcon, 
  Shield as ShieldIcon, 
  CreditCard as CreditCardIcon
} from 'lucide-vue-next';
import api from '../services/api';

const router = useRouter();
const currentPlan = ref<'free' | 'pro' | 'business'>('free');
const openFaqs = ref<number[]>([0, 1]);

// Features
const freeFeatures = [
  { text: '5 AI generations per day', included: true },
  { text: 'Basic AI models', included: true },
  { text: 'Standard response time', included: true },
  { text: 'Community support', included: true },
  { text: '7-day chat history', included: true },
  { text: 'Export to PDF/DOCX/TXT', included: false },
  { text: 'Priority processing', included: false },
  { text: 'API access', included: false },
];

const proFeatures = [
  'Unlimited AI generations',
  'Advanced AI (Llama 3.3 70B)',
  'Priority processing',
  'Export to PDF/DOCX/TXT',
  'Full history with search',
  'API access included',
  'Priority email support',
  'Early access to new features'
];

const businessFeatures = [
  'Everything in Pro, plus:',
  'Team collaboration',
  'Custom AI model training',
  'SLA guarantee',
  'Dedicated support',
  'Custom integrations',
  'Usage analytics dashboard',
  'SSO & advanced security'
];

const faqs = [
  {
    question: "How does the free trial work?",
    answer: "Try all Pro features for 7 days without payment. Cancel anytime before the trial ends to avoid charges."
  },
  {
    question: "Can I switch plans anytime?",
    answer: "Yes, upgrade anytime. Downgrades apply at the end of your billing cycle."
  },
  {
    question: "What payment methods do you accept?",
    answer: "All major credit cards via Stripe. Apple Pay and Google Pay also supported."
  },
  {
    question: "Is there an annual discount?",
    answer: "Annual billing saves 16.7% ($90/year instead of $108)."
  },
  {
    question: "How do I cancel?",
    answer: "Cancel anytime from account settings. Features remain until billing period ends."
  }
];

// Methods
const toggleFaq = (index: number) => {
  if (openFaqs.value.includes(index)) {
    openFaqs.value = openFaqs.value.filter(i => i !== index);
  } else {
    openFaqs.value.push(index);
  }
};

const selectPlan = async (plan: 'free' | 'pro' | 'business') => {
  if (plan === currentPlan.value) return;
  
  if (plan === 'pro') {
    router.push('/upgrade-payment');
  } else if (plan === 'business') {
    window.location.href = 'mailto:sales@smarttools.ai';
  } else if (plan === 'free') {
    if (confirm('Switch to Free plan? Your Pro features will be disabled.')) {
      try {
        await api.post('/subscription/downgrade');
        currentPlan.value = 'free';
        alert('Successfully switched to Free plan.');
      } catch (error) {
        alert('Failed to switch plans. Please try again.');
      }
    }
  }
};

// Load current plan
onMounted(async () => {
  try {
    const response = await api.get('/user/plan');
    currentPlan.value = response.data.plan;
  } catch (error) {
    console.error('Failed to fetch plan info:', error);
  }
});
</script>

<style scoped>
.container {
  max-width: 1200px;
}
</style>