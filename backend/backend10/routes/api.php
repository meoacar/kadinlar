use App\Http\Controllers\ZodiacController;
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\JsonResponse;

use App\Http\Controllers\ProfileController;

Route::post('/register', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6',
    ]);
    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);
    $token = JWTAuth::fromUser($user);
    return response()->json(['user' => $user, 'token' => $token]);
});


// Profil görüntüleme ve güncelleme (JWT auth gerektirir)
Route::middleware(['auth:api'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::post('/profile', [ProfileController::class, 'update']);
    Route::get('/zodiac', [ZodiacController::class, 'calculate']);
    Route::post('/refresh', [\App\Http\Controllers\AuthController::class, 'refresh']);
});

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    if (!$token = JWTAuth::attempt($credentials)) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    return response()->json(['token' => $token]);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
