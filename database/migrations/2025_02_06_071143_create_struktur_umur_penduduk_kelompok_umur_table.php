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
        Schema::create('kelompok_umur_penduduk', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kode_wilayah');
            $table->integer('00_04_TAHUN_LK');
            $table->integer('00_04_TAHUN_PR');
            $table->integer('00_04_TAHUN_JML');
            $table->integer('05_09_TAHUN_LK');
            $table->integer('05_09_TAHUN_PR');
            $table->integer('05_09_TAHUN_JML');
            $table->integer('10_14_TAHUN_LK');
            $table->integer('10_14_TAHUN_PR');
            $table->integer('10_14_TAHUN_JML');
            $table->integer('15_19_TAHUN_LK');
            $table->integer('15_19_TAHUN_PR');
            $table->integer('15_19_TAHUN_JML');
            $table->integer('20_24_TAHUN_LK');
            $table->integer('20_24_TAHUN_PR');
            $table->integer('20_24_TAHUN_JML');
            $table->integer('25_29_TAHUN_LK');
            $table->integer('25_29_TAHUN_PR');
            $table->integer('25_29_TAHUN_JML');
            $table->integer('30_34_TAHUN_LK');
            $table->integer('30_34_TAHUN_PR');
            $table->integer('30_34_TAHUN_JML');
            $table->integer('35_39_TAHUN_LK');
            $table->integer('35_39_TAHUN_PR');
            $table->integer('35_39_TAHUN_JML');
            $table->integer('40_44_TAHUN_LK');
            $table->integer('40_44_TAHUN_PR');
            $table->integer('40_44_TAHUN_JML');
            $table->integer('45_49_TAHUN_LK');
            $table->integer('45_49_TAHUN_PR');
            $table->integer('45_49_TAHUN_JML');
            $table->integer('50_54_TAHUN_LK');
            $table->integer('50_54_TAHUN_PR');
            $table->integer('50_54_TAHUN_JML');
            $table->integer('55_59_TAHUN_LK');
            $table->integer('55_59_TAHUN_PR');
            $table->integer('55_59_TAHUN_JML');
            $table->integer('60_64_TAHUN_LK');
            $table->integer('60_64_TAHUN_PR');
            $table->integer('60_64_TAHUN_JML');
            $table->integer('65_69_TAHUN_LK');
            $table->integer('65_69_TAHUN_PR');
            $table->integer('65_69_TAHUN_JML');
            $table->integer('70_74_TAHUN_LK');
            $table->integer('70_74_TAHUN_PR');
            $table->integer('70_74_TAHUN_JML');
            $table->integer('LEBIH_75_TAHUN_LK');
            $table->integer('LEBIH_75_TAHUN_PR');
            $table->integer('LEBIH_75_TAHUN_JML');
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
        Schema::dropIfExists('kelompok_umur_penduduk');
    }
};
