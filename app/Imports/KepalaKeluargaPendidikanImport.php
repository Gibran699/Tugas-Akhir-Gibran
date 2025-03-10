<?php

namespace App\Imports;

use App\Models\AgregatDKB\KepalaKeluarga\Pendidikan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class KepalaKeluargaPendidikanImport implements ToModel, WithHeadingRow
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
        $categoryEducation = config('dataArray.categoryEducation');
        return new Pendidikan([
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
        ]);
        foreach ($categoryEducation as $key) {
            $data[$key] = $row[$key] ?? null;
        }
        return new Pendidikan($data);
    }
}
