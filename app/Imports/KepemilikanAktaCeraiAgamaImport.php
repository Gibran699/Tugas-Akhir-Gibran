<?php

namespace App\Imports;

use App\Models\Kepemilikan\AktaCeraiAgama;
use Maatwebsite\Excel\Concerns\ToModel;

class KepemilikanAktaCeraiAgamaImport implements ToModel
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
        return new AktaCeraiAgama([
            'uuid' => Str::uuid(),
            'kode_wilayah' => $row['kode_wilayah'],
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'ISLAM_MEMILIKI_LK' => $row['ISLAM_MEMILIKI_LK'],
            'ISLAM_MEMILIKI_PR' => $row['ISLAM_MEMILIKI_PR'],
            'ISLAM_MEMILIKI_JML' => $row['ISLAM_MEMILIKI_JML'],
            'ISLAM_BLM_MEMILIKI_JML' => $row['ISLAM_BLM_MEMILIKI_JML'],
            'KRISTEN_MEMILIKI_LK' => $row['KRISTEN_MEMILIKI_LK'],
            'KRISTEN_MEMILIKI_PR' => $row['KRISTEN_MEMILIKI_PR'],
            'KRISTEN_MEMILIKI_JML' => $row['KRISTEN_MEMILIKI_JML'],
            'KRISTEN_BLM_MEMILIKI_JML' => $row['KRISTEN_BLM_MEMILIKI_JML'],
            'KATHOLIK_MEMILIKI_LK' => $row['KATHOLIK_MEMILIKI_LK'],
            'KATHOLIK_MEMILIKI_PR' => $row['KATHOLIK_MEMILIKI_PR'],
            'KATHOLIK_MEMILIKI_JML' => $row['KATHOLIK_MEMILIKI_JML'],
            'KATHOLIK_BLM_MEMILIKI_JML' => $row['KATHOLIK_BLM_MEMILIKI_JML'],
            'HINDU_MEMILIKI_LK' => $row['HINDU_MEMILIKI_LK'],
            'HINDU_MEMILIKI_PR' => $row['HINDU_MEMILIKI_PR'],
            'HINDU_MEMILIKI_JML' => $row['HINDU_MEMILIKI_JML'],
            'HINDU_BLM_MEMILIKI_JML' => $row['HINDU_BLM_MEMILIKI_JML'],
            'BUDHA_MEMILIKI_LK' => $row['BUDHA_MEMILIKI_LK'],
            'BUDHA_MEMILIKI_PR' => $row['BUDHA_MEMILIKI_PR'],
            'BUDHA_MEMILIKI_JML' => $row['BUDHA_MEMILIKI_JML'],
            'BUDHA_BLM_MEMILIKI_JML' => $row['BUDHA_BLM_MEMILIKI_JML'],
            'KHONGHUCU_MEMILIKI_LK' => $row['KHONGHUCU_MEMILIKI_LK'],
            'KHONGHUCU_MEMILIKI_PR' => $row['KHONGHUCU_MEMILIKI_PR'],
            'KHONGHUCU_MEMILIKI_JML' => $row['KHONGHUCU_MEMILIKI_JML'],
            'KHONGHUCU_BLM_MEMILIKI_JML' => $row['KHONGHUCU_BLM_MEMILIKI_JML'],
            'KEPERCAYAAN_MEMILIKI_LK' => $row['KEPERCAYAAN_MEMILIKI_LK'],
            'KEPERCAYAAN_MEMILIKI_PR' => $row['KEPERCAYAAN_MEMILIKI_PR'],
            'KEPERCAYAAN_MEMILIKI_JML' => $row['KEPERCAYAAN_MEMILIKI_JML'],
            'KEPERCAYAAN_BLM_MEMILIKI_JML' => $row['KEPERCAYAAN_BLM_MEMILIKI_JML'],
        ]);
    }
}
