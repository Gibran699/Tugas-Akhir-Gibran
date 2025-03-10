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
            'muslim_jml' => $row['muslim_jml'],
            'non_muslim_jml' => $row['non_muslim_jml'],
            'status_cerai_lk' => $row['status_cerai_lk'],
            'status_cerai_pr' => $row['status_cerai_pr'],
            'status_cerai_jml' => $row['status_cerai_jml'],
            'memiliki_akta_cerai_lk' => $row['memiliki_akta_cerai_lk'],
            'memiliki_akta_cerai_pr' => $row['memiliki_akta_cerai_pr'],
            'memiliki_akta_cerai_jml' => $row['memiliki_akta_cerai_jml'],
            'belum_memiliki_akta_cerai_jml' => $row['belum_memiliki_akta_cerai_jml'],
            'persen_memiliki' => $row['persen_memiliki'],
        ]);
    }
}
