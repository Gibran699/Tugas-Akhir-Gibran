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
        Schema::create('pendidikan_kepala_keluarga', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kode_wilayah', 50);
            $table->integer('TIDAK_BLM_SEKOLAH_L');
            $table->integer('TIDAK_BLM_SEKOLAH_P');
            $table->integer('TIDAK_BLM_SEKOLAH_JML');
            $table->integer('BELUM_TAMAT_SD_SEDERAJAT_L');
            $table->integer('BELUM_TAMAT_SD_SEDERAJAT_P');
            $table->integer('BELUM_TAMAT_SD_SEDERAJAT_JML');
            $table->integer('TAMAT_SD_SEDERAJAT_L');
            $table->integer('TAMAT_SD_SEDERAJAT_P');
            $table->integer('TAMAT_SD_SEDERAJAT_JML');
            $table->integer('SLTP_SEDERAJAT_L');
            $table->integer('SLTP_SEDERAJAT_P');
            $table->integer('SLTP_SEDERAJAT_JML');
            $table->integer('SLTA_SEDERAJAT_L');
            $table->integer('SLTA_SEDERAJAT_P');
            $table->integer('SLTA_SEDERAJAT_JML');
            $table->integer('DIPLOMA_I_II_L');
            $table->integer('DIPLOMA_I_II_P');
            $table->integer('DIPLOMA_I_II_JML');
            $table->integer('AKADEMI_DIPL_III_S_MUDA_L');
            $table->integer('AKADEMI_DIPL_III_S_MUDA_P');
            $table->integer('AKADEMI_DIPL_III_S_MUDA_JML');
            $table->integer('DIPLOMA_IV_STRATA_I_L');
            $table->integer('DIPLOMA_IV_STRATA_I_P');
            $table->integer('DIPLOMA_IV_STRATA_I_JML');
            $table->integer('STRATA_II_L');
            $table->integer('STRATA_II_P');
            $table->integer('STRATA_II_JML');
            $table->integer('STRATA_III_L');
            $table->integer('STRATA_III_P');
            $table->integer('STRATA_III_JML');
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
        Schema::dropIfExists('pendidikan_kepala_keluarga');
    }
};
