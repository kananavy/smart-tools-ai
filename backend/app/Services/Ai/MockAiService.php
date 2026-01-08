<?php

namespace App\Services\Ai;

class MockAiService
{
    public function generateText(string $prompt, string $tone = 'neutral'): string
    {
        return "This is a mocked response for the prompt: \"{$prompt}\" with tone: {$tone}. \n\n".
            'AI generation is simulated here to demonstrate the architecture.';
    }

    public function summarize(string $text): string
    {
        return 'Summary: This is a shortened version of the provided text. (Mocked Summary)';
    }

    public function analyzeImage(string $imagePath): string
    {
        return 'This image appears to be a digital creation. It contains colors and shapes. (Mocked Analysis)';
    }
}
