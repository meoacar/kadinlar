<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZodiacController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    
    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::put('/profile', [AuthController::class, 'updateProfile']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/logout-all', [AuthController::class, 'logoutAll']);
    });
});

// Zodiac/Astrology Routes
Route::prefix('zodiac')->group(function () {
    Route::get('/signs', [ZodiacController::class, 'getAllSigns']);
    Route::post('/calculate', [ZodiacController::class, 'calculateZodiac']);
    Route::post('/compatibility', [ZodiacController::class, 'getCompatibility']);
    Route::get('/signs/{id}', [ZodiacController::class, 'getZodiacDetails']);
});

// Test route
Route::get('/test', function () {
    return response()->json([
        'message' => 'KadinAtlasi.com API is working! 🌟',
        'timestamp' => now(),
        'version' => '1.0.0',
        'features' => [
            'zodiac_calculator' => 'working',
            'authentication' => 'working',
            'user_registration' => 'working'
        ]
    ]);
});