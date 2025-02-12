<?php

namespace App\Imports;

use App\Models\StrukturUmur\KepalaKeluarga\KelompokUmur;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StrukturUmurKepalaKeluargaKelompokUmurImport implements ToModel, WithHeadingRow
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
        return new KelompokUmur([
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
            '00_04_TAHUN_LK' => $row['00_04_TAHUN_LK'],
            '00_04_TAHUN_PR' => $row['00_04_TAHUN_PR'],
            '00_04_TAHUN_JML' => $row['00_04_TAHUN_JML'],
            '05_09_TAHUN_LK' => $row['05_09_TAHUN_LK'],
            '05_09_TAHUN_PR' => $row['05_09_TAHUN_PR'],
            '05_09_TAHUN_JML' => $row['05_09_TAHUN_JML'],
            '10_14_TAHUN_LK' => $row['10_14_TAHUN_LK'],
            '10_14_TAHUN_PR' => $row['10_14_TAHUN_PR'],
            '10_14_TAHUN_JML' => $row['10_14_TAHUN_JML'],
            '15_19_TAHUN_LK' => $row['15_19_TAHUN_LK'],
            '15_19_TAHUN_PR' => $row['15_19_TAHUN_PR'],
            '15_19_TAHUN_JML' => $row['15_19_TAHUN_JML'],
            '20_24_TAHUN_LK' => $row['20_24_TAHUN_LK'],
            '20_24_TAHUN_PR' => $row['20_24_TAHUN_PR'],
            '20_24_TAHUN_JML' => $row['20_24_TAHUN_JML'],
            '25_29_TAHUN_LK' => $row['25_29_TAHUN_LK'],
            '25_29_TAHUN_PR' => $row['25_29_TAHUN_PR'],
            '25_29_TAHUN_JML' => $row['25_29_TAHUN_JML'],
            '30_34_TAHUN_LK' => $row['30_34_TAHUN_LK'],
            '30_34_TAHUN_PR' => $row['30_34_TAHUN_PR'],
            '30_34_TAHUN_JML' => $row['30_34_TAHUN_JML'],
            '35_39_TAHUN_LK' => $row['35_39_TAHUN_LK'],
            '35_39_TAHUN_PR' => $row['35_39_TAHUN_PR'],
            '35_39_TAHUN_JML' => $row['35_39_TAHUN_JML'],
            '40_44_TAHUN_LK' => $row['40_44_TAHUN_LK'],
            '40_44_TAHUN_PR' => $row['40_44_TAHUN_PR'],
            '40_44_TAHUN_JML' => $row['40_44_TAHUN_JML'],
            '45_49_TAHUN_LK' => $row['45_49_TAHUN_LK'],
            '45_49_TAHUN_PR' => $row['45_49_TAHUN_PR'],
            '45_49_TAHUN_JML' => $row['45_49_TAHUN_JML'],
            '50_54_TAHUN_LK' => $row['50_54_TAHUN_LK'],
            '50_54_TAHUN_PR' => $row['50_54_TAHUN_PR'],
            '50_54_TAHUN_JML' => $row['50_54_TAHUN_JML'],
            '55_59_TAHUN_LK' => $row['55_59_TAHUN_LK'],
            '55_59_TAHUN_PR' => $row['55_59_TAHUN_PR'],
            '55_59_TAHUN_JML' => $row['55_59_TAHUN_JML'],
            '60_64_TAHUN_LK' => $row['60_64_TAHUN_LK'],
            '60_64_TAHUN_PR' => $row['60_64_TAHUN_PR'],
            '60_64_TAHUN_JML' => $row['60_64_TAHUN_JML'],
            '65_69_TAHUN_LK' => $row['65_69_TAHUN_LK'],
            '65_69_TAHUN_PR' => $row['65_69_TAHUN_PR'],
            '65_69_TAHUN_JML' => $row['65_69_TAHUN_JML'],
            '70_74_TAHUN_LK' => $row['70_74_TAHUN_LK'],
            '70_74_TAHUN_PR' => $row['70_74_TAHUN_PR'],
            '70_74_TAHUN_JML' => $row['70_74_TAHUN_JML'],
            'LEBIH_75_TAHUN_LK' => $row['LEBIH_75_TAHUN_LK'],
            'LEBIH_75_TAHUN_PR' => $row['LEBIH_75_TAHUN_PR'],
            'LEBIH_75_TAHUN_JML' => $row['LEBIH_75_TAHUN_JML'],
        ]);
    }
}
