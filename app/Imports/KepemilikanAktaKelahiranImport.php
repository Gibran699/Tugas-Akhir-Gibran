<?php

namespace App\Imports;


use App\Imports\Concerns\ImportReconciliationTrait;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

use App\Models\Kepemilikan\AktaKelahiran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Str;

class KepemilikanAktaKelahiranImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, SkipsOnFailure, SkipsOnError, SkipsEmptyRows, WithValidation{
    use ImportReconciliationTrait;


    protected $tahun;
    protected $semester;

    public function __construct($tahun, $semester)
    {
        $this->tahun = $tahun;
        $this->semester = $semester;
    }

    public function model(array $row)
    {
        // ── Skip baris kosong / tidak lengkap ───────────────────────────────
        // Beberapa file Excel punya baris kosong di akhir atau baris dengan
        // kolom wajib tidak terisi. Lewati baris seperti ini agar tidak
        // memicu error DB "cannot be null".
        $kodeWilayah = trim((string) ($row['kode_wilayah'] ?? ''));
        $keterangan  = trim((string) ($row['keterangan'] ?? ''));

        // Bersihkan format kode wilayah — buang titik pemisah
        // Beberapa file Excel pakai format "64.72.04.1014",
        // database simpan tanpa titik: "6472041014".
        $kodeWilayah = str_replace('.', '', $kodeWilayah);

        if ($kodeWilayah === '') {
            // Baris kosong / tidak ada kode wilayah → lewati
            return null;
        }

        if ($keterangan === '') {
            // Baris punya kode wilayah tapi keterangan kosong — log dan lewati
            \Log::warning("Akta Kelahiran Import: baris dengan kode_wilayah={$kodeWilayah} dilewati karena 'keterangan' kosong.");
            return null;
        }

        $categoryAktaKelahiranOwnerShip = config('dataArray.categoryAktaKelahiranOwnerShip');
        $data = [
            'uuid'         => Str::uuid(),
            'semester'     => $this->semester,
            'tahun'        => $this->tahun,
            'kode_wilayah' => $kodeWilayah,
            'keterangan'   => $keterangan,
        ];
        foreach ($categoryAktaKelahiranOwnerShip as $key) {
            // Cell kosong di Excel → default 0 (kolom angka tidak boleh null)
            $val = $row[$key] ?? null;
            $data[$key] = ($val === null || $val === '') ? 0 : $val;
        }
        return new AktaKelahiran($data);
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function batchSize(): int
    {
        return 100;
    }
}
