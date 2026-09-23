<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tiket_parkir', function (Blueprint $table) {
            $table->unsignedBigInteger('member_id')->nullable()->after('id');
            $table->string('nomor_polisi')->nullable()->after('member_id');
            $table->string('jenis_kendaraan')->nullable()->after('nomor_polisi');
            $table->decimal('tarif', 12, 2)->default(0)->after('jenis_kendaraan');

            $table->foreign('member_id')
                  ->references('id')
                  ->on('members')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('tiket_parkir', function (Blueprint $table) {
            $table->dropForeign(['member_id']);
            $table->dropColumn([
                'member_id',
                'nomor_polisi',
                'jenis_kendaraan',
                'tarif'
            ]);
        });
    }
};