<?php

namespace App\Models\StrukturUmur\Penduduk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KelompokUmur extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'kelompok_umur_penduduk';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid',
        'kode_wilayah',
        '00_04_tahun_lk',
        '00_04_tahun_pr',
        '00_04_tahun_jml',
        '05_09_tahun_lk',
        '05_09_tahun_pr',
        '05_09_tahun_jml',
        '10_14_tahun_lk',
        '10_14_tahun_pr',
        '10_14_tahun_jml',
        '15_19_tahun_lk',
        '15_19_tahun_pr',
        '15_19_tahun_jml',
        '20_24_tahun_lk',
        '20_24_tahun_pr',
        '20_24_tahun_jml',
        '25_29_tahun_lk',
        '25_29_tahun_pr',
        '25_29_tahun_jml',
        '30_34_tahun_lk',
        '30_34_tahun_pr',
        '30_34_tahun_jml',
        '35_39_tahun_lk',
        '35_39_tahun_pr',
        '35_39_tahun_jml',
        '40_44_tahun_lk',
        '40_44_tahun_pr',
        '40_44_tahun_jml',
        '45_49_tahun_lk',
        '45_49_tahun_pr',
        '45_49_tahun_jml',
        '50_54_tahun_lk',
        '50_54_tahun_pr',
        '50_54_tahun_jml',
        '55_59_tahun_lk',
        '55_59_tahun_pr',
        '55_59_tahun_jml',
        '60_64_tahun_lk',
        '60_64_tahun_pr',
        '60_64_tahun_jml',
        '65_69_tahun_lk',
        '65_69_tahun_pr',
        '65_69_tahun_jml',
        '70_74_tahun_lk',
        '70_74_tahun_pr',
        '70_74_tahun_jml',
        'lebih_75_tahun_lk',
        'lebih_75_tahun_pr',
        'lebih_75_tahun_jml',
        'semester',
        'tahun'
    ];
}
