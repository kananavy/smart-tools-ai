<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
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
