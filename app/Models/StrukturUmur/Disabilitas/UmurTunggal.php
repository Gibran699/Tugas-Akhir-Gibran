<?php

namespace App\Models\StrukturUmur\Disabilitas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UmurTunggal extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'umur_tunggal_disabilitas';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid', 'kode_wilayah',
        'umur',
        'disabiltas_fisik_lk',
        'disabiltas_fisik_pr',
        'disabiltas_fisik_jml',
        'disabiltas_netra_buta_lk',
        'disabiltas_netra_buta_pr',
        'disabiltas_netra_buta_jml',
        'disabiltas_rungu_wicara_lk',
        'disabiltas_rungu_wicara_pr',
        'disabiltas_rungu_wicara_jml',
        'disabiltas_mental_jiwa_lk',
        'disabiltas_mental_jiwa_pr',
        'disabiltas_mental_jiwa_jml',
        'disabiltas_fisik_mental_lk',
        'disabiltas_fisik_mental_pr',
        'disabiltas_fisik_mental_jml',
        'disabiltas_lainya_lk',
        'disabiltas_lainya_pr',
        'disabiltas_lainya_jml',
        'semester', 'tahun',
    ];
}
