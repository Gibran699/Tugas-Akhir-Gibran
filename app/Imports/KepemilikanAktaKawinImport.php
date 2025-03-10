<?php

namespace App\Imports;

use App\Models\Kepemilikan\AktaKawin;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class KepemilikanAktaKawinImport implements ToModel, WithHeadingRow
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
        return new AktaKawin([
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
            'muslim_jml' => $row['muslim_jml'],
            'non_muslim_jml' => $row['non_muslim_jml'],
            'status_kawin_lk' => $row['status_kawin_lk'],
            'status_kawin_pr' => $row['status_kawin_pr'],
            'status_kawin_jml' => $row['status_kawin_jml'],
            'memiliki_akta_kawin_lk' => $row['memiliki_akta_kawin_lk'],
            'memiliki_akta_kawin_pr' => $row['memiliki_akta_kawin_pr'],
            'memiliki_akta_kawin_jml' => $row['memiliki_akta_kawin_jml'],
            'belum_memiliki_akta_kawin_jml' => $row['belum_memiliki_akta_kawin_jml'],
            'persen_memiliki' => $row['persen_memiliki'],
        ]);
    }
}
