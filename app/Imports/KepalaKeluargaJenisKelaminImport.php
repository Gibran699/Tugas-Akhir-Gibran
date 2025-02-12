<?php

namespace App\Imports;

use App\Models\AgregatDKB\KepalaKeluarga\JenisKelamin;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KepalaKeluargaJenisKelaminImport implements ToModel, WithHeadingRow
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
        return new JenisKelamin([
            'uuid' => Str::uuid(),
            'kode_wilayah' => $row['kode_wilayah'],
            'lk' => $row['lk'],
            'pr' => $row['pr'],
            'jumlah' => $row['jumlah'],
            'semester' => $this->semester,
            'tahun' => $this->tahun,
        ]);
    }
}
