<?php

namespace App\Imports;

use App\Models\AgregatDKB\Penduduk\Agama;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class PendudukAgamaImport implements ToModel, WithHeadingRow
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
        $categoryReligious = config('dataArray.categoryReligious');
        $data = [
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
        ];
        foreach ($categoryReligious as $key) {
            $data[$key] = $row[$key] ?? null;
        }
        return new Agama($data);
    }
}
