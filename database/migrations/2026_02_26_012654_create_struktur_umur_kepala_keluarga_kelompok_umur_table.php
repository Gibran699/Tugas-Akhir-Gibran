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
        Schema::create('kelompok_umur_kepala_keluarga', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kode_wilayah', 50);
            $table->bigInteger('00_04_tahun_lk');
            $table->bigInteger('00_04_tahun_pr');
            $table->bigInteger('00_04_tahun_jml');
            $table->bigInteger('05_09_tahun_lk');
            $table->bigInteger('05_09_tahun_pr');
            $table->bigInteger('05_09_tahun_jml');
            $table->bigInteger('10_14_tahun_lk');
            $table->bigInteger('10_14_tahun_pr');
            $table->bigInteger('10_14_tahun_jml');
            $table->bigInteger('15_19_tahun_lk');
            $table->bigInteger('15_19_tahun_pr');
            $table->bigInteger('15_19_tahun_jml');
            $table->bigInteger('20_24_tahun_lk');
            $table->bigInteger('20_24_tahun_pr');
            $table->bigInteger('20_24_tahun_jml');
            $table->bigInteger('25_29_tahun_lk');
            $table->bigInteger('25_29_tahun_pr');
            $table->bigInteger('25_29_tahun_jml');
            $table->bigInteger('30_34_tahun_lk');
            $table->bigInteger('30_34_tahun_pr');
            $table->bigInteger('30_34_tahun_jml');
            $table->bigInteger('35_39_tahun_lk');
            $table->bigInteger('35_39_tahun_pr');
            $table->bigInteger('35_39_tahun_jml');
            $table->bigInteger('40_44_tahun_lk');
            $table->bigInteger('40_44_tahun_pr');
            $table->bigInteger('40_44_tahun_jml');
            $table->bigInteger('45_49_tahun_lk');
            $table->bigInteger('45_49_tahun_pr');
            $table->bigInteger('45_49_tahun_jml');
            $table->bigInteger('50_54_tahun_lk');
            $table->bigInteger('50_54_tahun_pr');
            $table->bigInteger('50_54_tahun_jml');
            $table->bigInteger('55_59_tahun_lk');
            $table->bigInteger('55_59_tahun_pr');
            $table->bigInteger('55_59_tahun_jml');
            $table->bigInteger('60_64_tahun_lk');
            $table->bigInteger('60_64_tahun_pr');
            $table->bigInteger('60_64_tahun_jml');
            $table->bigInteger('65_69_tahun_lk');
            $table->bigInteger('65_69_tahun_pr');
            $table->bigInteger('65_69_tahun_jml');
            $table->bigInteger('70_74_tahun_lk');
            $table->bigInteger('70_74_tahun_pr');
            $table->bigInteger('70_74_tahun_jml');
            $table->bigInteger('lebih_75_tahun_lk');
            $table->bigInteger('lebih_75_tahun_pr');
            $table->bigInteger('lebih_75_tahun_jml');
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
        Schema::dropIfExists('kelompok_umur_kepala_keluarga');
    }
};
