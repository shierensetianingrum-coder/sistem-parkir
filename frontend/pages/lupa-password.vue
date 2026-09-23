<template>

  <div
    class="min-h-screen bg-gradient-to-br from-[#061A12] via-[#0B2A1D] to-[#164A31]
    flex items-center justify-center p-6 relative overflow-hidden"
  >

    <!-- BACKGROUND DECORATION -->
    <div
      class="absolute -top-32 -left-32 w-80 h-80
      bg-green-400/10 rounded-full blur-3xl"
    ></div>

    <div
      class="absolute -bottom-32 -right-32 w-96 h-96
      bg-emerald-300/10 rounded-full blur-3xl"
    ></div>


    <div class="w-full max-w-md relative z-10">

      <!-- LOGO -->
      <div class="text-center text-white mb-8">

        <div
          class="mx-auto mb-5 w-24 h-24 rounded-[28px]
          bg-gradient-to-br from-white to-green-100
          flex items-center justify-center
          shadow-2xl shadow-black/30
          border-4 border-white/20"
        >

          <div
            class="w-16 h-16 rounded-2xl
            bg-gradient-to-br from-[#0B2A1D] to-[#1D5C3D]
            flex items-center justify-center
            shadow-lg"
          >

            <span class="text-5xl font-black text-white">
              P
            </span>

          </div>

        </div>

        <h1 class="text-3xl font-black tracking-wide">
          PARKIR PLAZA ANDALAS
        </h1>

        <div class="flex items-center justify-center gap-2 mt-3">

          <div class="h-px w-8 bg-green-300/50"></div>

          <p class="text-green-200 text-sm">
            Sistem Manajemen Parkir
          </p>

          <div class="h-px w-8 bg-green-300/50"></div>

        </div>

      </div>


      <!-- CARD -->
      <div
        class="bg-white/95 backdrop-blur-xl
        rounded-[28px]
        shadow-2xl
        p-8
        border border-white/40"
      >

        <!-- HEADER -->
        <div class="mb-7">

          <div class="flex items-center gap-3">

            <div
              class="w-11 h-11 rounded-xl
              bg-green-100
              flex items-center justify-center
              text-xl"
            >
              🔑
            </div>

            <div>

              <h2 class="text-2xl font-bold text-gray-800">
                Lupa Password
              </h2>

              <p class="text-gray-500 text-xs">
                Pulihkan akses akun Anda
              </p>

            </div>

          </div>

        </div>


        <!-- PROGRESS -->
        <div class="flex items-center mb-7">

          <div class="flex items-center flex-1">

            <div
              :class="[
                'w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold',
                step >= 1
                  ? 'bg-green-700 text-white'
                  : 'bg-gray-200 text-gray-500'
              ]"
            >
              1
            </div>

            <div
              class="h-1 flex-1 mx-2 rounded"
              :class="step >= 2 ? 'bg-green-600' : 'bg-gray-200'"
            ></div>

          </div>


          <div class="flex items-center flex-1">

            <div
              :class="[
                'w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold',
                step >= 2
                  ? 'bg-green-700 text-white'
                  : 'bg-gray-200 text-gray-500'
              ]"
            >
              2
            </div>

            <div
              class="h-1 flex-1 mx-2 rounded"
              :class="step >= 3 ? 'bg-green-600' : 'bg-gray-200'"
            ></div>

          </div>


          <div
            :class="[
              'w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold',
              step >= 3
                ? 'bg-green-700 text-white'
                : 'bg-gray-200 text-gray-500'
            ]"
          >
            3
          </div>

        </div>


        <!-- =============================== -->
        <!-- STEP 1 : EMAIL -->
        <!-- =============================== -->

        <div v-if="step === 1">

          <div class="mb-5">

            <h3 class="text-lg font-bold text-gray-800">
              Verifikasi Email
            </h3>

            <p class="text-sm text-gray-500 mt-1">
              Masukkan email yang terdaftar di sistem.
            </p>

          </div>


          <div class="mb-5">

            <label
              class="block text-sm font-semibold text-gray-700 mb-2"
            >
              Email
            </label>

            <div class="relative">

              <span
                class="absolute left-4 top-1/2
                -translate-y-1/2 text-gray-400"
              >
                ✉️
              </span>

              <input
                v-model="email"
                type="email"
                placeholder="Masukkan email terdaftar"
                class="w-full pl-12 pr-4 py-3.5
                rounded-xl border border-gray-200
                bg-gray-50 outline-none
                focus:bg-white
                focus:ring-2 focus:ring-green-600
                focus:border-green-600 transition"
                @keyup.enter="verifikasiEmail"
              />

            </div>

          </div>


          <button
            type="button"
            @click="verifikasiEmail"
            :disabled="loading"
            class="w-full py-4
            rounded-xl
            bg-gradient-to-r
            from-[#0B2A1D]
            to-[#1D5C3D]
            text-white font-bold
            shadow-lg
            hover:shadow-xl
            transition
            disabled:opacity-50"
          >
            {{ loading ? 'MEMERIKSA...' : 'VERIFIKASI EMAIL →' }}
          </button>

        </div>


        <!-- =============================== -->
        <!-- STEP 2 : NOMOR HP + OTP -->
        <!-- =============================== -->

        <div v-if="step === 2">

          <div class="mb-5">

            <h3 class="text-lg font-bold text-gray-800">
              Verifikasi WhatsApp
            </h3>

            <p class="text-sm text-gray-500 mt-1">
              Verifikasi nomor HP yang terdaftar pada akun.
            </p>

          </div>


          <!-- NOMOR HP -->
          <div class="mb-4">

            <label
              class="block text-sm font-semibold text-gray-700 mb-2"
            >
              Nomor WhatsApp
            </label>

            <div class="relative">

              <span
                class="absolute left-4 top-1/2
                -translate-y-1/2 text-gray-400"
              >
                📱
              </span>

              <input
                v-model="noHp"
                type="tel"
                placeholder="Masukkan nomor WhatsApp"
                class="w-full pl-12 pr-4 py-3.5
                rounded-xl border border-gray-200
                bg-gray-50 outline-none
                focus:bg-white
                focus:ring-2 focus:ring-green-600
                focus:border-green-600 transition"
              />

            </div>

          </div>


          <!-- KIRIM OTP -->
          <button
            type="button"
            @click="kirimOTP"
            :disabled="loading"
            class="w-full py-3.5
            rounded-xl
            border-2 border-green-700
            text-green-700
            font-bold
            hover:bg-green-50
            transition
            disabled:opacity-50"
          >
            {{ loading ? 'MENGIRIM OTP...' : 'KIRIM OTP WHATSAPP' }}
          </button>


          <!-- OTP -->
          <div class="mt-5">

            <label
              class="block text-sm font-semibold text-gray-700 mb-2"
            >
              Kode OTP
            </label>

            <input
              v-model="otp"
              type="text"
              maxlength="6"
              placeholder="Masukkan 6 digit OTP"
              class="w-full px-4 py-3.5
              rounded-xl border border-gray-200
              bg-gray-50 outline-none
              text-center tracking-[0.4em]
              font-bold text-lg
              focus:bg-white
              focus:ring-2 focus:ring-green-600
              focus:border-green-600 transition"
            />

          </div>


          <button
            type="button"
            @click="verifikasiOTP"
            :disabled="loading"
            class="w-full mt-4 py-4
            rounded-xl
            bg-gradient-to-r
            from-[#0B2A1D]
            to-[#1D5C3D]
            text-white font-bold
            shadow-lg
            hover:shadow-xl
            transition
            disabled:opacity-50"
          >
            {{ loading ? 'MEMVERIFIKASI...' : 'VERIFIKASI OTP →' }}
          </button>

        </div>


        <!-- =============================== -->
        <!-- STEP 3 : RESET PASSWORD -->
        <!-- =============================== -->

        <div v-if="step === 3">

          <div class="mb-5">

            <h3 class="text-lg font-bold text-gray-800">
              Reset Password
            </h3>

            <p class="text-sm text-gray-500 mt-1">
              Buat password baru untuk akun Anda.
            </p>

          </div>


          <!-- PASSWORD BARU -->
          <div class="mb-4">

            <label
              class="block text-sm font-semibold text-gray-700 mb-2"
            >
              Password Baru
            </label>

            <div class="relative">

              <span
                class="absolute left-4 top-1/2
                -translate-y-1/2 text-gray-400"
              >
                🔒
              </span>

              <input
                v-model="passwordBaru"
                :type="showNewPassword ? 'text' : 'password'"
                placeholder="Masukkan password baru"
                class="w-full pl-12 pr-24 py-3.5
                rounded-xl border border-gray-200
                bg-gray-50 outline-none
                focus:bg-white
                focus:ring-2 focus:ring-green-600
                focus:border-green-600 transition"
              />

              <button
                type="button"
                @click="showNewPassword = !showNewPassword"
                class="absolute right-3 top-1/2
                -translate-y-1/2
                text-xs font-bold text-green-700"
              >
                {{ showNewPassword ? 'SEMBUNYI' : 'LIHAT' }}
              </button>

            </div>

          </div>


          <!-- KONFIRMASI -->
          <div class="mb-5">

            <label
              class="block text-sm font-semibold text-gray-700 mb-2"
            >
              Konfirmasi Password Baru
            </label>

            <input
              v-model="konfirmasiPassword"
              type="password"
              placeholder="Ulangi password baru"
              class="w-full px-4 py-3.5
              rounded-xl border border-gray-200
              bg-gray-50 outline-none
              focus:bg-white
              focus:ring-2 focus:ring-green-600
              focus:border-green-600 transition"
            />

          </div>


          <button
            type="button"
            @click="resetPassword"
            :disabled="loading"
            class="w-full py-4
            rounded-xl
            bg-gradient-to-r
            from-[#0B2A1D]
            to-[#1D5C3D]
            text-white font-bold
            shadow-lg
            hover:shadow-xl
            transition
            disabled:opacity-50"
          >
            {{ loading ? 'MENYIMPAN...' : 'RESET PASSWORD →' }}
          </button>

        </div>


        <!-- ERROR -->
        <div
          v-if="error"
          class="mt-5
          bg-red-50 border border-red-200
          text-red-600 px-4 py-3
          rounded-xl text-sm"
        >
          ⚠️ {{ error }}
        </div>


        <!-- SUCCESS -->
        <div
          v-if="success"
          class="mt-5
          bg-green-50 border border-green-200
          text-green-700 px-4 py-3
          rounded-xl text-sm"
        >
          ✅ {{ success }}
        </div>


        <!-- KEMBALI -->
        <div class="mt-6 text-center">

          <button
            type="button"
            @click="router.push('/')"
            class="text-sm font-bold
            text-green-700
            hover:text-green-900
            hover:underline transition"
          >
            ← Kembali ke Login
          </button>

        </div>

      </div>


      <!-- FOOTER -->
      <div class="text-center mt-6">

        <p class="text-green-200 text-xs">
          © 2026
          <span class="font-bold">
            PARKIR PLAZA ANDALAS
          </span>
        </p>

        <p class="text-green-300/60 text-[10px] mt-1">
          Sistem Manajemen Parkir
        </p>

      </div>

    </div>

  </div>

</template>


<script setup lang="ts">

import { ref } from 'vue'

const router = useRouter()

// =========================================================
// API
// =========================================================

const config = useRuntimeConfig()

const apiBase = config.public.apiBase


// =========================================================
// DATA
// =========================================================

const step = ref(1)

const email = ref('')
const noHp = ref('')
const otp = ref('')

const passwordBaru = ref('')
const konfirmasiPassword = ref('')

const error = ref('')
const success = ref('')
const loading = ref(false)

const showNewPassword = ref(false)


// =========================================================
// STEP 1
// VERIFIKASI EMAIL
// =========================================================

const verifikasiEmail = async () => {

  error.value = ''
  success.value = ''

  if (!email.value) {

    error.value = 'Email wajib diisi.'

    return
  }

  loading.value = true

  try {

    const response: any = await $fetch(
      `${apiBase}/forgot-password/check-email`,
      {
        method: 'POST',

        body: {
          email: email.value.trim()
        }
      }
    )

    if (response.success) {

      noHp.value = response.no_hp || ''

      success.value = 'Email ditemukan. Silakan verifikasi WhatsApp.'

      step.value = 2

    } else {

      error.value = response.message || 'Email tidak ditemukan.'

    }

  } catch (err: any) {

    error.value =
      err?.data?.message ||
      'Email tidak ditemukan atau terjadi kesalahan.'

  } finally {

    loading.value = false

  }
}


// =========================================================
// STEP 2
// KIRIM OTP
// =========================================================

const kirimOTP = async () => {

  error.value = ''
  success.value = ''

  if (!noHp.value) {

    error.value = 'Nomor WhatsApp wajib diisi.'

    return
  }

  loading.value = true

  try {

    const response: any = await $fetch(
      `${apiBase}/forgot-password/send-otp`,
      {
        method: 'POST',

        body: {
          no_hp: noHp.value.trim()
        }
      }
    )

    if (response.success) {

      success.value =
        'Kode OTP berhasil dikirim ke WhatsApp. Silakan cek WhatsApp kamu.'

    } else {

      error.value =
        response.message || 'Gagal mengirim OTP.'

    }

  } catch (err: any) {

    error.value =
      err?.data?.message ||
      'Gagal mengirim OTP ke WhatsApp.'

  } finally {

    loading.value = false

  }
}


// =========================================================
// STEP 2
// VERIFIKASI OTP
// =========================================================

const verifikasiOTP = async () => {

  error.value = ''
  success.value = ''

  if (!otp.value) {

    error.value = 'Kode OTP wajib diisi.'

    return
  }

  if (otp.value.length !== 6) {

    error.value = 'Kode OTP harus 6 digit.'

    return
  }

  loading.value = true

  try {

    const response: any = await $fetch(
      `${apiBase}/forgot-password/verify-otp`,
      {
        method: 'POST',

        body: {
          no_hp: noHp.value.trim(),
          otp: otp.value.trim()
        }
      }
    )

    if (response.success) {

      success.value =
        'OTP berhasil diverifikasi. Silakan buat password baru.'

      step.value = 3

    } else {

      error.value =
        response.message || 'OTP tidak valid.'

    }

  } catch (err: any) {

    error.value =
      err?.data?.message ||
      'Kode OTP salah atau sudah expired.'

  } finally {

    loading.value = false

  }
}


// =========================================================
// STEP 3
// RESET PASSWORD
// =========================================================

const resetPassword = async () => {

  error.value = ''
  success.value = ''

  if (!passwordBaru.value || !konfirmasiPassword.value) {

    error.value =
      'Password baru dan konfirmasi wajib diisi.'

    return
  }

  if (passwordBaru.value.length < 8) {

    error.value =
      'Password minimal 8 karakter.'

    return
  }

  if (
    passwordBaru.value !==
    konfirmasiPassword.value
  ) {

    error.value =
      'Konfirmasi password tidak sama.'

    return
  }

  loading.value = true

  try {

    const response: any = await $fetch(
      `${apiBase}/forgot-password/reset-password`,
      {
        method: 'POST',

        body: {
          no_hp: noHp.value.trim(),

          password: passwordBaru.value,

          password_confirmation:
            konfirmasiPassword.value
        }
      }
    )

    if (response.success) {

      success.value =
        'Password berhasil diubah. Silakan login kembali.'

      setTimeout(() => {

        router.push('/')

      }, 1500)

    } else {

      error.value =
        response.message ||
        'Gagal mengubah password.'

    }

  } catch (err: any) {

    error.value =
      err?.data?.message ||
      'Gagal mengubah password.'

  } finally {

    loading.value = false

  }
}

</script>