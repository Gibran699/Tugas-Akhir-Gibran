<?php

namespace App\Imports;

use App\Models\StrukturUmur\Disabilitas\UsiaSekolahKelompokUmur;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class StrukturUmurDisabilitasUsiaSekolahKelompokUmurImport implements ToModel, WithHeadingRow
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
        return new UsiaSekolahKelompokUmur([
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
            'FISIK_U4_6TH_LK' => $row['FISIK_U4_6TH_LK'],
            'FISIK_U4_6TH_PR' => $row['FISIK_U4_6TH_PR'],
            'FISIK_U7_12TH_LK' => $row['FISIK_U7_12TH_LK'],
            'FISIK_U7_12TH_PR' => $row['FISIK_U7_12TH_PR'],
            'FISIK_U13_15TH_LK' => $row['FISIK_U13_15TH_LK'],
            'FISIK_U13_15TH_PR' => $row['FISIK_U13_15TH_PR'],
            'FISIK_U16_18TH_LK' => $row['FISIK_U16_18TH_LK'],
            'FISIK_U16_18TH_PR' => $row['FISIK_U16_18TH_PR'],
            'NETRA_BUTA_U4_6TH_LK' => $row['NETRA_BUTA_U4_6TH_LK'],
            'NETRA_BUTA_U4_6TH_PR' => $row['NETRA_BUTA_U4_6TH_PR'],
            'NETRA_BUTA_U7_12TH_LK' => $row['NETRA_BUTA_U7_12TH_LK'],
            'NETRA_BUTA_U7_12TH_PR' => $row['NETRA_BUTA_U7_12TH_PR'],
            'NETRA_BUTA_U13_15TH_LK' => $row['NETRA_BUTA_U13_15TH_LK'],
            'NETRA_BUTA_U13_15TH_PR' => $row['NETRA_BUTA_U13_15TH_PR'],
            'NETRA_BUTA_U16_18TH_LK' => $row['NETRA_BUTA_U16_18TH_LK'],
            'NETRA_BUTA_U16_18TH_PR' => $row['NETRA_BUTA_U16_18TH_PR'],
            'RUNGU_WICARA_U4_6TH_LK' => $row['RUNGU_WICARA_U4_6TH_LK'],
            'RUNGU_WICARA_U4_6TH_PR' => $row['RUNGU_WICARA_U4_6TH_PR'],
            'RUNGU_WICARA_U7_12TH_LK' => $row['RUNGU_WICARA_U7_12TH_LK'],
            'RUNGU_WICARA_U7_12TH_PR' => $row['RUNGU_WICARA_U7_12TH_PR'],
            'RUNGU_WICARA_U13_15TH_LK' => $row['RUNGU_WICARA_U13_15TH_LK'],
            'RUNGU_WICARA_U13_15TH_PR' => $row['RUNGU_WICARA_U13_15TH_PR'],
            'RUNGU_WICARA_U16_18TH_LK' => $row['RUNGU_WICARA_U16_18TH_LK'],
            'RUNGU_WICARA_U16_18TH_PR' => $row['RUNGU_WICARA_U16_18TH_PR'],
            'MENTAL_JIWA_U4_6TH_LK' => $row['MENTAL_JIWA_U4_6TH_LK'],
            'MENTAL_JIWA_U4_6TH_PR' => $row['MENTAL_JIWA_U4_6TH_PR'],
            'MENTAL_JIWA_U7_12TH_LK' => $row['MENTAL_JIWA_U7_12TH_LK'],
            'MENTAL_JIWA_U7_12TH_PR' => $row['MENTAL_JIWA_U7_12TH_PR'],
            'MENTAL_JIWA_U13_15TH_LK' => $row['MENTAL_JIWA_U13_15TH_LK'],
            'MENTAL_JIWA_U13_15TH_PR' => $row['MENTAL_JIWA_U13_15TH_PR'],
            'MENTAL_JIWA_U16_18TH_LK' => $row['MENTAL_JIWA_U16_18TH_LK'],
            'MENTAL_JIWA_U16_18TH_PR' => $row['MENTAL_JIWA_U16_18TH_PR'],
            'FISIK_MENTAL_U4_6TH_LK' => $row['FISIK_MENTAL_U4_6TH_LK'],
            'FISIK_MENTAL_U4_6TH_PR' => $row['FISIK_MENTAL_U4_6TH_PR'],
            'FISIK_MENTAL_U7_12TH_LK' => $row['FISIK_MENTAL_U7_12TH_LK'],
            'FISIK_MENTAL_U7_12TH_PR' => $row['FISIK_MENTAL_U7_12TH_PR'],
            'FISIK_MENTAL_U13_15TH_LK' => $row['FISIK_MENTAL_U13_15TH_LK'],
            'FISIK_MENTAL_U13_15TH_PR' => $row['FISIK_MENTAL_U13_15TH_PR'],
            'FISIK_MENTAL_U16_18TH_LK' => $row['FISIK_MENTAL_U16_18TH_LK'],
            'FISIK_MENTAL_U16_18TH_PR' => $row['FISIK_MENTAL_U16_18TH_PR'],
            'LAINNYA_U4_6TH_LK' => $row['LAINNYA_U4_6TH_LK'],
            'LAINNYA_U4_6TH_PR' => $row['LAINNYA_U4_6TH_PR'],
            'LAINNYA_U7_12TH_LK' => $row['LAINNYA_U7_12TH_LK'],
            'LAINNYA_U7_12TH_PR' => $row['LAINNYA_U7_12TH_PR'],
            'LAINNYA_U13_15TH_LK' => $row['LAINNYA_U13_15TH_LK'],
            'LAINNYA_U13_15TH_PR' => $row['LAINNYA_U13_15TH_PR'],
            'LAINNYA_U16_18TH_LK' => $row['LAINNYA_U16_18TH_LK'],
            'LAINNYA_U16_18TH_PR' => $row['LAINNYA_U16_18TH_PR'],

        ]);
    }
}
