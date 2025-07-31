<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZodiacController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

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
        'version' => '1.0.0'
    ]);
});