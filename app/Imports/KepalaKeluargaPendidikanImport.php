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
        return new Pendidikan([
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
            'TIDAK_BLM_SEKOLAH_L' => $row['TIDAK_BLM_SEKOLAH_L'],
            'TIDAK_BLM_SEKOLAH_P' => $row['TIDAK_BLM_SEKOLAH_P'],
            'TIDAK_BLM_SEKOLAH_JML' => $row['TIDAK_BLM_SEKOLAH_JML'],
            'BELUM_TAMAT_SD_SEDERAJAT_L' => $row['BELUM_TAMAT_SD_SEDERAJAT_L'],
            'BELUM_TAMAT_SD_SEDERAJAT_P' => $row['BELUM_TAMAT_SD_SEDERAJAT_P'],
            'BELUM_TAMAT_SD_SEDERAJAT_JML' => $row['BELUM_TAMAT_SD_SEDERAJAT_JML'],
            'TAMAT_SD_SEDERAJAT_L' => $row['TAMAT_SD_SEDERAJAT_L'],
            'TAMAT_SD_SEDERAJAT_P' => $row['TAMAT_SD_SEDERAJAT_P'],
            'TAMAT_SD_SEDERAJAT_JML' => $row['TAMAT_SD_SEDERAJAT_JML'],
            'SLTP_SEDERAJAT_L' => $row['SLTP_SEDERAJAT_L'],
            'SLTP_SEDERAJAT_P' => $row['SLTP_SEDERAJAT_P'],
            'SLTP_SEDERAJAT_JML' => $row['SLTP_SEDERAJAT_JML'],
            'SLTA_SEDERAJAT_L' => $row['SLTA_SEDERAJAT_L'],
            'SLTA_SEDERAJAT_P' => $row['SLTA_SEDERAJAT_P'],
            'SLTA_SEDERAJAT_JML' => $row['SLTA_SEDERAJAT_JML'],
            'DIPLOMA_I_II_L' => $row['DIPLOMA_I_II_L'],
            'DIPLOMA_I_II_P' => $row['DIPLOMA_I_II_P'],
            'DIPLOMA_I_II_JML' => $row['DIPLOMA_I_II_JML'],
            'AKADEMI_DIPL_III_S_MUDA_L' => $row['AKADEMI_DIPL_III_S_MUDA_L'],
            'AKADEMI_DIPL_III_S_MUDA_P' => $row['AKADEMI_DIPL_III_S_MUDA_P'],
            'AKADEMI_DIPL_III_S_MUDA_JML' => $row['AKADEMI_DIPL_III_S_MUDA_JML'],
            'DIPLOMA_IV_STRATA_I_L' => $row['DIPLOMA_IV_STRATA_I_L'],
            'DIPLOMA_IV_STRATA_I_P' => $row['DIPLOMA_IV_STRATA_I_P'],
            'DIPLOMA_IV_STRATA_I_JML' => $row['DIPLOMA_IV_STRATA_I_JML'],
            'STRATA_II_L' => $row['STRATA_II_L'],
            'STRATA_II_P' => $row['STRATA_II_P'],
            'STRATA_II_JML' => $row['STRATA_II_JML'],
            'STRATA_III_L' => $row['STRATA_III_L'],
            'STRATA_III_P' => $row['STRATA_III_P'],
            'STRATA_III_JML' => $row['STRATA_III_JML'],
        ]);
    }
}
