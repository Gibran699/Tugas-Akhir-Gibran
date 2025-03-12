<?php

namespace App\Imports;

use App\Models\AgregatDKB\Pendidikan\Pekerjaan as PendidikanPekerjaan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;



class PendidikanPekerjaanImport implements ToModel, WithHeadingRow
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
        $data = [
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
            'pendidikan' => $row['pendidikan']
        ];
        foreach ($categoryJob as $key) {
            $data[$key] = $row[$key] ?? null;
        }
        return new PendidikanPekerjaan($data);
    }
}
