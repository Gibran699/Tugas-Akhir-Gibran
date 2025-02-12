<?php

namespace App\Imports;

use App\Models\StrukturUmur\Penduduk\UsiaMudaProduktifTua;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class StrukturUmurPendudukUsiaMudaProduktifImport implements ToModel, WithHeadingRow
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
        return new UsiaMudaProduktifTua([
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
            'USIA_MUDA' => $row['USIA_MUDA'],
            'USIA_PRODUKTIF' => $row['USIA_PRODUKTIF'],
            'USIA_TUA' => $row['USIA_TUA'],
        ]);
    }
}
