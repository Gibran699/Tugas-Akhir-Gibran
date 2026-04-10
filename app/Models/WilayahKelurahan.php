<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WilayahKelurahan extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'mstr_kelurahan';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid',
        'kode',
        'nama',
        'kec_id'
    ];

    public function kecamatan()
    {
        return $this->belongsTo(\App\Models\WilayahKecamatan::class, 'kec_id');
    }
}
