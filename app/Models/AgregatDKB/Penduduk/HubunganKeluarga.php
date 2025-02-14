<?php

namespace App\Models\AgregatDKB\Penduduk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HubunganKeluarga extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'hubungan_keluarga_penduduk';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid',
        'kode_wilayah',
        "kepala_keluarga_l",
        "kepala_keluarga_p",
        "kepala_keluarga_jml",
        "suami_l",
        "suami_p",
        "suami_jml",
        "isteri_l",
        "isteri_p",
        "isteri_jml",
        "anak_l",
        "anak_p",
        "anak_jml",
        "menantu_l",
        "menantu_p",
        "menantu_jml",
        "cucu_l",
        "cucu_p",
        "cucu_jml",
        "orang_tua_l",
        "orang_tua_p",
        "orang_tua_jml",
        "mertua_l",
        "mertua_p",
        "mertua_jml",
        "famili_lain_l",
        "famili_lain_p",
        "famili_lain_jml",
        "pembantu_l",
        "pembantu_p",
        "pembantu_jml",
        "lainnya_l",
        "lainnya_p",
        "lainnya_jml",
        'semester',
        'tahun'
    ];
}
