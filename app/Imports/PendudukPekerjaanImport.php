<?php

namespace App\Imports;

use App\Models\AgregatDKB\Penduduk\Pekerjaan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class PendudukPekerjaanImport implements ToModel, WithHeadingRow
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
        $categoryJob = config('dataArray.categoryJob');
        return new Pekerjaan([
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah']
        ]);
        foreach ($categoryJob as $key) {
            $data[$key] = $row[$key];
        }
    }
}
