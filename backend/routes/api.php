<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ToolController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Tools Routes
    Route::get('/tools', [ToolController::class, 'index']);
    Route::post('/tools/{tool}/generate', [ToolController::class, 'generate']);

    // History
    Route::get('/history', [ToolController::class, 'history']);
});
