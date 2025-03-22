<?php

namespace App\Models\AgregatDKB\Disabilitas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pendidikan extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'pendidikan_disabilitas';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid',
        'kode_wilayah',
        'keterangan',
        'tidak_blm_sekolah_l',
        'tidak_blm_sekolah_p',
        'tidak_blm_sekolah_jml',
        'belum_tamat_sd_sederajat_l',
        'belum_tamat_sd_sederajat_p',
        'belum_tamat_sd_sederajat_jml',
        'tamat_sd_sederajat_l',
        'tamat_sd_sederajat_p',
        'tamat_sd_sederajat_jml',
        'sltp_sederajat_l',
        'sltp_sederajat_p',
        'sltp_sederajat_jml',
        'slta_sederajat_l',
        'slta_sederajat_p',
        'slta_sederajat_jml',
        'diploma_i_ii_l',
        'diploma_i_ii_p',
        'diploma_i_ii_jml',
        'akademi_dipl_iii_s_muda_l',
        'akademi_dipl_iii_s_muda_p',
        'akademi_dipl_iii_s_muda_jml',
        'diploma_iv_strata_i_l',
        'diploma_iv_strata_i_p',
        'diploma_iv_strata_i_jml',
        'strata_ii_l',
        'strata_ii_p',
        'strata_ii_jml',
        'strata_iii_l',
        'strata_iii_p',
        'strata_iii_jml',
        'semester',
        'tahun',
    ];
}
