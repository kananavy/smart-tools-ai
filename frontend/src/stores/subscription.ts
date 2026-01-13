// stores/subscription.ts
import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import api from '../services/api';

export const useSubscriptionStore = defineStore('subscription', () => {
    const plan = ref<'basic' | 'pro'>('basic');
    const status = ref<'active' | 'cancelled' | 'expired'>('active');
    const nextBillingDate = ref<string>('');
    const remainingUses = ref<number>(40);
    const isLoading = ref(false);

    const isPro = computed(() => plan.value === 'pro');
    const isFree = computed(() => plan.value === 'basic');
    const hasUnlimitedAccess = computed(() => isPro.value && status.value === 'active');

    async function upgradeToPro(paymentData: any) {
        isLoading.value = true;
        try {
            const response = await api.post('/subscription/upgrade', paymentData);

            plan.value = 'pro';
            status.value = 'active';
            nextBillingDate.value = response.data.next_billing_date;
            remainingUses.value = -1;

            // Sauvegarder dans localStorage
            localStorage.setItem('smarttools_pro', 'true');
            localStorage.setItem('pro_data', JSON.stringify({
                plan: 'pro',
                next_billing: nextBillingDate.value,
                upgraded_at: new Date().toISOString()
            }));

            return response.data;
        } catch (error) {
            console.error('Failed to upgrade:', error);
            throw error;
        } finally {
            isLoading.value = false;
        }
    }

    async function fetchSubscription() {
        isLoading.value = true;
        try {
            // Vérifier d'abord le cache local
            const cachedPro = localStorage.getItem('smarttools_pro');
            if (cachedPro === 'true') {
                const cachedData = localStorage.getItem('pro_data');
                if (cachedData) {
                    const data = JSON.parse(cachedData);
                    plan.value = 'pro';
                    nextBillingDate.value = data.next_billing;
                    remainingUses.value = -1;
                    return;
                }
            }

            // Sinon, fetch depuis l'API
            const response = await api.get('/subscription');
            const data = response.data;

            plan.value = data.plan; // Fixed to match backend
            status.value = data.status;
            nextBillingDate.value = data.next_billing_date;
            const limit = data.monthly_limit || 40;
            remainingUses.value = data.plan === 'pro' ? -1 : Math.max(0, limit - (data.usage_count || 0));

            // Mettre en cache si Pro, sinon nettoyer
            if (data.plan === 'pro') {
                localStorage.setItem('smarttools_pro', 'true');
                localStorage.setItem('pro_data', JSON.stringify(data));
            } else {
                localStorage.removeItem('smarttools_pro');
                localStorage.removeItem('pro_data');
            }
        } catch (error) {
            console.error('Failed to fetch subscription:', error);
        } finally {
            isLoading.value = false;
        }
    }

    function updateRemaining(val: number) {
        remainingUses.value = val;
    }

    function reset() {
        plan.value = 'basic';
        status.value = 'active';
        nextBillingDate.value = '';
        remainingUses.value = 40;
        localStorage.removeItem('smarttools_pro');
        localStorage.removeItem('pro_data');
    }

    return {
        plan,
        status,
        nextBillingDate,
        remainingUses,
        isLoading,
        isPro,
        isFree,
        hasUnlimitedAccess,
        upgradeToPro,
        fetchSubscription,
        updateRemaining,
        reset
    };
});