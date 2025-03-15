<?php

namespace App\Imports;

use App\Models\Kepemilikan\AktaKawinAgama;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class KepemilikanAktaAgamaKawinImport implements ToModel, WithHeadingRow
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
        $categoryReligiosOwnerShip = config('dataArray.categoryReligiosOwnerShip');
        $data = [
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah']
        ];
        foreach ($categoryReligiosOwnerShip as $key) {
            $data[$key] = $row[$key] ?? null;
        }
        return new AktaKawinAgama($data);
    }
}
