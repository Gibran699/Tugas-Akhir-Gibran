<?php

namespace App\Models\StrukturUmur\Penduduk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatusKawinUmurTunggal extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'status_kawin_umur_tunggal_penduduk';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid',
        'kode_wilayah',
        'umur',
        'belum_kawin_lk',
        'belum_kawin_pr',
        'kawin_lk',
        'kawin_pr',
        'cerai_hidup_lk',
        'cerai_hidup_pr',
        'cerai_mati_lk',
        'cerai_mati_pr',
        'semester',
        'tahun'
    ];
}
