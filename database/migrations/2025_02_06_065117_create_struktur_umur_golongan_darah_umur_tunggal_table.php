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
        Schema::create('umur_tunggal_golongan_darah', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kode_wilayah', 36);
            $table->integer('A_LK');
            $table->integer('A_PR');
            $table->integer('A_JML');
            $table->integer('A_M_LK');
            $table->integer('A_M_PR');
            $table->integer('A_M_JML');
            $table->integer('A_P_LK');
            $table->integer('A_P_PR');
            $table->integer('A_P_JML');
            $table->integer('B_LK');
            $table->integer('B_PR');
            $table->integer('B_JML');
            $table->integer('B_M_LK');
            $table->integer('B_M_PR');
            $table->integer('B_M_JML');
            $table->integer('B_P_LK');
            $table->integer('B_P_PR');
            $table->integer('B_P_JML');
            $table->integer('AB_LK');
            $table->integer('AB_PR');
            $table->integer('AB_JML');
            $table->integer('AB_M_LK');
            $table->integer('AB_M_PR');
            $table->integer('AB_M_JML');
            $table->integer('AB_P_LK');
            $table->integer('AB_P_PR');
            $table->integer('AB_P_JML');
            $table->integer('O_LK');
            $table->integer('O_PR');
            $table->integer('O_JML');
            $table->integer('O_M_LK');
            $table->integer('O_M_PR');
            $table->integer('O_M_JML');
            $table->integer('O_P_LK');
            $table->integer('O_P_PR');
            $table->integer('O_P_JML');
            $table->integer('TIDAK_TAHU_LK');
            $table->integer('TIDAK_TAHU_PR');
            $table->integer('TIDAK_TAHU_JML');
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
        Schema::dropIfExists('umur_tunggal_golongan_darah');
    }
};
