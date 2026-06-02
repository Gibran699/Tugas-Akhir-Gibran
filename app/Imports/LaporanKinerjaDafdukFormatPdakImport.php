<?php

namespace App\Imports;


use App\Imports\Concerns\ImportReconciliationTrait;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

use App\Models\LaporanKinerjaFormatPdak\Dafduk;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class LaporanKinerjaDafdukFormatPdakImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, SkipsOnFailure, SkipsOnError, SkipsEmptyRows, WithValidation{
    use ImportReconciliationTrait;

    protected $tanggal_laporan;

    public function __construct($tanggal_laporan)
    {
        $this->tanggal_laporan = $tanggal_laporan;
    }
    public function model(array $row)
    {
        $attibute = [
            'kode_wilayah',
            'penerbitan_kk',
            'perubahan_kk',
            'penerbitan_nik_wni_lk',
            'penerbitan_nik_wni_pr',
            'penerbitan_nik_wni_jml',
            'penerbitan_nik_oa_lk',
            'penerbitan_nik_oa_pr',
            'penerbitan_nik_oa_jml',
            'pencetakan_kia_lk',
            'pencetakan_kia_pr',
            'pencetakan_kia_jml',
            'ktp_el_rekam_lk',
            'ktp_el_rekam_pr',
            'ktp_el_rekam_jml',
            'ktp_el_cetak_lk',
            'ktp_el_cetak_pr',
            'ktp_el_cetak_jml',
            'jml_surat_pindah',
            'jml_pindah_lk',
            'jml_pindah_pr',
            'jml_pindah_jml',
            'jml_surat_datang',
            'jml_datang_lk',
            'jml_datang_pr',
            'jml_datang_jml',
        ];
        $data = [
            'uuid' => Str::uuid(),
            'tanggal_laporan' => $this->tanggal_laporan,
        ];
        foreach ($attibute as $key) {
            $data[$key] = $row[$key] ?? null;
        }
        return new Dafduk($data);
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
