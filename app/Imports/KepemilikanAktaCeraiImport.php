<?php

namespace App\Imports;

use App\Models\Kepemilikan\AktaCerai;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KepemilikanAktaCeraiImport implements ToModel, WithHeadingRow
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
            'MUSLIM_JML' => $row['MUSLIM_JML'],
            'NON_MUSLIM_JML' => $row['NON_MUSLIM_JML'],
            'STATUS_CERAI_LK' => $row['STATUS_CERAI_LK'],
            'STATUS_CERAI_PR' => $row['STATUS_CERAI_PR'],
            'STATUS_CERAI_JML' => $row['STATUS_CERAI_JML'],
            'MEMILIKI_AKTA_CERAI_LK' => $row['MEMILIKI_AKTA_CERAI_LK'],
            'MEMILIKI_AKTA_CERAI_PR' => $row['MEMILIKI_AKTA_CERAI_PR'],
            'MEMILIKI_AKTA_CERAI_JML' => $row['MEMILIKI_AKTA_CERAI_JML'],
            'BELUM_MEMILIKI_AKTA_CERAI_JML' => $row['BELUM_MEMILIKI_AKTA_CERAI_JML'],
            'PERSEN_MEMILIKI' => $row['PERSEN_MEMILIKI'],
        ]);
    }
}
