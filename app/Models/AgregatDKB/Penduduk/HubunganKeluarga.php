<?php

namespace App\Models\AgregatDKB\Penduduk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HubunganKeluarga extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'hubungan_keluarga_penduduk';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid','kode_wilayah',
        'TIDAK_BLM_SEKOLAH_L',
        'TIDAK_BLM_SEKOLAH_P',
        'TIDAK_BLM_SEKOLAH_JML',
        'BELUM_TAMAT_SD_SEDERAJAT_L',
        'BELUM_TAMAT_SD_SEDERAJAT_P',
        'BELUM_TAMAT_SD_SEDERAJAT_JML',
        'TAMAT_SD_SEDERAJAT_L',
        'TAMAT_SD_SEDERAJAT_P',
        'TAMAT_SD_SEDERAJAT_JML',
        'SLTP_SEDERAJAT_L',
        'SLTP_SEDERAJAT_P',
        'SLTP_SEDERAJAT_JML',
        'SLTA_SEDERAJAT_L',
        'SLTA_SEDERAJAT_P',
        'SLTA_SEDERAJAT_JML',
        'DIPLOMA_I_II_L',
        'DIPLOMA_I_II_P',
        'DIPLOMA_I_II_JML',
        'AKADEMI_DIPL_III_S_MUDA_L',
        'AKADEMI_DIPL_III_S_MUDA_P',
        'AKADEMI_DIPL_III_S_MUDA_JML',
        'DIPLOMA_IV_STRATA_I_L',
        'DIPLOMA_IV_STRATA_I_P',
        'DIPLOMA_IV_STRATA_I_JML',
        'STRATA_II_L',
        'STRATA_II_P',
        'STRATA_II_JML',
        'STRATA_III_L',
        'STRATA_III_P',
        'STRATA_III_JML',
        'semester','tahun'
    ];
}
