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
        Schema::create('constitution_articles', function (Blueprint $table) {
            $table->id();
            $table->integer('article_number')->unique();//madde numarası 
            $table->string('title');//madde başlıklar
            $table->text('official_text');//Resmi metin
            $table->text('simplified_explanation')->nullable();//sadeleştirilmiş açıklama
            $table->text('keywords')->nullable();//Anahtar kelimeler
            $table->integer('order')->default(0);//sıralama
            $table->boolean('is_active')->default(true);//Aktif/Pasif durumu
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('constitution_articles');
    }
};
