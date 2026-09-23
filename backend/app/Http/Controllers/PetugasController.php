<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    // ==========================================
    // TAMPIL SEMUA PETUGAS + ADMIN
    // ==========================================

    public function index()
    {
        $petugas = User::orderBy('id', 'asc')->get();

        return response()->json([
            'success' => true,
            'data' => $petugas
        ]);
    }


    // ==========================================
    // TAMBAH PETUGAS
    // ==========================================

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',

            'email' => 'required|email|unique:users,email',

            'no_hp' => 'required|string|max:20|unique:users,no_hp',

            'password' => 'required|string|min:6',
        ], [
            'name.required' => 'Nama petugas wajib diisi.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email tersebut sudah digunakan.',

            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.unique' => 'Nomor HP tersebut sudah digunakan.',

            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);


        $petugas = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'role' => 'petugas',
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Petugas berhasil ditambahkan',
            'data' => $petugas
        ], 201);
    }


    // ==========================================
    // EDIT PETUGAS / ADMIN
    // ==========================================

    public function update(Request $request, $id)
    {
        $petugas = User::find($id);

        if (!$petugas) {
            return response()->json([
                'success' => false,
                'message' => 'Akun tidak ditemukan'
            ], 404);
        }


        $request->validate([
            'name' => 'required|string|max:255',

            'email' => 'required|email|unique:users,email,' . $id,

            'no_hp' => 'required|string|max:20|unique:users,no_hp,' . $id,
        ], [
            'name.required' => 'Nama wajib diisi.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email tersebut sudah digunakan akun lain.',

            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.unique' => 'Nomor HP tersebut sudah digunakan akun lain.',
        ]);


        // UPDATE DATA
        $petugas->name = $request->name;
        $petugas->email = $request->email;
        $petugas->no_hp = $request->no_hp;


        // PASSWORD HANYA DIUBAH JIKA DIISI
        if ($request->filled('password')) {

            $request->validate([
                'password' => 'string|min:6'
            ]);

            $petugas->password = Hash::make($request->password);
        }


        $petugas->save();


        return response()->json([
            'success' => true,
            'message' => 'Data akun berhasil diperbarui',
            'data' => $petugas
        ]);
    }


    // ==========================================
    // HAPUS PETUGAS / ADMIN
    // ==========================================

    public function destroy($id)
    {
        $petugas = User::find($id);

        if (!$petugas) {
            return response()->json([
                'success' => false,
                'message' => 'Akun tidak ditemukan'
            ], 404);
        }


        $petugas->delete();


        return response()->json([
            'success' => true,
            'message' => 'Akun berhasil dihapus'
        ]);
    }
}