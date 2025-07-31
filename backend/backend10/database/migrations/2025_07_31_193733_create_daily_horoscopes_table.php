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
            $table->unsignedBigInteger('zodiac_sign_id');
            $table->date('date');
            $table->text('content');
            $table->timestamps();

            $table->foreign('zodiac_sign_id')->references('id')->on('zodiac_signs')->onDelete('cascade');
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
