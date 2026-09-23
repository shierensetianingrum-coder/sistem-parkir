<template>
  <div
    class="min-h-screen bg-gradient-to-br from-[#061A12] via-[#0B2A1D] to-[#164A31]
           flex items-center justify-center px-4 py-8 relative overflow-hidden"
  >

    <!-- Background Glow -->
    <div
      class="absolute -top-32 -left-32 w-96 h-96 bg-emerald-500/20
             rounded-full blur-3xl"
    ></div>

    <div
      class="absolute -bottom-32 -right-32 w-96 h-96 bg-lime-400/10
             rounded-full blur-3xl"
    ></div>

    <!-- CARD -->
    <div
      class="relative z-10 w-full max-w-md
             bg-white/95 backdrop-blur-xl
             rounded-3xl shadow-2xl
             p-8"
    >

      <!-- LOGO -->
      <div class="text-center mb-7">
        <div
          class="mx-auto mb-4 w-16 h-16 rounded-2xl
                 bg-gradient-to-br from-emerald-600 to-green-800
                 flex items-center justify-center
                 shadow-lg"
        >
          <span class="text-white text-3xl font-black">
            P
          </span>
        </div>

        <h1 class="text-2xl font-black text-[#0B2A1D]">
          Daftar Akun
        </h1>

        <p class="text-gray-500 text-sm mt-1">
          Sistem Parkir Plaza Andalas
        </p>
      </div>

      <!-- SUCCESS -->
      <div
        v-if="success"
        class="mb-5 rounded-xl bg-green-50 border border-green-200
               px-4 py-3 text-sm text-green-700"
      >
        {{ success }}
      </div>

      <!-- ERROR -->
      <div
        v-if="error"
        class="mb-5 rounded-xl bg-red-50 border border-red-200
               px-4 py-3 text-sm text-red-600"
      >
        {{ error }}
      </div>

      <!-- FORM -->
      <form @submit.prevent="register" class="space-y-4">

        <!-- NAMA -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            Nama Lengkap
          </label>

          <input
            v-model="nama"
            type="text"
            placeholder="Masukkan nama lengkap"
            class="w-full px-4 py-3 rounded-xl
                   border border-gray-200
                   bg-gray-50
                   outline-none
                   focus:border-emerald-600
                   focus:ring-2 focus:ring-emerald-100
                   transition"
          />
        </div>

        <!-- EMAIL -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            Email
          </label>

          <input
            v-model="email"
            type="email"
            placeholder="contoh@email.com"
            class="w-full px-4 py-3 rounded-xl
                   border border-gray-200
                   bg-gray-50
                   outline-none
                   focus:border-emerald-600
                   focus:ring-2 focus:ring-emerald-100
                   transition"
          />
        </div>

        <!-- NO HP -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            Nomor HP
          </label>

          <input
            v-model="noHp"
            type="tel"
            placeholder="08xxxxxxxxxx"
            class="w-full px-4 py-3 rounded-xl
                   border border-gray-200
                   bg-gray-50
                   outline-none
                   focus:border-emerald-600
                   focus:ring-2 focus:ring-emerald-100
                   transition"
          />

          <p class="text-xs text-gray-400 mt-1">
            Gunakan nomor HP yang aktif.
          </p>
        </div>

        <!-- PASSWORD -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            Password
          </label>

          <div class="relative">
            <input
              v-model="password"
              :type="showPassword ? 'text' : 'password'"
              placeholder="Minimal 6 karakter"
              class="w-full px-4 py-3 pr-12 rounded-xl
                     border border-gray-200
                     bg-gray-50
                     outline-none
                     focus:border-emerald-600
                     focus:ring-2 focus:ring-emerald-100
                     transition"
            />

            <button
              type="button"
              @click="showPassword = !showPassword"
              class="absolute right-3 top-1/2 -translate-y-1/2
                     text-gray-400 hover:text-emerald-700"
            >
              {{ showPassword ? '🙈' : '👁️' }}
            </button>
          </div>
        </div>

        <!-- KONFIRMASI PASSWORD -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            Konfirmasi Password
          </label>

          <div class="relative">
            <input
              v-model="konfirmasiPassword"
              :type="showConfirmPassword ? 'text' : 'password'"
              placeholder="Ulangi password"
              class="w-full px-4 py-3 pr-12 rounded-xl
                     border border-gray-200
                     bg-gray-50
                     outline-none
                     focus:border-emerald-600
                     focus:ring-2 focus:ring-emerald-100
                     transition"
            />

            <button
              type="button"
              @click="showConfirmPassword = !showConfirmPassword"
              class="absolute right-3 top-1/2 -translate-y-1/2
                     text-gray-400 hover:text-emerald-700"
            >
              {{ showConfirmPassword ? '🙈' : '👁️' }}
            </button>
          </div>
        </div>

        <!-- BUTTON -->
        <button
          type="submit"
          :disabled="loading"
          class="w-full py-3.5 rounded-xl
                 bg-gradient-to-r from-emerald-700 to-green-800
                 hover:from-emerald-800 hover:to-green-900
                 text-white font-bold
                 shadow-lg shadow-emerald-900/20
                 transition
                 disabled:opacity-60
                 disabled:cursor-not-allowed"
        >
          <span v-if="!loading">
            Daftar Sekarang
          </span>

          <span v-else>
            Sedang mendaftarkan...
          </span>
        </button>

      </form>

      <!-- LOGIN -->
      <div class="text-center mt-6">
        <span class="text-sm text-gray-500">
          Sudah punya akun?
        </span>

        <button
          type="button"
          @click="router.push('/')"
          class="ml-1 text-sm font-bold text-emerald-700
                 hover:text-emerald-900"
        >
          Login
        </button>
      </div>

    </div>
  </div>
