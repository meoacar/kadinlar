<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class HealthToolsController extends Controller
{
    // BMI Hesaplama
    public function bmi(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'weight' => 'required|numeric|min:20|max:300', // kg
            'height' => 'required|numeric|min:100|max:250', // cm
        ]);
        $weight = $validated['weight'];
        $height = $validated['height'] / 100; // metreye çevir
        $bmi = $weight / ($height * $height);
        $bmi = round($bmi, 2);
        $status = $this->bmiStatus($bmi);
        return response()->json([
            'bmi' => $bmi,
            'status' => $status
        ]);
    }

    private function bmiStatus($bmi): string
    {
        if ($bmi < 18.5) return 'Zayıf';
        if ($bmi < 25) return 'Normal';
        if ($bmi < 30) return 'Fazla Kilolu';
        return 'Obez';
    }
}
