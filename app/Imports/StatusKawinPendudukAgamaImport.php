<?php

namespace App\Imports;

use App\Models\AgregatDKB\StatusKawin\Agama;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class StatusKawinPendudukAgamaImport implements ToModel, WithHeadingRow
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
        return new Agama([
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
            'keterangan' => $row['keterangan'],
            'islam_lk' => $row['islam_lk'],
            'islam_pr' => $row['islam_pr'],
            'islam_jml' => $row['islam_jml'],
            'katholik_lk' => $row['katholik_lk'],
            'katholik_pr' => $row['katholik_pr'],
            'katholik_jml' => $row['katholik_jml'],
            'kristen_lk' => $row['kristen_lk'],
            'kristen_pr' => $row['kristen_pr'],
            'kristen_jml' => $row['kristen_jml'],
            'hindu_lk' => $row['hindu_lk'],
            'hindu_pr' => $row['hindu_pr'],
            'hindu_jml' => $row['hindu_jml'],
            'budha_lk' => $row['budha_lk'],
            'budha_pr' => $row['budha_pr'],
            'budha_jml' => $row['budha_jml'],
            'konghucu_lk' => $row['konghucu_lk'],
            'konghucu_pr' => $row['konghucu_pr'],
            'konghucu_jml' => $row['konghucu_jml'],
            'kepercayaan_lk' => $row['kepercayaan_lk'],
            'kepercayaan_pr' => $row['kepercayaan_pr'],
            'kepercayaan_jml' => $row['kepercayaan_jml'],

        ]);
    }
}