</template>

<script setup lang="ts">

const router = useRouter()

const nama = ref('')
const email = ref('')
const noHp = ref('')
const password = ref('')
const konfirmasiPassword = ref('')

const error = ref('')
const success = ref('')
const loading = ref(false)

const showPassword = ref(false)
const showConfirmPassword = ref(false)


const register = async () => {

  // Reset pesan
  error.value = ''
  success.value = ''

  // ==============================
  // VALIDASI FORM
  // ==============================

  if (
    !nama.value ||
    !email.value ||
    !noHp.value ||
    !password.value ||
    !konfirmasiPassword.value
  ) {
    error.value = 'Semua data wajib diisi.'
    return
  }

  if (password.value.length < 6) {
    error.value = 'Password minimal 6 karakter.'
    return
  }

  if (password.value !== konfirmasiPassword.value) {
    error.value = 'Konfirmasi password tidak sama.'
    return
  }

  loading.value = true

  try {

    // ==============================
    // KIRIM KE LARAVEL
    // ==============================

    const response = await $fetch(
      'http://127.0.0.1:8000/api/register',
      {
        method: 'POST',

        body: {
          nama: nama.value,
          email: email.value,
          no_hp: noHp.value,
          password: password.value
        }
      }
    )

    console.log('Registrasi berhasil:', response)

    // ==============================
    // BERHASIL
    // ==============================

    success.value =
      'Registrasi berhasil! Silakan login menggunakan akun kamu.'

    // Kosongkan form
    nama.value = ''
    email.value = ''
    noHp.value = ''
    password.value = ''
    konfirmasiPassword.value = ''

    // Kembali ke login setelah 1,5 detik
    setTimeout(() => {
      router.push('/')
    }, 1500)

  } catch (err: any) {

    console.error('Registrasi gagal:', err)

    // ==============================
    // ERROR VALIDASI LARAVEL
    // ==============================

    if (err?.data?.errors) {

      const errors = err.data.errors

      const firstError = Object.values(errors)[0]

      if (Array.isArray(firstError)) {
        error.value = String(firstError[0])
      } else {
        error.value = String(firstError)
      }

    }

    // ==============================
    // ERROR MESSAGE LARAVEL
    // ==============================

    else if (err?.data?.message) {

      error.value = err.data.message

    }

    // ==============================
    // ERROR LAIN
    // ==============================

    else {

      error.value =
        'Registrasi gagal. Pastikan server Laravel sedang berjalan.'

    }

  } finally {

    loading.value = false

  }
}

</script>