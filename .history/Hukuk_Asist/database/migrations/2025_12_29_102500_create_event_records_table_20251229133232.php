<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpKernel\TerminableInterface;
use function Laravel\Prompts\table;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_records', function (Blueprint $table) {
            $table->id();//
            $table->text('event_description');//Olay açıklaması
            $table->text('detected_keywords')->nullable();//tespit edilen anahtar kelimeler 
            $table->text('detected_right_categories')->nullable();//tespit edilen hak kategorileri
            $table->text('matched_articles')->nullable();//eşleşen anayasa maddeleri
            $table->string('ip_addrees', 45)->nullable();//Ip adresi 
            $table->string('session_id')->nullable();//Oturum IDü,
            $table->timestamp('analyzed_at')->nullable();//Analiz Zamanı
            $table->timestamps();

            //İndexler 
            $table->index('create_at');
            $table->index('session_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_records');
    }
};
