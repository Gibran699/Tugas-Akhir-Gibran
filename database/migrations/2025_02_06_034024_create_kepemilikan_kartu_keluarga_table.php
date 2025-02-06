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
            $table->integer('KK_LK');
            $table->integer('KK_PR');
            $table->integer('KK_JML');
            $table->integer('MEMILIKI_LK');
            $table->integer('MEMILIKI_PR');
            $table->integer('MEMILIKI_JML');
            $table->integer('BELUM_MEMILIKI_LK');
            $table->integer('BELUM_MEMILIKI_PR');
            $table->integer('BELUM_MEMILIKI_JML');
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
