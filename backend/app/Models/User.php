<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'birth_date',
        'birth_time',
        'birth_place',
        'zodiac_sign_id',
        'phone',
        'bio',
        'avatar',
        'instagram',
        'twitter',
        'facebook',
        'role',
        'subscription_type',
        'subscription_expires_at',
        'email_verified',
        'is_active',
        'last_login_at',
        'privacy_settings',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'birth_date' => 'date',
            'birth_time' => 'datetime',
            'subscription_expires_at' => 'datetime',
            'last_login_at' => 'datetime',
            'email_verified' => 'boolean',
            'is_active' => 'boolean',
            'privacy_settings' => 'array',
            'password' => 'hashed',
        ];
    }

    // Relations
    public function zodiacSign()
    {
        return $this->belongsTo(ZodiacSign::class);
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getIsSubscribedAttribute()
    {
        return $this->subscription_type !== 'free' && 
               $this->subscription_expires_at && 
               $this->subscription_expires_at->isFuture();
    }
}
