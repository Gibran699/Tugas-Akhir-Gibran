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
        Schema::create('jenis_kelamin_disabilitas', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kode_wilayah');
            $table->bigInteger('disabilitas_fisik_lk');
            $table->bigInteger('disabilitas_fisik_pr');
            $table->bigInteger('disabilitas_fisik_jml');
            $table->bigInteger('disabilitas_netra_buta_lk');
            $table->bigInteger('disabilitas_netra_buta_pr');
            $table->bigInteger('disabilitas_netra_buta_jml');
            $table->bigInteger('disabilitas_rungu_wicara_lk');
            $table->bigInteger('disabilitas_rungu_wicara_pr');
            $table->bigInteger('disabilitas_rungu_wicara_jml');
            $table->bigInteger('disabilitas_mental_jiwa_lk');
            $table->bigInteger('disabilitas_mental_jiwa_pr');
            $table->bigInteger('disabilitas_mental_jiwa_jml');
            $table->bigInteger('disabilitas_fisik_mental_lk');
            $table->bigInteger('disabilitas_fisik_mental_pr');
            $table->bigInteger('disabilitas_fisik_mental_jml');
            $table->bigInteger('disabilitas_lainnya_lk');
            $table->bigInteger('disabilitas_lainnya_pr');
            $table->bigInteger('disabilitas_lainnya_jml');
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
        Schema::dropIfExists('jenis_kelamin_disabilitas');
    }
};
