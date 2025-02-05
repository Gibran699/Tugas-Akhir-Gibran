<?php

namespace App\Models\StrukturUmur\Penduduk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsiaMudaProduktifTua extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'usia_muda_produktif_tua_penduduk';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid','kode_wilayah',
        'USIA_MUDA',
        'USIA_PRODUKTIF',
        'USIA_TUA',
        'semester','tahun'
    ];
}
