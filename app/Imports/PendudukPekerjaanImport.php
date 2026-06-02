<?php

namespace App\Imports;

use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\AgregatDKB\Penduduk\Pekerjaan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Str;

class PendudukPekerjaanImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue
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
        // Excel mengandung spasi seperti "duta_besar _p") menjadi single
        // underscore agar cocok dengan nama kolom di database.
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

        // Bersihkan kode wilayah dari titik (auto-cleanup format lama)
        $kodeWilayah = str_replace(['.', ' '], '', (string) $kodeWilayah);

        $categoryJob = config('dataArray.categoryJob');
        $data = [
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $kodeWilayah,
        ];

        foreach ($categoryJob as $key) {
            // Default ke 0 supaya tidak melanggar NOT NULL constraint
            $value = $row[$key] ?? 0;
            $data[$key] = is_numeric($value) ? (int) $value : 0;
        }

        return new Pekerjaan($data);
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
