<?php

namespace App\Models\Kepemilikan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ktp extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'ktp';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid',
        'kode_wilayah',
        'wajib_ktp_lk',
        'wajib_ktp_pr',
        'wajib_ktp_jml',
        'rekam_lk',
        'rekam_pr',
        'rekam_jml',
        'belum_rekam_lk',
        'belum_rekam_pr',
        'belum_rekam_jml',
        'ktp_pr',
        'ktp_lk',
        'ktp_jml',
        'blm_ktp_lk',
        'blm_ktp_pr',
        'blm_ktp_jml',
        'semester',
        'tahun',
    ];
}
