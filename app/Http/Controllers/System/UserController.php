<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\DataPengguna;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function store(Request $request) {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'contact' => 'required',
            'nik' => 'required|integer',
            'instansi' => 'required|integer',
            'nama_instasi' => 'required'
        ]);
        $validateNik = DataPengguna::where('nik',$request->nik)->exists();
        $validateEmail = User::where('email',$request->email)->exists();
        $validateContact = User::where('contact',$request->contact)->exists();
        if ($validateNik) {
            return response()->json('Nik sudah terdaftar', 409);
        }
        if ($validateEmail) {
            return response()->json('Email sudah terdaftar', 409);
        }
        if ($validateContact) {
            return response()->json('Contact sudah terdaftar', 409);
        }
        
    }
}
