<?php

namespace App\Models\AgregatDKB\KepalaKeluarga;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusKawin extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'status_kawin_kepala_keluarga';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid','kode_wilayah',
        'Belum_Kawin_LK',
        'Belum_Kawin_PR',
        'Kawin_LK',
        'Kawin_PR',
        'Cerai_Hidup_LK',
        'Cerai_Hidup_PR',
        'Cerai_Mati_LK',
        'Cerai_Mati_PR',
        'semester','tahun',
    ];
}
