<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Extension\CommonMark\Renderer\Block\ThematicBreakRenderer;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    /**
     * Destekleyici kanunlar tablosu
     * Anayasa maddelerini destekleyen kanunlar (bilgilendirme amaçlı)
     */
    public function up(): void
    {
        Schema::create('supporting_laws', function (Blueprint $table) {
            $table->id();
            $table->foreignId('constitution_article_id')->constrained('constitution_articles')->onDelete('cascade');
            $table->string('law_name'); // Kanun adı (örn: "Ceza Muhakemesi Kanunu")
            $table->string('law_number')->nullable(); // Kanun numarası
            $table->text('relevant_articles')->nullable(); // İlgili maddeler
            $table->text('description')->nullable(); // Açıklama
            $table->text('keywords')->nullable(); // Anahtar kelimeler (JSON)
            $table->integer('order')->default(0); // Sıralama
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supporting_laws');
    }
};
