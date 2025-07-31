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
        Schema::create('zodiac_signs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Koç, Boğa, İkizler, vb.
            $table->string('name_en'); // Aries, Taurus, Gemini, vb.
            $table->string('symbol', 10); // ♈, ♉, ♊, vb.
            $table->date('start_date'); // Başlangıç tarihi (MM-DD)
            $table->date('end_date'); // Bitiş tarihi (MM-DD)
            $table->string('color_primary', 7); // #FFB3BA (hex color)
            $table->string('color_secondary', 7)->nullable(); // İkincil renk
            $table->string('element'); // Ateş, Toprak, Hava, Su
            $table->text('personality_traits'); // JSON - kişilik özellikleri
            $table->text('strengths'); // Güçlü yönler
            $table->text('weaknesses'); // Zayıf yönler
            $table->text('description'); // Genel açıklama
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0); // Sıralama
            $table->timestamps();
            
            // Indexes
            $table->index('name');
            $table->index('element');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zodiac_signs');
    }
};
