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
        Schema::create('umur_tunggal_kepala_keluarga', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('kode_wilayah', 50);
            $table->integer('lk');
            $table->integer('pr');
            $table->integer('jumlah');
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
        Schema::dropIfExists('umur_tunggal_kepala_keluarga');
    }
};
