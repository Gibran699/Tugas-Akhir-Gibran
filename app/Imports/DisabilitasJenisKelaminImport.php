<?php

namespace App\Imports;

use App\Models\AgregatDKB\Disabilitas\JenisKelamin;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class DisabilitasJenisKelaminImport implements ToModel, WithHeadingRow
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
        return new JenisKelamin([
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
            'disabiltas_fisik_lk' => $row['disabiltas_fisik_lk'],
            'disabiltas_fisik_pr' => $row['disabiltas_fisik_pr'],
            'disabiltas_fisik_jml' => $row['disabiltas_fisik_jml'],
            'disabiltas_netra_buta_lk' => $row['disabiltas_netra_buta_lk'],
            'disabiltas_netra_buta_pr' => $row['disabiltas_netra_buta_pr'],
            'disabiltas_netra_buta_jml' => $row['disabiltas_netra_buta_jml'],
            'disabiltas_rungu_wicara_lk' => $row['disabiltas_rungu_wicara_lk'],
            'disabiltas_rungu_wicara_pr' => $row['disabiltas_rungu_wicara_pr'],
            'disabiltas_rungu_wicara_jml' => $row['disabiltas_rungu_wicara_jml'],
            'disabiltas_mental_jiwa_lk' => $row['disabiltas_mental_jiwa_lk'],
            'disabiltas_mental_jiwa_pr' => $row['disabiltas_mental_jiwa_pr'],
            'disabiltas_mental_jiwa_jml' => $row['disabiltas_mental_jiwa_jml'],
            'disabiltas_fisik_mental_lk' => $row['disabiltas_fisik_mental_lk'],
            'disabiltas_fisik_mental_pr' => $row['disabiltas_fisik_mental_pr'],
            'disabiltas_fisik_mental_jml' => $row['disabiltas_fisik_mental_jml'],
            'disabiltas_lainya_lk' => $row['disabiltas_lainya_lk'],
            'disabiltas_lainya_pr' => $row['disabiltas_lainya_pr'],
            'disabiltas_lainya_jml' => $row['disabiltas_lainya_jml'],
        ]);
    }
}
