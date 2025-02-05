<?php

namespace App\Models\StrukturUmur\Penduduk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusKawinUmurTunggal extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'status_kawin_umur_tunggal_penduduk';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid','kode_wilayah',
        'umur',
        'BELUM_KAWIN_LK',
        'BELUM_KAWIN_PR',
        'KAWIN_LK',
        'KAWIN_PR',
        'CERAI_HIDUP_LK',
        'CERAI_HIDUP_PR',
        'CERAI_MATI_LK',
        'CERAI_MATI_PR',
        'semester','tahun'
    ];
}
