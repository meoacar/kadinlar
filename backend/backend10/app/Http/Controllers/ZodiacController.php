<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ZodiacController extends Controller
{
    // Doğum tarihine göre burç hesaplama
    public function calculate(Request $request)
    {
        $user = Auth::user();
        $birthDate = $user->birth_date ?? $request->input('birth_date');
        if (!$birthDate) {
            return response()->json(['error' => 'Doğum tarihi bulunamadı'], 400);
        }
        $zodiac = $this->getZodiacSign($birthDate);
        return response()->json(['zodiac' => $zodiac]);
    }

    // Basit burç hesaplama algoritması (geliştirilebilir)
    private function getZodiacSign($date)
    {
        $dt = date('m-d', strtotime($date));
        $zodiacs = [
            'Capricorn' => ['12-22', '01-19'],
            'Aquarius' => ['01-20', '02-18'],
            'Pisces' => ['02-19', '03-20'],
            'Aries' => ['03-21', '04-19'],
            'Taurus' => ['04-20', '05-20'],
            'Gemini' => ['05-21', '06-20'],
            'Cancer' => ['06-21', '07-22'],
            'Leo' => ['07-23', '08-22'],
            'Virgo' => ['08-23', '09-22'],
            'Libra' => ['09-23', '10-22'],
            'Scorpio' => ['10-23', '11-21'],
            'Sagittarius' => ['11-22', '12-21'],
        ];
        foreach ($zodiacs as $sign => [$start, $end]) {
            if (($dt >= $start && $dt <= '12-31') || ($dt >= '01-01' && $dt <= $end)) {
                return $sign;
            }
        }
        return null;
    }
}
