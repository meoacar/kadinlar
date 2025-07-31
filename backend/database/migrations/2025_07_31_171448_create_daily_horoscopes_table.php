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
        Schema::create('daily_horoscopes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zodiac_sign_id')->constrained('zodiac_signs');
            $table->date('horoscope_date'); // Hangi gün için
            $table->text('general_prediction'); // Genel yorum
            $table->text('love_prediction')->nullable(); // Aşk yorumu
            $table->text('career_prediction')->nullable(); // Kariyer yorumu
            $table->text('health_prediction')->nullable(); // Sağlık yorumu
            $table->text('money_prediction')->nullable(); // Para yorumu
            $table->integer('luck_percentage')->default(50); // Şans yüzdesi (1-100)
            $table->string('lucky_color')->nullable(); // Şanslı renk
            $table->string('lucky_number')->nullable(); // Şanslı numara
            $table->boolean('is_published')->default(false);
            $table->foreignId('created_by')->constrained('users'); // Hangi admin/yazar yazdı
            $table->timestamps();
            
            // Indexes
            $table->index('zodiac_sign_id');
            $table->index('horoscope_date');
            $table->index('is_published');
            $table->unique(['zodiac_sign_id', 'horoscope_date']); // Her burç için günde bir kayıt
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_horoscopes');
    }
};
