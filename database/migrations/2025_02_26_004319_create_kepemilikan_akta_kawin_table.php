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
            $table->bigInteger('muslim_jml');
            $table->bigInteger('non_muslim_jml');
            $table->bigInteger('status_kawin_lk');
            $table->bigInteger('status_kawin_pr');
            $table->bigInteger('status_kawin_jml');
            $table->bigInteger('memiliki_akta_kawin_lk');
            $table->bigInteger('memiliki_akta_kawin_pr');
            $table->bigInteger('memiliki_akta_kawin_jml');
            $table->bigInteger('belum_memiliki_akta_kawin_jml');
            $table->bigInteger('persen_memiliki');
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
