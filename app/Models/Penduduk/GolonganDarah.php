<?php

namespace App\Models\Penduduk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GolonganDarah extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'golongan_darah';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid','kode_wilayah',
        'A (LK)',
        'A (PR)',
        'A (JML)',
        'A- (LK)',
        'A- (PR)',
        'A- (JML)',
        'A+ (LK)',
        'A+ (PR)',
        'A+ (JML)',
        'B (LK)',
        'B (PR)',
        'B (JML)',
        'B- (LK)',
        'B- (PR)',
        'B- (JML)',
        'B+ (LK)',
        'B+ (PR)',
        'B+ (JML)',
        'AB (LK)',
        'AB (PR)',
        'AB (JML)',
        'AB- (LK)',
        'AB- (PR)',
        'AB- (JML)',
        'AB+ (LK)',
        'AB+ (PR)',
        'AB+ (JML)',
        'O (LK)',
        'O (PR)',
        'O (JML)',
        'O- (LK)',
        'O- (PR)',
        'O- (JML)',
        'O+ (LK)',
        'O+ (PR)',
        'O+ (JML)',
        'TIDAK TAHU (LK)',
        'TIDAK TAHU (PR)',
        'TIDAK TAHU (JML)',
        'semester','tahun',
    ];
}
