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
        Schema::create('status_kawin_kepala_keluarga', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kode_wilayah', 50);
            $table->integer('Belum_Kawin_LK');
            $table->integer('Belum_Kawin_PR');
            $table->integer('Kawin_LK');
            $table->integer('Kawin_PR');
            $table->integer('Cerai_Hidup_LK');
            $table->integer('Cerai_Hidup_PR');
            $table->integer('Cerai_Mati_LK');
            $table->integer('Cerai_Mati_PR');
            $table->integer('semester');
            $table->integer('tahun');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_kawin_kepala_keluarga');
    }
};
