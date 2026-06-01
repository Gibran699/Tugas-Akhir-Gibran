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
            $table->bigInteger('wajib_akta_kawin_lk');
            $table->bigInteger('wajib_akta_kawin_pr');
            $table->bigInteger('wajib_akta_kawin_jml');
            $table->bigInteger('memiliki_akta_kawin_lk');
            $table->bigInteger('memiliki_akta_kawin_pr');
            $table->bigInteger('memiliki_akta_kawin_jml');
            $table->bigInteger('belum_memiliki_akta_kawin_lk');
            $table->bigInteger('belum_memiliki_akta_kawin_pr');
            $table->bigInteger('belum_memiliki_akta_kawin_jml');
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
