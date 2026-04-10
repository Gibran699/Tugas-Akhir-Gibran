<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataPengguna extends Model
{
    use HasFactory,HasUuids,SoftDeletes;
    public $table = 'data_pengguna';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    protected $fillable =[
        'nik','nama','contact','instansi','nama_instansi','user_id'
    ];

    /**
     * Get the user that owns the data pengguna.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
