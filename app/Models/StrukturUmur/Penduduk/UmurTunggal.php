<?php

namespace App\Models\StrukturUmur\Penduduk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UmurTunggal extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'umur_tunggal_penduduk';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid','kode_wilayah',
        'umur',
        'lk',
        'pr',
        'jumlah',
        'semester','tahun'
    ];
}
