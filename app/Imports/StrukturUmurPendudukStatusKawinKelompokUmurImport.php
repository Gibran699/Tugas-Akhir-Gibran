<?php

namespace App\Imports;

use App\Models\StrukturUmur\Penduduk\StatusKawinKelompokUmur;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class StrukturUmurPendudukStatusKawinKelompokUmurImport implements ToModel, WithHeadingRow
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
        $categoryAgeGroupMarriageStatus = config('dataArray.categoryAgeGroupMarriageStatus');
        $data =[
            'uuid' => Str::uuid(),
            'tahun' => $this->tahun,
            'semester' => $this->semester,
            'kode_wilayah' => $row['kode_wilayah']
        ];
        foreach ($categoryAgeGroupMarriageStatus as $key) {
            $data[$key] = $row[$key] ?? null;
        }
        return new StatusKawinKelompokUmur($data);
    }
}
