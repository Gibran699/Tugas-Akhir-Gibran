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
        return new GolonganDarah([
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
            'keterangan' => $row['keterangan'],
            'A_LK' => $row['A_LK'],
            'A_PR' => $row['A_PR'],
            'A_JML' => $row['A_JML'],
            'A_M_LK' => $row['A_M_LK'],
            'A_M_PR' => $row['A_M_PR'],
            'A_M_JML' => $row['A_M_JML'],
            'A_P_LK' => $row['A_P_LK'],
            'A_P_PR' => $row['A_P_PR'],
            'A_P_JML' => $row['A_P_JML'],
            'B_LK' => $row['B_LK'],
            'B_PR' => $row['B_PR'],
            'B_JML' => $row['B_JML'],
            'B_M_LK' => $row['B_M_LK'],
            'B_M_PR' => $row['B_M_PR'],
            'B_M_JML' => $row['B_M_JML'],
            'B_P_LK' => $row['B_P_LK'],
            'B_P_PR' => $row['B_P_PR'],
            'B_P_JML' => $row['B_P_JML'],
            'AB_LK' => $row['AB_LK'],
            'AB_PR' => $row['AB_PR'],
            'AB_JML' => $row['AB_JML'],
            'AB_M_LK' => $row['AB_M_LK'],
            'AB_M_PR' => $row['AB_M_PR'],
            'AB_M_JML' => $row['AB_M_JML'],
            'AB_P_LK' => $row['AB_P_LK'],
            'AB_P_PR' => $row['AB_P_PR'],
            'AB_P_JML' => $row['AB_P_JML'],
            'O_LK' => $row['O_LK'],
            'O_PR' => $row['O_PR'],
            'O_JML' => $row['O_JML'],
            'O_M_LK' => $row['O_M_LK'],
            'O_M_PR' => $row['O_M_PR'],
            'O_M_JML' => $row['O_M_JML'],
            'O_P_LK' => $row['O_P_LK'],
            'O_P_PR' => $row['O_P_PR'],
            'O_P_JML' => $row['O_P_JML'],
            'TIDAK_TAHU_LK' => $row['TIDAK_TAHU_LK'],
            'TIDAK_TAHU_PR' => $row['TIDAK_TAHU_PR'],
            'TIDAK_TAHU_JML' => $row['TIDAK_TAHU_JML'],
        ]);
    }
}
