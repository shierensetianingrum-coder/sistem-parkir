<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // daftar akun (bisa nanti dipindah ke tabel users kalau mau lebih rapi)
        $akun = [
            [
                'email' => 'admin@parkir.com',
                'password' => 'admin123',
                'role' => 'super_admin',
                'nama' => 'Super Admin',
            ],
            [
                'email' => 'petugas@parkir.com',
                'password' => 'petugas123',
                'role' => 'petugas',
                'nama' => 'Petugas Parkir',
            ],
        ];

        foreach ($akun as $item) {
            if ($item['email'] === $request->email && $item['password'] === $request->password) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil',
                    'data' => [
                        'nama' => $item['nama'],
                        'email' => $item['email'],
                        'role' => $item['role'],
                    ],
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Email atau password salah',
        ], 401);
    }
}