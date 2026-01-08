<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function show(Request $request)
    {
        $subscription = $request->user()->subscription;

        if (! $subscription) {
            // Create default free subscription if doesn't exist
            $subscription = $request->user()->subscription()->create([
                'plan' => 'free',
                'monthly_limit' => 50,
                'usage_count' => 0,
                'resets_at' => now()->addMonth(),
                'is_active' => true,
            ]);
        }

        return response()->json($subscription);
    }

    public function upgrade(Request $request)
    {
        $subscription = $request->user()->subscription;

        if (! $subscription) {
            return response()->json(['error' => 'No subscription found'], 404);
        }

        // In a real app, this would integrate with Stripe
        // For now, we'll just upgrade directly
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
