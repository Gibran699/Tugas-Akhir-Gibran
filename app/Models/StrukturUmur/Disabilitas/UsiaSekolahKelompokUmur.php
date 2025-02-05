<?php

namespace App\Models\StrukturUmur\Disabilitas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsiaSekolahKelompokUmur extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'usia_sekolah_kelompok_umur_disabilitas';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    public $fillable = [
        'uuid','kode_wilayah',
        'FISIK_U4_6TH_LK',
        'FISIK_U4_6TH_PR',
        'FISIK_U7_12TH_LK',
        'FISIK_U7_12TH_PR',
        'FISIK_U13_15TH_LK',
        'FISIK_U13_15TH_PR',
        'FISIK_U16_18TH_LK',
        'FISIK_U16_18TH_PR',
        'NETRA_BUTA_U4_6TH_LK',
        'NETRA_BUTA_U4_6TH_PR',
        'NETRA_BUTA_U7_12TH_LK',
        'NETRA_BUTA_U7_12TH_PR',
        'NETRA_BUTA_U13_15TH_LK',
        'NETRA_BUTA_U13_15TH_PR',
        'NETRA_BUTA_U16_18TH_LK',
        'NETRA_BUTA_U16_18TH_PR',
        'RUNGU_WICARA_U4_6TH_LK',
        'RUNGU_WICARA_U4_6TH_PR',
        'RUNGU_WICARA_U7_12TH_LK',
        'RUNGU_WICARA_U7_12TH_PR',
        'RUNGU_WICARA_U13_15TH_LK',
        'RUNGU_WICARA_U13_15TH_PR',
        'RUNGU_WICARA_U16_18TH_LK',
        'RUNGU_WICARA_U16_18TH_PR',
        'MENTAL_JIWA_U4_6TH_LK',
        'MENTAL_JIWA_U4_6TH_PR',
        'MENTAL_JIWA_U7_12TH_LK',
        'MENTAL_JIWA_U7_12TH_PR',
        'MENTAL_JIWA_U13_15TH_LK',
        'MENTAL_JIWA_U13_15TH_PR',
        'MENTAL_JIWA_U16_18TH_LK',
        'MENTAL_JIWA_U16_18TH_PR',
        'FISIK_MENTAL_U4_6TH_LK',
        'FISIK_MENTAL_U4_6TH_PR',
        'FISIK_MENTAL_U7_12TH_LK',
        'FISIK_MENTAL_U7_12TH_PR',
        'FISIK_MENTAL_U13_15TH_LK',
        'FISIK_MENTAL_U13_15TH_PR',
        'FISIK_MENTAL_U16_18TH_LK',
        'FISIK_MENTAL_U16_18TH_PR',
        'LAINNYA_U4_6TH_LK',
        'LAINNYA_U4_6TH_PR',
        'LAINNYA_U7_12TH_LK',
        'LAINNYA_U7_12TH_PR',
        'LAINNYA_U13_15TH_LK',
        'LAINNYA_U13_15TH_PR',
        'LAINNYA_U16_18TH_LK',
        'LAINNYA_U16_18TH_PR',
        'semester','tahun'
    ];
}
