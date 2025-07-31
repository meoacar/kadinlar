<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZodiacSign;

class ZodiacController extends Controller
{
    /**
     * Get all zodiac signs with colors
     */
    public function getAllSigns()
    {
        $signs = ZodiacSign::where('is_active', true)
                          ->orderBy('order')
                          ->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $signs
        ]);
    }

    /**
     * Calculate zodiac sign by birth date (CORE FEATURE!)
     */
    public function calculateZodiac(Request $request)
    {
        $request->validate([
            'birth_date' => 'required|date'
        ]);

        $zodiacSign = ZodiacSign::findByBirthDateSimple($request->birth_date);

        if (!$zodiacSign) {
            return response()->json([
                'status' => 'error',
                'message' => 'Burç hesaplanamadı'
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'birth_date' => $request->birth_date,
                'zodiac_sign' => $zodiacSign,
                'message' => "Burcunuz: {$zodiacSign->name} {$zodiacSign->symbol}",
                'colors' => [
                    'primary' => $zodiacSign->color_primary,
                    'secondary' => $zodiacSign->color_secondary
                ]
            ]
        ])->header('Access-Control-Allow-Origin', '*')
          ->header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
          ->header('Access-Control-Allow-Headers', 'Content-Type');
    }

    /**
     * Get zodiac compatibility
     */
    public function getCompatibility(Request $request)
    {
        $request->validate([
            'sign1_id' => 'required|exists:zodiac_signs,id',
            'sign2_id' => 'required|exists:zodiac_signs,id'
        ]);

        $sign1 = ZodiacSign::find($request->sign1_id);
        $sign2 = ZodiacSign::find($request->sign2_id);

        $compatibility = $this->calculateCompatibility($sign1, $sign2);

        return response()->json([
            'status' => 'success',
            'data' => [
                'sign1' => $sign1,
                'sign2' => $sign2,
                'compatibility_percentage' => $compatibility,
                'message' => $this->getCompatibilityMessage($compatibility)
            ]
        ]);
    }

    private function calculateCompatibility($sign1, $sign2)
    {
        // Element-based compatibility
        $elementCompatibility = [
            'Ateş' => ['Ateş' => 85, 'Toprak' => 60, 'Hava' => 90, 'Su' => 50],
            'Toprak' => ['Ateş' => 60, 'Toprak' => 80, 'Hava' => 55, 'Su' => 85],
            'Hava' => ['Ateş' => 90, 'Toprak' => 55, 'Hava' => 85, 'Su' => 70],
            'Su' => ['Ateş' => 50, 'Toprak' => 85, 'Hava' => 70, 'Su' => 90]
        ];

        return $elementCompatibility[$sign1->element][$sign2->element] ?? 70;
    }

    private function getCompatibilityMessage($percentage)
    {
        if ($percentage >= 85) return 'Mükemmel uyum! 💕';
        if ($percentage >= 70) return 'Çok iyi uyum! ❤️';
        if ($percentage >= 55) return 'Orta seviye uyum 💛';
        return 'Challenging but possible! 💪';
    }
}
