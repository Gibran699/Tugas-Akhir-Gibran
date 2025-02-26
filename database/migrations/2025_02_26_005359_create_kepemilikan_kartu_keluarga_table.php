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
        Schema::create('kartu_keluarga', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kode_wilayah');
            $table->bigInteger('kk_lk');
            $table->bigInteger('kk_pr');
            $table->bigInteger('kk_jml');
            $table->bigInteger('memiliki_lk');
            $table->bigInteger('memiliki_pr');
            $table->bigInteger('memiliki_jml');
            $table->bigInteger('belum_memiliki_lk');
            $table->bigInteger('belum_memiliki_pr');
            $table->bigInteger('belum_memiliki_jml');
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
        Schema::dropIfExists('kartu_keluarga');
    }
};
