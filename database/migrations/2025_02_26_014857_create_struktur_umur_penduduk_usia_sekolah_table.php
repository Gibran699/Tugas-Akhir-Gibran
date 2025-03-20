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
        Schema::create('usia_sekolah_penduduk', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kode_wilayah');
            $table->bigInteger('usia_sd_sederajat');
            $table->bigInteger('usia_sltp_sederajat');
            $table->bigInteger('usia_slta_sederajat');
            $table->bigInteger('usia_perguruan_tinggi');
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
        Schema::dropIfExists('usia_sekolah_penduduk');
    }
};
