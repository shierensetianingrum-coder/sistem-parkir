<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambahkan jumlah_bayar hanya kalau belum ada
        if (!Schema::hasColumn('members', 'jumlah_bayar')) {
            Schema::table('members', function (Blueprint $table) {
                $table->decimal('jumlah_bayar', 15, 2)
                    ->default(0)
                    ->after('total_harga');
            });
        }

        // Tambahkan tanggal_bayar hanya kalau belum ada
        if (!Schema::hasColumn('members', 'tanggal_bayar')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dateTime('tanggal_bayar')
                    ->nullable()
                    ->after('jumlah_bayar');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('members', 'tanggal_bayar')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropColumn('tanggal_bayar');
            });
        }

        if (Schema::hasColumn('members', 'jumlah_bayar')) {
            Schema::table('members', function (Blueprint $table) {
                $table->dropColumn('jumlah_bayar');
            });
        }
    }
};