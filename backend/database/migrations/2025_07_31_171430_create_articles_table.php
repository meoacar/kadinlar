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
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable(); // Özet
            $table->longText('content'); // Ana içerik
            $table->string('featured_image')->nullable();
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('author_id')->constrained('users'); // Yazar
            $table->string('status')->default('draft'); // draft, published, archived
            $table->boolean('is_featured')->default(false); // Öne çıkan
            $table->boolean('is_premium')->default(false); // Premium içerik
            $table->json('seo_meta')->nullable(); // SEO meta tags
            $table->integer('view_count')->default(0);
            $table->integer('like_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('slug');
            $table->index('category_id');
            $table->index('author_id');
            $table->index('status');
            $table->index('is_featured');
            $table->index('is_premium');
            $table->index('published_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
