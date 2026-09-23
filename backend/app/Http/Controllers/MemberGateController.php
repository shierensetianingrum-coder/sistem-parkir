<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\TiketParkir;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MemberGateController extends Controller
{
    /**
     * =========================================================
     * CEK MEMBER
     * =========================================================
     *
     * Bisa menggunakan:
     * 1. kode_member
     * 2. token QR
     *
     * =========================================================
     */
    public function checkMember(Request $request)
    {
        $request->validate([
            'kode_member' => 'required|string',
        ]);

        $kode = strtoupper(
            trim($request->kode_member)
        );

        // =====================================================
        // CARI MEMBER
        // Bisa berdasarkan kode member ATAU token QR
        // =====================================================

        $member = Member::whereRaw(
            'UPPER(TRIM(kode_member)) = ?',
            [$kode]
        )
        ->orWhereRaw(
            'UPPER(TRIM(token)) = ?',
            [$kode]
        )
        ->first();

        // =====================================================
        // MEMBER TIDAK DITEMUKAN
        // =====================================================

        if (!$member) {
            return response()->json([
                'success' => false,
                'status' => false,
                'type' => 'non-member',
                'message' => 'Member tidak ditemukan.',
            ], 404);
        }

        // =====================================================
        // CEK STATUS PEMBAYARAN
        // =====================================================

        $status = strtolower(
            trim($member->status ?? '')
        );

        if ($status !== 'lunas') {
            return response()->json([
                'success' => false,
                'status' => false,
                'type' => 'member',
                'message' => 'Member belum melakukan pembayaran.',
                'member' => $member,
                'data' => $member,
            ], 422);
        }

        // =====================================================
        // CEK MASA BERLAKU
        // =====================================================

        if ($member->tanggal_expired) {

            $tanggalExpired = Carbon::parse(
                $member->tanggal_expired
            )->startOfDay();

            $hariIni = Carbon::today();

            if ($hariIni->gt($tanggalExpired)) {

                return response()->json([
                    'success' => false,
                    'status' => false,
                    'type' => 'member',
                    'message' => 'Masa berlaku member sudah expired.',
                    'member' => $member,
                    'data' => $member,
                ], 422);
            }
        }

        // =====================================================
        // MEMBER VALID
        // =====================================================

        return response()->json([
            'success' => true,
            'status' => true,
            'type' => 'member',
            'message' => 'Member berhasil terdeteksi.',
            'member' => $member,
            'data' => $member,
        ]);
    }


    /**
     * =========================================================
     * MEMBER MASUK
     * =========================================================
     */
    public function memberGate(Request $request)
    {
        $request->validate([
            'member_id' => 'required|integer',
            'nomor_polisi' => 'nullable|string|max:30',
        ]);

        // =====================================================
        // CARI MEMBER
        // =====================================================

        $member = Member::find(
            $request->member_id
        );

        if (!$member) {
            return response()->json([
                'success' => false,
                'status' => false,
                'type' => 'member',
                'message' => 'Data member tidak ditemukan.',
            ], 404);
        }

        // =====================================================
        // CEK STATUS MEMBER
        // =====================================================

        $status = strtolower(
            trim($member->status ?? '')
        );

        if ($status !== 'lunas') {
            return response()->json([
                'success' => false,
                'status' => false,
                'type' => 'member',
                'message' => 'Member belum melakukan pembayaran.',
            ], 422);
        }

        // =====================================================
        // CEK MASA BERLAKU MEMBER
        // =====================================================
        //
        // PENTING:
        // CEK EXPIRED DILAKUKAN SEBELUM
        // CEK MEMBER MASIH DI DALAM PARKIR.
        //
        // Jadi kalau member sudah expired,
        // pesan yang keluar:
        //
        // "Masa berlaku member sudah expired."
        //
        // =====================================================

        if ($member->tanggal_expired) {

            $tanggalExpired = Carbon::parse(
                $member->tanggal_expired
            )->startOfDay();

            $hariIni = Carbon::today();

            if ($hariIni->gt($tanggalExpired)) {

                return response()->json([
                    'success' => false,
                    'status' => false,
                    'type' => 'member',
                    'message' => 'Masa berlaku member sudah expired.',
                    'member' => $member,
                    'data' => $member,
                ], 422);
            }
        }

        // =====================================================
        // NOMOR POLISI
        // =====================================================

        $nomorPolisi = $request->nomor_polisi
            ? strtoupper(
                trim($request->nomor_polisi)
            )
            : null;


        // =====================================================
        // CEK MEMBER MASIH BERADA DI DALAM
        // =====================================================

        $tiketAktif = TiketParkir::where(
            'member_id',
            $member->id
        )
        ->where(
            'status',
            'masuk'
        )
        ->first();


        if ($tiketAktif) {

            return response()->json([
                'success' => false,
                'status' => false,
                'type' => 'member',
                'message' => 'Member masih berada di dalam parkir.',
                'tiket' => $tiketAktif,
            ], 422);
        }


        // =====================================================
        // BUAT KODE TIKET
        // =====================================================

        $kodeTiket =
            $this->buatKodeTiket();


        // =====================================================
        // BUAT QR CODE
        // =====================================================

        $qrCode =
            $this->buatQrCode(
                $kodeTiket
            );


        // =====================================================
        // BUAT TIKET MEMBER
        // =====================================================

        $tiket =
            new TiketParkir();

        $tiket->member_id =
            $member->id;

        $tiket->kode_tiket =
            $kodeTiket;

        $tiket->qr_code =
            $qrCode;

        $tiket->status =
            'masuk';

        $tiket->waktu_masuk =
            now();

        $tiket->waktu_keluar =
            null;

        $tiket->nomor_polisi =
            $nomorPolisi;

        $tiket->jenis_kendaraan =
            'member';

        $tiket->tarif =
            0;

        $tiket->save();


        // =====================================================
        // RESPONSE BERHASIL
        // =====================================================

        return response()->json([
            'success' => true,
            'status' => true,
            'type' => 'member',
            'message' => 'Member terdeteksi. Tiket berhasil dibuat. Pintu terbuka.',
            'member' => $member,
            'tiket' => $tiket,
        ]);
    }


    /**
     * =========================================================
     * NON MEMBER MASUK
     *
     * Motor = Rp3.000
     * Mobil = Rp5.000
     * =========================================================
     */
    public function nonMemberGate(Request $request)
    {
        $request->validate([
            'nomor_polisi' => 'required|string|max:30',
            'jenis_kendaraan' => 'required|in:motor,mobil',
        ]);


        // =====================================================
        // NOMOR POLISI
        // =====================================================

        $nomorPolisi = strtoupper(
            trim($request->nomor_polisi)
        );


        // =====================================================
        // JENIS KENDARAAN
        // =====================================================

        $jenisKendaraan = strtolower(
            trim($request->jenis_kendaraan)
        );


        // =====================================================
        // CEK KENDARAAN MASIH BERADA DI DALAM
        // =====================================================

        $tiketAktif =
            TiketParkir::whereNull(
                'member_id'
            )
            ->where(
                'nomor_polisi',
                $nomorPolisi
            )
            ->where(
                'status',
                'masuk'
            )
            ->first();


        if ($tiketAktif) {

            return response()->json([
                'success' => false,
                'status' => false,
                'type' => 'non-member',
                'message' => 'Kendaraan dengan nomor polisi tersebut masih berada di dalam parkir.',
                'tiket' => $tiketAktif,
            ], 422);
        }


        // =====================================================
        // TARIF
        // =====================================================

        if ($jenisKendaraan === 'motor') {

            $tarif = 3000;

        } else {

            $tarif = 5000;

        }


        // =====================================================
        // BUAT KODE TIKET
        // =====================================================

        $kodeTiket =
            $this->buatKodeTiket();


        // =====================================================
        // BUAT QR CODE
        // =====================================================

        $qrCode =
            $this->buatQrCode(
                $kodeTiket
            );


        // =====================================================
        // BUAT TIKET NON MEMBER
        // =====================================================

        $tiket =
            new TiketParkir();

        $tiket->member_id =
            null;

        $tiket->kode_tiket =
            $kodeTiket;

        $tiket->qr_code =
            $qrCode;

        $tiket->status =
            'masuk';

        $tiket->waktu_masuk =
            now();

        $tiket->waktu_keluar =
            null;

        $tiket->nomor_polisi =
            $nomorPolisi;

        $tiket->jenis_kendaraan =
            $jenisKendaraan;

        $tiket->tarif =
            $tarif;

        $tiket->save();


        // =====================================================
        // RESPONSE
        // =====================================================

        return response()->json([
            'success' => true,
            'status' => true,
            'type' => 'non-member',
            'message' => 'Kendaraan non-member berhasil masuk. Pintu terbuka.',
            'tiket' => $tiket,
        ]);
    }


    /**
     * =========================================================
     * BUAT KODE TIKET RANDOM
     * =========================================================
     */
    private function buatKodeTiket()
    {
        do {

            $kodeTiket =
                'A' .
                strtoupper(
                    Str::random(5)
                );

        } while (
            TiketParkir::where(
                'kode_tiket',
                $kodeTiket
            )->exists()
        );


        return $kodeTiket;
    }


    /**
     * =========================================================
     * BUAT QR CODE
     * =========================================================
     */
    private function buatQrCode(
        $kodeTiket
    ) {
        return $kodeTiket;
    }
}