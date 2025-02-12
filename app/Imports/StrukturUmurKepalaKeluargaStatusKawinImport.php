<?php

namespace App\Imports;

use App\Models\StrukturUmur\KepalaKeluarga\StatusKawinKelompokUmur;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class StrukturUmurKepalaKeluargaStatusKawinImport implements ToModel, WithHeadingRow
{
    protected $tahun;
    protected $semester;


    protected $ageRanges = [
        '00_04', '05_09', '10_14', '15_19', '20_24',
        '25_29', '30_34', '35_39', '40_44', '45_49',
        '50_54', '55_59', '60_64', '65_69', '70_74',
        'LEBIH_75'
    ];


    protected $marriageStatus = [
        'BELUM_KAWIN', 'KAWIN', 'CERAI_HIDUP', 'CERAI_MATI'
    ];

    // Definisikan jenis kelamin
    protected $genders = ['LK', 'PR'];

    public function __construct($tahun, $semester)
    {
        $this->tahun = $tahun;
        $this->semester = $semester;
    }

    public function model(array $row)
    {

        $data = [
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
        ];


        foreach ($this->ageRanges as $age) {
            foreach ($this->marriageStatus as $status) {
                foreach ($this->genders as $gender) {
                    $fieldName = "{$age}_{$status}_{$gender}";
                    $data[$fieldName] = $row[$fieldName];
                }
            }
        }

        return new StatusKawinKelompokUmur($data);
    }
}
