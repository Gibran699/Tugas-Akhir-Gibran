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
    protected $fillable = [
        'uuid', 'kode_wilayah',
        'fisik_u4_6th_lk',
        'fisik_u4_6th_pr',
        'fisik_u7_12th_lk',
        'fisik_u7_12th_pr',
        'fisik_u13_15th_lk',
        'fisik_u13_15th_pr',
        'fisik_u16_18th_lk',
        'fisik_u16_18th_pr',
        'netra_buta_u4_6th_lk',
        'netra_buta_u4_6th_pr',
        'netra_buta_u7_12th_lk',
        'netra_buta_u7_12th_pr',
        'netra_buta_u13_15th_lk',
        'netra_buta_u13_15th_pr',
        'netra_buta_u16_18th_lk',
        'netra_buta_u16_18th_pr',
        'rungu_wicara_u4_6th_lk',
        'rungu_wicara_u4_6th_pr',
        'rungu_wicara_u7_12th_lk',
        'rungu_wicara_u7_12th_pr',
        'rungu_wicara_u13_15th_lk',
        'rungu_wicara_u13_15th_pr',
        'rungu_wicara_u16_18th_lk',
        'rungu_wicara_u16_18th_pr',
        'mental_jiwa_u4_6th_lk',
        'mental_jiwa_u4_6th_pr',
        'mental_jiwa_u7_12th_lk',
        'mental_jiwa_u7_12th_pr',
        'mental_jiwa_u13_15th_lk',
        'mental_jiwa_u13_15th_pr',
        'mental_jiwa_u16_18th_lk',
        'mental_jiwa_u16_18th_pr',
        'fisik_mental_u4_6th_lk',
        'fisik_mental_u4_6th_pr',
        'fisik_mental_u7_12th_lk',
        'fisik_mental_u7_12th_pr',
        'fisik_mental_u13_15th_lk',
        'fisik_mental_u13_15th_pr',
        'fisik_mental_u16_18th_lk',
        'fisik_mental_u16_18th_pr',
        'lainnya_u4_6th_lk',
        'lainnya_u4_6th_pr',
        'lainnya_u7_12th_lk',
        'lainnya_u7_12th_pr',
        'lainnya_u13_15th_lk',
        'lainnya_u13_15th_pr',
        'lainnya_u16_18th_lk',
        'lainnya_u16_18th_pr',
        'semester', 'tahun',
    ];
}
