<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->conversations()
            ->latest()
            ->with([
                'toolRequests' => function ($query) {
                    // Fetch only the latest request for preview if needed, or exclude heavy data
                    $query->latest()->limit(1);
                }
            ])
            ->get();
    }

    public function show(Request $request, Conversation $conversation)
    {
        if ($request->user()->id !== $conversation->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $conversation->load([
            'toolRequests' => function ($query) {
                $query->orderBy('created_at', 'asc');
            }
        ]);
    }

    public function destroy(Request $request, Conversation $conversation)
    {
        if ($request->user()->id !== $conversation->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $conversation->delete();
        return response()->json(['message' => 'Deleted']);
    }

    public function store(Request $request)
    {
        // Explicitly create a new conversation
        $conversation = $request->user()->conversations()->create([
            'title' => 'New Chat',
        ]);
        return $conversation;
    }
}
