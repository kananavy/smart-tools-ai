<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'plan',
        'monthly_limit',
        'usage_count',
        'resets_at',
        'is_active',
    ];

    protected $casts = [
        'resets_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isPro(): bool
    {
        return $this->plan === 'pro' && $this->is_active;
    }

    public function canGenerate(): bool
    {
        if ($this->isPro()) {
            return true; // Unlimited for pro
        }

        // Check if reset is needed
        if ($this->resets_at && Carbon::now()->greaterThan($this->resets_at)) {
            $this->resetUsage();
        }

        return $this->usage_count < $this->monthly_limit;
    }

    public function incrementUsage(): void
    {
        $this->increment('usage_count');
    }

    public function resetUsage(): void
    {
        $this->update([
            'usage_count' => 0,
            'resets_at' => Carbon::now()->addMonth(),
        ]);
    }

    public function getRemainingGenerations(): int
    {
        if ($this->isPro()) {
            return -1; // Unlimited
        }

        return max(0, $this->monthly_limit - $this->usage_count);
    }
}
