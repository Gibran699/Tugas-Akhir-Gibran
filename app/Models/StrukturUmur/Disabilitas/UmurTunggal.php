<?php

namespace App\Models\StrukturUmur\Disabilitas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UmurTunggal extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'umur_tunggal_disabilitas';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid','kode_wilayah',
        'Umur',
        'Disabiltas_Fisik_LK',
        'Disabiltas_Fisik_PR',
        'Disabiltas_Fisik_JML',
        'Disabiltas_Netra_Buta_LK',
        'Disabiltas_Netra_Buta_PR',
        'Disabiltas_Netra_Buta_JML',
        'Disabiltas_Rungu_Wicara_LK',
        'Disabiltas_Rungu_Wicara_PR',
        'Disabiltas_Rungu_Wicara_JML',
        'Disabiltas_Mental_Jiwa_LK',
        'Disabiltas_Mental_Jiwa_PR',
        'Disabiltas_Mental_Jiwa_JML',
        'Disabiltas_Fisik_Mental_LK',
        'Disabiltas_Fisik_Mental_PR',
        'Disabiltas_Fisik_Mental_JML',
        'Disabiltas_Lainya_LK',
        'Disabiltas_Lainya_PR',
        'Disabiltas_Lainya_JML',
        'semester','tahun'
    ];
}
