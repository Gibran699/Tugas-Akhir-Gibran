<?php

namespace App\Imports;

use App\Models\Kepemilikan\AktaKelahiran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class KepemilikanAktaKelahiranImport implements ToModel, WithHeadingRow
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
        $categoryAktaKelahiranOwnerShip = config('dataArray.categoryAktaKelahiranOwnerShip');
        $data = [
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
            'keterangan' => $row['keterangan'],
        ];
        foreach ($categoryAktaKelahiranOwnerShip as $key) {
            $data[$key] = $row[$key] ?? null;
        }
        return new AktaKelahiran($data);
    }
}
