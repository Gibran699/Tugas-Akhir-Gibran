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
            'USIA_SD_SEDERAJAT' => $row['USIA_SD_SEDERAJAT'],
            'USIA_SLTP_SEDERAJAT' => $row['USIA_SLTP_SEDERAJAT'],
            'USIA_SLTA_SEDERAJAT' => $row['USIA_SLTA_SEDERAJAT'],
            'USIA_PERGURUAN_TINGGI' => $row['USIA_PERGURUAN_TINGGI'],
        ]);
    }
}
