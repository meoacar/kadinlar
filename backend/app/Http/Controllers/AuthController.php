<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ZodiacSign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register new user with zodiac calculation
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'birth_date' => 'required|date',
            'birth_time' => 'nullable|date_format:H:i',
            'birth_place' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Calculate zodiac sign
        $zodiacSign = ZodiacSign::findByBirthDateSimple($request->birth_date);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birth_date' => $request->birth_date,
            'birth_time' => $request->birth_time,
            'birth_place' => $request->birth_place,
            'zodiac_sign_id' => $zodiacSign?->id,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
            'data' => [
                'user' => $user->load('zodiacSign'),
                'token' => $token,
                'token_type' => 'Bearer',
                'zodiac_info' => $zodiacSign ? [
                    'name' => $zodiacSign->name,
                    'symbol' => $zodiacSign->symbol,
                    'colors' => [
                        'primary' => $zodiacSign->color_primary,
                        'secondary' => $zodiacSign->color_secondary
                    ]
                ] : null
            ]
        ])->header('Access-Control-Allow-Origin', '*');
    }

    /**
     * Login user
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        }

        // Update last login
        $user->update(['last_login_at' => now()]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'data' => [
                'user' => $user->load('zodiacSign'),
                'token' => $token,
                'token_type' => 'Bearer'
            ]
        ])->header('Access-Control-Allow-Origin', '*');
    }

    /**
     * Get authenticated user profile
     */
    public function profile(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'data' => $request->user()->load('zodiacSign')
        ])->header('Access-Control-Allow-Origin', '*');
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();
        
        $validator = Validator::make($request->all(), [
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'bio' => 'sometimes|string|max:1000',
            'birth_time' => 'sometimes|nullable|date_format:H:i',
            'birth_place' => 'sometimes|nullable|string|max:255',
            'instagram' => 'sometimes|nullable|string|max:255',
            'twitter' => 'sometimes|nullable|string|max:255',
            'facebook' => 'sometimes|nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user->update($request->only([
            'first_name', 'last_name', 'bio', 'birth_time', 
            'birth_place', 'instagram', 'twitter', 'facebook'
        ]));

        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully',
            'data' => $user->load('zodiacSign')
        ])->header('Access-Control-Allow-Origin', '*');
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ])->header('Access-Control-Allow-Origin', '*');
    }

    /**
     * Logout from all devices
     */
    public function logoutAll(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out from all devices'
        ])->header('Access-Control-Allow-Origin', '*');
    }
}
