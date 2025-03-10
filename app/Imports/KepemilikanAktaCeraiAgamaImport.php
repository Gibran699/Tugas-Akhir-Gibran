<?php

namespace App\Imports;

use App\Models\Kepemilikan\AktaCerai;
use App\Models\Kepemilikan\AktaCeraiAgama;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KepemilikanAktaCeraiAgamaImport implements ToModel,WithHeadingRow
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
        return new AktaCeraiAgama([
            'uuid' => Str::uuid(),
            'kode_wilayah' => $row['kode_wilayah'],
            'semester' => $this->semester,
            'tahun' => $this->tahun,
        ]);
        foreach ($categoryReligiosOwnerShip as $key) {
            $data[$key] = $row[$key] ?? null;
        }
        return new AktaCerai($data);
    }
}
