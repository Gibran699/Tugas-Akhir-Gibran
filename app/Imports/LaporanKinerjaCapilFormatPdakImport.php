<?php

namespace App\Imports;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Imports\Concerns\ImportReconciliationTrait;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;

use Illuminate\Support\Str;
use App\Models\LaporanKinerjaFormatPdak\Capil;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class LaporanKinerjaCapilFormatPdakImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue, SkipsOnFailure, SkipsOnError, WithValidation{
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
            'cetak_akta_kelahiran_lk',
            'cetak_akta_kelahiran_pr',
            'cetak_akta_kelahiran_jml',
            'pembatalan_kelahiran',
            'pembetulan_kelahiran',
            'cetak_akta_kematian_lk',
            'cetak_akta_kematian_pr',
            'cetak_akta_kematian_jml',
            'cetak_akta_kawin',
            'pembatalan_akta_kawin',
            'cetak_akta_cerai',
            'pembatalan_akta_cerai',
            'perubahan_wni_wna',
            'perubahan_wna_wni',
            'perubahan_nama',
            'perubahan_jenis_kelamin',
            'pengesahan_anak_lk',
            'pengesahan_anak_pr',
            'pengesahan_anak_jml',
            'pengangkatan_anak_lk',
            'pengangkatan_anak_pr',
            'pengangkatan_anak_jml',
        ];
        $data = [
            'uuid' => Str::uuid(),
            'tanggal_laporan' => $this->tanggal_laporan,
        ];
        foreach ($attibute as $key) {
            $data[$key] = $row[$key] ?? null;
        }
        return new Capil($data);
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
