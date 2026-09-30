<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagihanMember extends Model
{
    use HasFactory;

    protected $table = 'tagihan_members';

    protected $fillable = [
        'member_id',
        'periode_bulan',
        'total_harga',
        'jumlah_bayar',
        'kembalian',
        'status',
        'tanggal_bayar',
    ];

    protected $casts = [
        'periode_bulan' => 'date',
        'total_harga' => 'integer',
        'jumlah_bayar' => 'integer',
        'kembalian' => 'integer',
        'tanggal_bayar' => 'date',
    ];

    /**
     * Tagihan ini dimiliki oleh satu member.
     */
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}