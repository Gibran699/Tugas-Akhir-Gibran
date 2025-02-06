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
        Schema::create('usia_muda_produktif_tua_penduduk', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kode_wilayah');
            $table->integer('USIA_MUDA');
            $table->integer('USIA_PRODUKTIF');
            $table->integer('USIA_TUA');
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
        Schema::dropIfExists('usia_muda_produktif_tua_penduduk');
    }
};
