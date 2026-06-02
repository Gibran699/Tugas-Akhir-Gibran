<?php

namespace App\Imports;


use App\Imports\Concerns\ImportReconciliationTrait;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

use App\Models\StrukturUmur\Penduduk\StatusKawinUmurTunggal;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Str;

class StrukturUmurPendudukStatusKawinUmurTunggalImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, SkipsOnFailure, SkipsOnError, SkipsEmptyRows, WithValidation{
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
        return new StatusKawinUmurTunggal([
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'umur' => $row['umur'],
            'kode_wilayah' => $row['kode_wilayah'],
            'belum_kawin_lk' => $row['belum_kawin_lk'],
            'belum_kawin_pr' => $row['belum_kawin_pr'],
            'kawin_lk' => $row['kawin_lk'],
            'kawin_pr' => $row['kawin_pr'],
            'cerai_hidup_lk' => $row['cerai_hidup_lk'],
            'cerai_hidup_pr' => $row['cerai_hidup_pr'],
            'cerai_mati_lk' => $row['cerai_mati_lk'],
            'cerai_mati_pr' => $row['cerai_mati_pr'],
        ]);
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
