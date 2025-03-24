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
        Schema::create('laporan_kinerja_dafduk_format_pdak', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid',36);
            $table->string('kode_wilayah');
            $table->bigInteger('penerbitan_kk');
            $table->bigInteger('perubahan_kk');
            $table->bigInteger('penerbitan_nik_wni_lk');
            $table->bigInteger('penerbitan_nik_wni_pr');
            $table->bigInteger('penerbitan_nik_wni_jml');
            $table->bigInteger('penerbitan_nik_oa_lk');
            $table->bigInteger('penerbitan_nik_oa_pr');
            $table->bigInteger('penerbitan_nik_oa_jml');
            $table->bigInteger('pencetakan_kia_lk');
            $table->bigInteger('pencetakan_kia_pr');
            $table->bigInteger('pencetakan_kia_jml');
            $table->bigInteger('ktp_el_rekam_lk');
            $table->bigInteger('ktp_el_rekam_pr');
            $table->bigInteger('ktp_el_rekam_jml');
            $table->bigInteger('ktp_el_cetak_lk');
            $table->bigInteger('ktp_el_cetak_pr');
            $table->bigInteger('ktp_el_cetak_jml');
            $table->bigInteger('jml_surat_pindah');
            $table->bigInteger('jml_pindah_lk');
            $table->bigInteger('jml_pindah_pr');
            $table->bigInteger('jml_pindah_jml');
            $table->bigInteger('jml_surat_datang');
            $table->bigInteger('jml_datang_lk');
            $table->bigInteger('jml_datang_pr');
            $table->bigInteger('jml_datang_jml');
            $table->dateTime('tanggal_laporan');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_kinerja_dafduk_format_pdak');
    }
};
