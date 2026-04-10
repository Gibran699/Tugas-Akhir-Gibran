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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'contact' => 'required|numeric|digits_between:10,15',
            'nik' => 'required|integer|digits:16|unique:data_pengguna,nik',
            'instansi' => 'required|integer',
            'nama_instansi' => 'required|string|max:255',
            'role' => 'required|exists:roles,name',
        ]);

        // Validation sudah ditangani oleh Laravel validation rules di atas

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

            // Assign role
            if ($request->role) {
                $user->syncRoles([$request->role]);
            }
            DB::commit();
            return response()->json(['message' => 'Berhasil membuat user'], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['data' => 'Terjadi kegagalan sistem: ' . $e->getMessage()], 500);
        }
    }
    function index()
    {
        // Optimized query with proper select and indexing
        $data = User::join('data_pengguna', 'data_pengguna.user_id', '=', 'users.id')
            ->select(
                'users.id',
                'data_pengguna.nik',
                'data_pengguna.nama',
                'data_pengguna.contact',
                'users.email'
            )
            ->orderBy('data_pengguna.nama', 'asc')
            ->get();
        
        // Cache role list untuk mengurangi query
        $role = Role::select('name')
            ->orderBy('name', 'asc')
            ->get();
        
        return view('pengaturan.user.create_index', compact('data', 'role'));
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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'contact' => 'required|numeric|digits_between:10,15',
            'nik' => 'required|integer|digits:16|unique:data_pengguna,nik,' . $id . ',user_id',
            'instansi' => 'required|integer',
            'nama_instansi' => 'required|string|max:255',
            'role' => 'required|exists:roles,name',
        ]);

        try {
            $user = User::findOrFail($id);
            $dataPengguna = DataPengguna::where('user_id', $id)->firstOrFail();

            DB::beginTransaction();

            // Update user
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Update data pengguna
            $dataPengguna->update([
                'nik' => $request->nik,
                'nama' => $request->name,
                'contact' => $request->contact,
                'instansi' => $request->instansi,
                'nama_instansi' => $request->nama_instansi,
            ]);
            
            // Sync role (replace old roles with new one)
            if ($request->role) {
                $user->syncRoles([$request->role]);
            }
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
        try {
            // Get user with data_pengguna
            $user = User::findOrFail($id);
            $dataPengguna = DataPengguna::where('user_id', $id)->firstOrFail();
            
            // Get the role names for the user
            $roleNames = $user->getRoleNames();
            
            // Prepare response data
            $data = [
                'id' => $user->id,
                'nama' => $dataPengguna->nama,
                'nik' => $dataPengguna->nik,
                'contact' => $dataPengguna->contact,
                'email' => $user->email,
                'instansi' => $dataPengguna->instansi,
                'nama_instansi' => $dataPengguna->nama_instansi,
                'role_names' => $roleNames->first(),
            ];
            
            return response()->json($data, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => 'Proses gagal: ' . $e->getMessage()], 500);
        }
    }
}
