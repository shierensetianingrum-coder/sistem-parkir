<?php

namespace App\Http\Controllers;

use App\Models\TiketParkir;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SCAN TIKET KELUAR
    |--------------------------------------------------------------------------
    */
    public function scan(Request $request)
    {
        $request->validate([
            'kode_tiket' => 'required|string',
        ]);

        $kodeTiket = strtoupper(
            trim($request->kode_tiket)
        );

        /*
        |--------------------------------------------------------------------------
        | CARI TIKET
        |--------------------------------------------------------------------------
        */
        $tiket = TiketParkir::with('member')
            ->where('kode_tiket', $kodeTiket)
            ->first();

        if (!$tiket) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket tidak ditemukan.',
            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | CEK TIKET SUDAH KELUAR
        |--------------------------------------------------------------------------
        */
        if ($tiket->status === 'keluar') {
            return response()->json([
                'success' => false,
                'message' => 'Tiket ini sudah digunakan untuk keluar.',
                'tiket' => $tiket,
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | WAKTU MASUK
        |--------------------------------------------------------------------------
        */
        $waktuMasuk = $tiket->waktu_masuk;

        /*
        |--------------------------------------------------------------------------
        | PASTIKAN CARBON
        |--------------------------------------------------------------------------
        */
        if (!$waktuMasuk instanceof Carbon) {
            $waktuMasuk = Carbon::parse($waktuMasuk);
        }

        /*
        |--------------------------------------------------------------------------
        | WAKTU SEKARANG
        |--------------------------------------------------------------------------
        */
        $waktuSekarang = now();

        /*
        |--------------------------------------------------------------------------
        | HITUNG DURASI
        |--------------------------------------------------------------------------
        */
        $durasiMenit = $waktuMasuk->diffInMinutes(
            $waktuSekarang
        );

        /*
        |--------------------------------------------------------------------------
        | TARIF
        |--------------------------------------------------------------------------
        */
        $tarif = (int) ($tiket->tarif ?? 0);

        /*
        |--------------------------------------------------------------------------
        | TENTUKAN MEMBER
        |--------------------------------------------------------------------------
        */
        $isMember =
            !empty($tiket->member_id);

        /*
        |--------------------------------------------------------------------------
        | MEMBER GRATIS
        |--------------------------------------------------------------------------
        */
        if ($isMember) {
            $tarif = 0;
        }

        /*
        |--------------------------------------------------------------------------
        | DATA UNTUK FRONTEND
        |--------------------------------------------------------------------------
        */
        $dataTiket = [
            'id' => $tiket->id,

            'kode_tiket' =>
                $tiket->kode_tiket,

            'qr_code' =>
                $tiket->qr_code,

            'status' =>
                $tiket->status,

            'waktu_masuk' =>
                $tiket->waktu_masuk,

            'waktu_keluar' =>
                $tiket->waktu_keluar,

            'nomor_polisi' =>
                $tiket->nomor_polisi,

            'jenis_kendaraan' =>
                $tiket->jenis_kendaraan,

            'tarif' =>
                $tarif,

            'durasi_menit' =>
                $durasiMenit,

            'is_member' =>
                $isMember,

            'member_id' =>
                $tiket->member_id,

            'kode_member' =>
                $tiket->member?->kode_member,

            'nama_member' =>
                $tiket->member?->nama_member,

            'nama_perusahaan' =>
                $tiket->member?->nama_perusahaan,
        ];

        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */
        return response()->json([
            'success' => true,
            'message' => 'Tiket berhasil ditemukan.',
            'tiket' => $dataTiket,
            'data' => $dataTiket,
        ]);
    }
}