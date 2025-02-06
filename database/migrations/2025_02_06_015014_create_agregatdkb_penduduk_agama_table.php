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
        Schema::create('agama_penduduk', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kode_wilayah', 50);
            $table->integer('Islam_LK');
            $table->integer('Islam_PR');
            $table->integer('Islam_JML');
            $table->integer('Kristen_LK');
            $table->integer('Kristen_PR');
            $table->integer('Kristen_JML');
            $table->integer('Katolik_LK');
            $table->integer('Katolik_PR');
            $table->integer('Katolik_JML');
            $table->integer('Hindu_LK');
            $table->integer('Hindu_PR');
            $table->integer('Hindu_JML');
            $table->integer('Budha_LK');
            $table->integer('Budha_PR');
            $table->integer('Budha_JML');
            $table->integer('Konghucu_LK');
            $table->integer('Konghucu_PR');
            $table->integer('Konghucu_JML');
            $table->integer('Kepercayaan_LK');
            $table->integer('Kepercayaan_PR');
            $table->integer('Kepercayaan_JML');
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
        Schema::dropIfExists('agama_penduduk');
    }
};
