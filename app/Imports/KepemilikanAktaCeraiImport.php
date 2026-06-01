<?php

namespace App\Imports;

use App\Models\Kepemilikan\AktaCerai;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class KepemilikanAktaCeraiImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts
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
        return new AktaCerai([
            'uuid' => Str::uuid(),
            'kode_wilayah' => $row['kode_wilayah'],
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'wajib_akta_cerai_lk' => $row['wajib_akta_cerai_lk'],
            'wajib_akta_cerai_pr' => $row['wajib_akta_cerai_pr'],
            'wajib_akta_cerai_jml' => $row['wajib_akta_cerai_jml'],
            'memiliki_akta_cerai_lk' => $row['memiliki_akta_cerai_lk'],
            'memiliki_akta_cerai_pr' => $row['memiliki_akta_cerai_pr'],
            'memiliki_akta_cerai_jml' => $row['memiliki_akta_cerai_jml'],
            'belum_memiliki_akta_cerai_jml' => $row['belum_memiliki_akta_cerai_jml'],
            'belum_memiliki_akta_cerai_pr' => $row['belum_memiliki_akta_cerai_pr'],
            'belum_memiliki_akta_cerai_lk' => $row['belum_memiliki_akta_cerai_lk'],
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
