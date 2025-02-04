<?php

namespace App\Models\Penduduk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HubunganKeluarga extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'hubungan_keluarga';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid','kode_wilayah',
        'TIDAK/BLM SEKOLAH L',
        'TIDAK/BLM SEKOLAH P',
        'TIDAK/BLM SEKOLAH JML',
        'BELUM TAMAT SD/SEDERAJAT L',
        'BELUM TAMAT SD/SEDERAJAT P',
        'BELUM TAMAT SD/SEDERAJAT JML',
        'TAMAT SD/SEDERAJAT L',
        'TAMAT SD/SEDERAJAT P',
        'TAMAT SD/SEDERAJAT JML',
        'SLTP/SEDERAJAT L',
        'SLTP/SEDERAJAT P',
        'SLTP/SEDERAJAT JML',
        'SLTA/SEDERAJAT L',
        'SLTA/SEDERAJAT P',
        'SLTA/SEDERAJAT JML',
        'DIPLOMA I/II L',
        'DIPLOMA I/II P',
        'DIPLOMA I/II JML',
        'AKADEMI/DIPL.III/S. MUDA L',
        'AKADEMI/DIPL.III/S.MUDA P',
        'AKADEMI/DIPL.III/S.MUDA JML',
        'DIPLOMA IV/STRATA I L',
        'DIPLOMA IV/STRATA I P',
        'DIPLOMA IV/STRATA I JML',
        'STRATA-II L',
        'STRATA-II P',
        'STRATA-II JML',
        'STRATA-III L',
        'STRATA-III P',
        'STRATA-III JML',
        'semester','tahun'
    ];
}
