<?php

namespace App\Models\Kepemilikan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akta_Kelahiran extends Model
{
    use HasFactory,SoftDeletes;
    public $table = 'akta_kelahiran';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid','kode_wilayah','WAJIB AKTA(AWAL - LK)',
        'WAJIB AKTA(AWAL-PR)','WAJIB AKTA(AWAL-JML)',
        'MEMILIKI(AWAL-LK)',
        'MEMILIKI(AWAL-PR)',
        'MEMILIKI(AWAL-JML)',
        'BELUM MEMILIKI(AWAL-LK)',
        'BELUM MEMILIKI(AWAL-PR)',
        'BELUM MEMILIKI(AW AL-LK)',
        'BELUM MEMILIKI(AWAL-PR)',
        'BELUM MEMILIKI(AWAL-JML)',
        'PERSEN (AWAL)(%)',
        'USIA LEBIH DARI TARGET(LK)',
        'USIA LEBIH DARI TARGET(PR)',
        'USIA LEBIH DARI TARGET(JML)',
        'MENINGGAL(LK)',
        'MENINGGAL(PR)',
        'MENINGGAL(JML)',
        'NONAKTIF(LK)',
        'NONAKTIF(PR)',
        'NONAKTIF(JML)',
        'PINDAH(LK)',
        'PINDAH(PR)',
        'PINDAH(JML)',
        'DATANG(LK)',
        'DATANG(PR)',
        'DATANG(JML)',
        'Hapus OPERATOR(LK)',
        'Hapus OPERATOR(PR)',
        'Hapus OPERATOR(JML)',
        'TERBIT AKTA BARU(DALAM DKB - LK)',
        'TERBIT AKTA BARU(DALAM DKB - PR)',
        'TERBIT AKTA BARU(DALAM DKB - JML)',
        'TERBIT AKTA BARU(LUAR DKB - LK)',
        'TERBIT AKTA BARU(LUAR DKB - PR)',
        'TERBIT AKTA BARU(LUAR DKB - JML)',
        'WAJIB AKTA(DINAMIS - LK)',
        'WAJIB AKTA(DINAMIS - PR)',
        'WAJIB AKTA(DINAMIS - JML)',
        'MEMILIKI(DINAMIS - LK)',
        'MEMILIKI(DINAMIS - PR)',
        'MEMILIKI(DINAMIS - JML)',
        'BELUM MEMILIKI(DINAMIS - LK)',
        'BELUM MEMILIKI(DINAMIS - PR)',
        'BELUM MEMILIKI(DINAMIS - JML)',
        'PERSEN (DINAMIS)(%)',
        'PENAMBAHAN(LK)',
        'PENAMBAHAN(PR)',
        'PENAMBAHAN(JML)',
        'semester','tahun',
    ];
}
