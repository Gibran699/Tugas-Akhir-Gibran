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
        Schema::create('laporan_kinerja_capil_format_pdak', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid',36);
            $table->string('kode_wilayah');
            $table->bigInteger('cetak_akta_kelahiran_lk');
            $table->bigInteger('cetak_akta_kelahiran_pr');
            $table->bigInteger('cetak_akta_kelahiran_jml');
            $table->bigInteger('pembatalan_kelahiran');
            $table->bigInteger('pembetulan_kelahiran');
            $table->bigInteger('cetak_akta_kematian_lk');
            $table->bigInteger('cetak_akta_kematian_pr');
            $table->bigInteger('cetak_akta_kematian_jml');
            $table->bigInteger('cetak_akta_kawin');
            $table->bigInteger('pembatalan_akta_kawin');
            $table->bigInteger('cetak_akta_cerai');
            $table->bigInteger('pembatalan_akta_cerai');
            $table->bigInteger('perubahan_wni_wna');
            $table->bigInteger('perubahan_wna_wni');
            $table->bigInteger('perubahan_nama');
            $table->bigInteger('perubahan_jenis_kelamin');
            $table->bigInteger('pengesahan_anak_lk');
            $table->bigInteger('pengesahan_anak_pr');
            $table->bigInteger('pengesahan_anak_jml');
            $table->bigInteger('pengangkatan_anak_lk');
            $table->bigInteger('pengangkatan_anak_pr');
            $table->bigInteger('pengangkatan_anak_jml');
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
        Schema::dropIfExists('laporan_kinerja_capil_format_pdak');
    }
};
