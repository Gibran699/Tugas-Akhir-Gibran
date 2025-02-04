<?php

namespace App\Models\Kepemilikan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akta_Kawin extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'akta_kawin';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid','kode_wilayah',
        'MUSLIM(JML)',
        'NON MUSLIM(JML)',
        'STATUS KAWIN(LK)',
        'STATUS KAWIN(PR)',
        'STATUS KAWIN(JML)',
        'MEMILIKI AKTA KAWIN(LK)',
        'MEMILIKI AKTA KAWIN(PR)',
        'MEMILIKI AKTA KAWIN(JML)',
        'BELUM MEMILIKI AKTA KAWIN(JML)',
        'PERSEN (MEMILIKI)(%)',
        'semester','tahun'
    ];
}
