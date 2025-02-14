<?php

namespace App\Models\Kepemilikan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AktaKelahiran extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'akta_kelahiran';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid', 'kode_wilayah', 'keterangan',
        'wajib_akta_awal_lk',
        'wajib_akta_awal_pr',
        'wajib_akta_awal_jml',
        'memiliki_awal_lk',
        'memiliki_awal_pr',
        'memiliki_awal_jml',
        'belum_memiliki_awal_lk',
        'belum_memiliki_awal_pr',
        'belum_memiliki_aw_al_lk',
        'belum_memiliki_awal_pr',
        'belum_memiliki_awal_jml',
        'persen_awal',
        'usia_lebih_dari_target_lk',
        'usia_lebih_dari_target_pr',
        'usia_lebih_dari_target_jml',
        'meninggal_lk',
        'meninggal_pr',
        'meninggal_jml',
        'nonaktif_lk',
        'nonaktif_pr',
        'nonaktif_jml',
        'pindah_lk',
        'pindah_pr',
        'pindah_jml',
        'datang_lk',
        'datang_pr',
        'datang_jml',
        'hapus_operator_lk',
        'hapus_operator_pr',
        'hapus_operator_jml',
        'terbit_akta_baru_dalam_dkb_lk',
        'terbit_akta_baru_dalam_dkb_pr',
        'terbit_akta_baru_dalam_dkb_jml',
        'terbit_akta_baru_luar_dkb_lk',
        'terbit_akta_baru_luar_dkb_pr',
        'terbit_akta_baru_luar_dkb_jml',
        'wajib_akta_dinamis_lk',
        'wajib_akta_dinamis_pr',
        'wajib_akta_dinamis_jml',
        'memiliki_dinamis_lk',
        'memiliki_dinamis_pr',
        'memiliki_dinamis_jml',
        'belum_memiliki_dinamis_lk',
        'belum_memiliki_dinamis_pr',
        'belum_memiliki_dinamis_jml',
        'persen_dinamis',
        'penambahan_lk',
        'penambahan_pr',
        'penambahan_jml',
        'semester',
        'tahun',
    ];
}
