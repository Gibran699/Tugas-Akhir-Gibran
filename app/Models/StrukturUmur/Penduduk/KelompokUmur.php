<?php

namespace App\Models\StrukturUmur\Penduduk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KelompokUmur extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'kelompok_umur_penduduk';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid','kode_wilayah',
        '00_04_TAHUN_LK',
        '00_04_TAHUN_PR',
        '00_04_TAHUN_JML',
        '05_09_TAHUN_LK',
        '05_09_TAHUN_PR',
        '05_09_TAHUN_JML',
        '10_14_TAHUN_LK',
        '10_14_TAHUN_PR',
        '10_14_TAHUN_JML',
        '15_19_TAHUN_LK',
        '15_19_TAHUN_PR',
        '15_19_TAHUN_JML',
        '20_24_TAHUN_LK',
        '20_24_TAHUN_PR',
        '20_24_TAHUN_JML',
        '25_29_TAHUN_LK',
        '25_29_TAHUN_PR',
        '25_29_TAHUN_JML',
        '30_34_TAHUN_LK',
        '30_34_TAHUN_PR',
        '30_34_TAHUN_JML',
        '35_39_TAHUN_LK',
        '35_39_TAHUN_PR',
        '35_39_TAHUN_JML',
        '40_44_TAHUN_LK',
        '40_44_TAHUN_PR',
        '40_44_TAHUN_JML',
        '45_49_TAHUN_LK',
        '45_49_TAHUN_PR',
        '45_49_TAHUN_JML',
        '50_54_TAHUN_LK',
        '50_54_TAHUN_PR',
        '50_54_TAHUN_JML',
        '55_59_TAHUN_LK',
        '55_59_TAHUN_PR',
        '55_59_TAHUN_JML',
        '60_64_TAHUN_LK',
        '60_64_TAHUN_PR',
        '60_64_TAHUN_JML',
        '65_69_TAHUN_LK',
        '65_69_TAHUN_PR',
        '65_69_TAHUN_JML',
        '70_74_TAHUN_LK',
        '70_74_TAHUN_PR',
        '70_74_TAHUN_JML',
        'LEBIH_75_TAHUN_LK',
        'LEBIH_75_TAHUN_PR',
        'LEBIH_75_TAHUN_JML',
        'semester','tahun'
    ];
}
