<?php

namespace App\Models\Kepemilikan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Akta_Cerai_Agama extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'akta_cerai_agama';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid','kode_wilayah',
        'ISLAM_MEMILIKI_LK',
        'ISLAM_MEMILIKI_PR',
        'ISLAM_MEMILIKI_JML',
        'ISLAM_BLM_MEMILIKI_JML',
        'KRISTEN_MEMILIKI_LK',
        'KRISTEN_MEMILIKI_PR',
        'KRISTEN_MEMILIKI_JML',
        'KRISTEN_BLM_MEMILIKI_JML',
        'KATHOLIK_MEMILIKI_LK',
        'KATHOLIK_MEMILIKI_PR',
        'KATHOLIK_MEMILIKI_JML',
        'KATHOLIK_BLM_MEMILIKI_JML',
        'HINDU_MEMILIKI_LK',
        'HINDU_MEMILIKI_PR',
        'HINDU_MEMILIKI_JML',
        'HINDU_BLM_MEMILIKI_JML',
        'BUDHA_MEMILIKI_LK',
        'BUDHA_MEMILIKI_PR',
        'BUDHA_MEMILIKI_JML',
        'BUDHA_BLM_MEMILIKI_JML',
        'KHONGHUCU_MEMILIKI_LK',
        'KHONGHUCU_MEMILIKI_PR',
        'KHONGHUCU_MEMILIKI_JML',
        'KHONGHUCU_BLM_MEMILIKI_JML',
        'KEPERCAYAAN_MEMILIKI_LK',
        'KEPERCAYAAN_MEMILIKI_PR',
        'KEPERCAYAAN_MEMILIKI_JML',
        'KEPERCAYAAN_BLM_MEMILIKI_JML',
        'semester','tahun'
    ];
}


