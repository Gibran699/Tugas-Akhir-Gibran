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
        'uuid', 'kode_wilayah','keterangan',
        'a_lk', 'a_pr', 'a_jml',
        'a_m_lk', 'a_m_pr', 'a_m_jml',
        'a_p_lk', 'a_p_pr', 'a_p_jml',
        'b_lk', 'b_pr', 'b_jml',
        'b_m_lk', 'b_m_pr', 'b_m_jml',
        'b_p_lk', 'b_p_pr', 'b_p_jml',
        'ab_lk', 'ab_pr', 'ab_jml',
        'ab_m_lk', 'ab_m_pr', 'ab_m_jml',
        'ab_p_lk', 'ab_p_pr', 'ab_p_jml',
        'o_lk', 'o_pr', 'o_jml',
        'o_m_lk', 'o_m_pr', 'o_m_jml',
        'o_p_lk', 'o_p_pr', 'o_p_jml',
        'tidak_tahu_lk', 'tidak_tahu_pr', 'tidak_tahu_jml',
        'semester', 'tahun'
    ];
}
