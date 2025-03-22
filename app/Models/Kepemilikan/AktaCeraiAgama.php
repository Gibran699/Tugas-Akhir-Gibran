<?php

namespace App\Models\Kepemilikan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AktaCeraiAgama extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'akta_cerai_agama';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid',
        'kode_wilayah',
        'islam_memiliki_lk',
        'islam_memiliki_pr',
        'islam_memiliki_jml',
        'islam_blm_memiliki_jml',
        'kristen_memiliki_lk',
        'kristen_memiliki_pr',
        'kristen_memiliki_jml',
        'kristen_blm_memiliki_jml',
        'katholik_memiliki_lk',
        'katholik_memiliki_pr',
        'katholik_memiliki_jml',
        'katholik_blm_memiliki_jml',
        'hindu_memiliki_lk',
        'hindu_memiliki_pr',
        'hindu_memiliki_jml',
        'hindu_blm_memiliki_jml',
        'budha_memiliki_lk',
        'budha_memiliki_pr',
        'budha_memiliki_jml',
        'budha_blm_memiliki_jml',
        'khonghucu_memiliki_lk',
        'khonghucu_memiliki_pr',
        'khonghucu_memiliki_jml',
        'khonghucu_blm_memiliki_jml',
        'kepercayaan_memiliki_lk',
        'kepercayaan_memiliki_pr',
        'kepercayaan_memiliki_jml',
        'kepercayaan_blm_memiliki_jml',
        'semester',
        'tahun'
    ];
}
