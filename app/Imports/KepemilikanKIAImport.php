<?php

namespace App\Imports;

use App\Models\Kepemilikan\KIA;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class KepemilikanKIAImport implements ToModel, WithHeadingRow
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
        return new KIA([
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
            'JUMLAH_AWAL_LK' => $row['JUMLAH_AWAL_LK'],
            'JUMLAH_AWAL_PR' => $row['JUMLAH_AWAL_PR'],
            'JUMLAH_AWAL_JML' => $row['JUMLAH_AWAL_JML'],
            'MEMILIKI_AWAL_LK' => $row['MEMILIKI_AWAL_LK'],
            'MEMILIKI_AWAL_PR' => $row['MEMILIKI_AWAL_PR'],
            'MEMILIKI_AWAL_JML' => $row['MEMILIKI_AWAL_JML'],
            'BELUM_MEMILIKI_AWAL_LK' => $row['BELUM_MEMILIKI_AWAL_LK'],
            'BELUM_MEMILIKI_AWAL_PR' => $row['BELUM_MEMILIKI_AWAL_PR'],
            'BELUM_MEMILIKI_AWAL_JML' => $row['BELUM_MEMILIKI_AWAL_JML'],
            'PERSEN_AWAL' => $row['PERSEN_AWAL'],
            'USIA_LEBIH_TARGET_LK' => $row['USIA_LEBIH_TARGET_LK'],
            'USIA_LEBIH_TARGET_PR' => $row['USIA_LEBIH_TARGET_PR'],
            'USIA_LEBIH_TARGET_JML' => $row['USIA_LEBIH_TARGET_JML'],
            'MENINGGAL_LK' => $row['MENINGGAL_LK'],
            'MENINGGAL_PR' => $row['MENINGGAL_PR'],
            'MENINGGAL_JML' => $row['MENINGGAL_JML'],
            'NONAKTIF_LK' => $row['NONAKTIF_LK'],
            'NONAKTIF_PR' => $row['NONAKTIF_PR'],
            'NONAKTIF_JML' => $row['NONAKTIF_JML'],
            'MEMILIKI_DALAM_DKB_LK' => $row['MEMILIKI_DALAM_DKB_LK'],
            'MEMILIKI_DALAM_DKB_PR' => $row['MEMILIKI_DALAM_DKB_PR'],
            'MEMILIKI_DALAM_DKB_JML' => $row['MEMILIKI_DALAM_DKB_JML'],
            'MEMILIKI_LUAR_DKB_LK' => $row['MEMILIKI_LUAR_DKB_LK'],
            'MEMILIKI_LUAR_DKB_PR' => $row['MEMILIKI_LUAR_DKB_PR'],
            'MEMILIKI_LUAR_DKB_JML' => $row['MEMILIKI_LUAR_DKB_JML'],
            'JUMLAH_DINAMIS_LK' => $row['JUMLAH_DINAMIS_LK'],
            'JUMLAH_DINAMIS_PR' => $row['JUMLAH_DINAMIS_PR'],
            'JUMLAH_DINAMIS_TTL' => $row['JUMLAH_DINAMIS_TTL'],
            'MEMILIKI_DINAMIS_LK' => $row['MEMILIKI_DINAMIS_LK'],
            'MEMILIKI_DINAMIS_PR' => $row['MEMILIKI_DINAMIS_PR'],
            'MEMILIKI_DINAMIS_JML' => $row['MEMILIKI_DINAMIS_JML'],
            'BELUM_MEMILIKI_DINAMIS_LK' => $row['BELUM_MEMILIKI_DINAMIS_LK'],
            'BELUM_MEMILIKI_DINAMIS_PR' => $row['BELUM_MEMILIKI_DINAMIS_PR'],
            'BELUM_MEMILIKI_DINAMIS_JML' => $row['BELUM_MEMILIKI_DINAMIS_JML'],
            'PERSEN_DINAMIS' => $row['PERSEN_DINAMIS'],
            'PENAMBAHAN_LK' => $row['PENAMBAHAN_LK'],
            'PENAMBAHAN_PR' => $row['PENAMBAHAN_PR'],
            'penambahan_jml' => $row['penambahan_jml'],
        ]);
    }
}
