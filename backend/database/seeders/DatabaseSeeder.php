<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tool;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create free subscription for test user
        \App\Models\Subscription::create([
            'user_id' => $user->id,
            'plan' => 'free',
            'monthly_limit' => 50,
            'usage_count' => 0,
            'resets_at' => now()->addMonth(),
            'is_active' => true,
        ]);

        // Seed Tools
        \App\Models\Tool::create([
            'name' => 'Text Generator',
            'slug' => 'text-generator',
            'type' => 'generator',
            'description' => 'Generate creative text based on your prompts.',
            'is_active' => true,
        ]);

        \App\Models\Tool::create([
            'name' => 'Text Summarizer',
            'slug' => 'summarizer',
            'type' => 'analyzer',
            'description' => 'Summarize long texts into concise summaries.',
            'is_active' => true,
        ]);

        \App\Models\Tool::create([
            'name' => 'Image Analyzer',
            'slug' => 'image-analyzer',
            'type' => 'vision',
            'description' => 'Analyze the content of images using AI vision.',
            'is_active' => true,
        ]);
    }
}
