<?php

namespace App\Imports;

use App\Models\AgregatDKB\KepalaKeluarga\StatusKawin;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KepalaKeluargaStatusKawinImport implements ToModel, WithHeadingRow
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
        return new StatusKawin([
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
            'Belum_Kawin_LK' => $row['belum_kawin_lk'],
            'Belum_Kawin_PR' => $row['belum_kawin_pr'],
            'Kawin_LK' => $row['kawin_lk'],
            'Kawin_PR' => $row['kawin_pr'],
            'Cerai_Hidup_LK' => $row['cerai_hidup_lk'],
            'Cerai_Hidup_PR' => $row['cerai_hidup_pr'],
            'Cerai_Mati_LK' => $row['cerai_mati_lk'],
            'Cerai_Mati_PR' => $row['cerai_mati_pr'],
        ]);
    }
}
