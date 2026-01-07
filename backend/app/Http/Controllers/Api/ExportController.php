<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function export(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'format' => 'required|in:txt,pdf,docx',
        ]);

        $content = $request->input('content');
        $format = $request->input('format');

        // Check if user is Pro
        $subscription = $request->user()->subscription;
        if (!$subscription || $subscription->plan !== 'pro') {
            return response()->json([
                'error' => 'Export is a Pro feature',
                'message' => 'Please upgrade to Pro to export your content.'
            ], 403);
        }

        // For now, we'll just return TXT format
        // In production, you'd use libraries like TCPDF or PHPWord
        $filename = 'smarttools-export-' . time() . '.' . $format;

        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
