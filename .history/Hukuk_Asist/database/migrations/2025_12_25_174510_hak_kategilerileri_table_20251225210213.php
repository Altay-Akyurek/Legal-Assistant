<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use function Laravel\Prompts\table;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('hak_kategorileri', function (Blueprint $table) {
            $table->id();
            $table->string('kod', 100)->unique()->comment('KISI_OZGURLUGU, IFADE_OZGURLUGU vb.');
            $table->string('baslik')->comment('Kişi Hürriyerti ve Güvenliği');
            $table->text('aciklama')->nullable();
            $table->string('renk_kodu', 7)->default('#3B82F6')->comment('Badge rengi (hex)');
            $table->unsignedTinyInteger('sira')->default(0)->comment('Görüntüleme sırası');
            $table->boolean('aktif')->default(true);
            $table->timestamp();

            $table->index('aktif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hak_kategorileri');
    }
};
