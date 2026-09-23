<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';

    protected $fillable = [
        'kode_member',
        'token',
        'nama_member',
        'nama_perusahaan',
        'total_harga',
        'jumlah_bayar',
        'kembalian',
        'status',
        'tanggal_bayar',
        'tanggal_mulai',
        'tanggal_expired',
        'tanggal_reset',
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
        'jumlah_bayar' => 'decimal:2',
        'kembalian' => 'decimal:2',

        'tanggal_bayar' => 'datetime',
        'tanggal_mulai' => 'datetime',
        'tanggal_expired' => 'datetime',
        'tanggal_reset' => 'datetime',
    ];
}