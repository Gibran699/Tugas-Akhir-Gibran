<?php

namespace App\Imports;

use App\Models\StrukturUmur\Penduduk\StatusKawinUmurTunggal;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class StrukturUmurPendudukStatusKawinUmurTunggalImport implements ToModel, WithHeadingRow
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
        return new StatusKawinUmurTunggal([
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
            'BELUM_KAWIN_LK' => $row['BELUM_KAWIN_LK'],
            'BELUM_KAWIN_PR' => $row['BELUM_KAWIN_PR'],
            'KAWIN_LK' => $row['KAWIN_LK'],
            'KAWIN_PR' => $row['KAWIN_PR'],
            'CERAI_HIDUP_LK' => $row['CERAI_HIDUP_LK'],
            'CERAI_HIDUP_PR' => $row['CERAI_HIDUP_PR'],
            'CERAI_MATI_LK' => $row['CERAI_MATI_LK'],
            'CERAI_MATI_PR' => $row['CERAI_MATI_PR'],
        ]);
    }
}
