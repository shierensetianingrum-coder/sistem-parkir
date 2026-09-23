<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MemberController extends Controller
{
    // ===================================
    // TAMPIL SEMUA MEMBER
    // ===================================

    public function index()
    {
        $members = Member::latest()->get();

        return response()->json([
            "status" => true,
            "data" => $members
        ]);
    }


    // ===================================
    // TAMBAH MEMBER
    // ===================================

    public function store(Request $request)
    {
        $request->validate([
            'nama_member' => 'required',
            'nama_perusahaan' => 'required',
            'jumlah_bayar' => 'required|numeric|min:0'
        ]);

        $harga_member = 150000;
        $jumlah_bayar = (float) $request->jumlah_bayar;

        if ($jumlah_bayar > $harga_member) {
            return response()->json([
                "status" => false,
                "message" => "Pembayaran tidak boleh lebih dari Rp " .
                    number_format($harga_member, 0, ',', '.')
            ], 422);
        }

        $kembalian = 0;

        $status = $jumlah_bayar >= $harga_member
            ? "lunas"
            : "belum lunas";

        $tanggal_mulai = Carbon::now();

        $tanggal_expired = $tanggal_mulai->copy()->addMonth();

        $member = Member::create([
            'kode_member' => $this->generateKodeMember(),

            // TOKEN INI YANG MASUK KE QR
            'token' => (string) Str::uuid(),

            'nama_member' => $request->nama_member,
            'nama_perusahaan' => $request->nama_perusahaan,

            'total_harga' => $harga_member,
            'jumlah_bayar' => $jumlah_bayar,
            'kembalian' => $kembalian,

            'status' => $status,

            'tanggal_bayar' => Carbon::now(),
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_expired' => $tanggal_expired
        ]);

        return response()->json([
            "status" => true,
            "message" => "Member berhasil dibuat",
            "data" => $member
        ], 201);
    }


    // ===================================
    // GENERATE KODE MEMBER
    // ===================================

    private function generateKodeMember()
    {
        do {
            $kode = 'MBR-' . strtoupper(Str::random(6));
        } while (
            Member::where('kode_member', $kode)->exists()
        );

        return $kode;
    }


    // ===================================
    // DETAIL MEMBER + QR
    // ===================================

    public function show($id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json([
                "status" => false,
                "message" => "Member tidak ditemukan"
            ], 404);
        }

        // QR BERISI TOKEN
        $qr = base64_encode(
            QrCode::format('svg')
                ->size(200)
                ->margin(1)
                ->generate($member->token)
        );

        return response()->json([
            "status" => true,
            "data" => [
                "id" => $member->id,
                "kode_member" => $member->kode_member,
                "token" => $member->token,
                "nama_member" => $member->nama_member,
                "nama_perusahaan" => $member->nama_perusahaan,
                "total_harga" => $member->total_harga,
                "jumlah_bayar" => $member->jumlah_bayar,
                "kembalian" => $member->kembalian,
                "status" => $member->status,
                "tanggal_bayar" => $member->tanggal_bayar,
                "tanggal_mulai" => $member->tanggal_mulai,
                "tanggal_expired" => $member->tanggal_expired,
                "qr" => "data:image/svg+xml;base64," . $qr
            ]
        ]);
    }


    // ===================================
    // UPDATE DATA MEMBER
    // ===================================

    public function update(Request $request, $id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json([
                "status" => false,
                "message" => "Member tidak ditemukan"
            ], 404);
        }

        $request->validate([
            'nama_member' => 'required',
            'nama_perusahaan' => 'required'
        ]);

        $member->update([
            'nama_member' => $request->nama_member,
            'nama_perusahaan' => $request->nama_perusahaan
        ]);

        return response()->json([
            "status" => true,
            "message" => "Data member berhasil diperbarui",
            "data" => $member
        ]);
    }


    // ===================================
    // UPDATE PEMBAYARAN
    // ===================================

    public function updatePembayaran(Request $request, $id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json([
                "status" => false,
                "message" => "Member tidak ditemukan"
            ], 404);
        }

        $request->validate([
            'jumlah_bayar' => 'required|numeric|min:0'
        ]);

        $jumlah_bayar = (float) $request->jumlah_bayar;
        $total_harga = (float) $member->total_harga;

        if ($jumlah_bayar > $total_harga) {
            return response()->json([
                "status" => false,
                "message" => "Pembayaran tidak boleh lebih dari Rp " .
                    number_format($total_harga, 0, ',', '.')
            ], 422);
        }

        $kembalian = 0;

        $status = $jumlah_bayar >= $total_harga
            ? "lunas"
            : "belum lunas";

        $tanggal_expired = $member->tanggal_expired;

        if ($status === "lunas") {
            $tanggal_expired = Carbon::now()->addMonth();
        }

        $member->update([
            'jumlah_bayar' => $jumlah_bayar,
            'kembalian' => $kembalian,
            'status' => $status,
            'tanggal_bayar' => Carbon::now(),
            'tanggal_expired' => $tanggal_expired
        ]);

        $member->refresh();

        return response()->json([
            "status" => true,
            "message" => $status === "lunas"
                ? "Pembayaran lunas dan masa aktif member diperbarui sampai " .
                    Carbon::parse($tanggal_expired)->format('d/m/Y')
                : "Pembayaran berhasil diperbarui",
            "data" => $member
        ]);
    }


    // ===================================
    // HAPUS MEMBER
    // ===================================

    public function destroy($id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json([
                "status" => false,
                "message" => "Member tidak ditemukan"
            ], 404);
        }

        $member->delete();

        return response()->json([
            "status" => true,
            "message" => "Member berhasil dihapus"
        ]);
    }


    // ===================================
    // CEK MEMBER
    // BISA TOKEN QR ATAU KODE MEMBER
    // ===================================

    public function check(Request $request)
    {
        $request->validate([
            'token' => 'required|string'
        ]);

        $kode = trim($request->token);

        // CARI DARI TOKEN QR ATAU KODE MEMBER
        $member = Member::where('token', $kode)
            ->orWhere('kode_member', $kode)
            ->first();

        if (!$member) {
            return response()->json([
                "status" => false,
                "message" => "Member tidak ditemukan"
            ], 404);
        }

        // ===================================
        // CEK EXPIRED
        // ===================================

        if (
            !$member->tanggal_expired ||
            Carbon::now()->greaterThan(
                Carbon::parse($member->tanggal_expired)
            )
        ) {
            return response()->json([
                "status" => false,
                "message" => "Member sudah expired"
            ]);
        }

        // ===================================
        // CEK PEMBAYARAN
        // ===================================

        if (strtolower(trim($member->status)) !== "lunas") {
            return response()->json([
                "status" => false,
                "message" => "Member belum melakukan pembayaran"
            ]);
        }

        // ===================================
        // MEMBER VALID
        // ===================================

        return response()->json([
            "status" => true,
            "message" => "Member valid",
            "data" => $member
        ]);
    }


    // ===================================
    // RESET BULANAN
    // ===================================

    public function resetBulanan()
    {
        $affected = Member::where('status', 'lunas')
            ->where('tanggal_expired', '<', Carbon::now())
            ->update([
                'status' => 'belum lunas',
                'jumlah_bayar' => 0,
                'kembalian' => 0,
                'tanggal_bayar' => null
            ]);

        return response()->json([
            "status" => true,
            "message" => "Status member diperbarui",
            "jumlah_diupdate" => $affected
        ]);
    }
}