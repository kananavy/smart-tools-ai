<template>
  <div class="min-h-screen bg-gradient-to-br from-[#0a0a0a] via-[#121212] to-[#0a0a0a] text-white">
    <!-- Background Effects -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
      <div class="absolute top-1/4 left-1/4 w-[40%] h-[40%] bg-violet-600/10 rounded-full blur-[120px]"></div>
      <div class="absolute bottom-1/4 right-1/4 w-[40%] h-[40%] bg-blue-600/10 rounded-full blur-[120px]"></div>
    </div>

    <div class="relative z-10 min-h-screen flex flex-col items-center justify-center p-4 md:p-6">
      <!-- Header with Back Button -->
      <div class="w-full max-w-5xl mb-8">
        <button
          @click="router.back()"
          class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition-colors group"
        >
          <div class="p-2 rounded-lg bg-white/5 group-hover:bg-white/10 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
          </div>
          <span>Back to Plans</span>
        </button>
      </div>

      <!-- Main Content -->
      <div class="w-full max-w-5xl">
        <!-- Header -->
        <div class="text-center mb-10">
          <h1 class="text-3xl md:text-4xl font-bold mb-3">
            Complete Your <span class="bg-gradient-to-r from-violet-400 to-blue-400 bg-clip-text text-transparent">Pro</span> Upgrade
          </h1>
          <p class="text-lg text-gray-400">Almost there! Just a few details to unlock unlimited AI power</p>
        </div>

        <!-- Payment Container -->
        <div class="grid md:grid-cols-2 gap-8 mb-10">
          <!-- Order Summary -->
          <div class="bg-gradient-to-br from-violet-900/10 to-blue-900/10 border border-white/10 rounded-2xl p-6">
            <div class="mb-6">
              <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-gradient-to-r from-violet-600 to-blue-600 rounded-xl flex items-center justify-center">
                  <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                  </svg>
                </div>
                <h2 class="text-xl font-bold text-white">Order Summary</h2>
              </div>
              
              <!-- Selected Plan -->
              <div class="bg-white/5 border border-white/10 rounded-xl p-5 mb-5">
                <div class="flex items-start justify-between mb-4">
                  <div>
                    <h3 class="text-lg font-bold text-white mb-1">SmartTools Pro</h3>
                    <p class="text-gray-400 text-sm">Monthly subscription</p>
                  </div>
                  <div class="text-right">
                    <div class="text-2xl font-bold text-white">$9</div>
                    <div class="text-gray-500 text-sm">per month</div>
                  </div>
                </div>
                
                <div class="space-y-2">
                  <div v-for="feature in features" :key="feature" class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="text-gray-300 text-sm">{{ feature }}</span>
                  </div>
                </div>
              </div>
              
              <!-- Pricing Breakdown -->
              <div class="space-y-3">
                <div class="flex items-center justify-between">
                  <span class="text-gray-400">Pro Plan (Monthly)</span>
                  <span class="text-white font-semibold">$9.00</span>
                </div>
                <div class="flex items-center justify-between">
                  <span class="text-gray-400">Tax</span>
                  <span class="text-white font-semibold">$0.00</span>
                </div>
                <div class="pt-3 border-t border-white/10 flex items-center justify-between">
                  <div>
                    <span class="text-white font-bold">Total Due Today</span>
                    <p class="text-gray-500 text-sm">First payment, then monthly</p>
                  </div>
                  <div class="text-right">
                    <span class="text-2xl font-bold text-white">$9.00</span>
                    <p class="text-gray-500 text-sm">USD</p>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Security Badges -->
            <div class="space-y-3">
              <div class="flex items-center gap-2 p-3 bg-white/5 rounded-lg">
                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <div>
                  <p class="text-white font-medium">Secure Payment</p>
                  <p class="text-gray-500 text-sm">256-bit SSL encryption</p>
                </div>
              </div>
              <div class="flex items-center gap-2 p-3 bg-white/5 rounded-lg">
                <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <div>
                  <p class="text-white font-medium">30-Day Guarantee</p>
                  <p class="text-gray-500 text-sm">Full refund if unsatisfied</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Payment Form -->
          <div class="space-y-6">
            <!-- Card Information -->
            <div class="bg-gradient-to-br from-[#151515] to-[#0a0a0a] border border-white/10 rounded-2xl p-6">
              <h2 class="text-xl font-bold text-white mb-4">Payment Details</h2>
              
              <div class="space-y-4">
                <!-- Card Number -->
                <div class="space-y-1">
                  <label class="text-sm font-medium text-gray-300">Card Number</label>
                  <div class="relative">
                    <input
                      v-model="cardNumber"
                      @input="formatCardNumber"
                      type="text"
                      placeholder="1234 5678 9012 3456"
                      maxlength="19"
                      :class="[
                        'w-full bg-black/20 border rounded-lg p-3 text-white placeholder-gray-500 transition-all',
                        cardError ? 'border-red-500' : 'border-white/10 focus:border-violet-500'
                      ]"
                    />
                    <div class="absolute right-2 top-1/2 -translate-y-1/2 flex gap-1">
                      <div class="w-7 h-5 bg-blue-600 rounded flex items-center justify-center text-[8px] font-bold text-white">
                        VISA
                      </div>
                      <div class="w-7 h-5 bg-red-600 rounded flex items-center justify-center">
                        <div class="flex gap-0.5">
                          <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
                          <div class="w-1.5 h-1.5 bg-orange-400 rounded-full -ml-1"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <p v-if="cardError" class="text-red-500 text-sm">{{ cardError }}</p>
                </div>

                <!-- Expiry and CVC -->
                <div class="grid grid-cols-2 gap-3">
                  <div class="space-y-1">
                    <label class="text-sm font-medium text-gray-300">Expiry Date</label>
                    <input
                      v-model="expiry"
                      @input="formatExpiry"
                      type="text"
                      placeholder="MM/YY"
                      maxlength="5"
                      :class="[
                        'w-full bg-black/20 border rounded-lg p-3 text-white placeholder-gray-500 transition-all',
                        expiryError ? 'border-red-500' : 'border-white/10 focus:border-violet-500'
                      ]"
                    />
                    <p v-if="expiryError" class="text-red-500 text-sm">{{ expiryError }}</p>
                  </div>
                  <div class="space-y-1">
                    <label class="text-sm font-medium text-gray-300">CVC</label>
                    <div class="relative">
                      <input
                        v-model="cvc"
                        type="password"
                        placeholder="123"
                        maxlength="4"
                        :class="[
                          'w-full bg-black/20 border rounded-lg p-3 text-white placeholder-gray-500 transition-all',
                          cvcError ? 'border-red-500' : 'border-white/10 focus:border-violet-500'
                        ]"
                      />
                      <div class="absolute right-2 top-1/2 -translate-y-1/2">
                        <svg 
                          class="w-4 h-4 text-gray-500 cursor-help" 
                          fill="none" 
                          stroke="currentColor" 
                          viewBox="0 0 24 24"
                          @mouseenter="showCvcTooltip = true"
                          @mouseleave="showCvcTooltip = false"
                        >
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div 
                          v-if="showCvcTooltip"
                          class="absolute top-full right-0 mt-1 w-40 p-2 bg-[#1a1a1a] border border-white/10 rounded-lg shadow-lg z-10"
                        >
                          <p class="text-xs text-gray-300">3-digit security code on the back of your card</p>
                        </div>
                      </div>
                    </div>
                    <p v-if="cvcError" class="text-red-500 text-sm">{{ cvcError }}</p>
                  </div>
                </div>

                <!-- Cardholder Name -->
                <div class="space-y-1">
                  <label class="text-sm font-medium text-gray-300">Cardholder Name</label>
                  <input
                    v-model="cardholderName"
                    type="text"
                    placeholder="John Doe"
                    :class="[
                      'w-full bg-black/20 border rounded-lg p-3 text-white placeholder-gray-500 transition-all',
                      nameError ? 'border-red-500' : 'border-white/10 focus:border-violet-500'
                    ]"
                  />
                  <p v-if="nameError" class="text-red-500 text-sm">{{ nameError }}</p>
                </div>

                <!-- Country -->
                <div class="space-y-1">
                  <label class="text-sm font-medium text-gray-300">Country</label>
                  <select
                    v-model="country"
                    class="w-full bg-black/20 border border-white/10 rounded-lg p-3 text-white appearance-none cursor-pointer focus:border-violet-500 focus:outline-none"
                  >
                    <option value="" disabled>Select your country</option>
                    <option value="MG">🇲🇬 Madagascar</option>
                    <option value="US">🇺🇸 United States</option>
                    <option value="FR">🇫🇷 France</option>
                    <option value="GB">🇬🇧 United Kingdom</option>
                    <option value="CA">🇨🇦 Canada</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- Terms and Submit -->
            <div class="space-y-4">
              <!-- Terms Agreement -->
              <div class="flex items-start gap-2">
                <input
                  v-model="termsAccepted"
                  type="checkbox"
                  id="terms"
                  class="mt-0.5 w-4 h-4 rounded border-white/10 bg-black/20 text-violet-600 focus:ring-violet-500 focus:ring-offset-transparent"
                />
                <label for="terms" class="text-sm text-gray-400">
                  I agree to the <a href="#" class="text-violet-400 hover:text-violet-300">Terms of Service</a> and <a href="#" class="text-violet-400 hover:text-violet-300">Privacy Policy</a>. 
                  I understand that I will be charged $9.00 monthly until I cancel.
                </label>
              </div>

              <!-- Submit Button -->
              <button
                @click="handlePayment"
                :disabled="!isFormValid || processing"
                :class="[
                  'w-full py-3 rounded-lg font-bold transition-all duration-300 relative overflow-hidden group',
                  isFormValid && !processing
                    ? 'bg-gradient-to-r from-violet-600 to-blue-600 text-white hover:from-violet-700 hover:to-blue-700 shadow-lg shadow-violet-500/20'
                    : 'bg-gray-800 text-gray-400 cursor-not-allowed'
                ]"
              >
                <div class="relative z-10 flex items-center justify-center gap-2">
                  <template v-if="processing">
                    <div class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                    <span>Processing Payment...</span>
                  </template>
                  <template v-else>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <span>Pay Securely - $9.00</span>
                  </template>
                </div>
                <div 
                  v-if="isFormValid && !processing" 
                  class="absolute inset-0 bg-gradient-to-r from-violet-700 to-blue-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                ></div>
              </button>

              <!-- Security Note -->
              <div class="text-center">
                <p class="text-xs text-gray-500">
                  <svg class="w-3 h-3 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                  </svg>
                  Secured by Stripe • 256-bit SSL encryption
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Alternative Methods -->
        <div class="text-center">
          <p class="text-gray-500 mb-3">Prefer another payment method?</p>
          <div class="flex justify-center gap-3">
            <button class="p-2 bg-white/5 hover:bg-white/10 rounded-lg transition-colors">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm0 22.5C6.201 22.5 1.5 17.799 1.5 12S6.201 1.5 12 1.5 22.5 6.201 22.5 12 17.799 22.5 12 22.5z"/>
                <path d="M12 6a6 6 0 100 12 6 6 0 000-12zm0 10.5a4.5 4.5 0 110-9 4.5 4.5 0 010 9z"/>
              </svg>
            </button>
            <button class="p-2 bg-white/5 hover:bg-white/10 rounded-lg transition-colors">
              <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm0 22.5C6.201 22.5 1.5 17.799 1.5 12S6.201 1.5 12 1.5 22.5 6.201 22.5 12 17.799 22.5 12 22.5z"/>
                <path d="M16.5 7.5h-9v9h9v-9zM8.25 9.75h5.5v5.5h-5.5v-5.5z"/>
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Success Modal -->
    <div v-if="showSuccess" class="fixed inset-0 bg-black/80 backdrop-blur-xl z-50 flex items-center justify-center p-4 animate-in fade-in">
      <div class="bg-gradient-to-br from-[#151515] to-[#0a0a0a] rounded-2xl max-w-md w-full border border-white/10 p-6 text-center animate-in zoom-in-95">
        <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
        </div>
        
        <h2 class="text-2xl font-bold text-white mb-3">Payment Successful! 🎉</h2>
        <p class="text-gray-400 text-sm mb-4">
          Welcome to SmartTools Pro! Your account has been upgraded with unlimited access to all advanced features.
        </p>
        
        <div class="space-y-3 mb-6">
          <div class="flex items-center justify-between p-3 bg-white/5 rounded-lg">
            <span class="text-gray-400">Plan</span>
            <span class="text-white font-semibold">SmartTools Pro</span>
          </div>
          <div class="flex items-center justify-between p-3 bg-white/5 rounded-lg">
            <span class="text-gray-400">Amount</span>
            <span class="text-white font-semibold">$9.00</span>
          </div>
          <div class="flex items-center justify-between p-3 bg-white/5 rounded-lg">
            <span class="text-gray-400">Next billing</span>
            <span class="text-white font-semibold">{{ nextBillingDate }}</span>
          </div>
        </div>
        
        <button
          @click="goToDashboard"
          class="w-full py-2.5 bg-gradient-to-r from-violet-600 to-blue-600 text-white font-medium rounded-lg hover:from-violet-700 hover:to-blue-700 transition-all"
        >
          Start Using Pro Features
        </button>
        
        <p class="text-gray-500 text-xs mt-3">
          You'll receive a receipt via email shortly
        </p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import api from '../services/api';


