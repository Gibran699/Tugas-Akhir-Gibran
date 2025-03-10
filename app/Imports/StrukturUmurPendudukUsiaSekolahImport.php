<?php

namespace App\Imports;

use App\Models\StrukturUmur\Penduduk\UsiaSekolah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class StrukturUmurPendudukUsiaSekolahImport implements ToModel, WithHeadingRow
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
        return new UsiaSekolah([
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
            'usia_sd_sederajat' => $row['usia_sd_sederajat'],
            'usia_sltp_sederajat' => $row['usia_sltp_sederajat'],
            'usia_slta_sederajat' => $row['usia_slta_sederajat'],
            'usia_perguruan_tinggi' => $row['usia_perguruan_tinggi'],
        ]);
    }
}
