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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('title');
            $table->text('content');
            $table->string('thumbnail')->nullable();
            $table->boolean('published')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');

            // Composite index (user_id, published)
            $table->index(['user_id', 'published']);
            // Full-text index (content)
            $table->fullText('content');
        });

        // Partitioning örneği (manuel SQL, migration sonrası çalıştırılmalı)
        // DB::statement('ALTER TABLE articles PARTITION BY RANGE (YEAR(created_at)) (
        // PARTITION p2025 VALUES LESS THAN (2026),
        // PARTITION pmax VALUES LESS THAN MAXVALUE
        // )');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
