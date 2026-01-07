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

        // Save to History (Mocking DB save if DB is down, but writing code as if it works)
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

        return response()->json([
            'result' => $output
        ]);
    }

    public function history(Request $request)
    {
        // return $request->user()->toolRequests()->with('tool')->latest()->get();
        return $request->user()->toolRequests()->with('tool')->latest()->get();
    }
}
