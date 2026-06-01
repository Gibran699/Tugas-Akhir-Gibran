<?php

namespace App\Imports;

use App\Models\Kepemilikan\Ktp;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class KepemilikanKtpImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts
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
        return new Ktp([
            'uuid' => Str::uuid(),
            'semester' => $this->semester,
            'tahun' => $this->tahun,
            'kode_wilayah' => $row['kode_wilayah'],
            'wajib_ktp_lk' => $row['wajib_ktp_lk'],
            'wajib_ktp_pr' => $row['wajib_ktp_pr'],
            'wajib_ktp_jml' => $row['wajib_ktp_jml'],
            'rekam_lk' => $row['rekam_lk'],
            'rekam_pr' => $row['rekam_pr'],
            'rekam_jml' => $row['rekam_jml'],
            'belum_rekam_lk' => $row['belum_rekam_lk'],
            'belum_rekam_pr' => $row['belum_rekam_pr'],
            'belum_rekam_jml' => $row['belum_rekam_jml'],
            'ktp_pr' => $row['ktp_pr'],
            'ktp_lk' => $row['ktp_lk'],
            'ktp_jml' => $row['ktp_jml'],
            'blm_ktp_lk' => $row['blm_ktp_lk'],
            'blm_ktp_pr' => $row['blm_ktp_pr'],
            'blm_ktp_jml' => $row['blm_ktp_jml']
        ]);
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function batchSize(): int
    {
        return 100;
    }
}
