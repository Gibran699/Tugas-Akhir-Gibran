<?php

namespace App\Imports;

use App\Models\AgregatDKB\Pendidikan\GolonganDarah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class PendidikanGolonganDarahImport implements ToModel, WithHeadingRow
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
        $data =[
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
            'keterangan' => $row['keterangan'],
        ];
        foreach ($categoryBlood as $key) {
            $data[$key] = $row[$key] ?? null;
        }
        return new GolonganDarah($data);
    }
}
