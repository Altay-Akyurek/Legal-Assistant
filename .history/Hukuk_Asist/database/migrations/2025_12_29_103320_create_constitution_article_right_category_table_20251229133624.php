<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('constitution_article_right_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('constitution_article_id')->constrained('constitution_articles')->onDelete('cascade');
            $table->foreignId('right_category_id')->constrained('right_categories')->onDelete('cascade');
            $table->integer('relevance_score')->default(100); // İlişki skoru (0-100)
            $table->timestamps();

            // Unique constraint: Aynı madde-kategori çifti tekrar edemez
            $table->unique(['constitution_article_id', 'right_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('constitution_article_right_category');
    }
};
