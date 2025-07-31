<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Burç ve doğum bilgileri
            $table->date('birth_date')->nullable(); // Doğum tarihi (ZORUNLU)
            $table->time('birth_time')->nullable(); // Doğum saati (opsiyonel)
            $table->string('birth_place')->nullable(); // Doğum yeri (opsiyonel)
            $table->foreignId('zodiac_sign_id')->nullable()->constrained('zodiac_signs');
            
            // Profil bilgileri
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->text('bio')->nullable(); // Biyografi
            $table->string('avatar')->nullable(); // Profil fotoğrafı
            
            // Sosyal medya
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('facebook')->nullable();
            
            // Sistem bilgileri
            $table->string('role')->default('user'); // user, admin, creator, etc.
            $table->string('subscription_type')->default('free'); // free, silver, gold, creator
            $table->timestamp('subscription_expires_at')->nullable();
            $table->boolean('email_verified')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login_at')->nullable();
            
            // Gizlilik ayarları
            $table->json('privacy_settings')->nullable(); // JSON field
            
            // Indexes
            $table->index('zodiac_sign_id');
            $table->index('subscription_type');
            $table->index('role');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['zodiac_sign_id']);
            $table->dropColumn([
                'birth_date', 'birth_time', 'birth_place', 'zodiac_sign_id',
                'first_name', 'last_name', 'phone', 'bio', 'avatar',
                'instagram', 'twitter', 'facebook',
                'role', 'subscription_type', 'subscription_expires_at',
                'email_verified', 'is_active', 'last_login_at', 'privacy_settings'
            ]);
        });
    }
};
