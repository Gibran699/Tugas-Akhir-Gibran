<?php

namespace App\Imports;

use App\Models\Kepemilikan\KartuKeluarga;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Str;

class KepemilikanKartuKeluargaImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts
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
        return new KartuKeluarga([
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
            'kk_lk' => $row['kk_lk'],
            'kk_pr' => $row['kk_pr'],
            'kk_jml' => $row['kk_jml'],
            'memiliki_lk' => $row['memiliki_lk'],
            'memiliki_pr' => $row['memiliki_pr'],
            'memiliki_jml' => $row['memiliki_jml'],
            'belum_memiliki_lk' => $row['belum_memiliki_lk'],
            'belum_memiliki_pr' => $row['belum_memiliki_pr'],
            'belum_memiliki_jml' => $row['belum_memiliki_jml'],
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
