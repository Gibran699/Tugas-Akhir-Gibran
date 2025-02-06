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
        Schema::create('status_kawin_umur_tunggal_penduduk', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kode_wilayah');
            $table->integer('umur');
            $table->integer('BELUM_KAWIN_LK');
            $table->integer('BELUM_KAWIN_PR');
            $table->integer('KAWIN_LK');
            $table->integer('KAWIN_PR');
            $table->integer('CERAI_HIDUP_LK');
            $table->integer('CERAI_HIDUP_PR');
            $table->integer('CERAI_MATI_LK');
            $table->integer('CERAI_MATI_PR');
            $table->integer('semester');
            $table->integer('tahun');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_kawin_umur_tunggal_penduduk');
    }
};
