<?php

namespace App\Models\AgregatDKB\Disabilitas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class JenisKelamin extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'jenis_kelamin_disabilitas';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid', 'kode_wilayah',
        'disabilitas_fisik_lk',
        'disabilitas_fisik_pr',
        'disabilitas_fisik_jml',
        'disabilitas_netra_buta_lk',
        'disabilitas_netra_buta_pr',
        'disabilitas_netra_buta_jml',
        'disabilitas_rungu_wicara_lk',
        'disabilitas_rungu_wicara_pr',
        'disabilitas_rungu_wicara_jml',
        'disabilitas_mental_jiwa_lk',
        'disabilitas_mental_jiwa_pr',
        'disabilitas_mental_jiwa_jml',
        'disabilitas_fisik_mental_lk',
        'disabilitas_fisik_mental_pr',
        'disabilitas_fisik_mental_jml',
        'disabilitas_lainnya_lk',
        'disabilitas_lainnya_pr',
        'disabilitas_lainnya_jml',
        'semester', 'tahun'
    ];
    
}
