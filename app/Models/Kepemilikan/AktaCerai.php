<?php

namespace App\Models\Kepemilikan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AktaCerai extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'akta_cerai';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid', 'kode_wilayah',
        'muslim_jml',
        'non_muslim_jml',
        'status_cerai_lk',
        'status_cerai_pr',
        'status_cerai_jml',
        'memiliki_akta_cerai_lk',
        'memiliki_akta_cerai_pr',
        'memiliki_akta_cerai_jml',
        'belum_memiliki_akta_cerai_jml',
        'persen_memiliki',
        'semester', 'tahun'
    ];
    
}