const router = useRouter();

// State
const cardNumber = ref('');
const expiry = ref('');
const cvc = ref('');
const cardholderName = ref('');
const country = ref('MG');
const termsAccepted = ref(false);
const processing = ref(false);
const showSuccess = ref(false);
const showCvcTooltip = ref(false);
const nextBillingDate = ref('');

// Error states
const cardError = ref('');
const expiryError = ref('');
const cvcError = ref('');
const nameError = ref('');

// Features list
const features = [
  'Unlimited AI generations',
  'Advanced AI (Llama 3.3 70B)',
  'Priority processing',
  'Export to PDF/DOCX/TXT',
  'Full history with search',
  'API access included'
];

// Computed
const isFormValid = computed(() => {
  const cardValid = cardNumber.value.replace(/\s/g, '').length >= 13;
  const expiryValid = expiry.value.length === 5;
  const cvcValid = cvc.value.length >= 3;
  const nameValid = cardholderName.value.length >= 3;
  const countryValid = country.value.length === 2;
  
  return cardValid && expiryValid && cvcValid && nameValid && countryValid && termsAccepted.value;
});

// Methods
const formatCardNumber = () => {
  let value = cardNumber.value.replace(/\D/g, '');
  if (value.length > 16) value = value.substring(0, 16);
  cardNumber.value = value.replace(/(\d{4})/g, '$1 ').trim();
  
  // Validate card number
  cardError.value = value.length < 13 ? 'Please enter a valid card number' : '';
};

