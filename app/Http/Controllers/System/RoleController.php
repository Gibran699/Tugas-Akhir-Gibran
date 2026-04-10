<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use App\Models\Role;

class RoleController extends Controller
{
    function index(){
        $data = Role::orderBy('name','asc')->get();
        $dataPermission = Permission::select('name','guard_name')->orderBy('name','asc')->get();
        return view('pengaturan.role.create_index',compact('data','dataPermission'));
    }
    function store(Request $request) {
        $this->validate($request,[
            'name' => 'required|unique:roles,name',
            'permission' => 'required|array',
        ]);
        try {
            DB::beginTransaction();
            $role = Role::create([
                'name' => $request->input('name'),
                'guard_name' => 'web'
            ]);
            $permissions = array_values($request->input('permission'));
            $role->syncPermissions($permissions);
            DB::commit();
            return response()->json(['message' => 'berhasil menambahkan'], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'proses gagal: ' . $e->getMessage()], 500);
        }
    }
    function destroy(Request $request,$id) {
        try {
            $role = Role::where('uuid',$id)->firstOrFail();
            DB::beginTransaction();
            $role->delete();
            DB::commit();
            return response()->json(['message' => 'berhasil menghapus'], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'proses gagal'], 500);
        }
    }
    function edit($id){
        $role = Role::where('uuid',$id)->firstOrFail();
        $permissionNames = $role->getPermissionNames();
        return response()->json(['role' => $role, 'permission' => $permissionNames], 200);
    }
    function update(Request $request,$id) {
        $this->validate($request,[
            'name' => 'required|unique:roles,name,' . $id . ',uuid',
            'permissionEdit' => 'required|array',
        ]);
        try {
            DB::beginTransaction();
            $role = Role::where('uuid',$id)->firstOrFail();
            $role->update([
                'name' => $request->name,
                'guard_name' => 'web'
            ]);
            $permissions = array_values($request->input('permissionEdit'));
            $role->syncPermissions($permissions);
            DB::commit();
            return response()->json(['message' => 'berhasil mengubah'], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'proses gagal: ' . $e->getMessage()], 500);
        }
    }
}
