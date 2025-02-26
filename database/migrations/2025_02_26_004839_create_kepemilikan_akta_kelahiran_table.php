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
        Schema::create('akta_kelahiran', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kode_wilayah');
            $table->string('keterangan', 225);
            $table->bigInteger('wajib_akta_awal_lk');
            $table->bigInteger('wajib_akta_awal_pr');
            $table->bigInteger('wajib_akta_awal_jml');
            $table->bigInteger('memiliki_awal_lk');
            $table->bigInteger('memiliki_awal_pr');
            $table->bigInteger('memiliki_awal_jml');
            $table->bigInteger('belum_memiliki_awal_lk');
            $table->bigInteger('belum_memiliki_awal_pr');
            $table->bigInteger('belum_memiliki_awal_jml');
            $table->bigInteger('persen_awal');
            $table->bigInteger('usia_lebih_dari_target_lk');
            $table->bigInteger('usia_lebih_dari_target_pr');
            $table->bigInteger('usia_lebih_dari_target_jml');
            $table->bigInteger('meninggal_lk');
            $table->bigInteger('meninggal_pr');
            $table->bigInteger('meninggal_jml');
            $table->bigInteger('nonaktif_lk');
            $table->bigInteger('nonaktif_pr');
            $table->bigInteger('nonaktif_jml');
            $table->bigInteger('pindah_lk');
            $table->bigInteger('pindah_pr');
            $table->bigInteger('pindah_jml');
            $table->bigInteger('datang_lk');
            $table->bigInteger('datang_pr');
            $table->bigInteger('datang_jml');
            $table->bigInteger('hapus_operator_lk');
            $table->bigInteger('hapus_operator_pr');
            $table->bigInteger('hapus_operator_jml');
            $table->bigInteger('terbit_akta_baru_dalam_dkb_lk');
            $table->bigInteger('terbit_akta_baru_dalam_dkb_pr');
            $table->bigInteger('terbit_akta_baru_dalam_dkb_jml');
            $table->bigInteger('terbit_akta_baru_luar_dkb_lk');
            $table->bigInteger('terbit_akta_baru_luar_dkb_pr');
            $table->bigInteger('terbit_akta_baru_luar_dkb_jml');
            $table->bigInteger('wajib_akta_dinamis_lk');
            $table->bigInteger('wajib_akta_dinamis_pr');
            $table->bigInteger('wajib_akta_dinamis_jml');
            $table->bigInteger('memiliki_dinamis_lk');
            $table->bigInteger('memiliki_dinamis_pr');
            $table->bigInteger('memiliki_dinamis_jml');
            $table->bigInteger('belum_memiliki_dinamis_lk');
            $table->bigInteger('belum_memiliki_dinamis_pr');
            $table->bigInteger('belum_memiliki_dinamis_jml');
            $table->bigInteger('persen_dinamis');
            $table->bigInteger('penambahan_lk');
            $table->bigInteger('penambahan_pr');
            $table->bigInteger('penambahan_jml');
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
        Schema::dropIfExists('akta_kelahiran');
    }
};
