<?php

namespace App\Models\StrukturUmur\Penduduk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsiaSekolah extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'usia_sekolah_penduduk';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid',
        'kode_wilayah',
        'usia_sd_sederajat',
        'usia_sltp_sederajat',
        'usia_slta_sederajat',
        'usia_perguruan_tinggi',
        'semester',
        'tahun',
    ];
}
