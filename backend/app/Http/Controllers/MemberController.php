<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\TagihanMember;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MemberController extends Controller
{
    // ===================================
    // HARGA MEMBER PER BULAN
    // ===================================

    private $hargaMember = 150000;


    // ===================================
    // MEMBUAT / MENGAMBIL TAGIHAN BULAN INI
    // ===================================

    private function getTagihanBulanIni(Member $member)
    {
        $periode = Carbon::now()->startOfMonth()->toDateString();

        $tagihan = TagihanMember::firstOrCreate(
            [
                'member_id' => $member->id,
                'periode_bulan' => $periode,
            ],
            [
                'total_harga' => $this->hargaMember,
                'jumlah_bayar' => 0,
                'kembalian' => 0,
                'status' => 'belum lunas',
                'tanggal_bayar' => null,
            ]
        );

        return $tagihan;
    }


    // ===================================
    // MENYINKRONKAN DATA MEMBER DENGAN
    // TAGIHAN BULAN BERJALAN
    // ===================================

    private function syncMemberWithTagihan(Member $member)
    {
        $tagihan = $this->getTagihanBulanIni($member);

        $tanggalExpired = Carbon::now()->endOfMonth();

        $member->update([
            'total_harga' => $tagihan->total_harga,
            'jumlah_bayar' => $tagihan->jumlah_bayar,
            'kembalian' => $tagihan->kembalian,
            'status' => $tagihan->status,
            'tanggal_bayar' => $tagihan->tanggal_bayar,
            'tanggal_expired' => $tanggalExpired,
        ]);

        $member->refresh();

        return $tagihan;
    }


    // ===================================
    // DATA MEMBER + TAGIHAN BULAN INI
    // ===================================

    private function formatMember(Member $member)
    {
        $tagihan = $this->getTagihanBulanIni($member);

        return [
            'id' => $member->id,
            'kode_member' => $member->kode_member,
            'token' => $member->token,

            'nama_member' => $member->nama_member,
            'nama_perusahaan' => $member->nama_perusahaan,

            'total_harga' => $tagihan->total_harga,
            'jumlah_bayar' => $tagihan->jumlah_bayar,
            'kembalian' => $tagihan->kembalian,

            'status' => $tagihan->status,

            'tanggal_bayar' => $tagihan->tanggal_bayar,
            'tanggal_mulai' => $member->tanggal_mulai,

            'tanggal_expired' => $member->tanggal_expired,

            'periode_bulan' => $tagihan->periode_bulan,

            'tagihan_id' => $tagihan->id,
        ];
    }


    // ===================================
    // TAMPIL SEMUA MEMBER
    // ===================================

    public function index()
    {
        $members = Member::latest()->get();

        $data = [];

        foreach ($members as $member) {
            $this->syncMemberWithTagihan($member);

            $data[] = $this->formatMember($member);
        }

        return response()->json([
            "status" => true,
            "data" => $data
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

        $harga_member = $this->hargaMember;
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

        // Karena sistem sekarang berdasarkan bulan kalender,
        // masa aktif pembayaran adalah sampai akhir bulan.
        $tanggal_expired = Carbon::now()->endOfMonth();

        // ===================================
        // BUAT DATA MEMBER
        // ===================================

        $member = Member::create([
            'kode_member' => $this->generateKodeMember(),

            // Token yang masuk ke QR
            'token' => (string) Str::uuid(),

            'nama_member' => $request->nama_member,
            'nama_perusahaan' => $request->nama_perusahaan,

            'total_harga' => $harga_member,
            'jumlah_bayar' => $jumlah_bayar,
            'kembalian' => $kembalian,

            'status' => $status,

            'tanggal_bayar' => $jumlah_bayar > 0
                ? Carbon::now()
                : null,

            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_expired' => $tanggal_expired
        ]);

        // ===================================
        // BUAT TAGIHAN BULAN INI
        // ===================================

        TagihanMember::create([
            'member_id' => $member->id,
            'periode_bulan' => Carbon::now()->startOfMonth(),

            'total_harga' => $harga_member,
            'jumlah_bayar' => $jumlah_bayar,
            'kembalian' => $kembalian,

            'status' => $status,

            'tanggal_bayar' => $jumlah_bayar > 0
                ? Carbon::now()
                : null,
        ]);

        $member->refresh();

        return response()->json([
            "status" => true,
            "message" => "Member berhasil dibuat",
            "data" => $this->formatMember($member)
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

        // Pastikan tagihan bulan berjalan tersedia
        $tagihan = $this->syncMemberWithTagihan($member);

        // QR berisi token member
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

                "total_harga" => $tagihan->total_harga,
                "jumlah_bayar" => $tagihan->jumlah_bayar,
                "kembalian" => $tagihan->kembalian,

                "status" => $tagihan->status,

                "tanggal_bayar" => $tagihan->tanggal_bayar,
                "tanggal_mulai" => $member->tanggal_mulai,
                "tanggal_expired" => $member->tanggal_expired,

                "periode_bulan" => $tagihan->periode_bulan,

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

        $member->refresh();

        return response()->json([
            "status" => true,
            "message" => "Data member berhasil diperbarui",
            "data" => $this->formatMember($member)
        ]);
    }


    // ===================================
    // UPDATE PEMBAYARAN BULAN INI
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

        // ===================================
        // AMBIL TAGIHAN BULAN BERJALAN
        // ===================================

        $tagihan = $this->getTagihanBulanIni($member);

        $jumlah_bayar = (float) $request->jumlah_bayar;
        $total_harga = (float) $tagihan->total_harga;

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

        $tanggal_bayar = $jumlah_bayar > 0
            ? Carbon::now()
            : null;

        // ===================================
        // UPDATE TAGIHAN BULAN INI
        // ===================================

        $tagihan->update([
            'jumlah_bayar' => $jumlah_bayar,
            'kembalian' => $kembalian,
            'status' => $status,
            'tanggal_bayar' => $tanggal_bayar,
        ]);

        // ===================================
        // SINKRONKAN DATA MEMBER
        // ===================================

        $tanggal_expired = Carbon::now()->endOfMonth();

        $member->update([
            'total_harga' => $total_harga,
            'jumlah_bayar' => $jumlah_bayar,
            'kembalian' => $kembalian,
            'status' => $status,
            'tanggal_bayar' => $tanggal_bayar,
            'tanggal_expired' => $tanggal_expired,
        ]);

        $member->refresh();

        return response()->json([
            "status" => true,

            "message" => $status === "lunas"
                ? "Pembayaran bulan ini berhasil. Member lunas sampai " .
                    Carbon::parse($tanggal_expired)->format('d/m/Y')
                : "Pembayaran bulan ini berhasil diperbarui",

            "data" => $this->formatMember($member)
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

        // Karena tagihan_members menggunakan cascadeOnDelete,
        // seluruh tagihan milik member ikut terhapus.
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

        // ===================================
        // CARI MEMBER
        // ===================================

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
        // AMBIL TAGIHAN BULAN INI
        // ===================================

        $tagihan = $this->getTagihanBulanIni($member);

        // ===================================
        // CEK PEMBAYARAN BULAN INI
        // ===================================

        if (strtolower(trim($tagihan->status)) !== "lunas") {
            return response()->json([
                "status" => false,
                "message" => "Member belum melakukan pembayaran bulan ini",
                "data" => [
                    "is_member" => true,
                    "kode_member" => $member->kode_member,
                    "nama_member" => $member->nama_member,
                    "nama_perusahaan" => $member->nama_perusahaan,
                    "periode_bulan" => $tagihan->periode_bulan,
                    "status" => $tagihan->status,
                    "total_harga" => $tagihan->total_harga,
                    "jumlah_bayar" => $tagihan->jumlah_bayar
                ]
            ]);
        }

        // ===================================
        // MEMBER VALID
        // ===================================

        $tanggalExpired = Carbon::now()->endOfMonth();

        $member->update([
            'status' => 'lunas',
            'jumlah_bayar' => $tagihan->jumlah_bayar,
            'kembalian' => $tagihan->kembalian,
            'tanggal_bayar' => $tagihan->tanggal_bayar,
            'tanggal_expired' => $tanggalExpired
        ]);

        $member->refresh();

        return response()->json([
            "status" => true,
            "message" => "Member valid",
            "data" => [
                "id" => $member->id,
                "is_member" => true,

                "kode_member" => $member->kode_member,
                "token" => $member->token,

                "nama_member" => $member->nama_member,
                "nama_perusahaan" => $member->nama_perusahaan,

                "total_harga" => $tagihan->total_harga,
                "jumlah_bayar" => $tagihan->jumlah_bayar,
                "kembalian" => $tagihan->kembalian,

                "status" => $tagihan->status,

                "tanggal_bayar" => $tagihan->tanggal_bayar,
                "tanggal_expired" => $tanggalExpired,

                "periode_bulan" => $tagihan->periode_bulan,

                // Member keluar = Rp0
                "total" => 0
            ]
        ]);
    }


    // ===================================
    // RESET / SIAPKAN TAGIHAN BULANAN
    // ===================================
    //
    // Fungsi ini TIDAK menghapus pembayaran bulan sebelumnya.
    //
    // Contoh:
    //
    // September = lunas
    // Oktober = dibuat baru, belum lunas
    // November = dibuat baru, belum lunas
    //
    // ===================================

    public function resetBulanan()
    {
        $periode = Carbon::now()->startOfMonth();

        $members = Member::all();

        $jumlahDibuat = 0;

        foreach ($members as $member) {

            $tagihan = TagihanMember::firstOrCreate(
                [
                    'member_id' => $member->id,
                    'periode_bulan' => $periode->toDateString(),
                ],
                [
                    'total_harga' => $this->hargaMember,
                    'jumlah_bayar' => 0,
                    'kembalian' => 0,
                    'status' => 'belum lunas',
                    'tanggal_bayar' => null,
                ]
            );

            if ($tagihan->wasRecentlyCreated) {
                $jumlahDibuat++;
            }

            // Sinkronkan member dengan tagihan bulan berjalan
            $member->update([
                'total_harga' => $tagihan->total_harga,
                'jumlah_bayar' => $tagihan->jumlah_bayar,
                'kembalian' => $tagihan->kembalian,
                'status' => $tagihan->status,
                'tanggal_bayar' => $tagihan->tanggal_bayar,
                'tanggal_expired' => $periode->copy()->endOfMonth(),
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => "Tagihan bulan " .
                $periode->format('m/Y') .
                " berhasil disiapkan",

            "jumlah_member" => $members->count(),

            "jumlah_tagihan_baru" => $jumlahDibuat
        ]);
    }
}