const formatExpiry = () => {
  let value = expiry.value.replace(/\D/g, '');
  if (value.length > 4) value = value.substring(0, 4);
  if (value.length >= 2) {
    value = value.substring(0, 2) + '/' + value.substring(2);
  }
  expiry.value = value;
  
  // Validate expiry
  if (value.length === 5) {
    const parts = value.split('/');
    const month = parts[0];
    const year = parts[1];
    const currentYear = new Date().getFullYear() % 100;
    const currentMonth = new Date().getMonth() + 1;
    
    const m = parseInt(month || '0');
    const y = parseInt(year || '0');

    if (isNaN(m) || m < 1 || m > 12) {
      expiryError.value = 'Invalid month';
    } else if (isNaN(y) || y < currentYear || (y === currentYear && m < currentMonth)) {
      expiryError.value = 'Card has expired';
    } else {
      expiryError.value = '';
    }
  } else {
    expiryError.value = '';
  }
};

const validateCvc = () => {
  if (cvc.value.length < 3) {
    cvcError.value = 'Please enter a valid CVC';
  } else {
    cvcError.value = '';
  }
};

const validateName = () => {
  if (cardholderName.value.length < 3) {
    nameError.value = 'Please enter your full name';
  } else {
    nameError.value = '';
  }
};

