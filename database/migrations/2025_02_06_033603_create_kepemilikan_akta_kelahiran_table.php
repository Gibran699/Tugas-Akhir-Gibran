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
            $table->varchar('keterangan');
            $table->integer('WAJIB_AKTA_AWAL_LK');
            $table->integer('WAJIB_AKTA_AWAL_PR');
            $table->integer('WAJIB_AKTA_AWAL_JML');
            $table->integer('MEMILIKI_AWAL_LK');
            $table->integer('MEMILIKI_AWAL_PR');
            $table->integer('MEMILIKI_AWAL_JML');
            $table->integer('BELUM_MEMILIKI_AWAL_LK');
            $table->integer('BELUM_MEMILIKI_AWAL_PR');
            $table->integer('BELUM_MEMILIKI_AW_AL_LK');
            $table->integer('BELUM_MEMILIKI_AWAL_JML');
            $table->integer('PERSEN_AWAL');
            $table->integer('USIA_LEBIH_DARI_TARGET_LK');
            $table->integer('USIA_LEBIH_DARI_TARGET_PR');
            $table->integer('USIA_LEBIH_DARI_TARGET_JML');
            $table->integer('MENINGGAL_LK');
            $table->integer('MENINGGAL_PR');
            $table->integer('MENINGGAL_JML');
            $table->integer('NONAKTIF_LK');
            $table->integer('NONAKTIF_PR');
            $table->integer('NONAKTIF_JML');
            $table->integer('PINDAH_LK');
            $table->integer('PINDAH_PR');
            $table->integer('PINDAH_JML');
            $table->integer('DATANG_LK');
            $table->integer('DATANG_PR');
            $table->integer('DATANG_JML');
            $table->integer('Hapus_OPERATOR_LK');
            $table->integer('Hapus_OPERATOR_PR');
            $table->integer('Hapus_OPERATOR_JML');
            $table->integer('TERBIT_AKTA_BARU_DALAM_DKB_LK');
            $table->integer('TERBIT_AKTA_BARU_DALAM_DKB_PR');
            $table->integer('TERBIT_AKTA_BARU_DALAM_DKB_JML');
            $table->integer('TERBIT_AKTA_BARU_LUAR_DKB_LK');
            $table->integer('TERBIT_AKTA_BARU_LUAR_DKB_PR');
            $table->integer('TERBIT_AKTA_BARU_LUAR_DKB_JML');
            $table->integer('WAJIB_AKTA_DINAMIS_LK');
            $table->integer('WAJIB_AKTA_DINAMIS_PR');
            $table->integer('WAJIB_AKTA_DINAMIS_JML');
            $table->integer('MEMILIKI_DINAMIS_LK');
            $table->integer('MEMILIKI_DINAMIS_PR');
            $table->integer('MEMILIKI_DINAMIS_JML');
            $table->integer('BELUM_MEMILIKI_DINAMIS_LK');
            $table->integer('BELUM_MEMILIKI_DINAMIS_PR');
            $table->integer('BELUM_MEMILIKI_DINAMIS_JML');
            $table->integer('PERSEN_DINAMIS');
            $table->integer('PENAMBAHAN_LK');
            $table->integer('PENAMBAHAN_PR');
            $table->integer('PENAMBAHAN_JML');
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
