<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Cek credentials
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['error_message' => 'Unauthorized'], 401);
        }

        // Cek role user (pastikan Anda menggunakan Spatie Laravel Permission atau sistem role lainnya)
        $user = Auth::user();
        if (!$user->hasRole('developer|api_smart_rt')) {
            return response()->json(['error_message' => 'Forbidden: Invalid role'], 403);
        }

        // Generate token (Passport)
        $tokenResult = $user->createToken('API Token');
        $token = $tokenResult->accessToken;

        // Jika ingin memberikan refresh token (opsional)
        // $refreshToken = $user->createToken('Refresh Token')->accessToken;

        return response()->json([
            'token_type' => 'Bearer',
            'access_token' => $token,
            'expires_at' => now()->addDays(7)->toDateTimeString(), // Sesuaikan dengan Passport::tokensExpireIn()
            // 'refresh_token' => $refreshToken, // Opsional
        ], 200);
    }
}
