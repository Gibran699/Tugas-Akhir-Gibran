<?php

namespace App\Imports;


use App\Imports\Concerns\ImportReconciliationTrait;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

use App\Models\AgregatDKB\StatusKawin\JenisKelamin;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Str;

class StatusKawinPendudukJenisKelaminImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, SkipsOnFailure, SkipsOnError, SkipsEmptyRows, WithValidation{
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
        // Normalisasi key: rapatkan double underscore akibat header bersepasi
        $normalized = [];
        foreach ($row as $key => $value) {
            $cleanKey = preg_replace('/_+/', '_', $key);
            $cleanKey = trim($cleanKey, '_');
            $normalized[$cleanKey] = $value;
        }
        $row = $normalized;

        // Lewati baris kosong
        $kodeWilayah = $row['kode_wilayah'] ?? null;
        if (empty($kodeWilayah)) {
            return null;
        }

        // Auto-cleanup titik di kode wilayah
        $kodeWilayah = str_replace(['.', ' '], '', (string) $kodeWilayah);

        // Helper: aman ambil integer (null/non-numeric → 0)
        $intVal = function ($v) {
            return is_numeric($v) ? (int) $v : 0;
        };

        // Template tidak punya kolom keterangan, tapi DB lama kolomnya NOT NULL.
        // Default ke '-' supaya aman meski migration nullable belum dijalankan.
        $keterangan = $row['keterangan'] ?? null;
        if ($keterangan === null || $keterangan === '') {
            $keterangan = '-';
        }

        return new JenisKelamin([
            'uuid'           => Str::uuid(),
            'semester'       => $this->semester,
            'tahun'          => $this->tahun,
            'kode_wilayah'   => $kodeWilayah,
            'keterangan'     => $keterangan,
            'belum_kawin_lk' => $intVal($row['belum_kawin_lk'] ?? 0),
            'belum_kawin_pr' => $intVal($row['belum_kawin_pr'] ?? 0),
            'kawin_lk'       => $intVal($row['kawin_lk'] ?? 0),
            'kawin_pr'       => $intVal($row['kawin_pr'] ?? 0),
            'cerai_hidup_lk' => $intVal($row['cerai_hidup_lk'] ?? 0),
            'cerai_hidup_pr' => $intVal($row['cerai_hidup_pr'] ?? 0),
            'cerai_mati_lk'  => $intVal($row['cerai_mati_lk'] ?? 0),
            'cerai_mati_pr'  => $intVal($row['cerai_mati_pr'] ?? 0),
        ]);
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
