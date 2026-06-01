<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Membuat kolom 'keterangan' menjadi nullable pada tabel-tabel yang
 * import class-nya tidak mengirimkan nilai keterangan dari file Excel.
 *
 * Tabel terdampak:
 *  - status_kawin_penduduk_jenis_kelamin
 *
 * Tabel lain yang punya keterangan sudah ditangani di import class-nya
 * masing-masing (data keterangan memang ada di file Excel-nya).
 */
return new class extends Migration
{
    public function up(): void
    {
        // status_kawin_penduduk_jenis_kelamin — import tidak mengirim keterangan
        Schema::table('status_kawin_penduduk_jenis_kelamin', function (Blueprint $table) {
            $table->string('keterangan', 50)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('status_kawin_penduduk_jenis_kelamin', function (Blueprint $table) {
            $table->string('keterangan', 50)->nullable(false)->change();
        });
    }
};
