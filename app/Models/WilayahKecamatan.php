<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WilayahKecamatan extends Model
{
    use HasFactory,SoftDeletes;

    public $table = 'mstr_kecamatan';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];

    protected $fillabel = [
        'uuid','kode','nama'
    ];
}
