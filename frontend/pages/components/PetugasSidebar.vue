<template>
  <aside
    class="fixed left-0 top-0 bottom-0 w-72 bg-gradient-to-b from-[#061A12] via-[#0B2A1D] to-[#164A31] text-white shadow-2xl flex flex-col z-50"
  >

    <!-- LOGO -->
    <div class="p-6 border-b border-white/10">

      <div class="flex items-center gap-3">

        <div
          class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-2xl"
        >
          🚗
        </div>

        <div>
          <h1 class="font-bold text-lg">
            Sistem Parkir
          </h1>

          <p class="text-xs text-green-200">
            Petugas
          </p>
        </div>

      </div>

    </div>

    <!-- MENU -->
    <nav class="flex-1 p-4 space-y-2">

      <NuxtLink
        to="/petugas"
        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition"
      >
        📊
        Dashboard
      </NuxtLink>

      <NuxtLink
        to="/petugas/scan-masuk"
        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition"
      >
        📥
        Scan Masuk
      </NuxtLink>

      <NuxtLink
        to="/petugas/scan-keluar"
        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition"
      >
        📤
        Scan Keluar
      </NuxtLink>

      <NuxtLink
        to="/petugas/transaksi"
        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition"
      >
        💳
        Kelola Transaksi
      </NuxtLink>

      <NuxtLink
        to="/petugas/member"
        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition"
      >
        👥
        Kelola Member
      </NuxtLink>

      <NuxtLink
        to="/petugas/laporan"
        class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/10 transition"
      >
        📄
        Laporan
      </NuxtLink>

    </nav>

    <!-- LOGOUT -->
    <div class="p-4 border-t border-white/10">

      <button
        @click="logout"
        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl bg-red-500/20 hover:bg-red-500/30 text-red-200 transition"
      >
        🚪
        Logout
      </button>

    </div>

  </aside>
</template>

<script setup lang="ts">
const router = useRouter()

const logout = () => {
  localStorage.removeItem('role')
  localStorage.removeItem('username')

  router.push('/')
}
</script>