<?php

namespace App\Models\Kepemilikan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KIA extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'kia';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid','kode_wilayah',
        'JUMLAH AWAL(LK)',
        'JUMLAH AWAL(PR)',
        'JUMLAH AWAL(JML)',
        'MEMILIKI AWAL(LK)',
        'MEMILIKI AWAL(PR)',
        'MEMILIKI AWAL(JML)',
        'BELUM MEMILIKI AWAL(LK)',
        'BELUM MEMILIKI AWAL(PR)',
        'BELUM MEMILIKI AWAL(JML)',
        'PERSEN AWAL(%)',
        'USIA LEBIH TARGET(LK)',
        'USIA LEBIH TARGET(PR)',
        'USIA LEBIH TARGET(JML)',
        'MENINGGAL(LK)',
        'MENINGGAL(PR)',
        'MENINGGAL(JML)',
        'NONAKTIF(LK)',
        'NONAKTIF(PR)',
        'NONAKTIF(JML)',
        'MEMILIKI DALAM DKB(LK)',
        'MEMILIKI DALAM DKB(PR)',
        'MEMILIKI DALAM DKB(JML)',
        'MEMILIKI LUAR DKB(LK)',
        'MEMILIKI LUAR DKB(PR)',
        'MEMILIKI LUAR DKB(JML)',
        'JUMLAH DINAMIS(LK)',
        'JUMLAH DINAMIS(PR)',
        'JUMLAH DINAMIS(TTL)',
        'MEMILIKI DINAMIS(LK)',
        'MEMILIKI DINAMIS(PR)',
        'MEMILIKI DINAMIS(JML)',
        'BELUM MEMILIKI DINAMIS(LK)',
        'BELUM MEMILIKI DINAMIS(PR)',
        'BELUM MEMILIKI DINAMIS(JML)',
        'PERSEN DINAMIS(%)',
        'PENAMBAHAN(LK)',
        'PENAMBAHAN(PR)',
        'semester','tahun'
    ];


}
