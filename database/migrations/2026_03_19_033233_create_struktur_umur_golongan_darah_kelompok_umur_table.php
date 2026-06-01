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
        Schema::create('kelompok_umur_golongan_darah', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kode_wilayah');
            $table->string('kelompok_umur');
            $blood = config('dataArray.categoryBlood');
            foreach ($blood as $item) {
                $table->bigInteger($item);
            }
            $table->bigInteger('semester');
            $table->bigInteger('tahun');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('struktur_umur_golongan_darah_kelompok_umur');
    }
};
