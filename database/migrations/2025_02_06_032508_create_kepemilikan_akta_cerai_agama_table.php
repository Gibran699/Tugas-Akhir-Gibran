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
            $table->integer('ISLAM_MEMILIKI_LK');
            $table->integer('ISLAM_MEMILIKI_PR');
            $table->integer('ISLAM_MEMILIKI_JML');
            $table->integer('ISLAM_BLM_MEMILIKI_JML');
            $table->integer('KRISTEN_MEMILIKI_LK');
            $table->integer('KRISTEN_MEMILIKI_PR');
            $table->integer('KRISTEN_MEMILIKI_JML');
            $table->integer('KRISTEN_BLM_MEMILIKI_JML');
            $table->integer('KATHOLIK_MEMILIKI_LK');
            $table->integer('KATHOLIK_MEMILIKI_PR');
            $table->integer('KATHOLIK_MEMILIKI_JML');
            $table->integer('KATHOLIK_BLM_MEMILIKI_JML');
            $table->integer('HINDU_MEMILIKI_LK');
            $table->integer('HINDU_MEMILIKI_PR');
            $table->integer('HINDU_MEMILIKI_JML');
            $table->integer('HINDU_BLM_MEMILIKI_JML');
            $table->integer('BUDHA_MEMILIKI_LK');
            $table->integer('BUDHA_MEMILIKI_PR');
            $table->integer('BUDHA_MEMILIKI_JML');
            $table->integer('BUDHA_BLM_MEMILIKI_JML');
            $table->integer('KHONGHUCU_MEMILIKI_LK');
            $table->integer('KHONGHUCU_MEMILIKI_PR');
            $table->integer('KHONGHUCU_MEMILIKI_JML');
            $table->integer('KHONGHUCU_BLM_MEMILIKI_JML');
            $table->integer('KEPERCAYAAN_MEMILIKI_LK');
            $table->integer('KEPERCAYAAN_MEMILIKI_PR');
            $table->integer('KEPERCAYAAN_MEMILIKI_JML');
            $table->integer('KEPERCAYAAN_BLM_MEMILIKI_JML');
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
