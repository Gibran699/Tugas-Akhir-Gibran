<?php

namespace App\Models\AgregatDKB\Pendidikan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GolonganDarah extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'golongan_darah_pendidikan';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid','kode_wilayah',
        'A_LK',
        'A_PR',
        'A_JML',
        'A_M_LK',
        'A_M_PR',
        'A_M_JML',
        'A_P_LK',
        'A_P_PR',
        'A_P_JML',
        'B_LK',
        'B_PR',
        'B_JML',
        'B_M_LK',
        'B_M_PR',
        'B_M_JML',
        'B_P_LK',
        'B_P_PR',
        'B_P_JML',
        'AB_LK',
        'AB_PR',
        'AB_JML',
        'AB_M_LK',
        'AB_M_PR',
        'AB_M_JML',
        'AB_P_LK',
        'AB_P_PR',
        'AB_P_JML',
        'O_LK',
        'O_PR',
        'O_JML',
        'O_M_LK',
        'O_M_PR',
        'O_M_JML',
        'O_P_LK',
        'O_P_PR',
        'O_P_JML',
        'TIDAK_TAHU_LK',
        'TIDAK_TAHU_PR',
        'TIDAK_TAHU_JML',
        'semester','tahun'
    ];
}
