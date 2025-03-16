<?php

namespace App\Models\Kepemilikan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'jumlah_awal_lk',
        'jumlah_awal_pr',
        'jumlah_awal_jml',
        'memiliki_awal_lk',
        'memiliki_awal_pr',
        'memiliki_awal_jml',
        'belum_memiliki_awal_lk',
        'belum_memiliki_awal_pr',
        'belum_memiliki_awal_jml',
        'usia_lebih_target_lk',
        'usia_lebih_target_pr',
        'usia_lebih_target_jml',
        'meninggal_lk',
        'meninggal_pr',
        'meninggal_jml',
        'nonaktif_lk',
        'nonaktif_pr',
        'nonaktif_jml',
        'memiliki_dalam_dkb_lk',
        'memiliki_dalam_dkb_pr',
        'memiliki_dalam_dkb_jml',
        'memiliki_luar_dkb_lk',
        'memiliki_luar_dkb_pr',
        'memiliki_luar_dkb_jml',
        'jumlah_dinamis_lk',
        'jumlah_dinamis_pr',
        'jumlah_dinamis_ttl',
        'memiliki_dinamis_lk',
        'memiliki_dinamis_pr',
        'memiliki_dinamis_jml',
        'belum_memiliki_dinamis_lk',
        'belum_memiliki_dinamis_pr',
        'belum_memiliki_dinamis_jml',
        'penambahan_lk',
        'penambahan_pr',
        'penambahan_jml',
        'semester',
        'tahun',
    ];


}
