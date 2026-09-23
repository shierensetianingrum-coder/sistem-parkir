<?php

namespace App\Http\Controllers;

use App\Models\TiketParkir;
use App\Models\Member;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class TiketController extends Controller
{
    // =========================================================
    // BUAT TIKET MASUK
    // =========================================================
    public function create(Request $request): JsonResponse
    {
        $request->validate([
            'nomor_polisi' => 'nullable|string|max:30',
            'jenis_kendaraan' => 'nullable|string|in:motor,mobil',
            'member_id' => 'nullable|integer|exists:members,id',
        ]);

        $nomorPolisi = $request->filled('nomor_polisi')
            ? strtoupper(trim($request->nomor_polisi))
            : null;

        $jenisKendaraan = $request->filled('jenis_kendaraan')
            ? strtolower(trim($request->jenis_kendaraan))
            : null;

        $memberId = $request->member_id;

        // =====================================================
        // MEMBER
        // =====================================================
        if ($memberId) {
            $jenisKendaraan = 'member';
            $tarif = 0;

            $sudahParkir = TiketParkir::where('member_id', $memberId)
                ->where('status', 'masuk')
                ->exists();

            if ($sudahParkir) {
                return response()->json([
                    'success' => false,
                    'message' => 'Member tersebut masih berada di dalam parkir.',
                ], 422);
            }
        }

        // =====================================================
        // NON MEMBER
        // =====================================================
        else {
            if (!in_array($jenisKendaraan, ['motor', 'mobil'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jenis kendaraan harus motor atau mobil.',
                ], 422);
            }

            $tarif = $jenisKendaraan === 'motor'
                ? 3000
                : 5000;

            if ($nomorPolisi) {
                $sudahParkir = TiketParkir::where(
                    'nomor_polisi',
                    $nomorPolisi
                )
                    ->where('status', 'masuk')
                    ->exists();

                if ($sudahParkir) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Kendaraan dengan nomor polisi tersebut masih berada di dalam parkir.',
                    ], 422);
                }
            }
        }

        // =====================================================
        // GENERATE KODE TIKET
        // =====================================================
        do {
            $kodeTiket = 'A' . strtoupper(Str::random(5));
        } while (
            TiketParkir::where('kode_tiket', $kodeTiket)->exists()
        );

        // QR cukup menyimpan kode tiket
        $qrCode = $kodeTiket;

        // =====================================================
        // SIMPAN TIKET
        // =====================================================
        $tiket = TiketParkir::create([
            'member_id' => $memberId,
            'kode_tiket' => $kodeTiket,
            'qr_code' => $qrCode,
            'status' => 'masuk',
            'waktu_masuk' => Carbon::now(),
            'waktu_keluar' => null,
            'nomor_polisi' => $nomorPolisi,
            'jenis_kendaraan' => $jenisKendaraan,
            'tarif' => $tarif,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tiket berhasil dibuat.',
            'data' => [
                'tiket' => $tiket,
            ],
        ], 201);
    }


    // =========================================================
    // CEK TIKET MASUK
    // =========================================================
    public function cekTiketMasuk(Request $request): JsonResponse
    {
        $request->validate([
            'kode_tiket' => 'required|string|max:100',
        ]);

        $kode = strtoupper(trim($request->kode_tiket));

        $tiket = TiketParkir::where('kode_tiket', $kode)->first();

        if (!$tiket) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket tidak ditemukan.',
            ], 404);
        }

        if ($tiket->status !== 'masuk') {
            return response()->json([
                'success' => false,
                'message' => 'Tiket sudah tidak aktif.',
            ], 422);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'tiket' => $tiket,
            ],
        ]);
    }


    // =========================================================
    // SCAN KELUAR
    //
    // BISA MENERIMA:
    //
    // 1. Axxxxx
    // 2. MBR-xxxxx
    // 3. QR JSON
    // 4. QR text
    // 5. kode_tiket
    // 6. kode_member
    // 7. member_id
    // =========================================================
    public function scanKeluar(Request $request): JsonResponse
    {
        $request->validate([
            'kode_tiket' => 'nullable|string|max:1000',
            'kode_member' => 'nullable|string|max:100',
            'member_id' => 'nullable|integer|exists:members,id',
            'nomor_polisi' => 'nullable|string|max:30',
        ]);

        // =====================================================
        // DATA INPUT
        // =====================================================
        $rawScan = trim((string) $request->input('kode_tiket'));

        $kodeMember = $request->filled('kode_member')
            ? strtoupper(trim($request->kode_member))
            : null;

        $memberId = $request->member_id;

        $nomorPolisi = $request->filled('nomor_polisi')
            ? strtoupper(trim($request->nomor_polisi))
            : null;


        // =====================================================
        // 1. COBA CARI KODE MEMBER
        // =====================================================
        if (!$kodeMember && $rawScan !== '') {
            $kodeMember = $this->ambilKodeMember($rawScan);
        }


        // =====================================================
        // 2. JIKA ADA MEMBER ID / KODE MEMBER
        // =====================================================
        if ($memberId || $kodeMember) {
            return $this->prosesScanMember(
                $memberId,
                $kodeMember,
                $nomorPolisi
            );
        }


        // =====================================================
        // 3. KODE TIKET KOSONG
        // =====================================================
        if ($rawScan === '') {
            return response()->json([
                'success' => false,
                'message' => 'Silakan scan QR atau masukkan kode tiket.',
                'code' => 'INVALID_TICKET_CODE',
            ], 422);
        }


        // =====================================================
        // 4. AMBIL KODE TIKET DARI QR
        // =====================================================
        $kodeTiket = $this->ambilKodeTiket($rawScan);


        // =====================================================
        // 5. KALAU INPUT LANGSUNG Axxxxx
        // =====================================================
        if (!$kodeTiket) {
            $langsung = strtoupper(trim($rawScan));

            if (preg_match('/^A[A-Z0-9]{5}$/', $langsung)) {
                $kodeTiket = $langsung;
            }
        }


        // =====================================================
        // 6. CARI TIKET
        // =====================================================
        $tiket = null;

        if ($kodeTiket) {
            $tiket = TiketParkir::with('member')
                ->where('kode_tiket', $kodeTiket)
                ->first();
        }


        // =====================================================
        // 7. COBA CARI DARI QR CODE
        // =====================================================
        if (!$tiket) {
            $tiket = TiketParkir::with('member')
                ->where('qr_code', $rawScan)
                ->first();
        }


        // =====================================================
        // 8. TIKET TIDAK DITEMUKAN
        // =====================================================
        if (!$tiket) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket tidak ditemukan di database.',
                'code' => 'TICKET_NOT_FOUND',
            ], 404);
        }


        // =====================================================
        // 9. CEK TIKET SUDAH KELUAR
        // =====================================================
        if ($tiket->status === 'keluar') {
            return response()->json([
                'success' => false,
                'message' => 'Tiket ini sudah digunakan untuk keluar.',
                'code' => 'TICKET_ALREADY_OUT',
            ], 422);
        }


        // =====================================================
        // 10. STATUS HARUS MASUK
        // =====================================================
        if ($tiket->status !== 'masuk') {
            return response()->json([
                'success' => false,
                'message' => 'Tiket tidak sedang berada di dalam parkir.',
                'code' => 'INVALID_TICKET_STATUS',
            ], 422);
        }


        // =====================================================
        // 11. KALAU TIKET TERNYATA MEMBER
        // =====================================================
        if ($tiket->member_id) {
            $member = $tiket->member;

            if (!$member) {
                $member = Member::find($tiket->member_id);
            }

            if (!$member) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data member dari tiket tidak ditemukan.',
                    'code' => 'MEMBER_NOT_FOUND',
                ], 404);
            }

            return $this->buatResponseMember(
                $tiket,
                $member
            );
        }


        // =====================================================
        // 12. NON MEMBER
        // =====================================================
        $tarif = $this->hitungTarif($tiket);


        return response()->json([
            'success' => true,
            'message' => 'Tiket non-member berhasil terdeteksi.',
            'code' => 'NON_MEMBER_FOUND',

            'data' => [
                'tiket' => $tiket,
                'is_member' => false,
                'total' => $tarif,
                'total_bayar' => $tarif,
                'nomor_polisi_scan' => $nomorPolisi,
            ],
        ]);
    }


    // =========================================================
    // PROSES SCAN MEMBER
    // =========================================================
    private function prosesScanMember(
        $memberId,
        ?string $kodeMember,
        ?string $nomorPolisi
    ): JsonResponse {

        $member = null;


        // =====================================================
        // CARI BERDASARKAN ID
        // =====================================================
        if ($memberId) {
            $member = Member::find($memberId);
        }


        // =====================================================
        // CARI BERDASARKAN KODE MEMBER
        // =====================================================
        if (!$member && $kodeMember) {
            $member = Member::where(
                'kode_member',
                strtoupper(trim($kodeMember))
            )->first();
        }


        // =====================================================
        // MEMBER TIDAK DITEMUKAN
        // =====================================================
        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Kode member tidak ditemukan.',
                'code' => 'MEMBER_NOT_FOUND',
            ], 404);
        }


        // =====================================================
        // CARI TIKET MEMBER YANG MASIH MASUK
        // =====================================================
        $tiket = TiketParkir::where(
            'member_id',
            $member->id
        )
            ->where('status', 'masuk')
            ->latest('id')
            ->first();


        // =====================================================
        // MEMBER TIDAK SEDANG PARKIR
        // =====================================================
        if (!$tiket) {
            return response()->json([
                'success' => false,
                'message' => 'Member tidak memiliki tiket aktif di dalam parkir.',
                'code' => 'MEMBER_NOT_PARKED',
            ], 404);
        }


        // =====================================================
        // KALAU PLAT KOSONG
        // PAKAI PLAT DARI TIKET
        // =====================================================
        if (!$nomorPolisi) {
            $nomorPolisi = $tiket->nomor_polisi;
        }


        // =====================================================
        // RESPONSE MEMBER
        // =====================================================
        return $this->buatResponseMember(
            $tiket,
            $member,
            $nomorPolisi
        );
    }


    // =========================================================
    // RESPONSE MEMBER
    // =========================================================
    private function buatResponseMember(
        TiketParkir $tiket,
        Member $member,
        ?string $nomorPolisi = null
    ): JsonResponse {

        if (!$nomorPolisi) {
            $nomorPolisi = $tiket->nomor_polisi;
        }


        // =====================================================
        // DATA TIKET
        // =====================================================
        $dataTiket = $tiket->toArray();

        $dataTiket['is_member'] = true;

        $dataTiket['member_id'] = $member->id;

        $dataTiket['kode_member'] =
            $member->kode_member ?? '-';

        $dataTiket['nama_member'] =
            $member->nama_member ?? '-';

        $dataTiket['nama_perusahaan'] =
            $member->nama_perusahaan ?? '-';

        $dataTiket['status_member'] =
            $member->status ?? '-';

        $dataTiket['tanggal_expired'] =
            $member->tanggal_expired ?? '-';

        $dataTiket['nomor_polisi'] =
            $tiket->nomor_polisi ?: $nomorPolisi;

        $dataTiket['total'] = 0;

        $dataTiket['total_bayar'] = 0;


        return response()->json([
            'success' => true,

            'message' => 'Member berhasil terdeteksi.',

            'code' => 'MEMBER_FOUND',

            'data' => [
                'tiket' => $dataTiket,
                'member' => $member,
                'is_member' => true,
                'total' => 0,
                'total_bayar' => 0,
            ],
        ]);
    }


    // =========================================================
    // HITUNG TARIF NON MEMBER
    // =========================================================
    private function hitungTarif(TiketParkir $tiket): int
    {
        if ($tiket->member_id) {
            return 0;
        }

        if ($tiket->jenis_kendaraan === 'motor') {
            return 3000;
        }

        if ($tiket->jenis_kendaraan === 'mobil') {
            return 5000;
        }

        return (int) $tiket->tarif;
    }


    // =========================================================
    // AMBIL KODE MEMBER DARI QR
    // =========================================================
    private function ambilKodeMember(string $text): ?string
    {
        $text = trim($text);

        if ($text === '') {
            return null;
        }


        // =====================================================
        // JSON
        // =====================================================
        $json = json_decode($text, true);

        if (is_array($json)) {

            $kemungkinan = [
                $json['kode_member'] ?? null,
                $json['member_code'] ?? null,
                $json['kode'] ?? null,
                $json['member'] ?? null,

                $json['data']['kode_member'] ?? null,
                $json['data']['member_code'] ?? null,
                $json['data']['kode'] ?? null,
                $json['data']['member'] ?? null,
            ];

            foreach ($kemungkinan as $nilai) {

                if (!is_string($nilai)) {
                    continue;
                }

                $nilai = strtoupper(trim($nilai));

                if (
                    preg_match(
                        '/\b(MBR-[A-Z0-9]+)\b/i',
                        $nilai,
                        $match
                    )
                ) {
                    return strtoupper($match[1]);
                }
            }
        }


        // =====================================================
        // TEXT BIASA
        // =====================================================
        if (
            preg_match(
                '/\b(MBR-[A-Z0-9]+)\b/i',
                strtoupper($text),
                $match
            )
        ) {
            return strtoupper($match[1]);
        }


        return null;
    }


    // =========================================================
    // AMBIL KODE TIKET DARI QR
    // =========================================================
    private function ambilKodeTiket(string $text): ?string
    {
        $text = trim($text);

        if ($text === '') {
            return null;
        }


        // =====================================================
        // JSON
        // =====================================================
        $json = json_decode($text, true);

        if (is_array($json)) {

            $kemungkinan = [
                $json['kode_tiket'] ?? null,
                $json['ticket_code'] ?? null,
                $json['qr_code'] ?? null,
                $json['kode'] ?? null,

                $json['data']['kode_tiket'] ?? null,
                $json['data']['ticket_code'] ?? null,
                $json['data']['qr_code'] ?? null,
                $json['data']['kode'] ?? null,
            ];

            foreach ($kemungkinan as $nilai) {

                if (!is_string($nilai)) {
                    continue;
                }

                $nilai = strtoupper(trim($nilai));

                if (
                    preg_match(
                        '/\b(A[A-Z0-9]{5})\b/i',
                        $nilai,
                        $match
                    )
                ) {
                    return strtoupper($match[1]);
                }
            }
        }


        // =====================================================
        // TEXT BIASA
        // =====================================================
        if (
            preg_match(
                '/\b(A[A-Z0-9]{5})\b/i',
                strtoupper($text),
                $match
            )
        ) {
            return strtoupper($match[1]);
        }


        // =====================================================
        // FORMAT:
        // KODE TIKET: A12345
        // =====================================================
        if (
            preg_match(
                '/KODE\s*TIKET\s*[:=-]?\s*(A[A-Z0-9]{5})/i',
                $text,
                $match
            )
        ) {
            return strtoupper($match[1]);
        }


        return null;
    }


    // =========================================================
    // PROSES KENDARAAN KELUAR
    //
    // DIPANGGIL SETELAH USER MENEKAN TOMBOL KELUAR
    // =========================================================
    public function keluar($id): JsonResponse
    {
        $tiket = TiketParkir::find($id);

        if (!$tiket) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket tidak ditemukan.',
            ], 404);
        }


        // =====================================================
        // SUDAH KELUAR
        // =====================================================
        if ($tiket->status === 'keluar') {
            return response()->json([
                'success' => false,
                'message' => 'Tiket sudah digunakan untuk keluar.',
                'code' => 'TICKET_ALREADY_OUT',
            ], 422);
        }


        // =====================================================
        // STATUS HARUS MASUK
        // =====================================================
        if ($tiket->status !== 'masuk') {
            return response()->json([
                'success' => false,
                'message' => 'Status tiket tidak valid.',
            ], 422);
        }


        // =====================================================
        // MEMBER = RP0
        // NON MEMBER = SESUAI KENDARAAN
        // =====================================================
        if ($tiket->member_id) {
            $tarif = 0;
        } else {
            $tarif = $this->hitungTarif($tiket);
        }


        // =====================================================
        // UPDATE TIKET
        // =====================================================
        $tiket->update([
            'status' => 'keluar',
            'waktu_keluar' => Carbon::now(),
            'tarif' => $tarif,
        ]);

        $tiket->refresh();


        return response()->json([
            'success' => true,
            'message' => 'Kendaraan berhasil keluar.',
            'gate' => true,

            'data' => [
                'tiket' => $tiket,
                'total' => $tarif,
                'total_bayar' => $tarif,
                'is_member' => $tiket->member_id ? true : false,
            ],
        ]);
    }


    // =========================================================
    // SEMUA TIKET
    // =========================================================
    public function index(): JsonResponse
    {
        $tiket = TiketParkir::with('member')
            ->latest('id')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $tiket,
        ]);
    }


    // =========================================================
    // DETAIL TIKET
    // =========================================================
    public function show($id): JsonResponse
    {
        $tiket = TiketParkir::with('member')
            ->find($id);

        if (!$tiket) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'tiket' => $tiket,
            ],
        ]);
    }


    // =========================================================
    // HAPUS TIKET
    // =========================================================
    public function destroy($id): JsonResponse
    {
        $tiket = TiketParkir::find($id);

        if (!$tiket) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket tidak ditemukan.',
            ], 404);
        }

        $tiket->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tiket berhasil dihapus.',
        ]);
    }
}