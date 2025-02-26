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
        Schema::create('pendidikan_disabilitas', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kode_wilayah', 50);
            $table->bigInteger('tidak_blm_sekolah_l');
            $table->bigInteger('tidak_blm_sekolah_p');
            $table->bigInteger('tidak_blm_sekolah_jml');
            $table->bigInteger('belum_tamat_sd_sederajat_l');
            $table->bigInteger('belum_tamat_sd_sederajat_p');
            $table->bigInteger('belum_tamat_sd_sederajat_jml');
            $table->bigInteger('tamat_sd_sederajat_l');
            $table->bigInteger('tamat_sd_sederajat_p');
            $table->bigInteger('tamat_sd_sederajat_jml');
            $table->bigInteger('sltp_sederajat_l');
            $table->bigInteger('sltp_sederajat_p');
            $table->bigInteger('sltp_sederajat_jml');
            $table->bigInteger('slta_sederajat_l');
            $table->bigInteger('slta_sederajat_p');
            $table->bigInteger('slta_sederajat_jml');
            $table->bigInteger('diploma_i_ii_l');
            $table->bigInteger('diploma_i_ii_p');
            $table->bigInteger('diploma_i_ii_jml');
            $table->bigInteger('akademi_dipl_iii_s_muda_l');
            $table->bigInteger('akademi_dipl_iii_s_muda_p');
            $table->bigInteger('akademi_dipl_iii_s_muda_jml');
            $table->bigInteger('diploma_iv_strata_i_l');
            $table->bigInteger('diploma_iv_strata_i_p');
            $table->bigInteger('diploma_iv_strata_i_jml');
            $table->bigInteger('strata_ii_l');
            $table->bigInteger('strata_ii_p');
            $table->bigInteger('strata_ii_jml');
            $table->bigInteger('strata_iii_l');
            $table->bigInteger('strata_iii_p');
            $table->bigInteger('strata_iii_jml');
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
        Schema::dropIfExists('pendidikan_disabilitas');
    }
};
