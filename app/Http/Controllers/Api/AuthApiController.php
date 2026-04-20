<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthApiController extends Controller
{
    public function loginQr(Request $request)
    {
        $request->validate([
            'qr_token'  => 'required',
            'device_id' => 'required',
        ]);

        $user = User::where('qr_activation', $request->qr_token)
            ->where('role', '2')
            ->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'QR Code tidak valid atau tidak ditemukan!'
            ], 401);
        }

        if ($user->device_id != null && $user->device_id != $request->device_id) {
            return response()->json([
                'status' => 'error',
                'message' => $user->device_id . ' - ' . $request->device_id . ' - Akses Ditolak! Akun ini sudah tertaut di perangkat lain. Hubungi Admin jika Anda ganti HP.'
            ], 403);
        }

        if ($user->device_id == null) {
            $user->device_id = $request->device_id;
            $user->save();
        }

        $user->tokens()->delete();

        $token = $user->createToken('MobileAppToken')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login Berhasil! Perangkat tertaut.',
            'data' => [
                'user'  => $user,
                'token' => $token
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil keluar.'
        ]);
    }
}
