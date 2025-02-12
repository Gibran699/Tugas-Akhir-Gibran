<?php

namespace App\Imports;

use App\Models\StrukturUmur\Agama\KelompokUmur;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class StrukturUmurAgamaKelompokUmurImport implements ToModel, WithHeadingRow
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
        return new KelompokUmur([
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
            'Kelompok_umur' => $row['Kelompok_umur'],
            'Islam_LK' => $row['Islam_LK'],
            'Islam_PR' => $row['Islam_PR'],
            'Islam_JML' => $row['Islam_JML'],
            'Katholik_LK' => $row['Katholik_LK'],
            'Katholik_PR' => $row['Katholik_PR'],
            'Katholik_JML' => $row['Katholik_JML'],
            'Kristen_LK' => $row['Kristen_LK'],
            'Kristen_PR' => $row['Kristen_PR'],
            'Kristen_JML' => $row['Kristen_JML'],
            'Hindu_LK' => $row['Hindu_LK'],
            'Hindu_PR' => $row['Hindu_PR'],
            'Hindu_JML' => $row['Hindu_JML'],
            'Budha_LK' => $row['Budha_LK'],
            'Budha_PR' => $row['Budha_PR'],
            'Budha_JML' => $row['Budha_JML'],
            'Konghucu_LK' => $row['Konghucu_LK'],
            'Konghucu_PR' => $row['Konghucu_PR'],
            'Konghucu_JML' => $row['Konghucu_JML'],
            'Kepercayaan_LK' => $row['Kepercayaan_LK'],
            'Kepercayaan_PR' => $row['Kepercayaan_PR'],
            'Kepercayaan_JML' => $row['Kepercayaan_JML'],
        ]);
    }
}
