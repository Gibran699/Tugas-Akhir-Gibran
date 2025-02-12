<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WilayahKelurahan extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'wilayah_kelurahan';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid',
        'kode',
        'kode_salah',
        'nama',
        'slug',
        'kec_id',
        'meta',
        'path',
        'saku_peta',
        'saku_overview',
        'saku_struktur',
        't_rt',
        't_rumah',
        't_kk',
        't_penduduk',
        't_user',
        'chart_gender',
        'chart_agama'
    ];
}
