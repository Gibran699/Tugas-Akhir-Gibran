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
        Schema::create('pendidikan_umur_tunggal_disabilitas', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kode_wilayah');

            $categories = ['FISIK', 'NETRA_BUTA', 'RUNGU_WICARA', 'LAINNYA'];
            $education_levels = [
                'TIDAK_BLM_SEKOLAH', 'BELUM_TAMAT_SD_SEDERAJAT', 'TAMAT_SD_SEDERAJAT',
                'SLTP_SEDERAJAT', 'SLTA_SEDERAJAT', 'DIPLOMA_I_II',
                'AKADEMI_DIPLOMA_III_S_MUDA', 'DIPLOMA_IV_STRATA_I',
                'STRATA_II', 'STRATA_III'
            ];

            foreach ($categories as $category) {
                foreach ($education_levels as $level) {
                    $table->integer("{$category}_{$level}_L");
                    $table->integer("{$category}_{$level}_P");
                    $table->integer("{$category}_{$level}");
                }
            }

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
        Schema::dropIfExists('pendidikan_umur_tunggal_disabilitas');
    }
};
