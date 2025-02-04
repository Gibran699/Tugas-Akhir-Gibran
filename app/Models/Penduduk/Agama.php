<?php

namespace App\Models\Penduduk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agama extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'penduduk_agama';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid','kode_wilayah','Islam PR','Islam JML',
        'Katholik LK','Katholik PR','Katholik JML',
        'Kristen LK','Kristen PR','Kristen JML',
        'Hindu LK','Hindu PR','Hindu JML',
        'Budha LK','Budha PR','Budha JML',
        'Konghucu LK','Konghucu PR','Konghucu JML',
        'Kepercayaan LK','Kepercayaan PR','Kepercayaan JML',
        'semester','tahun'
    ];
}
