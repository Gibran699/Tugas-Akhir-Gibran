<?php

namespace App\Models\LaporanKinerjaFormatPdak;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dafduk extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'laporan_kinerja_dafduk_format_pdak';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid',
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
        'tanggal_laporan',
    ];
}
