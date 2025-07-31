<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ZodiacSign;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware(function ($request, $next) {
            if ($request->user()->role !== 'admin') {
                return response()->json(['message' => 'Admin access required'], 403);
            }
            return $next($request);
        });
    }

    /**
     * Admin Dashboard - Colorful overview
     */
    public function dashboard()
    {
        $stats = [
            'users' => [
                'total' => User::count(),
                'new_today' => User::whereDate('created_at', today())->count(),
                'active' => User::where('is_active', true)->count(),
                'subscribed' => User::where('subscription_type', '!=', 'free')->count(),
                'color' => '#E91E63' // Pink
            ],
            'zodiac_distribution' => ZodiacSign::withCount('users')
                ->get()
                ->map(function ($sign) {
                    return [
                        'name' => $sign->name,
                        'symbol' => $sign->symbol,
                        'count' => $sign->users_count,
                        'color' => $sign->color_primary
                    ];
                }),
            'content' => [
                'articles' => Article::count(),
                'categories' => Category::count(),
                'published' => Article::where('status', 'published')->count(),
                'drafts' => Article::where('status', 'draft')->count(),
                'color' => '#9C27B0' // Purple
            ],
            'activity' => [
                'daily_registrations' => User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                    ->where('created_at', '>=', now()->subDays(7))
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get(),
                'popular_signs' => ZodiacSign::withCount('users')
                    ->orderBy('users_count', 'desc')
                    ->take(3)
                    ->get(),
                'color' => '#FF9800' // Orange
            ]
        ];

        return response()->json([
            'status' => 'success',
            'data' => $stats,
            'message' => 'Colorful admin dashboard data! 🌈'
        ])->header('Access-Control-Allow-Origin', '*');
    }

    /**
     * User Management
     */
    public function users(Request $request)
    {
        $query = User::with('zodiacSign');
        
        // Filters
        if ($request->has('role')) {
            $query->where('role', $request->role);
        }
        
        if ($request->has('subscription')) {
            $query->where('subscription_type', $request->subscription);
        }
        
        if ($request->has('zodiac')) {
            $query->where('zodiac_sign_id', $request->zodiac);
        }

        $users = $query->paginate(20);

        return response()->json([
            'status' => 'success',
            'data' => $users
        ])->header('Access-Control-Allow-Origin', '*');
    }

    /**
     * Update user role/subscription
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'role' => 'sometimes|in:user,admin,creator',
            'subscription_type' => 'sometimes|in:free,silver,gold,creator',
            'is_active' => 'sometimes|boolean'
        ]);

        $user->update($request->only(['role', 'subscription_type', 'is_active']));

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully',
            'data' => $user->load('zodiacSign')
        ])->header('Access-Control-Allow-Origin', '*');
    }

    /**
     * Analytics for zodiac distribution
     */
    public function zodiacAnalytics()
    {
        $analytics = ZodiacSign::with('users')
            ->withCount('users')
            ->get()
            ->map(function ($sign) {
                $users = $sign->users;
                return [
                    'zodiac' => [
                        'name' => $sign->name,
                        'symbol' => $sign->symbol,
                        'color_primary' => $sign->color_primary,
                        'element' => $sign->element
                    ],
                    'stats' => [
                        'total_users' => $sign->users_count,
                        'percentage' => $sign->users_count > 0 ? round(($sign->users_count / User::count()) * 100, 1) : 0,
                        'subscriptions' => [
                            'free' => $users->where('subscription_type', 'free')->count(),
                            'silver' => $users->where('subscription_type', 'silver')->count(),
                            'gold' => $users->where('subscription_type', 'gold')->count(),
                        ],
                        'recent_joins' => $users->where('created_at', '>=', now()->subDays(7))->count()
                    ]
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => $analytics,
            'message' => 'Zodiac analytics with beautiful colors! 🎨'
        ])->header('Access-Control-Allow-Origin', '*');
    }

    /**
     * System health check
     */
    public function systemHealth()
    {
        $health = [
            'database' => [
                'status' => 'healthy',
                'users_table' => User::count(),
                'zodiac_table' => ZodiacSign::count(),
                'color' => '#48BB78' // Green
            ],
            'storage' => [
                'status' => 'healthy',
                'disk_usage' => '12%', // Placeholder
                'color' => '#4299E1' // Blue
            ],
            'api' => [
                'status' => 'healthy',
                'response_time' => '120ms', // Placeholder
                'color' => '#F56565' // Red/Pink
            ]
        ];

        return response()->json([
            'status' => 'success',
            'data' => $health,
            'timestamp' => now()
        ])->header('Access-Control-Allow-Origin', '*');
    }
}
