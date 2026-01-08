<?php

namespace App\Services\Ai;

use Illuminate\Support\Facades\Http;

class GroqAiService
{
    protected string $apiKey;

    protected string $baseUrl = 'https://api.groq.com/openai/v1';

    public function __construct()
    {
        $this->apiKey = config('services.groq.api_key');
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
                    'model' => 'llama-3.3-70b-versatile',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => "You are a creative AI assistant. Generate content with a {$tone} tone.",
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt,
                        ],
                    ],
                    'temperature' => 0.9,
                    'max_tokens' => 1024,
                ]);

            if ($response->successful()) {
                $data = $response->json();

                return $data['choices'][0]['message']['content'] ?? 'No response generated.';
            }

            return 'Error: Unable to generate content. ' . $response->body();
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
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
                    'model' => 'llama-3.3-70b-versatile',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are a summarization expert. Provide concise, accurate summaries.',
                        ],
                        [
                            'role' => 'user',
                            'content' => "Summarize the following text:\n\n{$text}",
                        ],
                    ],
                    'temperature' => 0.3,
                    'max_tokens' => 512,
                ]);

            if ($response->successful()) {
                $data = $response->json();

                return $data['choices'][0]['message']['content'] ?? 'No summary generated.';
            }

            return 'Error: Unable to summarize. ' . $response->body();
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function analyzeImage(?string $imageUrl, string $prompt): string
    {
        if (!$imageUrl) {
            return 'Error: No image provided for analysis.';
        }

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => "Bearer {$this->apiKey}",
                    'Content-Type' => 'application/json',
                ])
                ->post("{$this->baseUrl}/chat/completions", [
                    'model' => 'llama-3.2-90b-vision-preview',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => [
                                [
                                    'type' => 'text',
                                    'text' => $prompt ?: 'Describe this image in detail.',
                                ],
                                [
                                    'type' => 'image_url',
                                    'image_url' => [
                                        'url' => $imageUrl,
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 512,
                ]);

            if ($response->successful()) {
                $data = $response->json();

                return $data['choices'][0]['message']['content'] ?? 'No analysis generated.';
            }

            return 'Error: Unable to analyze. ' . $response->body();
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function humanizeText(string $text): string
    {
        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => "Bearer {$this->apiKey}",
                    'Content-Type' => 'application/json',
                ])
                ->post("{$this->baseUrl}/chat/completions", [
                    'model' => 'llama-3.3-70b-versatile',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are a text humanizer. Rewrite the input text to sound more natural, engaging, and human-like, while maintaining the original meaning.',
                        ],
                        [
                            'role' => 'user',
                            'content' => $text,
                        ],
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 1024,
                ]);

            if ($response->successful()) {
                $data = $response->json();

                return $data['choices'][0]['message']['content'] ?? 'No text generated.';
            }

            return 'Error: Unable to humanize. ' . $response->body();
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}
