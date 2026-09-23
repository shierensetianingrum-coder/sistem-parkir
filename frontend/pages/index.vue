<template>
  <div
    class="min-h-screen relative overflow-hidden
           bg-gradient-to-br from-[#03150E] via-[#08281C] to-[#12452E]
           flex items-center justify-center px-4 py-8"
  >

    <!-- BACKGROUND GLOW -->
    <div
      class="absolute -top-32 -left-32 w-96 h-96
             bg-emerald-400/10 rounded-full blur-3xl"
    ></div>

    <div
      class="absolute -bottom-32 -right-32 w-96 h-96
             bg-lime-300/10 rounded-full blur-3xl"
    ></div>

    <!-- GARIS BACKGROUND -->
    <div
      class="absolute inset-0 opacity-10
             bg-[linear-gradient(135deg,transparent_45%,#86efac_46%,transparent_47%)]"
    ></div>

    <!-- LOGIN WRAPPER -->
    <div class="relative z-10 w-full max-w-md">

      <!-- LOGO -->
      <div class="text-center mb-7">

        <div
          class="mx-auto mb-5 w-20 h-20 rounded-3xl
                 bg-gradient-to-br from-emerald-300 to-lime-400
                 flex items-center justify-center
                 shadow-[0_0_45px_rgba(52,211,153,0.25)]
                 rotate-3"
        >
          <div
            class="w-14 h-14 rounded-2xl
                   bg-[#08281C]
                   flex items-center justify-center
                   -rotate-3"
          >
            <span
              class="text-3xl font-black
                     bg-gradient-to-r from-emerald-300 to-lime-300
                     bg-clip-text text-transparent"
            >
              P
            </span>
          </div>
        </div>

        <h1 class="text-3xl font-black tracking-tight text-white">
          PARKIR PLAZA ANDALAS
        </h1>

        <p class="mt-2 text-sm text-emerald-200/70">
          Sistem Manajemen Parkir
        </p>

      </div>


      <!-- CARD -->
      <div
        class="rounded-[28px]
               border border-white/10
               bg-white/[0.07]
               backdrop-blur-2xl
               p-7 sm:p-8
               shadow-2xl"
      >

        <!-- HEADER -->
        <div class="mb-7">

          <div class="flex items-center gap-3 mb-2">

            <div
              class="w-10 h-10 rounded-xl
                     bg-emerald-400/10
                     border border-emerald-300/10
                     flex items-center justify-center"
            >
              <span class="text-xl">🔐</span>
            </div>

            <div>
              <h2 class="text-xl font-bold text-white">
                Selamat Datang
              </h2>

              <p class="text-xs text-emerald-100/50">
                Silakan masuk untuk melanjutkan
              </p>
            </div>

          </div>

        </div>


        <!-- EMAIL -->
        <div class="mb-5">

          <label
            class="block text-sm font-semibold
                   text-emerald-100 mb-2"
          >
            Email
          </label>

          <div class="relative">

            <span
              class="absolute left-4 top-1/2
                     -translate-y-1/2
                     text-emerald-300/60"
            >
              ✉
            </span>

            <input
              v-model="email"
              type="email"
              placeholder="Masukkan email"
              class="w-full pl-11 pr-4 py-3.5
                     rounded-2xl
                     bg-black/20
                     border border-white/10
                     text-white
                     placeholder-white/30
                     outline-none
                     transition
                     focus:border-emerald-400/60
                     focus:bg-black/30
                     focus:ring-4 focus:ring-emerald-400/10"
              @keyup.enter="login"
            />

          </div>

        </div>


        <!-- PASSWORD -->
        <div class="mb-5">

          <label
            class="block text-sm font-semibold
                   text-emerald-100 mb-2"
          >
            Password
          </label>

          <div class="relative">

            <span
              class="absolute left-4 top-1/2
                     -translate-y-1/2
                     text-emerald-300/60"
            >
              🔒
            </span>

            <input
              v-model="password"
              :type="showPassword ? 'text' : 'password'"
              placeholder="Masukkan password"
              class="w-full pl-11 pr-12 py-3.5
                     rounded-2xl
                     bg-black/20
                     border border-white/10
                     text-white
                     placeholder-white/30
                     outline-none
                     transition
                     focus:border-emerald-400/60
                     focus:bg-black/30
                     focus:ring-4 focus:ring-emerald-400/10"
              @keyup.enter="login"
            />

            <button
              type="button"
              @click="showPassword = !showPassword"
              class="absolute right-4 top-1/2
                     -translate-y-1/2
                     text-emerald-200/60
                     hover:text-white transition"
            >
              {{ showPassword ? '🙈' : '👁️' }}
            </button>

          </div>

        </div>


        <!-- ERROR -->
        <div
          v-if="error"
          class="mb-5 p-3.5 rounded-2xl
                 bg-red-500/10
                 border border-red-400/20
                 text-red-200 text-sm"
        >
          ⚠️ {{ error }}
        </div>


        <!-- LOGIN BUTTON -->
        <button
          type="button"
          @click="login"
          :disabled="loading"
          class="w-full py-3.5 rounded-2xl
                 bg-gradient-to-r
                 from-emerald-400 to-lime-400
                 text-[#062016]
                 font-black
                 shadow-lg shadow-emerald-500/20
                 hover:shadow-emerald-400/30
                 hover:-translate-y-0.5
                 active:translate-y-0
                 transition-all
                 disabled:opacity-60
                 disabled:cursor-not-allowed"
        >
          {{ loading ? 'Memproses...' : 'Masuk ke Sistem →' }}
        </button>


        <!-- LUPA PASSWORD -->
        <div class="text-center mt-5">

          <NuxtLink
            to="/lupa-password"
            class="text-sm font-semibold
                   text-emerald-300
                   hover:text-lime-300
                   transition"
          >
            Lupa Password?
          </NuxtLink>

        </div>


        <!-- INFO -->
        <div
          class="mt-6 pt-5
                 border-t border-white/10
                 text-center"
        >
          <p class="text-xs text-white/35">
            Akses hanya untuk akun yang terdaftar
          </p>
        </div>

      </div>


      <!-- FOOTER -->
      <div class="text-center mt-6">

        <p class="text-xs text-white/30">
          © 2026 Parkir Plaza Andalas
        </p>

        <p class="text-[11px] text-emerald-300/30 mt-1">
          Smart Parking Management System
        </p>

      </div>

    </div>

  </div>
</template>


<script setup lang="ts">

const router = useRouter()

// ==================================================
// DATA FORM
// ==================================================

const email = ref('')
const password = ref('')
const error = ref('')
const loading = ref(false)
const showPassword = ref(false)


// ==================================================
// LOGIN
// ==================================================

const login = async () => {

  // Bersihkan error sebelumnya
  error.value = ''

  // ==================================================
  // CEK INPUT
  // ==================================================

  if (!email.value.trim() || !password.value) {

    error.value = 'Email dan password wajib diisi.'

    return
  }

  // Aktifkan loading
  loading.value = true


  try {

    // ==================================================
    // LOGIN KE BACKEND
    // ==================================================

    const response: any = await $fetch(
      'http://127.0.0.1:8000/api/login',
      {
        method: 'POST',

        body: {
          email: email.value.trim(),
          password: password.value
        }
      }
    )


    // ==================================================
    // CEK RESPONSE
    // ==================================================

    if (response.success) {

      const user = response.data


      // ==================================================
      // SIMPAN DATA LOGIN
      // ==================================================

      localStorage.setItem(
        'role',
        user.role
      )

      localStorage.setItem(
        'email',
        user.email
      )

      localStorage.setItem(
        'nama',
        user.nama
      )

      localStorage.setItem(
        'user_id',
        String(user.id)
      )


      // ==================================================
      // LOGIN ADMIN
      // ==================================================

      if (user.role === 'admin') {

        await router.push('/admin')

        return
      }


      // ==================================================
      // LOGIN PETUGAS
      // ==================================================

      if (user.role === 'petugas') {

        await router.push('/petugas')

        return
      }


      // ==================================================
      // ROLE TIDAK DIKENAL
      // ==================================================

      error.value = 'Role akun tidak dikenali.'

      return
    }


    // ==================================================
    // LOGIN GAGAL
    // ==================================================

    error.value =
      response.message ||
      'Email atau password salah.'

  } catch (err: any) {

    console.error('Login error:', err)


    // ==================================================
    // ERROR DARI LARAVEL
    // ==================================================

    if (err?.data?.message) {

      error.value = err.data.message

    } else {

      error.value =
        'Email atau password salah.'
    }

  } finally {

    // Matikan loading
    loading.value = false
  }

}

</script>