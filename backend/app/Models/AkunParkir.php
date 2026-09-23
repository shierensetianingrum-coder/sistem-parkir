<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class AkunParkir extends Model
{
    protected $table = 'akun_parkir';

    protected $fillable = [
        'nama',
        'email',
        'no_hp',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}