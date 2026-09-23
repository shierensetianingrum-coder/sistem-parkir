<template>
  <div class="min-h-screen bg-[#F3F7F5]">

    <!-- ===================================================== -->
    <!-- SIDEBAR -->
    <!-- ===================================================== -->

    <aside
      class="fixed left-0 top-0 bottom-0 w-72
      bg-gradient-to-b from-[#061A12] via-[#0B2A1D] to-[#164A31]
      text-white shadow-2xl z-50 flex flex-col"
    >

      <!-- LOGO -->
      <div class="px-6 py-7 border-b border-white/10">

        <div class="flex items-center gap-3">

          <div
            class="w-12 h-12 rounded-2xl
            bg-gradient-to-br from-white to-green-100
            flex items-center justify-center
            shadow-lg"
          >

            <div
              class="w-9 h-9 rounded-xl
              bg-gradient-to-br from-[#0B2A1D] to-[#1D5C3D]
              flex items-center justify-center"
            >

              <span class="text-2xl font-black text-white">
                P
              </span>

            </div>

          </div>


          <div class="min-w-0">

            <h1
              class="font-black text-base tracking-wide truncate"
            >
              PARKIR PLAZA
            </h1>

            <p class="text-xs text-green-300">
              ANDALAS
            </p>

          </div>

        </div>

      </div>


      <!-- PROFIL -->
      <div
        class="mx-4 mt-5 p-4 rounded-2xl
        bg-white/10 border border-white/10"
      >

        <div class="flex items-center gap-3">

          <div
            class="w-11 h-11 rounded-full
            bg-gradient-to-br from-green-300 to-green-600
            flex items-center justify-center
            text-xl shadow-lg"
          >
            👤
          </div>


          <div class="min-w-0">

            <p class="font-semibold text-sm">
              Super Admin
            </p>

            <p class="text-xs text-green-200 truncate">
              admin@parkir.com
            </p>

          </div>

        </div>

      </div>


      <!-- MENU -->
      <nav class="flex-1 px-4 mt-6 space-y-2">

        <p
          class="text-[10px] uppercase tracking-widest
          text-green-400 px-3 mb-3"
        >
          Menu Utama
        </p>


        <!-- DASHBOARD -->
        <NuxtLink
          to="/admin"
          class="flex items-center gap-3 px-4 py-3.5
          rounded-xl
          bg-white/15
          border border-white/10
          shadow-lg transition"
        >

          <span class="text-xl">
            📊
          </span>

          <span class="font-semibold">
            Dashboard
          </span>

        </NuxtLink>


        <!-- KELOLA PETUGAS -->
        <NuxtLink
          to="/admin/kelola-petugas"
          class="flex items-center gap-3 px-4 py-3.5
          rounded-xl
          hover:bg-white/10
          transition"
        >

          <span class="text-xl">
            👥
          </span>

          <span>
            Kelola Petugas
          </span>

        </NuxtLink>


        <!-- LAPORAN -->
        <NuxtLink
          to="/admin/laporan"
          class="flex items-center gap-3 px-4 py-3.5
          rounded-xl
          hover:bg-white/10
          transition"
        >

          <span class="text-xl">
            📄
          </span>

          <span>
            Laporan
          </span>

        </NuxtLink>


        <!-- SISTEM -->
        <p
          class="text-[10px] uppercase tracking-widest
          text-green-400 px-3 pt-6 mb-3"
        >
          Sistem
        </p>


        <div
          class="flex items-center gap-3 px-4 py-3
          rounded-xl text-green-100/70"
        >

          <span
            class="w-7 h-7 rounded-lg
            bg-white/10
            flex items-center justify-center
            font-black text-sm"
          >
            P
          </span>

          <span class="text-sm">
            PARKIR PLAZA ANDALAS
          </span>

        </div>

      </nav>


      <!-- LOGOUT -->
      <div class="p-4 border-t border-white/10">

        <button
          @click="logout"
          class="w-full flex items-center gap-3
          px-4 py-3 rounded-xl
          bg-red-500/10
          hover:bg-red-500/20
          text-red-200
          transition"
        >

          <span class="text-xl">
            🚪
          </span>

          <span class="font-semibold">
            Logout
          </span>

        </button>

      </div>

    </aside>


    <!-- ===================================================== -->
    <!-- MAIN -->
    <!-- ===================================================== -->

    <main class="ml-72 p-8">

      <!-- HEADER -->
      <div class="flex items-center justify-between mb-8">

        <div>

          <div
            class="flex items-center gap-2
            text-sm text-gray-400"
          >

            <span>
              PARKIR PLAZA ANDALAS
            </span>

            <span>
              /
            </span>

            <span class="text-green-700 font-medium">
              Admin
            </span>

          </div>


          <h1
            class="text-3xl font-black
            text-gray-800 mt-2"
          >
            Dashboard Super Admin 👋
          </h1>


          <p class="text-gray-500 mt-1">
            Pantau aktivitas dan statistik
            parkir Plaza Andalas hari ini.
          </p>

        </div>


        <!-- TANGGAL OTOMATIS -->
        <div
          class="hidden md:flex items-center gap-3
          bg-white px-5 py-3 rounded-2xl
          shadow-sm border border-gray-100"
        >

          <div
            class="w-10 h-10 rounded-xl
            bg-green-100
            flex items-center justify-center"
          >
            📅
          </div>


          <div>

            <p class="text-xs text-gray-400">
              Hari ini
            </p>

            <p class="text-sm font-bold text-gray-700">
              {{ tanggalHariIni }}
            </p>

          </div>

        </div>

      </div>


      <!-- ===================================================== -->
      <!-- STAT CARDS -->
      <!-- ===================================================== -->

      <div
        class="grid grid-cols-1 md:grid-cols-2
        xl:grid-cols-4 gap-5 mb-7"
      >

        <!-- TRANSAKSI -->
        <div
          class="bg-white rounded-2xl p-5
          border border-gray-100
          shadow-sm hover:shadow-lg
          hover:-translate-y-1 transition"
        >

          <div class="flex justify-between items-start">

            <div>

              <p class="text-sm text-gray-500">
                Total Transaksi
              </p>

              <h2
                class="text-3xl font-bold
                text-gray-800 mt-2"
              >
                1.248
              </h2>

            </div>


            <div
              class="w-12 h-12 rounded-2xl
              bg-green-100
              flex items-center justify-center
              text-2xl"
            >
              💳
            </div>

          </div>


          <div class="mt-4 flex items-center gap-2">

            <span
              class="text-xs font-bold
              text-green-600
              bg-green-50
              px-2 py-1 rounded-lg"
            >
              +12.5%
            </span>

            <span class="text-xs text-gray-400">
              dari bulan lalu
            </span>

          </div>

        </div>


        <!-- PENDAPATAN -->
        <div
          class="bg-white rounded-2xl p-5
          border border-gray-100
          shadow-sm hover:shadow-lg
          hover:-translate-y-1 transition"
        >

          <div class="flex justify-between items-start">

            <div>

              <p class="text-sm text-gray-500">
                Pendapatan
              </p>

              <h2
                class="text-2xl font-bold
                text-gray-800 mt-2"
              >
                Rp 12,8 Jt
              </h2>

            </div>


            <div
              class="w-12 h-12 rounded-2xl
              bg-emerald-100
              flex items-center justify-center
              text-2xl"
            >
              💰
            </div>

          </div>


          <div class="mt-4 flex items-center gap-2">

            <span
              class="text-xs font-bold
              text-green-600
              bg-green-50
              px-2 py-1 rounded-lg"
            >
              +8.2%
            </span>

            <span class="text-xs text-gray-400">
              bulan ini
            </span>

          </div>

        </div>


        <!-- MEMBER -->
        <div
          class="bg-white rounded-2xl p-5
          border border-gray-100
          shadow-sm hover:shadow-lg
          hover:-translate-y-1 transition"
        >

          <div class="flex justify-between items-start">

            <div>

              <p class="text-sm text-gray-500">
                Member Aktif
              </p>

              <h2
                class="text-3xl font-bold
                text-gray-800 mt-2"
              >
                86
              </h2>

            </div>


            <div
              class="w-12 h-12 rounded-2xl
              bg-blue-100
              flex items-center justify-center
              text-2xl"
            >
              👥
            </div>

          </div>


          <div class="mt-4 flex items-center gap-2">

            <span
              class="text-xs font-bold
              text-blue-600
              bg-blue-50
              px-2 py-1 rounded-lg"
            >
              +7
            </span>

            <span class="text-xs text-gray-400">
              member baru
            </span>

          </div>

        </div>


        <!-- KENDARAAN -->
        <div
          class="bg-white rounded-2xl p-5
          border border-gray-100
          shadow-sm hover:shadow-lg
          hover:-translate-y-1 transition"
        >

          <div class="flex justify-between items-start">

            <div>

              <p class="text-sm text-gray-500">
                Kendaraan Hari Ini
              </p>

              <h2
                class="text-3xl font-bold
                text-gray-800 mt-2"
              >
                327
              </h2>

            </div>


            <div
              class="w-12 h-12 rounded-2xl
              bg-orange-100
              flex items-center justify-center
              text-2xl"
            >
              🚗
            </div>

          </div>


          <div class="mt-4 flex items-center gap-2">

            <span
              class="text-xs font-bold
              text-orange-600
              bg-orange-50
              px-2 py-1 rounded-lg"
            >
              Aktif
            </span>

            <span class="text-xs text-gray-400">
              hari ini
            </span>

          </div>

        </div>

      </div>


      <!-- ===================================================== -->
      <!-- GRAFIK + STATUS -->
      <!-- ===================================================== -->

      <div
        class="grid grid-cols-1 xl:grid-cols-3
        gap-6 mb-6"
      >

        <!-- GRAFIK -->
        <div
          class="xl:col-span-2
          bg-white rounded-2xl
          border border-gray-100
          shadow-sm p-6"
        >

          <div
            class="flex items-center
            justify-between mb-6"
          >

            <div>

              <h2
                class="text-xl font-bold
                text-gray-800"
              >
                Statistik Transaksi
              </h2>

              <p class="text-sm text-gray-400 mt-1">
                Jumlah kendaraan masuk dan keluar
              </p>

            </div>


            <select
              v-model="periode"
              class="text-sm
              border border-gray-200
              rounded-xl px-3 py-2
              outline-none
              focus:ring-2
              focus:ring-green-500"
            >

              <option>
                7 Hari
              </option>

              <option>
                30 Hari
              </option>

            </select>

          </div>


          <!-- CHART -->
          <div class="h-72 flex items-end gap-4">

            <div
              v-for="item in grafik"
              :key="item.hari"
              class="flex-1 h-full
              flex flex-col
              justify-end items-center"
            >

              <p
                class="text-xs font-bold
                text-gray-500 mb-2"
              >
                {{ item.nilai }}
              </p>


              <div
                class="w-full max-w-[48px]
                bg-gradient-to-t
                from-[#0B2A1D]
                via-[#26704C]
                to-[#73B894]
                rounded-t-xl
                hover:opacity-80 transition"
                :style="{
                  height: item.nilai + '%'
                }"
              ></div>


              <p
                class="text-xs text-gray-400 mt-3"
              >
                {{ item.hari }}
              </p>

            </div>

          </div>


          <!-- LEGEND -->
          <div
            class="flex items-center gap-6
            mt-6 pt-5
            border-t border-gray-100"
          >

            <div class="flex items-center gap-2">

              <span
                class="w-3 h-3 rounded-full
                bg-[#0B2A1D]"
              ></span>

              <span class="text-xs text-gray-500">
                Transaksi
              </span>

            </div>


            <div class="flex items-center gap-2">

              <span
                class="w-3 h-3 rounded-full
                bg-green-300"
              ></span>

              <span class="text-xs text-gray-500">
                Kendaraan
              </span>

            </div>

          </div>

        </div>


        <!-- STATUS PARKIR -->
        <div
          class="bg-white rounded-2xl
          border border-gray-100
          shadow-sm p-6"
        >

          <h2
            class="text-xl font-bold
            text-gray-800"
          >
            Status Parkir
          </h2>

          <p class="text-sm text-gray-400 mt-1">
            Kondisi area parkir saat ini
          </p>


          <!-- CIRCLE -->
          <div class="flex justify-center my-7">

            <div
              class="w-40 h-40 rounded-full
              border-[18px]
              border-[#0B2A1D]
              flex items-center
              justify-center"
            >

              <div class="text-center">

                <p
                  class="text-3xl font-bold
                  text-gray-800"
                >
                  72%
                </p>

                <p class="text-xs text-gray-400">
                  Terisi
                </p>

              </div>

            </div>

          </div>


          <!-- PROGRESS -->
          <div class="space-y-5">

            <div>

              <div
                class="flex justify-between
                text-sm mb-2"
              >

                <span class="text-gray-500">
                  🚗 Mobil
                </span>

                <span class="font-bold">
                  68%
                </span>

              </div>


              <div
                class="h-2 bg-gray-100
                rounded-full overflow-hidden"
              >

                <div
                  class="h-full
                  bg-[#0B2A1D]
                  rounded-full"
                  style="width: 68%"
                ></div>

              </div>

            </div>


            <div>

              <div
                class="flex justify-between
                text-sm mb-2"
              >

                <span class="text-gray-500">
                  🛵 Motor
                </span>

                <span class="font-bold">
                  82%
                </span>

              </div>


              <div
                class="h-2 bg-gray-100
                rounded-full overflow-hidden"
              >

                <div
                  class="h-full
                  bg-green-500
                  rounded-full"
                  style="width: 82%"
                ></div>

              </div>

            </div>

          </div>

        </div>

      </div>


      <!-- ===================================================== -->
      <!-- PENDAPATAN + AKTIVITAS -->
      <!-- ===================================================== -->

      <div
        class="grid grid-cols-1 xl:grid-cols-3
        gap-6 mb-6"
      >

        <!-- PENDAPATAN -->
        <div
          class="xl:col-span-2
          bg-white rounded-2xl
          border border-gray-100
          shadow-sm p-6"
        >

          <div
            class="flex justify-between
            items-center mb-6"
          >

            <div>

              <h2
                class="text-xl font-bold
                text-gray-800"
              >
                Pendapatan Mingguan
              </h2>

              <p class="text-sm text-gray-400 mt-1">
                Perkiraan pendapatan
                Parkir Plaza Andalas
              </p>

            </div>


            <div class="text-right">

              <p class="text-xs text-gray-400">
                Total
              </p>

              <p
                class="text-lg font-bold
                text-green-700"
              >
                Rp 3.245.000
              </p>

            </div>

          </div>


          <div
            class="grid grid-cols-7 gap-3
            items-end h-52"
          >

            <div
              v-for="item in pendapatan"
              :key="item.hari"
              class="flex flex-col
              items-center h-full
              justify-end"
            >

              <div
                class="w-9 rounded-xl
                bg-gradient-to-t
                from-[#164A31]
                to-[#72B795]
                hover:opacity-80 transition"
                :style="{
                  height: item.nilai + '%'
                }"
              ></div>


              <p
                class="text-xs text-gray-400 mt-3"
              >
                {{ item.hari }}
              </p>

            </div>

          </div>

        </div>


        <!-- AKTIVITAS -->
        <div
          class="bg-white rounded-2xl
          border border-gray-100
          shadow-sm p-6"
        >

          <div
            class="flex justify-between
            items-center"
          >

            <div>

              <h2
                class="text-xl font-bold
                text-gray-800"
              >
                Aktivitas
              </h2>

              <p class="text-sm text-gray-400">
                Terbaru
              </p>

            </div>


            <span
              class="text-xs
              text-green-700
              font-semibold"
            >
              ● Live
            </span>

          </div>


          <div class="space-y-5 mt-6">

            <!-- AKTIVITAS 1 -->
            <div class="flex gap-3">

              <div
                class="w-10 h-10 shrink-0
                rounded-xl
                bg-green-100
                flex items-center
                justify-center"
              >
                🚗
              </div>


              <div>

                <p
                  class="text-sm font-semibold
                  text-gray-700"
                >
                  Kendaraan masuk
                </p>

                <p class="text-xs text-gray-400">
                  B 1234 ABC
                </p>

                <p
                  class="text-[10px]
                  text-gray-300 mt-1"
                >
                  5 menit lalu
                </p>

              </div>

            </div>


            <!-- AKTIVITAS 2 -->
            <div class="flex gap-3">

              <div
                class="w-10 h-10 shrink-0
                rounded-xl
                bg-blue-100
                flex items-center
                justify-center"
              >
                💳
              </div>


              <div>

                <p
                  class="text-sm font-semibold
                  text-gray-700"
                >
                  Transaksi selesai
                </p>

                <p class="text-xs text-gray-400">
                  Rp 10.000
                </p>

                <p
                  class="text-[10px]
                  text-gray-300 mt-1"
                >
                  12 menit lalu
                </p>

              </div>

            </div>


            <!-- AKTIVITAS 3 -->
            <div class="flex gap-3">

              <div
                class="w-10 h-10 shrink-0
                rounded-xl
                bg-purple-100
                flex items-center
                justify-center"
              >
                👤
              </div>


              <div>

                <p
                  class="text-sm font-semibold
                  text-gray-700"
                >
                  Member baru
                </p>

                <p class="text-xs text-gray-400">
                  Member berhasil ditambahkan
                </p>

                <p
                  class="text-[10px]
                  text-gray-300 mt-1"
                >
                  30 menit lalu
                </p>

              </div>

            </div>


            <!-- AKTIVITAS 4 -->
            <div class="flex gap-3">

              <div
                class="w-10 h-10 shrink-0
                rounded-xl
                bg-orange-100
                flex items-center
                justify-center"
              >
                📄
              </div>


              <div>

                <p
                  class="text-sm font-semibold
                  text-gray-700"
                >
                  Laporan dibuat
                </p>

                <p class="text-xs text-gray-400">
                  Laporan parkir harian
                </p>

                <p
                  class="text-[10px]
                  text-gray-300 mt-1"
                >
                  1 jam lalu
                </p>

              </div>

            </div>

          </div>

        </div>

      </div>


      <!-- ===================================================== -->
      <!-- MENU CEPAT -->
      <!-- ===================================================== -->

      <div>

        <div class="flex justify-between items-center mb-4">

          <div>

            <h2
              class="text-xl font-bold
              text-gray-800"
            >
              Menu Cepat
            </h2>

            <p class="text-sm text-gray-400">
              Akses fitur administrasi
              Parkir Plaza Andalas
            </p>

          </div>

        </div>


        <div
          class="grid grid-cols-1
          md:grid-cols-2 gap-5"
        >

          <!-- KELOLA PETUGAS -->
          <NuxtLink
            to="/admin/kelola-petugas"
            class="group
            bg-gradient-to-r
            from-[#0B2A1D]
            to-[#246B48]
            text-white
            rounded-2xl p-6
            shadow-lg
            hover:shadow-xl
            hover:-translate-y-1
            transition"
          >

            <div
              class="w-12 h-12 rounded-xl
              bg-white/10
              flex items-center
              justify-center
              text-2xl mb-4"
            >
              👥
            </div>


            <h3 class="text-xl font-bold">
              Kelola Petugas
            </h3>


            <p class="text-green-100 text-sm mt-1">
              Kelola data dan akun
              petugas parkir.
            </p>


            <div class="mt-5 text-sm font-semibold">
              Buka Kelola Petugas →
            </div>

          </NuxtLink>


          <!-- LAPORAN -->
          <NuxtLink
            to="/admin/laporan"
            class="group
            bg-white
            border border-gray-100
            rounded-2xl p-6
            shadow-sm
            hover:shadow-lg
            hover:-translate-y-1
            transition"
          >

            <div
              class="w-12 h-12 rounded-xl
              bg-green-100
              flex items-center
              justify-center
              text-2xl mb-4"
            >
              📄
            </div>


            <h3
              class="text-xl font-bold
              text-gray-800"
            >
              Laporan
            </h3>


            <p class="text-gray-400 text-sm mt-1">
              Lihat laporan dan statistik
              parkir.
            </p>


            <div
              class="mt-5 text-sm
              font-semibold
              text-green-700"
            >
              Buka Laporan →
            </div>

          </NuxtLink>

        </div>

      </div>


      <!-- FOOTER BRAND -->
      <div class="mt-8 pb-4 text-center">

        <p class="text-xs text-gray-400">

          © 2026

          <span class="font-bold text-green-700">
            PARKIR PLAZA ANDALAS
          </span>

        </p>

      </div>

    </main>

  </div>
</template>


<script setup lang="ts">

const router = useRouter()

const periode = ref('7 Hari')


// =====================================================
// TANGGAL OTOMATIS
// =====================================================

const tanggalHariIni = ref('')


// =====================================================
// CEK LOGIN ADMIN + TANGGAL
// =====================================================

onMounted(() => {

  // Ambil tanggal dari komputer/laptop
  const sekarang = new Date()

  tanggalHariIni.value = sekarang.toLocaleDateString(
    'id-ID',
    {
      weekday: 'long',
      day: 'numeric',
      month: 'long',
      year: 'numeric'
    }
  )


  // Cek role login
  const role = localStorage.getItem('role')

  if (role !== 'admin') {

    router.push('/')

  }

})


// =====================================================
// DATA GRAFIK TRANSAKSI
// =====================================================

const grafik = [

  {
    hari: 'Sen',
    nilai: 45
  },

  {
    hari: 'Sel',
    nilai: 65
  },

  {
    hari: 'Rab',
    nilai: 52
  },

  {
    hari: 'Kam',
    nilai: 82
  },

  {
    hari: 'Jum',
    nilai: 70
  },

  {
    hari: 'Sab',
    nilai: 95
  },

  {
    hari: 'Min',
    nilai: 76
  }

]


// =====================================================
// DATA PENDAPATAN
// =====================================================

const pendapatan = [

  {
    hari: 'Sen',
    nilai: 45
  },

  {
    hari: 'Sel',
    nilai: 65
  },

  {
    hari: 'Rab',
    nilai: 55
  },

  {
    hari: 'Kam',
    nilai: 78
  },

  {
    hari: 'Jum',
    nilai: 62
  },

  {
    hari: 'Sab',
    nilai: 92
  },

  {
    hari: 'Min',
    nilai: 72
  }

]


// =====================================================
// LOGOUT
// =====================================================

const logout = () => {

  localStorage.removeItem('role')

  localStorage.removeItem('email')

  router.push('/')

}

</script>