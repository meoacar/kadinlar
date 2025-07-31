<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZodiacSign extends Model
{
    protected $fillable = [
        'name',
        'name_en',
        'symbol',
        'start_date',
        'end_date',
        'color_primary',
        'color_secondary',
        'element',
        'personality_traits',
        'strengths',
        'weaknesses',
        'description',
        'is_active',
        'order'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'personality_traits' => 'array',
        'is_active' => 'boolean'
    ];

    // Relations
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function dailyHoroscopes()
    {
        return $this->hasMany(DailyHoroscope::class);
    }

    // Helper methods - SQLite/MySQL compatible
    public static function findByBirthDate($birthDate)
    {
        $date = \Carbon\Carbon::parse($birthDate);
        $month = $date->month;
        $day = $date->day;
        
        return self::where(function($query) use ($month, $day) {
            $query->where(function($subQuery) use ($month, $day) {
                // Normal case: start month <= end month
                $subQuery->whereRaw("CAST(strftime('%m', start_date) AS INTEGER) <= CAST(strftime('%m', end_date) AS INTEGER)")
                         ->where(function($dateQuery) use ($month, $day) {
                             $dateQuery->where(function($startQuery) use ($month, $day) {
                                 $startQuery->whereRaw("CAST(strftime('%m', start_date) AS INTEGER) < ?", [$month])
                                           ->orWhere(function($sameMQuery) use ($month, $day) {
                                               $sameMQuery->whereRaw("CAST(strftime('%m', start_date) AS INTEGER) = ?", [$month])
                                                         ->whereRaw("CAST(strftime('%d', start_date) AS INTEGER) <= ?", [$day]);
                                           });
                             })->where(function($endQuery) use ($month, $day) {
                                 $endQuery->whereRaw("CAST(strftime('%m', end_date) AS INTEGER) > ?", [$month])
                                         ->orWhere(function($sameMQuery) use ($month, $day) {
                                             $sameMQuery->whereRaw("CAST(strftime('%m', end_date) AS INTEGER) = ?", [$month])
                                                       ->whereRaw("CAST(strftime('%d', end_date) AS INTEGER) >= ?", [$day]);
                                         });
                             });
                         });
            })->orWhere(function($subQuery) use ($month, $day) {
                // Capricorn case: start month > end month (spans year)
                $subQuery->whereRaw("CAST(strftime('%m', start_date) AS INTEGER) > CAST(strftime('%m', end_date) AS INTEGER)")
                         ->where(function($dateQuery) use ($month, $day) {
                             $dateQuery->where(function($startQuery) use ($month, $day) {
                                 $startQuery->whereRaw("CAST(strftime('%m', start_date) AS INTEGER) < ?", [$month])
                                           ->orWhere(function($sameMQuery) use ($month, $day) {
                                               $sameMQuery->whereRaw("CAST(strftime('%m', start_date) AS INTEGER) = ?", [$month])
                                                         ->whereRaw("CAST(strftime('%d', start_date) AS INTEGER) <= ?", [$day]);
                                           });
                             })->orWhere(function($endQuery) use ($month, $day) {
                                 $endQuery->whereRaw("CAST(strftime('%m', end_date) AS INTEGER) > ?", [$month])
                                         ->orWhere(function($sameMQuery) use ($month, $day) {
                                             $sameMQuery->whereRaw("CAST(strftime('%m', end_date) AS INTEGER) = ?", [$month])
                                                       ->whereRaw("CAST(strftime('%d', end_date) AS INTEGER) >= ?", [$day]);
                                         });
                             });
                         });
            });
        })->first();
    }

    // Simpler alternative method
    public static function findByBirthDateSimple($birthDate)
    {
        $date = \Carbon\Carbon::parse($birthDate);
        $signs = self::all();
        
        foreach ($signs as $sign) {
            $startDate = \Carbon\Carbon::parse($sign->start_date);
            $endDate = \Carbon\Carbon::parse($sign->end_date);
            
            // Set same year for comparison
            $startDate->year($date->year);
            $endDate->year($date->year);
            
            // Handle year boundary (Capricorn)
            if ($startDate->month > $endDate->month) {
                if ($date->month >= $startDate->month || $date->month <= $endDate->month) {
                    if (($date->month == $startDate->month && $date->day >= $startDate->day) ||
                        ($date->month == $endDate->month && $date->day <= $endDate->day) ||
                        ($date->month > $startDate->month) ||
                        ($date->month < $endDate->month)) {
                        return $sign;
                    }
                }
            } else {
                // Normal case
                if ($date->between($startDate, $endDate)) {
                    return $sign;
                }
            }
        }
        
        return null;
    }
}
