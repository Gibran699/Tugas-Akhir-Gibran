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
        Schema::create('kelompok_umur_agama', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kode_wilayah');
            $table->string('kelompok_umur');
            $table->bigInteger('islam_lk');
            $table->bigInteger('islam_pr');
            $table->bigInteger('islam_jml');
            $table->bigInteger('katholik_lk');
            $table->bigInteger('katholik_pr');
            $table->bigInteger('katholik_jml');
            $table->bigInteger('kristen_lk');
            $table->bigInteger('kristen_pr');
            $table->bigInteger('kristen_jml');
            $table->bigInteger('hindu_lk');
            $table->bigInteger('hindu_pr');
            $table->bigInteger('hindu_jml');
            $table->bigInteger('budha_lk');
            $table->bigInteger('budha_pr');
            $table->bigInteger('budha_jml');
            $table->bigInteger('konghucu_lk');
            $table->bigInteger('konghucu_pr');
            $table->bigInteger('konghucu_jml');
            $table->bigInteger('kepercayaan_lk');
            $table->bigInteger('kepercayaan_pr');
            $table->bigInteger('kepercayaan_jml');
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
        Schema::dropIfExists('kelompok_umur_agama');
    }
};
