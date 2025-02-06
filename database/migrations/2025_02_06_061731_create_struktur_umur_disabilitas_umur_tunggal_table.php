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
        Schema::create('umur_tunggal_disabilitas', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kode_wilayah');
            $table->integer('umur');
            $table->integer('Disabiltas_Fisik_LK');
            $table->integer('Disabiltas_Fisik_PR');
            $table->integer('Disabiltas_Fisik_JML');
            $table->integer('Disabiltas_Netra_Buta_LK');
            $table->integer('Disabiltas_Netra_Buta_PR');
            $table->integer('Disabiltas_Netra_Buta_JML');
            $table->integer('Disabiltas_Rungu_Wicara_LK');
            $table->integer('Disabiltas_Rungu_Wicara_PR');
            $table->integer('Disabiltas_Rungu_Wicara_JML');
            $table->integer('Disabiltas_Mental_Jiwa_LK');
            $table->integer('Disabiltas_Mental_Jiwa_PR');
            $table->integer('Disabiltas_Mental_Jiwa_JML');
            $table->integer('Disabiltas_Fisik_Mental_LK');
            $table->integer('Disabiltas_Fisik_Mental_PR');
            $table->integer('Disabiltas_Fisik_Mental_JML');
            $table->integer('Disabiltas_Lainya_LK');
            $table->integer('Disabiltas_Lainya_PR');
            $table->integer('Disabiltas_Lainya_JML');
            $table->string('semester');
            $table->year('tahun');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umur_tunggal_disabilitas');
    }
};
