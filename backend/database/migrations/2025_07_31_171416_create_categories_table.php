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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Moda & Güzellik, Astroloji, vb.
            $table->string('slug')->unique(); // URL-friendly name
            $table->text('description')->nullable();
            $table->string('icon')->nullable(); // Font awesome icon class
            $table->string('color_primary', 7)->default('#E91E63'); // PRD renkleri
            $table->string('color_secondary', 7)->nullable();
            $table->string('image')->nullable(); // Kategori görseli
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            // Indexes
            $table->index('slug');
            $table->index('is_active');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
