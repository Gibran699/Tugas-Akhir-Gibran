<?php

namespace App\Models\Kepemilikan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AktaKawin extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'akta_kawin';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid',
        'kode_wilayah',
        'muslim_jml',
        'non_muslim_jml',
        'status_kawin_lk',
        'status_kawin_pr',
        'status_kawin_jml',
        'memiliki_akta_kawin_lk',
        'memiliki_akta_kawin_pr',
        'memiliki_akta_kawin_jml',
        'belum_memiliki_akta_kawin_jml',
        'persen_memiliki',
        'semester',
        'tahun'
    ];
    
}
