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
        Schema::create('kia', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kode_wilayah');
            $table->bigInteger('jumlah_awal_lk');
            $table->bigInteger('jumlah_awal_pr');
            $table->bigInteger('jumlah_awal_jml');
            $table->bigInteger('memiliki_awal_lk');
            $table->bigInteger('memiliki_awal_pr');
            $table->bigInteger('memiliki_awal_jml');
            $table->bigInteger('belum_memiliki_awal_lk');
            $table->bigInteger('belum_memiliki_awal_pr');
            $table->bigInteger('belum_memiliki_awal_jml');
            $table->bigInteger('persen_awal');
            $table->bigInteger('usia_lebih_target_lk');
            $table->bigInteger('usia_lebih_target_pr');
            $table->bigInteger('usia_lebih_target_jml');
            $table->bigInteger('meninggal_lk');
            $table->bigInteger('meninggal_pr');
            $table->bigInteger('meninggal_jml');
            $table->bigInteger('nonaktif_lk');
            $table->bigInteger('nonaktif_pr');
            $table->bigInteger('nonaktif_jml');
            $table->bigInteger('memiliki_dalam_dkb_lk');
            $table->bigInteger('memiliki_dalam_dkb_pr');
            $table->bigInteger('memiliki_dalam_dkb_jml');
            $table->bigInteger('memiliki_luar_dkb_lk');
            $table->bigInteger('memiliki_luar_dkb_pr');
            $table->bigInteger('memiliki_luar_dkb_jml');
            $table->bigInteger('jumlah_dinamis_lk');
            $table->bigInteger('jumlah_dinamis_pr');
            $table->bigInteger('jumlah_dinamis_ttl');
            $table->bigInteger('memiliki_dinamis_lk');
            $table->bigInteger('memiliki_dinamis_pr');
            $table->bigInteger('memiliki_dinamis_jml');
            $table->bigInteger('belum_memiliki_dinamis_lk');
            $table->bigInteger('belum_memiliki_dinamis_pr');
            $table->bigInteger('belum_memiliki_dinamis_jml');
            $table->bigInteger('persen_dinamis');
            $table->bigInteger('penambahan_lk');
            $table->bigInteger('penambahan_pr');
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
        Schema::dropIfExists('kia');
    }
};
