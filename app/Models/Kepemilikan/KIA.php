<?php

namespace App\Models\Kepemilikan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KIA extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'kia';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid',
        'kode_wilayah',
        'JUMLAH_AWAL_LK',
        'JUMLAH_AWAL_PR',
        'JUMLAH_AWAL_JML',
        'MEMILIKI_AWAL_LK',
        'MEMILIKI_AWAL_PR',
        'MEMILIKI_AWAL_JML',
        'BELUM_MEMILIKI_AWAL_LK',
        'BELUM_MEMILIKI_AWAL_PR',
        'BELUM_MEMILIKI_AWAL_JML',
        'PERSEN_AWAL',
        'USIA_LEBIH_TARGET_LK',
        'USIA_LEBIH_TARGET_PR',
        'USIA_LEBIH_TARGET_JML',
        'MENINGGAL_LK',
        'MENINGGAL_PR',
        'MENINGGAL_JML',
        'NONAKTIF_LK',
        'NONAKTIF_PR',
        'NONAKTIF_JML',
        'MEMILIKI_DALAM_DKB_LK',
        'MEMILIKI_DALAM_DKB_PR',
        'MEMILIKI_DALAM_DKB_JML',
        'MEMILIKI_LUAR_DKB_LK',
        'MEMILIKI_LUAR_DKB_PR',
        'MEMILIKI_LUAR_DKB_JML',
        'JUMLAH_DINAMIS_LK',
        'JUMLAH_DINAMIS_PR',
        'JUMLAH_DINAMIS_TTL',
        'MEMILIKI_DINAMIS_LK',
        'MEMILIKI_DINAMIS_PR',
        'MEMILIKI_DINAMIS_JML',
        'BELUM_MEMILIKI_DINAMIS_LK',
        'BELUM_MEMILIKI_DINAMIS_PR',
        'BELUM_MEMILIKI_DINAMIS_JML',
        'PERSEN_DINAMIS',
        'PENAMBAHAN_LK',
        'PENAMBAHAN_PR',
        'semester',
        'tahun'
    ];


}
