<?php

namespace App\Models\Kepemilikan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Akta_Kawin extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'akta_kawin';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid',
        'kode_wilayah',
        'MUSLIM_JML',
        'NON_MUSLIM_JML',
        'STATUS_KAWIN_LK',
        'STATUS_KAWIN_PR',
        'STATUS_KAWIN_JML',
        'MEMILIKI_AKTA_KAWIN_LK',
        'MEMILIKI_AKTA_KAWIN_PR',
        'MEMILIKI_AKTA_KAWIN_JML',
        'BELUM_MEMILIKI_AKTA_KAWIN_JML',
        'PERSEN_MEMILIKI',
        'semester',
        'tahun'
    ];
}
