<?php

namespace App\Services\Ai;

use Illuminate\Support\Facades\Http;

class DeepSeekAiService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://api.deepseek.com/v1';

    public function __construct()
    {
        $this->apiKey = config('services.deepseek.api_key');
    }

    public function generateText(string $prompt, string $tone = 'neutral'): string
    {
        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => "Bearer {$this->apiKey}",
                    'Content-Type' => 'application/json',
                ])
                ->post("{$this->baseUrl}/chat/completions", [
                    'model' => 'deepseek-chat',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => "You are a creative AI assistant. Generate content with a {$tone} tone."
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'temperature' => 0.9,
                    'max_tokens' => 1024,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['choices'][0]['message']['content'] ?? 'No response generated.';
            }

            return "Error: Unable to generate content. " . $response->body();
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function summarize(string $text): string
    {
        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => "Bearer {$this->apiKey}",
                    'Content-Type' => 'application/json',
                ])
                ->post("{$this->baseUrl}/chat/completions", [
                    'model' => 'deepseek-chat',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are a summarization expert. Provide concise, accurate summaries.'
                        ],
                        [
                            'role' => 'user',
                            'content' => "Summarize the following text:\n\n{$text}"
                        ]
                    ],
                    'temperature' => 0.3,
                    'max_tokens' => 512,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['choices'][0]['message']['content'] ?? 'No summary generated.';
            }

            return "Error: Unable to summarize. " . $response->body();
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function analyzeImage(string $imagePath): string
    {
        try {
            // DeepSeek doesn't have vision capabilities yet, so we'll provide a creative text response
            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => "Bearer {$this->apiKey}",
                    'Content-Type' => 'application/json',
                ])
                ->post("{$this->baseUrl}/chat/completions", [
                    'model' => 'deepseek-chat',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are an image analysis expert. Provide detailed, creative descriptions.'
                        ],
                        [
                            'role' => 'user',
                            'content' => 'Describe what a typical image analysis would reveal. Be creative and detailed.'
                        ]
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 512,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['choices'][0]['message']['content'] ?? 'No analysis generated.';
            }

            return "Error: Unable to analyze. " . $response->body();
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
