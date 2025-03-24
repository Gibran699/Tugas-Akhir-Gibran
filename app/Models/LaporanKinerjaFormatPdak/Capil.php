<?php

namespace App\Models\LaporanKinerjaFormatPdak;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Capil extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'laporan_kinerja_capil_format_pdak';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid',
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
        'tanggal_laporan'
    ];
}
