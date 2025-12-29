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
            $table->id();
            $table->text('event_description'); // Olay açıklaması
            $table->text('detected_keywords')->nullable(); // Tespit edilen anahtar kelimeler (JSON)
            $table->text('detected_right_categories')->nullable(); // Tespit edilen hak kategorileri (JSON)
            $table->text('matched_articles')->nullable(); // Eşleşen anayasa maddeleri (JSON)
            $table->string('ip_address', 45)->nullable(); // IP adresi (anonimleştirilmiş)
            $table->string('session_id')->nullable(); // Oturum ID
            $table->timestamp('analyzed_at')->nullable(); // Analiz zamanı
            $table->timestamps();

            // Index'ler
            $table->index('created_at');
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
