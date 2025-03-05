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
        Schema::create('golongan_darah_pendidikan', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kode_wilayah', 50);
            $table->string('keterangan', 70);
            $table->bigInteger('a_lk');
            $table->bigInteger('a_pr');
            $table->bigInteger('a_jml');
            $table->bigInteger('a_m_lk');
            $table->bigInteger('a_m_pr');
            $table->bigInteger('a_m_jml');
            $table->bigInteger('a_p_lk');
            $table->bigInteger('a_p_pr');
            $table->bigInteger('a_p_jml');
            $table->bigInteger('b_lk');
            $table->bigInteger('b_pr');
            $table->bigInteger('b_jml');
            $table->bigInteger('b_m_lk');
            $table->bigInteger('b_m_pr');
            $table->bigInteger('b_m_jml');
            $table->bigInteger('b_p_lk');
            $table->bigInteger('b_p_pr');
            $table->bigInteger('b_p_jml');
            $table->bigInteger('ab_lk');
            $table->bigInteger('ab_pr');
            $table->bigInteger('ab_jml');
            $table->bigInteger('ab_m_lk');
            $table->bigInteger('ab_m_pr');
            $table->bigInteger('ab_m_jml');
            $table->bigInteger('ab_p_lk');
            $table->bigInteger('ab_p_pr');
            $table->bigInteger('ab_p_jml');
            $table->bigInteger('o_lk');
            $table->bigInteger('o_pr');
            $table->bigInteger('o_jml');
            $table->bigInteger('o_m_lk');
            $table->bigInteger('o_m_pr');
            $table->bigInteger('o_m_jml');
            $table->bigInteger('o_p_lk');
            $table->bigInteger('o_p_pr');
            $table->bigInteger('o_p_jml');
            $table->bigInteger('tidak_tahu_lk');
            $table->bigInteger('tidak_tahu_pr');
            $table->bigInteger('tidak_tahu_jml');
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
        Schema::dropIfExists('golongan_darah_pendidikan');
    }
};
