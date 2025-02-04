<?php

namespace App\Models\Kepemilikan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kartu_Keluarga extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'kartu_keluarga';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid','kode_wilayah',
        'KK(LK)',
        'KK(PR)',
        'KK(JML)',
        'MEMILIKI(LK)',
        'MEMILIKI(PR)',
        'MEMILIKI(JML)',
        'BELUM MEMILIKI(LK)',
        'BELUM MEMILIKI(PR)',
        'BELUM MEMILIKI(JML)',
        'semester','tahun'];
}
