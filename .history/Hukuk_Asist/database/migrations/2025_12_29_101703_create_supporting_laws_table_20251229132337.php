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
            $table->foreign('constitution_article_id')->constrained('constitution_articles')->onDelete('cascade');
            $table->string('law_name');//Kanun Adı:(örn:"Ceza Muhakemesi kanunu")
            $table->string('law_number')->nullable();//kanun numarası
            $table->text('relevant_articles')->nullable();//ilgili maddeler
            $table->text('description')->nullable();//Açılma
            $table->text('keywords')->nullable();//Anahtar kelimeler
            $table->integer('order')->default(0);//Sıralama
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
