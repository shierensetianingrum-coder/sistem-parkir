<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tagihan_members', function (Blueprint $table) {
            $table->id();

            $table->foreignId('member_id')
                ->constrained('members')
                ->cascadeOnDelete();

            $table->date('periode_bulan');

            $table->integer('total_harga')->default(150000);

            $table->integer('jumlah_bayar')->default(0);

            $table->integer('kembalian')->default(0);

            $table->enum('status', [
                'lunas',
                'belum lunas'
            ])->default('belum lunas');

            $table->date('tanggal_bayar')->nullable();

            $table->timestamps();

            $table->unique([
                'member_id',
                'periode_bulan'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan_members');
    }
};