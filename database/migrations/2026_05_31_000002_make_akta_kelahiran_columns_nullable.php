<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Membuat semua kolom angka di tabel `akta_kelahiran` menjadi nullable
 * dengan default 0. File Excel impor sering punya cell kosong untuk
 * kolom yang tidak relevan (misal usia_lebih_dari_target untuk kategori 0-1
 * tidak masuk akal). Tanpa nullable, insert akan gagal dengan error
 * "Column 'xxx' cannot be null".
 */
return new class extends Migration
{
    private array $numericColumns = [
        'wajib_akta_awal_lk', 'wajib_akta_awal_pr', 'wajib_akta_awal_jml',
        'memiliki_awal_lk', 'memiliki_awal_pr', 'memiliki_awal_jml',
        'belum_memiliki_awal_lk', 'belum_memiliki_awal_pr', 'belum_memiliki_awal_jml',
        'usia_lebih_dari_target_lk', 'usia_lebih_dari_target_pr', 'usia_lebih_dari_target_jml',
        'meninggal_lk', 'meninggal_pr', 'meninggal_jml',
        'nonaktif_lk', 'nonaktif_pr', 'nonaktif_jml',
        'pindah_lk', 'pindah_pr', 'pindah_jml',
        'datang_lk', 'datang_pr', 'datang_jml',
        'hapus_operator_lk', 'hapus_operator_pr', 'hapus_operator_jml',
        'terbit_akta_baru_dalam_dkb_lk', 'terbit_akta_baru_dalam_dkb_pr', 'terbit_akta_baru_dalam_dkb_jml',
        'terbit_akta_baru_luar_dkb_lk', 'terbit_akta_baru_luar_dkb_pr', 'terbit_akta_baru_luar_dkb_jml',
        'wajib_akta_dinamis_lk', 'wajib_akta_dinamis_pr', 'wajib_akta_dinamis_jml',
        'memiliki_dinamis_lk', 'memiliki_dinamis_pr', 'memiliki_dinamis_jml',
        'belum_memiliki_dinamis_lk', 'belum_memiliki_dinamis_pr', 'belum_memiliki_dinamis_jml',
        'penambahan_lk', 'penambahan_pr', 'penambahan_jml',
    ];

    public function up(): void
    {
        // Pakai raw SQL agar tidak butuh package doctrine/dbal
        foreach ($this->numericColumns as $col) {
            DB::statement("ALTER TABLE `akta_kelahiran` MODIFY `{$col}` BIGINT NULL DEFAULT 0");
        }
        // Kolom keterangan juga dibuat nullable supaya baris dengan keterangan
        // kosong tidak langsung memicu error fatal — sudah ada validasi di import class.
        DB::statement("ALTER TABLE `akta_kelahiran` MODIFY `keterangan` VARCHAR(225) NULL");
    }

    public function down(): void
    {
        foreach ($this->numericColumns as $col) {
            DB::statement("ALTER TABLE `akta_kelahiran` MODIFY `{$col}` BIGINT NOT NULL");
        }
        DB::statement("ALTER TABLE `akta_kelahiran` MODIFY `keterangan` VARCHAR(225) NOT NULL");
    }
};
