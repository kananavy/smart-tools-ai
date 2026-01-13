<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function show(Request $request)
    {
        $subscription = $request->user()->subscription;

        if (!$subscription) {
            // Create default basic subscription if doesn't exist
            $subscription = $request->user()->subscription()->create([
                'plan' => 'basic',
                'monthly_limit' => 40,
                'usage_count' => 0,
                'resets_at' => now()->addMonth(),
                'is_active' => true,
            ]);
        }

        return response()->json($subscription);
    }

    public function upgrade(Request $request)
    {
        $request->validate([
            'card_number' => 'required|string',
            'expiry' => 'required|string',
            'cvc' => 'required|string',
            'cardholder_name' => 'required|string',
            'country' => 'required|string',
        ]);

        $subscription = $request->user()->subscription;
        if (!$subscription) {
            $subscription = $request->user()->subscription()->create([
                'plan' => 'basic',
                'monthly_limit' => 40,
                'usage_count' => 0,
                'resets_at' => now()->addMonth(),
                'is_active' => true,
            ]);
        }

        // Simulate payment validation
        // In a real app, this would call Stripe/PayPal API
        $cardNumber = preg_replace('/\D/', '', $request->card_number);

        // Simple mock validation: Fail if card doesn't start with 4242
        if (substr($cardNumber, 0, 4) !== '4242') {
            return response()->json([
                'message' => 'Payment failed. Card declined.'
            ], 402);
        }

        $subscription->update([
            'plan' => 'pro',
            'monthly_limit' => -1, // Unlimited
            'is_active' => true,
        ]);

        return response()->json([
            'message' => 'Successfully upgraded to Pro!',
            'subscription' => $subscription,
        ]);
    }
}
