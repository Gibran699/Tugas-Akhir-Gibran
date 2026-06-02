<?php

namespace App\Imports;


use App\Imports\Concerns\ImportReconciliationTrait;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

use App\Models\StrukturUmur\Penduduk\StatusKawinKelompokUmur;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Str;

class StrukturUmurPendudukStatusKawinKelompokUmurImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, SkipsOnFailure, SkipsOnError, SkipsEmptyRows, WithValidation{
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
        $categoryAgeGroupMarriageStatus = config('dataArray.categoryAgeGroupMarriageStatus');
        $data =[
            'uuid' => Str::uuid(),
            'tahun' => $this->tahun,
            'semester' => $this->semester,
            'kode_wilayah' => $row['kode_wilayah']
        ];
        foreach ($categoryAgeGroupMarriageStatus as $key) {
            $data[$key] = $row[$key] ?? null;
        }
        return new StatusKawinKelompokUmur($data);
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
