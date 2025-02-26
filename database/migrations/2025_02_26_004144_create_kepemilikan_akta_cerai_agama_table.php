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
        Schema::create('akta_cerai_agama', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kode_wilayah');
            $table->bigInteger('islam_memiliki_lk');
            $table->bigInteger('islam_memiliki_pr');
            $table->bigInteger('islam_memiliki_jml');
            $table->bigInteger('islam_blm_memiliki_jml');
            $table->bigInteger('kristen_memiliki_lk');
            $table->bigInteger('kristen_memiliki_pr');
            $table->bigInteger('kristen_memiliki_jml');
            $table->bigInteger('kristen_blm_memiliki_jml');
            $table->bigInteger('katholik_memiliki_lk');
            $table->bigInteger('katholik_memiliki_pr');
            $table->bigInteger('katholik_memiliki_jml');
            $table->bigInteger('katholik_blm_memiliki_jml');
            $table->bigInteger('hindu_memiliki_lk');
            $table->bigInteger('hindu_memiliki_pr');
            $table->bigInteger('hindu_memiliki_jml');
            $table->bigInteger('hindu_blm_memiliki_jml');
            $table->bigInteger('budha_memiliki_lk');
            $table->bigInteger('budha_memiliki_pr');
            $table->bigInteger('budha_memiliki_jml');
            $table->bigInteger('budha_blm_memiliki_jml');
            $table->bigInteger('khonghucu_memiliki_lk');
            $table->bigInteger('khonghucu_memiliki_pr');
            $table->bigInteger('khonghucu_memiliki_jml');
            $table->bigInteger('khonghucu_blm_memiliki_jml');
            $table->bigInteger('kepercayaan_memiliki_lk');
            $table->bigInteger('kepercayaan_memiliki_pr');
            $table->bigInteger('kepercayaan_memiliki_jml');
            $table->bigInteger('kepercayaan_blm_memiliki_jml');
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
        Schema::dropIfExists('akta_cerai_agama');
    }
};
