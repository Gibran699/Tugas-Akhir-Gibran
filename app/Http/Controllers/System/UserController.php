<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\DataPengguna;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'contact' => 'required|numeric',
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

        try {
            DB::beginTransaction();

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
            $user->assignRole($request->role);
            DB::commit();
            return response()->json(['message' => 'Berhasil membuat user'], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['data' => 'Terjadi kegagalan sistem: ' . $e->getMessage()], 500);
        }
    }
    function index()
    {
        $data = User::join('data_pengguna', 'data_pengguna.user_id', '=', 'users.id')
            ->select(
                'data_pengguna.nik',
                'data_pengguna.nama',
                'data_pengguna.contact',
                'users.email',
                'users.id'
            )->orderBy('data_pengguna.nama', 'asc')
            ->get();
        // $user = User::all();
        // // dd($user);
        $role = Role::select('name')->orderBy('name', 'asc')->get();
        return view('pengaturan.user.create_index', compact('data','role'));
    }
    function destroy($id)
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($id);
            $user->delete();
            DB::commit();
            return response()->json(['message' => 'Berhasil menghapus data'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Proses gagal'], 500);
        }
    }

    function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $dataPengguna = DataPengguna::where('user_id', $id)->firstOrFail();

            // Unique validations with ignoring current user
            $validateNik = DataPengguna::where('nik', $request->nik)
                ->where('user_id', '!=', $id)
                ->exists();

            $validateEmail = User::where('email', $request->email)
                ->where('id', '!=', $id)
                ->exists();

            $validateContact = DataPengguna::where('contact', $request->contact)
                ->where('user_id', '!=', $id)
                ->exists();

            if ($validateNik) return response()->json(['data' => 'NIK sudah terdaftar'], 409);
            if ($validateEmail) return response()->json(['data' => 'Email sudah terdaftar'], 409);
            if ($validateContact) return response()->json(['data' => 'Contact sudah terdaftar'], 409);

            DB::beginTransaction();

            // Update user
            $user->update([
                'name' => $request->name,
                'email' => $request->email, // Fixed typo from $request->name
            ]);

            // Update data pengguna
            $dataPengguna->update([
                'nik' => $request->nik,
                'nama' => $request->name,
                'contact' => $request->contact,
                'instansi' => $request->instansi,
                'nama_instansi' => $request->nama_instansi,
            ]);
            $user->assignRole($request->role);
            DB::commit();
            return response()->json(['message' => 'Berhasil mengubah data'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Proses gagal'], 500);
        }
    }
    function edit($id)
    {
        $data = User::join('data_pengguna', 'users.id', '=', 'data_pengguna.user_id')
            ->select(
                'users.id',
                'data_pengguna.nama',
                'data_pengguna.nik',
                'data_pengguna.contact',
                'users.email',
                'data_pengguna.instansi',
                'data_pengguna.nama_instansi',
            )
            ->where('users.id', $id)
            ->first();
        // Get the role names for the user
        $roleNames = $data->getRoleNames();

        // Add the role names to the data array
        $data->role_names = $roleNames->first();
        return response()->json($data, 200);
    }
}
