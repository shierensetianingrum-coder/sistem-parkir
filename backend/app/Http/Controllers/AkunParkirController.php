<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunParkirController extends Controller
{
    // ==========================================
    // REGISTER
    // ==========================================

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'required|string|max:20|unique:users,no_hp',
            'password' => 'required|string|min:6',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.unique' => 'Nomor HP sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        // ==========================================
        // BUAT USER BARU
        // ==========================================

        $user = User::create([
            'name' => $request->nama,
            'email' => trim($request->email),
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'role' => 'petugas',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil.',
            'data' => [
                'id' => $user->id,
                'nama' => $user->name,
                'email' => $user->email,
                'no_hp' => $user->no_hp,
                'role' => $user->role,
            ],
        ], 201);
    }


    // ==========================================
    // LOGIN
    // ==========================================

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // ==========================================
        // BERSIHKAN EMAIL
        // ==========================================

        $email = trim($request->email);

        // ==========================================
        // CARI USER DI TABEL USERS
        // ==========================================

        $user = User::where('email', $email)->first();

        // ==========================================
        // EMAIL TIDAK DITEMUKAN
        // ==========================================

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.',
            ], 401);
        }

        // ==========================================
        // CEK PASSWORD
        // ==========================================

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.',
            ], 401);
        }

        // ==========================================
        // CEK ROLE
        // ==========================================

        if (!in_array($user->role, ['admin', 'petugas'])) {
            return response()->json([
                'success' => false,
                'message' => 'Role akun tidak dikenali.',
            ], 403);
        }

        // ==========================================
        // LOGIN BERHASIL
        // ==========================================

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'data' => [
                'id' => $user->id,
                'nama' => $user->name,
                'email' => $user->email,
                'no_hp' => $user->no_hp,
                'role' => $user->role,
            ],
        ], 200);
    }
}