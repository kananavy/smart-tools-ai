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
        $request->validate(['prompt' => 'required|string']);
        $user = $request->user();
        $subscription = $user->subscription;

        // --- Limit Check (Simple: Pro unlimited, Basic 40 generations) ---
        $isPro = $subscription && $subscription->status === 'active' && $subscription->plan === 'pro';
        if (!$isPro) {
            $monthlyLimit = $subscription ? $subscription->monthly_limit : 40;
            // Fallback if subscription is somehow missing usage_count
            $currentUsage = $subscription ? $subscription->usage_count : 0;

            if ($currentUsage >= $monthlyLimit) {
                return response()->json(['message' => 'Monthly limit reached. Upgrade to Pro for unlimited access.'], 403);
            }
        }

        // --- Conversation Handling ---
        $conversation = null;
        if ($id = $request->input('conversation_id')) {
            $conversation = $user->conversations()->find($id);
        }
        if (!$conversation) {
            $title = substr($request->input('prompt'), 0, 30);
            $conversation = $user->conversations()->create(['title' => $title ?: 'New Chat']);
        }

        // --- Generation ---
        $input = $request->input('prompt');
        $output = '';

        try {
            switch ($toolSlug) {
                case 'text-generator':
                    $output = $this->aiService->generateText($input, $request->input('tone', 'neutral'));
                    break;
                case 'summarizer':
                    $output = $this->aiService->summarize($input);
                    break;
                case 'image-analyzer':
                    $output = $this->aiService->analyzeImage($request->input('image'), $input);
                    break;
                case 'humanizer':
                    $output = $this->aiService->humanizeText($input);
                    break;
                default:
                    return response()->json(['error' => 'Tool not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

        // --- Save Request ---
        $tool = Tool::where('slug', $toolSlug)->first();
        if ($tool) {
            ToolRequest::create([
                'user_id' => $user->id,
                'tool_id' => $tool->id,
                'conversation_id' => $conversation->id,
                'input_data' => ['prompt' => $input],
                'output_data' => ['result' => $output],
                'status' => 'completed',
                'role' => 'assistant'
            ]);
        }

        // Update Usage
        if ($subscription) {
            $subscription->increment('usage_count');
        }

        return response()->json([
            'result' => $output,
            'conversation_id' => $conversation->id,
            'result' => $output,
            'conversation_id' => $conversation->id,
            // Return -1 for Pro, otherwise calc remaining
            'remaining' => $isPro ? -1 : max(0, ($subscription ? $subscription->monthly_limit : 40) - ($subscription ? $subscription->usage_count : 0))
        ]);
    }

    public function history(Request $request)
    {
        // return $request->user()->toolRequests()->with('tool')->latest()->get();
        return $request->user()->toolRequests()->with('tool')->latest()->get();
    }
}
