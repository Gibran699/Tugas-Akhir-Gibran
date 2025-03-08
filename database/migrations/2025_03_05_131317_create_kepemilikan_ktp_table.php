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
        Schema::create('ktp', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kode_wilayah', 50);
            $table->bigInteger('wajib_ktp_lk');
            $table->bigInteger('wajib_ktp_pr');
            $table->bigInteger('wajib_ktp_jml');
            $table->bigInteger('rekam_lk');
            $table->bigInteger('rekam_pr');
            $table->bigInteger('rekam_jml');
            $table->bigInteger('belum_rekam_lk');
            $table->bigInteger('belum_rekam_pr');
            $table->bigInteger('belum_rekam_jml');
            $table->bigInteger('ktp_lk');
            $table->bigInteger('ktp_pr');
            $table->bigInteger('ktp_jml');
            $table->bigInteger('blm_ktp_lk');
            $table->bigInteger('blm_ktp_pr');
            $table->bigInteger('blm_ktp_jml');
            $table->bigInteger('semester');
            $table->bigInteger('tahun');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kepemilikan_ktp');
    }
};
