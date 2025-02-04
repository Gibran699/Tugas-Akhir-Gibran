<?php

namespace App\Models\Kepemilikan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Akta_Cerai extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'akta_cerai';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid','kode_wilayah',
        'MUSLIM(JML)',
        'NON MUSLIM(JML)',
        'STATUS CERAI(LK)',
        'STATUS CERAI(PR)',
        'STATUS CERAI(JML)',
        'MEMILIKI AKTA CERAI(LK)',
        'MEMILIKI AKTA CERAI(PR)',
        'MEMILIKI AKTA CERAI(JML)',
        'BELUM MEMILIKI AKTA CERAI(JML)',
        'PERSEN (MEMILIKI)(%)',
        'semester','tahun'
    ];
}
