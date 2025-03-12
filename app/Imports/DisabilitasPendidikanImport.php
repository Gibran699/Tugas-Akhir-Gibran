<?php

namespace App\Imports;

use App\Models\AgregatDKB\Disabilitas\Pendidikan;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DisabilitasPendidikanImport implements ToModel, WithHeadingRow
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
        $cetegoryEducation = config('dataArray.categoryEducation');
        $data = [
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
            'keterangan' => $row['keterangan'],
        ];
        foreach ($cetegoryEducation as $key) {
            $data[$key] = $row[$key] ?? null;
        }
        return new Pendidikan($data);
    }
}
