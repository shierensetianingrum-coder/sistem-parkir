<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Member;

class TiketParkir extends Model
{
    protected $table = 'tiket_parkir';

    protected $fillable = [
        'member_id',
        'kode_tiket',
        'qr_code',
        'status',
        'waktu_masuk',
        'waktu_keluar',
        'nomor_polisi',
        'jenis_kendaraan',
        'tarif',
    ];

    /*
    |--------------------------------------------------------------------------
    | CAST DATA
    |--------------------------------------------------------------------------
    | Supaya waktu_masuk dan waktu_keluar otomatis menjadi Carbon.
    | Jadi bisa menggunakan diffInMinutes(), format(), dll.
    |--------------------------------------------------------------------------
    */
    protected $casts = [
        'waktu_masuk' => 'datetime',
        'waktu_keluar' => 'datetime',
        'tarif' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI MEMBER
    |--------------------------------------------------------------------------
    */
    public function member()
    {
        return $this->belongsTo(
            Member::class,
            'member_id'
        );
    }
}