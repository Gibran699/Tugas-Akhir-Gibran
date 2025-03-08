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
            $table->string('umur');

            $categories = ['fisik', 'netra_buta', 'rungu_wicara', 'lainnya'];
            $education_levels = [
                'tidak_blm_sekolah', 'belum_tamat_sd_sederajat', 'tamat_sd_sederajat',
                'sltp_sederajat', 'slta_sederajat', 'diploma_i_ii',
                'akademi_diploma_iii_s_muda', 'diploma_iv_strata_i',
                'strata_ii', 'strata_iii'
            ];

            foreach ($categories as $category) {
                foreach ($education_levels as $level) {
                    $table->bigInteger("{$category}_{$level}_l");
                    $table->bigInteger("{$category}_{$level}_p");
                    $table->bigInteger("{$category}_{$level}");
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
