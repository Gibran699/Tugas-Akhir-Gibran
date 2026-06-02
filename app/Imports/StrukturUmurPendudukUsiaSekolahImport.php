<?php

namespace App\Imports;


use App\Imports\Concerns\ImportReconciliationTrait;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;

use App\Models\StrukturUmur\Penduduk\UsiaSekolah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Str;

class StrukturUmurPendudukUsiaSekolahImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, SkipsEmptyRows, SkipsOnFailure, SkipsOnError, WithValidation{
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
        // Skip baris kosong atau baris total/footer (kode_wilayah tidak ada)
        if (empty($row['kode_wilayah'])) {
            return null;
        }

        return new UsiaSekolah([
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
            'usia_sd_sederajat' => isset($row['usia_sd_sederajat']) && $row['usia_sd_sederajat'] !== '' ? (int) $row['usia_sd_sederajat'] : 0,
            'usia_sltp_sederajat' => isset($row['usia_sltp_sederajat']) && $row['usia_sltp_sederajat'] !== '' ? (int) $row['usia_sltp_sederajat'] : 0,
            'usia_slta_sederajat' => isset($row['usia_slta_sederajat']) && $row['usia_slta_sederajat'] !== '' ? (int) $row['usia_slta_sederajat'] : 0,
            'usia_perguruan_tinggi' => isset($row['usia_perguruan_tinggi']) && $row['usia_perguruan_tinggi'] !== '' ? (int) $row['usia_perguruan_tinggi'] : 0,
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
