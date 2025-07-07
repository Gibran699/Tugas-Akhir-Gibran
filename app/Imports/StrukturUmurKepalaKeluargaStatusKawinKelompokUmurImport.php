<?php

namespace App\Imports;

use App\Models\StrukturUmur\KepalaKeluarga\StatusKawinKelompokUmur;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class StrukturUmurKepalaKeluargaStatusKawinKelompokUmurImport implements ToModel, WithHeadingRow
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
        $data = [
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah']
        ];
        foreach ($categoryAgeGroup as $key) {
            $data[$key] = $row[$key] ?? null;
        }
        return new StatusKawinKelompokUmur($data);
    }
}
