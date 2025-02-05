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
        'uuid','kode_wilayah','keterangan',
        'WAJIB_AKTA_AWAL_LK',
        'WAJIB_AKTA_AWAL_PR',
        'WAJIB_AKTA_AWAL_JML',
        'MEMILIKI_AWAL_LK',
        'MEMILIKI_AWAL_PR',
        'MEMILIKI_AWAL_JML',
        'BELUM_MEMILIKI_AWAL_LK',
        'BELUM_MEMILIKI_AWAL_PR',
        'BELUM_MEMILIKI_AW_AL_LK',
        'BELUM_MEMILIKI_AWAL_PR',
        'BELUM_MEMILIKI_AWAL_JML',
        'PERSEN_AWAL',
        'USIA_LEBIH_DARI_TARGET_LK',
        'USIA_LEBIH_DARI_TARGET_PR',
        'USIA_LEBIH_DARI_TARGET_JML',
        'MENINGGAL_LK',
        'MENINGGAL_PR',
        'MENINGGAL_JML',
        'NONAKTIF_LK',
        'NONAKTIF_PR',
        'NONAKTIF_JML',
        'PINDAH_LK',
        'PINDAH_PR',
        'PINDAH_JML',
        'DATANG_LK',
        'DATANG_PR',
        'DATANG_JML',
        'Hapus_OPERATOR_LK',
        'Hapus_OPERATOR_PR',
        'Hapus_OPERATOR_JML',
        'TERBIT_AKTA_BARU_DALAM_DKB_LK',
        'TERBIT_AKTA_BARU_DALAM_DKB_PR',
        'TERBIT_AKTA_BARU_DALAM_DKB_JML',
        'TERBIT_AKTA_BARU_LUAR_DKB_LK',
        'TERBIT_AKTA_BARU_LUAR_DKB_PR',
        'TERBIT_AKTA_BARU_LUAR_DKB_JML',
        'WAJIB_AKTA_DINAMIS_LK',
        'WAJIB_AKTA_DINAMIS_PR',
        'WAJIB_AKTA_DINAMIS_JML',
        'MEMILIKI_DINAMIS_LK',
        'MEMILIKI_DINAMIS_PR',
        'MEMILIKI_DINAMIS_JML',
        'BELUM_MEMILIKI_DINAMIS_LK',
        'BELUM_MEMILIKI_DINAMIS_PR',
        'BELUM_MEMILIKI_DINAMIS_JML',
        'PERSEN_DINAMIS',
        'PENAMBAHAN_LK',
        'PENAMBAHAN_PR',
        'PENAMBAHAN_JML',
        'semester',
        'tahun'
    ];
}
