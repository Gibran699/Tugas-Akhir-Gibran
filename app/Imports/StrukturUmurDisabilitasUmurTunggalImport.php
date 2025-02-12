<?php

namespace App\Imports;

use App\Models\StrukturUmur\Disabilitas\UmurTunggal;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class StrukturUmurDisabilitasUmurTunggalImport implements ToModel, WithHeadingRow
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
        return new UmurTunggal([
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
            'umur' => $row['umur'],
            'Disabiltas_Fisik_LK' => $row['Disabiltas_Fisik_LK'],
            'Disabiltas_Fisik_PR' => $row['Disabiltas_Fisik_PR'],
            'Disabiltas_Fisik_JML' => $row['Disabiltas_Fisik_JML'],
            'Disabiltas_Netra_Buta_LK' => $row['Disabiltas_Netra_Buta_LK'],
            'Disabiltas_Netra_Buta_PR' => $row['Disabiltas_Netra_Buta_PR'],
            'Disabiltas_Netra_Buta_JML' => $row['Disabiltas_Netra_Buta_JML'],
            'Disabiltas_Rungu_Wicara_LK' => $row['Disabiltas_Rungu_Wicara_LK'],
            'Disabiltas_Rungu_Wicara_PR' => $row['Disabiltas_Rungu_Wicara_PR'],
            'Disabiltas_Rungu_Wicara_JML' => $row['Disabiltas_Rungu_Wicara_JML'],
            'Disabiltas_Mental_Jiwa_LK' => $row['Disabiltas_Mental_Jiwa_LK'],
            'Disabiltas_Mental_Jiwa_PR' => $row['Disabiltas_Mental_Jiwa_PR'],
            'Disabiltas_Mental_Jiwa_JML' => $row['Disabiltas_Mental_Jiwa_JML'],
            'Disabiltas_Fisik_Mental_LK' => $row['Disabiltas_Fisik_Mental_LK'],
            'Disabiltas_Fisik_Mental_PR' => $row['Disabiltas_Fisik_Mental_PR'],
            'Disabiltas_Fisik_Mental_JML' => $row['Disabiltas_Fisik_Mental_JML'],
            'Disabiltas_Lainya_LK' => $row['Disabiltas_Lainya_LK'],
            'Disabiltas_Lainya_PR' => $row['Disabiltas_Lainya_PR'],
            'Disabiltas_Lainya_JML' => $row['Disabiltas_Lainya_JML'],
        ]);
    }
}
