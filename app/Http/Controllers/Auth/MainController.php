<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $validasiAccount = User::where('email', $request->email)->exists();
        if (!$validasiAccount) {
            return response()->json(['error' => 'email tidak terdaftar!'], 404);
        }
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json(['message' => 'Login successful!', 200]);
        }
        return response()->json(['error' => 'Invalid credentials'], 401);
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    function changePassword(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);
        $user = Auth::user();
        // check if the current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Kata sandi yang dimasukkan tidak sesuai dengan kata sandi lama.'], 403);
        }
        try {
            DB::beginTransaction();

            $user->password = Hash::make($request->new_password);
            $user->save();

            DB::commit();
            return response()->json(['message' => 'Ganti sandi berhasil.'], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'proses gagal'], 500);
        }
    }
}
