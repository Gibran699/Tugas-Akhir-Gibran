<?php

namespace App\Models\StrukturUmur\Agama;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KelompokUmur extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'kelompok_umur_agama';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid','kode_wilayah',
        'Kelompok_umur',
        'Islam_LK',
        'Islam_PR',
        'Islam_JML',
        'Katholik_LK',
        'Katholik_PR',
        'Katholik_JML',
        'Kristen_LK',
        'Kristen_PR',
        'Kristen_JML',
        'Hindu_LK',
        'Hindu_PR',
        'Hindu_JML',
        'Budha_LK',
        'Budha_PR',
        'Budha_JML',
        'Konghucu_LK',
        'Konghucu_PR',
        'Konghucu_JML',
        'Kepercayaan_LK',
        'Kepercayaan_PR',
        'Kepercayaan_JML',
        'semester','tahun'
    ];
}
