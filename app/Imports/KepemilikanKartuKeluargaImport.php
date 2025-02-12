<?php

namespace App\Imports;

use App\Models\Kepemilikan\KartuKeluarga;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class KepemilikanKartuKeluargaImport implements ToModel, WithHeadingRow
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
            'KK_LK' => $row['KK_LK'],
            'KK_PR' => $row['KK_PR'],
            'KK_JML' => $row['KK_JML'],
            'MEMILIKI_LK' => $row['MEMILIKI_LK'],
            'MEMILIKI_PR' => $row['MEMILIKI_PR'],
            'MEMILIKI_JML' => $row['MEMILIKI_JML'],
            'BELUM_MEMILIKI_LK' => $row['BELUM_MEMILIKI_LK'],
            'BELUM_MEMILIKI_PR' => $row['BELUM_MEMILIKI_PR'],
            'BELUM_MEMILIKI_JML' => $row['BELUM_MEMILIKI_JML'],
        ]);
    }
}
