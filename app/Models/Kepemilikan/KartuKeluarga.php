<?php

namespace App\Models\Kepemilikan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class KartuKeluarga extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'kartu_keluarga';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid',
        'kode_wilayah',
        'KK_LK',
        'KK_PR',
        'KK_JML',
        'MEMILIKI_LK',
        'MEMILIKI_PR',
        'MEMILIKI_JML',
        'BELUM_MEMILIKI_LK',
        'BELUM_MEMILIKI_PR',
        'BELUM_MEMILIKI_JML',
        'semester',
        'tahun'
    ];
}
