<?php

namespace App\Imports;

use App\Models\AgregatDKB\Pendidikan\Pekerjaan as PendidikanPekerjaan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Str;

class PendidikanPekerjaanImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts
{
    protected $tahun;
    protected $semester;

    public function __construct($tahun, $semester)
    {
        $this->tahun = $tahun;
        $this->semester = $semester;
    }

    public function model(array $row)
    {
        // Normalisasi key row: rapatkan double underscore (akibat header
        // Excel yang mengandung spasi seperti "duta_besar _p") supaya
        // cocok dengan nama kolom di database.
        $normalized = [];
        foreach ($row as $key => $value) {
            $cleanKey = preg_replace('/_+/', '_', $key);
            $cleanKey = trim($cleanKey, '_');
            $normalized[$cleanKey] = $value;
        }
        $row = $normalized;

        // Lewati baris kosong (tidak ada kode wilayah)
        $kodeWilayah = $row['kode_wilayah'] ?? null;
        if (empty($kodeWilayah)) {
            return null;
        }

        // Auto-cleanup titik di kode wilayah
        $kodeWilayah = str_replace(['.', ' '], '', (string) $kodeWilayah);

        // Pendidikan kosong → default '-'
        $pendidikan = $row['pendidikan'] ?? null;
        if ($pendidikan === null || $pendidikan === '') {
            $pendidikan = '-';
        }

        $categoryJob = config('dataArray.categoryJob');
        $data = [
            'uuid'         => Str::uuid(),
            'semester'     => $this->semester,
            'tahun'        => $this->tahun,
            'kode_wilayah' => $kodeWilayah,
            'pendidikan'   => $pendidikan,
        ];

        foreach ($categoryJob as $key) {
            // Default 0 supaya aman dari NOT NULL constraint
            $value = $row[$key] ?? 0;
            $data[$key] = is_numeric($value) ? (int) $value : 0;
        }

        return new PendidikanPekerjaan($data);
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function batchSize(): int
    {
        return 50;
    }
}
