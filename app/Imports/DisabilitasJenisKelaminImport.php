<?php

namespace App\Imports;


use App\Imports\Concerns\ImportReconciliationTrait;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

use App\Models\AgregatDKB\Disabilitas\JenisKelamin;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class DisabilitasJenisKelaminImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, SkipsOnFailure, SkipsOnError, SkipsEmptyRows, WithValidation{
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
        return new JenisKelamin([
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
            'disabilitas_fisik_lk' => $row['disabilitas_fisik_lk'],
            'disabilitas_fisik_pr' => $row['disabilitas_fisik_pr'],
            'disabilitas_fisik_jml' => $row['disabilitas_fisik_jml'],
            'disabilitas_netra_buta_lk' => $row['disabilitas_netra_buta_lk'],
            'disabilitas_netra_buta_pr' => $row['disabilitas_netra_buta_pr'],
            'disabilitas_netra_buta_jml' => $row['disabilitas_netra_buta_jml'],
            'disabilitas_rungu_wicara_lk' => $row['disabilitas_rungu_wicara_lk'],
            'disabilitas_rungu_wicara_pr' => $row['disabilitas_rungu_wicara_pr'],
            'disabilitas_rungu_wicara_jml' => $row['disabilitas_rungu_wicara_jml'],
            'disabilitas_mental_jiwa_lk' => $row['disabilitas_mental_jiwa_lk'],
            'disabilitas_mental_jiwa_pr' => $row['disabilitas_mental_jiwa_pr'],
            'disabilitas_mental_jiwa_jml' => $row['disabilitas_mental_jiwa_jml'],
            'disabilitas_fisik_mental_lk' => $row['disabilitas_fisik_mental_lk'],
            'disabilitas_fisik_mental_pr' => $row['disabilitas_fisik_mental_pr'],
            'disabilitas_fisik_mental_jml' => $row['disabilitas_fisik_mental_jml'],
            'disabilitas_lainnya_lk' => $row['disabilitas_lainnya_lk'],
            'disabilitas_lainnya_pr' => $row['disabilitas_lainnya_pr'],
            'disabilitas_lainnya_jml' => $row['disabilitas_lainnya_jml'],
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
