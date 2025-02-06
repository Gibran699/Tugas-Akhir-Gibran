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
            $table->integer('JUMLAH_AWAL_LK');
            $table->integer('JUMLAH_AWAL_PR');
            $table->integer('JUMLAH_AWAL_JML');
            $table->integer('MEMILIKI_AWAL_LK');
            $table->integer('MEMILIKI_AWAL_PR');
            $table->integer('MEMILIKI_AWAL_JML');
            $table->integer('BELUM_MEMILIKI_AWAL_LK');
            $table->integer('BELUM_MEMILIKI_AWAL_PR');
            $table->integer('BELUM_MEMILIKI_AWAL_JML');
            $table->integer('PERSEN_AWAL');
            $table->integer('USIA_LEBIH_TARGET_LK');
            $table->integer('USIA_LEBIH_TARGET_PR');
            $table->integer('USIA_LEBIH_TARGET_JML');
            $table->integer('MENINGGAL_LK');
            $table->integer('MENINGGAL_PR');
            $table->integer('MENINGGAL_JML');
            $table->integer('NONAKTIF_LK');
            $table->integer('NONAKTIF_PR');
            $table->integer('NONAKTIF_JML');
            $table->integer('MEMILIKI_DALAM_DKB_LK');
            $table->integer('MEMILIKI_DALAM_DKB_PR');
            $table->integer('MEMILIKI_DALAM_DKB_JML');
            $table->integer('MEMILIKI_LUAR_DKB_LK');
            $table->integer('MEMILIKI_LUAR_DKB_PR');
            $table->integer('MEMILIKI_LUAR_DKB_JML');
            $table->integer('JUMLAH_DINAMIS_LK');
            $table->integer('JUMLAH_DINAMIS_PR');
            $table->integer('JUMLAH_DINAMIS_TTL');
            $table->integer('MEMILIKI_DINAMIS_LK');
            $table->integer('MEMILIKI_DINAMIS_PR');
            $table->integer('MEMILIKI_DINAMIS_JML');
            $table->integer('BELUM_MEMILIKI_DINAMIS_LK');
            $table->integer('BELUM_MEMILIKI_DINAMIS_PR');
            $table->integer('BELUM_MEMILIKI_DINAMIS_JML');
            $table->integer('PERSEN_DINAMIS');
            $table->integer('PENAMBAHAN_LK');
            $table->integer('PENAMBAHAN_PR');
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
