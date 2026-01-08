<?php

namespace App\Services\Ai;

use Illuminate\Support\Facades\Http;

class GeminiAiService
{
    protected string $apiKey;

    protected string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
    }

    public function generateText(string $prompt, string $tone = 'neutral'): string
    {
        try {
            $response = Http::timeout(30)->post(
                "{$this->baseUrl}/models/gemini-1.5-flash:generateContent?key={$this->apiKey}",
                [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => "Generate creative text with a {$tone} tone: {$prompt}"],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'temperature' => 0.9,
                        'maxOutputTokens' => 1024,
                    ],
                ]
            );

            if ($response->successful()) {
                $data = $response->json();

                return $data['candidates'][0]['content']['parts'][0]['text'] ?? 'No response generated.';
            }

            return 'Error: Unable to generate content. '.$response->body();
        } catch (\Exception $e) {
            return 'Error: '.$e->getMessage();
        }
    }

    public function summarize(string $text): string
    {
        try {
            $response = Http::timeout(30)->post(
                "{$this->baseUrl}/models/gemini-1.5-flash:generateContent?key={$this->apiKey}",
                [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => "Summarize the following text concisely:\n\n{$text}"],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'temperature' => 0.3,
                        'maxOutputTokens' => 512,
                    ],
                ]
            );

            if ($response->successful()) {
                $data = $response->json();

                return $data['candidates'][0]['content']['parts'][0]['text'] ?? 'No summary generated.';
            }

            return 'Error: Unable to summarize. '.$response->body();
        } catch (\Exception $e) {
            return 'Error: '.$e->getMessage();
        }
    }

    public function analyzeImage(string $imagePath): string
    {
        try {
            // For now, return a placeholder since image analysis requires base64 encoding
            // This can be implemented when actual image upload is added
            $response = Http::timeout(30)->post(
                "{$this->baseUrl}/models/gemini-1.5-flash:generateContent?key={$this->apiKey}",
                [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => 'Describe what you would see in an image analysis scenario. Provide a detailed, creative description.'],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'maxOutputTokens' => 512,
                    ],
                ]
            );

            if ($response->successful()) {
                $data = $response->json();

                return $data['candidates'][0]['content']['parts'][0]['text'] ?? 'No analysis generated.';
            }

            return 'Error: Unable to analyze. '.$response->body();
        } catch (\Exception $e) {
            return 'Error: '.$e->getMessage();
        }
    }
}