const handlePayment = async () => {
  if (!isFormValid.value || processing.value) return;
  
  // Validate all fields
  validateCvc();
  validateName();
  
  if (cardError.value || expiryError.value || cvcError.value || nameError.value) {
    return;
  }
  
  processing.value = true;
  
  try {
    // Call backend API
    await api.post('/subscription/upgrade', {
      card_number: cardNumber.value.replace(/\s/g, ''),
      expiry: expiry.value,
      cvc: cvc.value,
      cardholder_name: cardholderName.value,
      country: country.value
    });
    
    // Calculate next billing date
    const today = new Date();
    const nextMonth = new Date(today);
    nextMonth.setMonth(today.getMonth() + 1);
    nextBillingDate.value = nextMonth.toLocaleDateString('en-US', { 
      month: 'long', 
      day: 'numeric', 
      year: 'numeric' 
    });
    
    // Show success modal
    showSuccess.value = true;
    
    // Clear form
    cardNumber.value = '';
    expiry.value = '';
    cvc.value = '';
    cardholderName.value = '';
    termsAccepted.value = false;
    
  } catch (error: any) {
    console.error('Payment failed:', error);
    alert(error.response?.data?.message || 'Payment failed. Please check your card details and try again.');
  } finally {
    processing.value = false;
  }
};

const goToDashboard = () => {
  showSuccess.value = false;
  router.push('/dashboard');
};

// Initialize
onMounted(() => {
  // Set focus to first input
  setTimeout(() => {
    const firstInput = document.querySelector('input');
    firstInput?.focus();
  }, 100);
});
</script>

<style scoped>
.animate-in {
  animation-fill-mode: both;
}

.fade-in {
  animation: fadeIn 0.3s ease-out;
}

.zoom-in-95 {
  animation: zoomIn 0.3s ease-out;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes zoomIn {
  from { opacity: 0; transform: scale(0.95); }
  to { opacity: 1; transform: scale(1); }
}

/* Custom scrollbar */
::-webkit-scrollbar {
  width: 6px;
}

::-webkit-scrollbar-track {
  background: rgba(255, 255, 255, 0.05);
  border-radius: 3px;
}

::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.1);
  border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
  background: rgba(255, 255, 255, 0.2);
}
</style>