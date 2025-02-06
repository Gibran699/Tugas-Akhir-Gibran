<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\DataPengguna;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'contact' => 'required|integer',
            'nik' => 'required|integer',
            'instansi' => 'required|integer',
            'nama_instansi' => 'required',
        ]);
    
        $validateNik = DataPengguna::where('nik', $request->nik)->exists();
        $validateEmail = User::where('email', $request->email)->exists();
        $validateContact = DataPengguna::where('contact', $request->contact)->exists();
    
        if ($validateNik) {
            return response()->json(['data' => 'NIK sudah terdaftar'], 409);
        }
        if ($validateEmail) {
            return response()->json(['data' => 'Email sudah terdaftar'], 409);
        }
        if ($validateContact) {
            return response()->json(['data' => 'Contact sudah terdaftar'], 409);
        }
    
        // try {
        //     DB::beginTransaction();
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('6472Dukcapil')
            ]);
    
            DataPengguna::create([
                'nik' => $request->nik,
                'nama' => $request->name,
                'contact' => $request->contact,
                'instansi' => $request->instansi,
                'nama_instansi' => $request->nama_instansi,
                'user_id' => $user->id,
            ]);
    
            // Assign role if needed
            // $user->assignRole($request->role);
            // DB::commit();
            return response()->json(['message' => 'Berhasil membuat user'], 200);
    
        // } catch (Exception $e) {
        //     DB::rollback();
        //     return response()->json(['data' => 'Terjadi kegagalan sistem: ' . $e->getMessage()], 500);
        // }
    }
}
