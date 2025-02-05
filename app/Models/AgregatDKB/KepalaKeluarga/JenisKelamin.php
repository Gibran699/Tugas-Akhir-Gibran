<?php

namespace App\Models\AgregatDKB\KepalaKeluarga;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisKelamin extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'jenis_kelamin_kepala_keluarga';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid','kode_wilayah',
        'lk',
        'pr',
        'jumlah',
        'semester','tahun'
    ];
}
