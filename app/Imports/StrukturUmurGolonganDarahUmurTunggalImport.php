<?php

namespace App\Imports;

use App\Models\StrukturUmur\GolonganDarah\UmurTunggal;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StrukturUmurGolonganDarahUmurTunggalImport implements ToModel, WithHeadingRow
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
        $categoryBlood = config('dataArray.categoryBlood');
        $data = [
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah']
        ];
        foreach ($categoryBlood as $key) {
            $data[$key] = $row[$key] ?? null;
        }
        return new UmurTunggal($data);
    }
}

