<?php

namespace App\Http\Controllers;

use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    // =========================================================
    // CEK EMAIL
    // =========================================================
    public function checkEmail(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Email wajib diisi dengan benar.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Bersihkan email
        $email = trim($request->email);

        // Cari user berdasarkan email
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak ditemukan.',
            ], 404);
        }

        // Cek apakah user memiliki nomor HP
        if (!$user->no_hp) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor WhatsApp akun ini belum tersedia.',
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Email ditemukan.',
            'no_hp' => $user->no_hp,
        ]);
    }


    // =========================================================
    // KIRIM OTP KE WHATSAPP
    // =========================================================
    public function sendOtp(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'no_hp' => ['required', 'string', 'max:20'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor WhatsApp wajib diisi.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // =====================================================
        // BERSIHKAN NOMOR HP
        // =====================================================
        $noHp = preg_replace('/[^0-9]/', '', $request->no_hp);

        // =====================================================
        // NORMALISASI KE FORMAT 62
        // =====================================================
        $noHp62 = $this->normalizePhone($noHp);

        // =====================================================
        // CARI USER
        // =====================================================
        $user = $this->findUserByPhone($noHp62);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor WhatsApp tidak ditemukan.',
            ], 404);
        }

        // =====================================================
        // HAPUS OTP LAMA
        // =====================================================
        PasswordResetOtp::where('user_id', $user->id)->delete();

        // =====================================================
        // BUAT OTP 6 DIGIT
        // =====================================================
        $otp = (string) random_int(100000, 999999);

        // =====================================================
        // SIMPAN OTP
        // =====================================================
        PasswordResetOtp::create([
            'user_id' => $user->id,
            'otp' => $otp,
            'expires_at' => Carbon::now()->addMinutes(5),
        ]);

        // =====================================================
        // AMBIL TOKEN FONNTE
        // =====================================================
        $token = config('services.fonnte.token');

        if (!$token) {
            PasswordResetOtp::where('user_id', $user->id)->delete();

            return response()->json([
                'success' => false,
                'message' => 'Fonnte API token belum dikonfigurasi.',
            ], 500);
        }

        // =====================================================
        // PESAN OTP
        // =====================================================
        $pesan =
            "*Kode OTP Reset Password PARKIR PLAZA ANDALAS*\n\n" .
            "Kode OTP kamu adalah: *{$otp}*\n\n" .
            "Kode ini berlaku selama 5 menit.\n" .
            "Jangan berikan kode OTP ini kepada siapa pun.";

        try {

            // =================================================
            // KIRIM KE FONNTE
            // =================================================
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->post('https://api.fonnte.com/send', [
                'target' => $noHp62,
                'message' => $pesan,
            ]);

            // =================================================
            // CEK HTTP RESPONSE
            // =================================================
            if (!$response->successful()) {

                PasswordResetOtp::where('user_id', $user->id)->delete();

                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengirim OTP ke WhatsApp.',
                    'error' => $response->body(),
                ], 500);
            }

            // =================================================
            // AMBIL HASIL FONNTE
            // =================================================
            $hasil = $response->json();

            // =================================================
            // CEK STATUS FONNTE
            // =================================================
            if (isset($hasil['status']) && $hasil['status'] === false) {

                PasswordResetOtp::where('user_id', $user->id)->delete();

                return response()->json([
                    'success' => false,
                    'message' => $hasil['reason']
                        ?? 'Gagal mengirim OTP ke WhatsApp.',
                ], 500);
            }

            // =================================================
            // BERHASIL
            // =================================================
            return response()->json([
                'success' => true,
                'message' => 'Kode OTP berhasil dikirim ke WhatsApp.',
            ]);

        } catch (\Throwable $e) {

            PasswordResetOtp::where('user_id', $user->id)->delete();

            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat terhubung ke layanan WhatsApp.',
            ], 500);
        }
    }


    // =========================================================
    // VERIFIKASI OTP
    // =========================================================
    public function verifyOtp(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'no_hp' => ['required', 'string', 'max:20'],
            'otp' => ['required', 'digits:6'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor WhatsApp dan OTP harus diisi dengan benar.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // =====================================================
        // BERSIHKAN NOMOR
        // =====================================================
        $noHp = preg_replace('/[^0-9]/', '', $request->no_hp);

        // Normalisasi ke format 62
        $noHp62 = $this->normalizePhone($noHp);

        // =====================================================
        // CARI USER
        // =====================================================
        $user = $this->findUserByPhone($noHp62);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor WhatsApp tidak ditemukan.',
            ], 404);
        }

        // =====================================================
        // CARI OTP TERBARU
        // =====================================================
        $otpData = PasswordResetOtp::where('user_id', $user->id)
            ->where('otp', $request->otp)
            ->whereNull('verified_at')
            ->latest()
            ->first();

        if (!$otpData) {
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP salah atau sudah tidak berlaku.',
            ], 422);
        }

        // =====================================================
        // CEK EXPIRED
        // =====================================================
        if (Carbon::now()->greaterThan($otpData->expires_at)) {

            $otpData->delete();

            return response()->json([
                'success' => false,
                'message' => 'Kode OTP sudah expired. Silakan minta OTP baru.',
            ], 422);
        }

        // =====================================================
        // TANDAI OTP SUDAH DIVERIFIKASI
        // =====================================================
        $otpData->update([
            'verified_at' => Carbon::now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'OTP berhasil diverifikasi.',
        ]);
    }


    // =========================================================
    // RESET PASSWORD
    // =========================================================
    public function resetPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'no_hp' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Password tidak valid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // =====================================================
        // BERSIHKAN NOMOR
        // =====================================================
        $noHp = preg_replace('/[^0-9]/', '', $request->no_hp);

        // Normalisasi ke format 62
        $noHp62 = $this->normalizePhone($noHp);

        // =====================================================
        // CARI USER
        // =====================================================
        $user = $this->findUserByPhone($noHp62);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor WhatsApp tidak ditemukan.',
            ], 404);
        }

        // =====================================================
        // CARI OTP YANG SUDAH DIVERIFIKASI
        // =====================================================
        $otpData = PasswordResetOtp::where('user_id', $user->id)
            ->whereNotNull('verified_at')
            ->latest()
            ->first();

        if (!$otpData) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan verifikasi OTP terlebih dahulu.',
            ], 422);
        }

        // =====================================================
        // CEK MASA BERLAKU RESET PASSWORD
        // =====================================================
        if (
            $otpData->verified_at &&
            Carbon::now()->greaterThan(
                Carbon::parse($otpData->verified_at)->addMinutes(5)
            )
        ) {

            $otpData->delete();

            return response()->json([
                'success' => false,
                'message' => 'Sesi reset password sudah expired. Silakan minta OTP baru.',
            ], 422);
        }

        // =====================================================
        // UPDATE PASSWORD
        // =====================================================

        // Hash password baru
        $user->password = Hash::make($request->password);

        // Simpan langsung ke tabel users
        $user->save();

        // =====================================================
        // HAPUS OTP
        // =====================================================
        PasswordResetOtp::where('user_id', $user->id)->delete();

        // =====================================================
        // RESPONSE
        // =====================================================
        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah. Silakan login kembali.',
        ]);
    }


    // =========================================================
    // NORMALISASI NOMOR HP
    // =========================================================
    private function normalizePhone(string $noHp): string
    {
        // Hapus semua karakter selain angka
        $noHp = preg_replace('/[^0-9]/', '', $noHp);

        // 08xxxxxxxx
        // menjadi 628xxxxxxxx
        if (str_starts_with($noHp, '0')) {
            return '62' . substr($noHp, 1);
        }

        // 62xxxxxxxx
        if (str_starts_with($noHp, '62')) {
            return $noHp;
        }

        // Kalau nomor belum punya 0 atau 62
        // tambahkan 62
        return '62' . $noHp;
    }


    // =========================================================
    // CARI USER BERDASARKAN NOMOR HP
    // SUPPORT:
    //
    // 089xxxxxxx
    // 6289xxxxxxx
    // =========================================================
    private function findUserByPhone(string $noHp62): ?User
    {
        // Coba format 62
        $user = User::where('no_hp', $noHp62)->first();

        if ($user) {
            return $user;
        }

        // Ubah 62xxxxxxxx menjadi 0xxxxxxxx
        if (str_starts_with($noHp62, '62')) {

            $noHp08 = '0' . substr($noHp62, 2);

            $user = User::where('no_hp', $noHp08)->first();

            if ($user) {
                return $user;
            }
        }

        return null;
    }
}