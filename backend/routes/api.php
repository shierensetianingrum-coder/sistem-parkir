<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TiketController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemberGateController;
use App\Http\Controllers\AkunParkirController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ForgotPasswordController;


// =====================================================
// TIKET PARKIR
// =====================================================

Route::post(
    '/tiket',
    [TiketController::class, 'create']
);


// =====================================================
// CEK TIKET NON-MEMBER UNTUK MASUK
// =====================================================

Route::post(
    '/tiket/cek-masuk',
    [TiketController::class, 'cekTiketMasuk']
);


Route::get(
    '/tiket',
    [TiketController::class, 'index']
);


Route::get(
    '/tiket/{id}',
    [TiketController::class, 'show']
);


Route::delete(
    '/tiket/{id}',
    [TiketController::class, 'destroy']
);


// =====================================================
// SCAN TIKET
// =====================================================

Route::post(
    '/scan',
    [ScanController::class, 'scan']
);


// =====================================================
// SCAN KELUAR
// =====================================================

Route::post(
    '/tiket/scan-keluar',
    [TiketController::class, 'scanKeluar']
);


Route::post(
    '/tiket/{id}/keluar',
    [TiketController::class, 'keluar']
);


// =====================================================
// MEMBER - CEK QR / KODE MEMBER
// =====================================================

Route::post(
    '/member/check',
    [MemberController::class, 'check']
);


// =====================================================
// MEMBER - CRUD
// =====================================================

Route::apiResource(
    '/members',
    MemberController::class
);


// =====================================================
// MEMBER - PEMBAYARAN
// =====================================================

Route::put(
    '/members/{id}/pembayaran',
    [MemberController::class, 'updatePembayaran']
);


// =====================================================
// MEMBER GATE
// =====================================================

Route::post(
    '/gate/check-member',
    [MemberGateController::class, 'checkMember']
);


// =====================================================
// MEMBER GATE - MASUK
// =====================================================

Route::post(
    '/gate/member',
    [MemberGateController::class, 'memberGate']
);


// =====================================================
// NON-MEMBER GATE - MASUK
// =====================================================

Route::post(
    '/gate/non-member',
    [MemberGateController::class, 'nonMemberGate']
);


// =====================================================
// AKUN PARKIR - REGISTRASI
// =====================================================

Route::post(
    '/register',
    [AkunParkirController::class, 'register']
);


// =====================================================
// AKUN PARKIR - LOGIN
// =====================================================

Route::post(
    '/login',
    [AkunParkirController::class, 'login']
);


// =====================================================
// KELOLA PETUGAS
// =====================================================

Route::get(
    '/petugas',
    [PetugasController::class, 'index']
);


Route::post(
    '/petugas',
    [PetugasController::class, 'store']
);


Route::put(
    '/petugas/{id}',
    [PetugasController::class, 'update']
);


Route::delete(
    '/petugas/{id}',
    [PetugasController::class, 'destroy']
);


// =====================================================
// LUPA PASSWORD
// =====================================================

// Cek email
Route::post(
    '/forgot-password/check-email',
    [ForgotPasswordController::class, 'checkEmail']
);


// Kirim OTP ke WhatsApp
Route::post(
    '/forgot-password/send-otp',
    [ForgotPasswordController::class, 'sendOtp']
);


// Verifikasi OTP
Route::post(
    '/forgot-password/verify-otp',
    [ForgotPasswordController::class, 'verifyOtp']
);


// Reset password
Route::post(
    '/forgot-password/reset-password',
    [ForgotPasswordController::class, 'resetPassword']
);