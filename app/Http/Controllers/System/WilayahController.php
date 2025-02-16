<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\WilayahKelurahan;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    function indexKelurahan() {
        $data = WilayahKelurahan::select('uuid','kode','nama','kec_id')->orderBy('kec_id','asc')->get();
        return response()->json([
            'data' => $data // Wrap the data in a 'data' key
        ], 200);
    }
}
