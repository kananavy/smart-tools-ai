<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use App\Models\ToolRequest;
use App\Services\Ai\GroqAiService;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    protected $aiService;

    public function __construct(GroqAiService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function index()
    {
        // For now, return hardcoded tools if DB is empty or unreachable
        // But optimally we fetch from DB
        return Tool::where('is_active', true)->get();
        // return Tool::where('is_active', true)->get();
    }

    public function generate(Request $request, string $toolSlug)
    {
        // Validate input
        $request->validate([
            'prompt' => 'required|string',
        ]);

        $user = $request->user();

        // Check subscription and usage limits
        $subscription = $user->subscription;
        if (!$subscription) {
            return response()->json(['error' => 'No subscription found'], 403);
        }

        if (!$subscription->canGenerate()) {
            return response()->json([
                'error' => 'Usage limit reached',
                'message' => 'You have reached your monthly generation limit. Please upgrade to Pro for unlimited access.',
                'remaining' => 0
            ], 429);
        }

        $input = $request->input('prompt');
        $output = '';

        // Determine tool and execute service
        switch ($toolSlug) {
            case 'text-generator':
                $output = $this->aiService->generateText($input, $request->input('tone', 'neutral'));
                break;
            case 'summarizer':
                $output = $this->aiService->summarize($input);
                break;
            case 'image-analyzer':
                $output = $this->aiService->analyzeImage($input); // Assuming input is path or mock
                break;
            default:
                return response()->json(['error' => 'Tool not found'], 404);
        }

        // Save to History
        $tool = Tool::where('slug', $toolSlug)->first();
        if ($tool) {
            ToolRequest::create([
                'user_id' => $user->id,
                'tool_id' => $tool->id,
                'input_data' => json_encode(['prompt' => $input]),
                'output_data' => json_encode(['result' => $output]),
                'status' => 'completed'
            ]);
        }

        // Increment usage count
        $subscription->incrementUsage();

        return response()->json([
            'result' => $output,
            'remaining' => $subscription->getRemainingGenerations()
        ]);
    }

    public function history(Request $request)
    {
        // return $request->user()->toolRequests()->with('tool')->latest()->get();
        return $request->user()->toolRequests()->with('tool')->latest()->get();
    }
}
