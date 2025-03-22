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
        'kk_lk',
        'kk_pr',
        'kk_jml',
        'memiliki_lk',
        'memiliki_pr',
        'memiliki_jml',
        'belum_memiliki_lk',
        'belum_memiliki_pr',
        'belum_memiliki_jml',
        'semester',
        'tahun',
    ];    
}
