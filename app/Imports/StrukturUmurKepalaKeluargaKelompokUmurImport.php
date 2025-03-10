<?php

namespace App\Imports;

use App\Models\StrukturUmur\KepalaKeluarga\KelompokUmur;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StrukturUmurKepalaKeluargaKelompokUmurImport implements ToModel, WithHeadingRow
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
        $categoryAgeGroup = config('dataArray.categoryAgeGroup');
        return new KelompokUmur([
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah']
        ]);
        foreach ($categoryAgeGroup as $key) {
            $data[$key] = $row[$key] ?? null;
        }
        return new KelompokUmur($data);
    }
}
