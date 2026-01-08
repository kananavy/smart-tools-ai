<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ToolController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Tools Routes
    Route::get('/tools', [ToolController::class, 'index']);
    Route::post('/tools/{tool}/generate', [ToolController::class, 'generate']);
    Route::apiResource('conversations', \App\Http\Controllers\Api\ConversationController::class);

    // History
    Route::get('/history', [ToolController::class, 'history']);

    // Subscription
    Route::get('/subscription', [\App\Http\Controllers\Api\SubscriptionController::class, 'show']);
    Route::post('/subscription/upgrade', [\App\Http\Controllers\Api\SubscriptionController::class, 'upgrade']);

    // Export (Pro feature)
    Route::post('/export', [\App\Http\Controllers\Api\ExportController::class, 'export']);
});
