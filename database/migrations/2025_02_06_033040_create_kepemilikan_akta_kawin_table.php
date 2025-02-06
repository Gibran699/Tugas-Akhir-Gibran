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
        Schema::create('akta_kawin', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('kode_wilayah');
            $table->integer('MUSLIM_JML');
            $table->integer('NON_MUSLIM_JML');
            $table->integer('STATUS_KAWIN_LK');
            $table->integer('STATUS_KAWIN_PR');
            $table->integer('STATUS_KAWIN_JML');
            $table->integer('MEMILIKI_AKTA_KAWIN_LK');
            $table->integer('MEMILIKI_AKTA_KAWIN_PR');
            $table->integer('MEMILIKI_AKTA_KAWIN_JML');
            $table->integer('BELUM_MEMILIKI_AKTA_KAWIN_JML');
            $table->integer('PERSEN_MEMILIKI');
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
        Schema::dropIfExists('akta_kawin');
    }
};
