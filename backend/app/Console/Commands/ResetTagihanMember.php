<?php

namespace App\Console\Commands;

use App\Models\Member;
use App\Models\TagihanMember;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ResetTagihanMember extends Command
{
    protected $signature = 'member:reset-bulanan
                            {--date= : Tanggal untuk testing, contoh 2026-10-01}';

    protected $description = 'Membuat tagihan member baru untuk bulan berjalan';

    public function handle()
    {
        // Kalau ada --date, gunakan tanggal tersebut.
        // Kalau tidak ada, gunakan tanggal sekarang.
        $tanggal = $this->option('date')
            ? Carbon::parse($this->option('date'))
            : Carbon::now();

        $periode = $tanggal->copy()->startOfMonth();

        $hargaMember = 150000;

        $members = Member::all();

        $jumlahDibuat = 0;

        foreach ($members as $member) {

            $tagihan = TagihanMember::firstOrCreate(
                [
                    'member_id' => $member->id,
                    'periode_bulan' => $periode->toDateString(),
                ],
                [
                    'total_harga' => $hargaMember,
                    'jumlah_bayar' => 0,
                    'kembalian' => 0,
                    'status' => 'belum lunas',
                    'tanggal_bayar' => null,
                ]
            );

            if ($tagihan->wasRecentlyCreated) {
                $jumlahDibuat++;
            }

            // Sinkronkan data member dengan tagihan bulan yang sedang dites
            $member->update([
                'total_harga' => $tagihan->total_harga,
                'jumlah_bayar' => $tagihan->jumlah_bayar,
                'kembalian' => $tagihan->kembalian,
                'status' => $tagihan->status,
                'tanggal_bayar' => $tagihan->tanggal_bayar,
                'tanggal_expired' => $periode->copy()->endOfMonth(),
            ]);
        }

        $this->info(
            'Tagihan bulan ' .
            $periode->format('m/Y') .
            ' berhasil disiapkan.'
        );

        $this->info(
            'Tanggal yang digunakan: ' .
            $tanggal->format('d/m/Y')
        );

        $this->info(
            'Jumlah member: ' .
            $members->count()
        );

        $this->info(
            'Jumlah tagihan baru: ' .
            $jumlahDibuat
        );

        return Command::SUCCESS;
    }
}