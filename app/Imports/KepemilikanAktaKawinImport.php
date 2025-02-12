<?php

namespace App\Imports;

use App\Models\Kepemilikan\AktaKawin;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class KepemilikanAktaKawinImport implements ToModel, WithHeadingRow
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
        return new AktaKawin([
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
            'MUSLIM_JML' => $row['MUSLIM_JML'],
            'NON_MUSLIM_JML' => $row['NON_MUSLIM_JML'],
            'STATUS_KAWIN_LK' => $row['STATUS_KAWIN_LK'],
            'STATUS_KAWIN_PR' => $row['STATUS_KAWIN_PR'],
            'STATUS_KAWIN_JML' => $row['STATUS_KAWIN_JML'],
            'MEMILIKI_AKTA_KAWIN_LK' => $row['MEMILIKI_AKTA_KAWIN_LK'],
            'MEMILIKI_AKTA_KAWIN_PR' => $row['MEMILIKI_AKTA_KAWIN_PR'],
            'MEMILIKI_AKTA_KAWIN_JML' => $row['MEMILIKI_AKTA_KAWIN_JML'],
            'BELUM_MEMILIKI_AKTA_KAWIN_JML' => $row['BELUM_MEMILIKI_AKTA_KAWIN_JML'],
            'PERSEN_MEMILIKI' => $row['PERSEN_MEMILIKI'],
        ]);
    }
}
