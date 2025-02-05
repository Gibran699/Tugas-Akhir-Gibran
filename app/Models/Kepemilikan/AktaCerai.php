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
        'uuid','kode_wilayah',
        'MUSLIM_JML',
        'NON_MUSLIM_JML',
        'STATUS_CERAI_LK',
        'STATUS_CERAI_PR',
        'STATUS_CERAI_JML',
        'MEMILIKI_AKTA_CERAI_LK',
        'MEMILIKI_AKTA_CERAI_PR',
        'MEMILIKI_AKTA_CERAI_JML',
        'BELUM_MEMILIKI_AKTA_CERAI_JML',
        'PERSEN_MEMILIKI',
        'semester','tahun'
    ];
}
