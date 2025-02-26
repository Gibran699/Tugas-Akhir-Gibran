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
            $table->bigInteger('umur');
            $table->bigInteger('belum_kawin_lk');
            $table->bigInteger('belum_kawin_pr');
            $table->bigInteger('kawin_lk');
            $table->bigInteger('kawin_pr');
            $table->bigInteger('cerai_hidup_lk');
            $table->bigInteger('cerai_hidup_pr');
            $table->bigInteger('cerai_mati_lk');
            $table->bigInteger('cerai_mati_pr');
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
