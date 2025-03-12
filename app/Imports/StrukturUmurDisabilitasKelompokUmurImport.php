<?php

namespace App\Imports;

use App\Models\StrukturUmur\Disabilitas\KelompokUmur;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StrukturUmurDisabilitasKelompokUmurImport implements ToModel, WithHeadingRow
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
        $categoryDisabilities =config('dataArray.categoryDisabilities');
        $data =[
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
            'kelompok_umur' => $row['kelompok_umur'],
        ];
        foreach ($categoryDisabilities as $key) {
            $data[$key] = $row[$key] ?? null;
        }
        return new KelompokUmur($data);
    }
}
