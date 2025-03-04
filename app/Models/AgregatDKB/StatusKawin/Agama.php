<?php

namespace App\Models\AgregatDKB\StatusKawin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agama extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'status_kawin_penduduk_agama';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid','kode_wilayah',
        'keterangan',
        'islam_lk',
        'islam_pr',
        'islam_jml',
        'katholik_lk',
        'katholik_pr',
        'katholik_jml',
        'kristen_lk',
        'kristen_pr',
        'kristen_jml',
        'hindu_lk',
        'hindu_pr',
        'hindu_jml',
        'budha_lk',
        'budha_pr',
        'budha_jml',
        'konghucu_lk',
        'konghucu_pr',
        'konghucu_jml',
        'kepercayaan_lk',
        'kepercayaan_pr',
        'kepercayaan_jml',
        'semester','tahun'
    ];
}
