<template>
  <div class="min-h-screen bg-[#F3F7F5] font-sans">

    <!-- ================================================= -->
    <!-- SIDEBAR -->
    <!-- ================================================= -->

    <aside
      class="fixed left-0 top-0 bottom-0 w-72
      bg-gradient-to-b from-[#061A12] via-[#0B2A1D] to-[#164A31]
      text-white shadow-2xl z-50 flex flex-col
      overflow-hidden"
    >

      <!-- LOGO -->
      <div class="px-6 py-7 border-b border-white/10">

        <div class="flex items-center gap-3">

          <div
            class="w-12 h-12 rounded-2xl
            bg-white/10
            flex items-center justify-center
            text-2xl font-bold"
          >
            P
          </div>

          <div>
            <h1 class="font-bold text-lg">
              PARKIR PLAZA
            </h1>

            <p class="text-xs text-green-300">
              ANDALAS • Petugas Panel
            </p>
          </div>

        </div>

      </div>


      <!-- USER PETUGAS -->
      <div
        class="mx-4 mt-5 p-4
        rounded-2xl bg-white/10"
      >

        <div class="flex items-center gap-3">

          <div
            class="w-11 h-11 rounded-full
            bg-green-500
            flex items-center justify-center
            text-xl"
          >
            👤
          </div>

          <div>

            <p class="font-semibold">
              Petugas
            </p>

            <p class="text-xs text-green-200">
              petugas@parkir.com
            </p>

          </div>

        </div>

      </div>


      <!-- ================================================= -->
      <!-- MENU -->
      <!-- ================================================= -->

      <nav
        class="flex-1
        px-4
        mt-6
        space-y-2
        overflow-y-auto"
      >

        <p
          class="px-3 mb-4
          text-xs font-semibold
          text-green-300"
        >
          MENU UTAMA
        </p>


        <!-- SCAN KELUAR -->

        <NuxtLink
          to="/petugas/scan-keluar"
          class="flex items-center gap-3
          px-4 py-3.5
          rounded-xl
          hover:bg-white/10
          transition"
        >

          <span class="text-lg">
            🔴
          </span>

          <span>
            Scan Keluar
          </span>

        </NuxtLink>


        <!-- TRANSAKSI -->

        <NuxtLink
          to="/petugas/transaksi"
          class="flex items-center gap-3
          px-4 py-3.5
          rounded-xl
          hover:bg-white/10
          transition"
        >

          <span class="text-lg">
            💳
          </span>

          <span>
            Kelola Transaksi
          </span>

        </NuxtLink>


        <!-- MEMBER -->

        <NuxtLink
          to="/petugas/member/select"
          class="flex items-center gap-3
          px-4 py-3.5
          rounded-xl
          hover:bg-white/10
          transition"
        >

          <span class="text-lg">
            👥
          </span>

          <span>
            Member
          </span>

        </NuxtLink>


        <!-- TIKET -->

        <NuxtLink
          to="/petugas/tiket"
          class="flex items-center gap-3
          px-4 py-3.5
          rounded-xl
          hover:bg-white/10
          transition"
        >

          <span class="text-lg">
            🎫
          </span>

          <span>
            Tiket
          </span>

        </NuxtLink>


        <!-- LAPORAN -->

        <NuxtLink
          to="/petugas/laporan"
          class="flex items-center gap-3
          px-4 py-3.5
          rounded-xl
          hover:bg-white/10
          transition"
        >

          <span class="text-lg">
            📋
          </span>

          <span>
            Laporan
          </span>

        </NuxtLink>

      </nav>


      <!-- ================================================= -->
      <!-- LOGOUT -->
      <!-- ================================================= -->

      <div
        class="mt-auto
        p-4
        border-t
        border-white/10
        bg-[#061A12]"
      >

        <button
          type="button"
          @click="logout"
          class="w-full
          px-4 py-3
          rounded-xl
          bg-red-500/10
          hover:bg-red-500/20
          text-red-200
          hover:text-white
          text-left
          font-semibold
          transition"
        >

          🚪 Logout

        </button>

      </div>

    </aside>


    <!-- ================================================= -->
    <!-- MAIN -->
    <!-- ================================================= -->

    <main
      class="ml-72 min-h-screen
      px-8 py-8"
    >

      <div class="max-w-[1500px] mx-auto">


        <!-- ================================================= -->
        <!-- HEADER -->
        <!-- ================================================= -->

        <div
          class="flex flex-col
          lg:flex-row
          lg:items-center
          lg:justify-between
          gap-5 mb-8"
        >

          <div>

            <p class="text-sm text-gray-400">
              PARKIR PLAZA ANDALAS / Petugas
            </p>

            <h1
              class="text-4xl
              font-extrabold
              text-[#0B2A1D]
              mt-2"
            >
              Dashboard Petugas 👋
            </h1>

            <p class="text-gray-500 mt-2">
              Pantau aktivitas parkir dan kelola sistem dari sini.
            </p>

          </div>


          <!-- STATUS ONLINE -->

          <div
            class="flex items-center gap-3
            bg-white
            px-5 py-3
            rounded-2xl
            border border-green-100
            shadow-sm"
          >

            <span
              class="w-3 h-3
              rounded-full
              bg-green-500
              animate-pulse"
            ></span>

            <div>

              <p
                class="text-sm
                font-bold
                text-gray-700"
              >
                Sistem Online
              </p>

              <p class="text-xs text-gray-400">
                Data diperbarui otomatis
              </p>

            </div>

          </div>

        </div>


        <!-- ================================================= -->
        <!-- WELCOME CARD -->
        <!-- ================================================= -->

        <div
          class="relative
          overflow-hidden
          rounded-[2rem]
          bg-gradient-to-r
          from-[#061A12]
          via-[#0B2A1D]
          to-[#23704A]
          text-white
          p-8 lg:p-10
          mb-8
          shadow-xl"
        >

          <div
            class="absolute
            -right-16
            -top-24
            w-80 h-80
            rounded-full
            bg-white/5"
          ></div>

          <div
            class="absolute
            right-52
            -bottom-32
            w-72 h-72
            rounded-full
            bg-white/5"
          ></div>


          <div
            class="relative z-10
            flex flex-col
            lg:flex-row
            lg:items-center
            lg:justify-between
            gap-8"
          >

            <div>

              <div
                class="inline-flex
                items-center gap-2
                px-3 py-1.5
                rounded-full
                bg-white/10
                text-green-200
                text-xs
                font-bold
                mb-4"
              >

                🟢 OPERASIONAL AKTIF

              </div>


              <h2
                class="text-3xl lg:text-4xl
                font-extrabold"
              >

                Selamat datang kembali, Petugas!

              </h2>


              <p
                class="text-green-100
                mt-3
                max-w-2xl"
              >

                Pantau kendaraan yang sedang parkir,
                proses kendaraan keluar,
                kelola transaksi, member, tiket,
                dan laporan PARKIR PLAZA ANDALAS.

              </p>

            </div>


            <!-- KAPASITAS -->

            <div
              class="min-w-[230px]
              rounded-3xl
              bg-white/10
              border border-white/10
              backdrop-blur
              p-6"
            >

              <p
                class="text-sm
                text-green-200"
              >
                Sedang Parkir
              </p>


              <div
                class="flex
                items-end
                gap-2
                mt-2"
              >

                <span
                  class="text-4xl
                  font-extrabold"
                >

                  {{ kendaraanMasuk }}

                </span>

                <span
                  class="text-green-200
                  mb-1"
                >
                  kendaraan
                </span>

              </div>


              <div
                class="mt-4
                h-2
                bg-white/10
                rounded-full
                overflow-hidden"
              >

                <div
                  class="h-full
                  bg-green-400
                  rounded-full
                  transition-all duration-500"
                  :style="{
                    width: persentaseParkir + '%'
                  }"
                ></div>

              </div>


              <p
                class="text-xs
                text-green-200
                mt-2"
              >

                {{ kendaraanMasuk }} /
                {{ kapasitasParkir }}
                kapasitas

              </p>

            </div>

          </div>

        </div>


        <!-- ================================================= -->
        <!-- STATISTIK -->
        <!-- ================================================= -->

        <div
          class="grid
          grid-cols-1
          sm:grid-cols-2
          xl:grid-cols-4
          gap-5
          mb-8"
        >


          <!-- SEDANG PARKIR -->

          <NuxtLink
            to="/petugas/tiket"
            class="bg-white
            rounded-3xl
            p-6
            border border-gray-100
            shadow-sm
            hover:shadow-xl
            hover:-translate-y-1
            transition-all
            block"
          >

            <div
              class="flex
              justify-between
              items-start"
            >

              <div>

                <p class="text-sm text-gray-400">
                  Sedang Parkir
                </p>

                <h3
                  class="text-4xl
                  font-extrabold
                  text-[#0B2A1D]
                  mt-2"
                >

                  {{ kendaraanMasuk }}

                </h3>

              </div>


              <div
                class="w-14 h-14
                rounded-2xl
                bg-green-100
                flex items-center
                justify-center
                text-2xl"
              >

                🚗

              </div>

            </div>


            <p
              class="text-xs
              font-bold
              text-green-600
              mt-5"
            >

              Lihat tiket aktif →

            </p>

          </NuxtLink>


          <!-- KELUAR -->

          <NuxtLink
            to="/petugas/scan-keluar"
            class="bg-white
            rounded-3xl
            p-6
            border border-gray-100
            shadow-sm
            hover:shadow-xl
            hover:-translate-y-1
            transition-all
            block"
          >

            <div
              class="flex
              justify-between
              items-start"
            >

              <div>

                <p class="text-sm text-gray-400">
                  Kendaraan Keluar
                </p>

                <h3
                  class="text-4xl
                  font-extrabold
                  text-[#0B2A1D]
                  mt-2"
                >

                  {{ kendaraanKeluar }}

                </h3>

              </div>


              <div
                class="w-14 h-14
                rounded-2xl
                bg-red-100
                flex items-center
                justify-center
                text-2xl"
              >

                🔴

              </div>

            </div>


            <p
              class="text-xs
              font-bold
              text-red-600
              mt-5"
            >

              Buka Scan Keluar →

            </p>

          </NuxtLink>


          <!-- MEMBER -->

          <NuxtLink
            to="/petugas/member/select"
            class="bg-white
            rounded-3xl
            p-6
            border border-gray-100
            shadow-sm
            hover:shadow-xl
            hover:-translate-y-1
            transition-all
            block"
          >

            <div
              class="flex
              justify-between
              items-start"
            >

              <div>

                <p class="text-sm text-gray-400">
                  Member Aktif
                </p>

                <h3
                  class="text-4xl
                  font-extrabold
                  text-[#0B2A1D]
                  mt-2"
                >

                  {{ jumlahMember }}

                </h3>

              </div>


              <div
                class="w-14 h-14
                rounded-2xl
                bg-blue-100
                flex items-center
                justify-center
                text-2xl"
              >

                👥

              </div>

            </div>


            <p
              class="text-xs
              font-bold
              text-blue-600
              mt-5"
            >

              Kelola member →

            </p>

          </NuxtLink>


          <!-- PENDAPATAN -->

          <NuxtLink
            to="/petugas/transaksi"
            class="bg-white
            rounded-3xl
            p-6
            border border-gray-100
            shadow-sm
            hover:shadow-xl
            hover:-translate-y-1
            transition-all
            block"
          >

            <div
              class="flex
              justify-between
              items-start"
            >

              <div>

                <p class="text-sm text-gray-400">
                  Pendapatan
                </p>

                <h3
                  class="text-2xl
                  font-extrabold
                  text-[#0B2A1D]
                  mt-3"
                >

                  {{ formatRupiah(pendapatan) }}

                </h3>

              </div>


              <div
                class="w-14 h-14
                rounded-2xl
                bg-yellow-100
                flex items-center
                justify-center
                text-2xl"
              >

                💰

              </div>

            </div>


            <p
              class="text-xs
              font-bold
              text-yellow-600
              mt-5"
            >

              Dari tiket yang tersimpan →

            </p>

          </NuxtLink>

        </div>


        <!-- ================================================= -->
        <!-- AKSES CEPAT -->
        <!-- ================================================= -->

        <div
          class="bg-white
          rounded-3xl
          border border-gray-100
          shadow-sm
          p-7
          mb-6"
        >

          <div class="mb-6">

            <h2
              class="text-xl
              font-extrabold
              text-[#0B2A1D]"
            >

              ⚡ Akses Cepat

            </h2>

            <p
              class="text-sm
              text-gray-400
              mt-1"
            >

              Akses menu operasional petugas

            </p>

          </div>


          <div
            class="grid
            grid-cols-2
            md:grid-cols-3
            lg:grid-cols-5
            gap-4"
          >


            <!-- SCAN KELUAR -->

            <NuxtLink
              to="/petugas/scan-keluar"
              class="group
              rounded-2xl
              bg-red-50
              border border-red-100
              p-5
              hover:bg-red-100
              hover:-translate-y-1
              transition"
            >

              <div
                class="w-12 h-12
                rounded-2xl
                bg-red-100
                flex items-center
                justify-center
                text-2xl
                group-hover:scale-110
                transition"
              >

                🔴

              </div>


              <p
                class="font-extrabold
                text-gray-700
                mt-4"
              >

                Scan Keluar

              </p>


              <p
                class="text-xs
                text-gray-400
                mt-1"
              >

                Proses kendaraan keluar

              </p>

            </NuxtLink>


            <!-- TRANSAKSI -->

            <NuxtLink
              to="/petugas/transaksi"
              class="group
              rounded-2xl
              bg-yellow-50
              border border-yellow-100
              p-5
              hover:bg-yellow-100
              hover:-translate-y-1
              transition"
            >

              <div
                class="w-12 h-12
                rounded-2xl
                bg-yellow-100
                flex items-center
                justify-center
                text-2xl
                group-hover:scale-110
                transition"
              >

                💳

              </div>


              <p
                class="font-extrabold
                text-gray-700
                mt-4"
              >

                Transaksi

              </p>


              <p
                class="text-xs
                text-gray-400
                mt-1"
              >

                Kelola pembayaran

              </p>

            </NuxtLink>


            <!-- MEMBER -->

            <NuxtLink
              to="/petugas/member/select"
              class="group
              rounded-2xl
              bg-blue-50
              border border-blue-100
              p-5
              hover:bg-blue-100
              hover:-translate-y-1
              transition"
            >

              <div
                class="w-12 h-12
                rounded-2xl
                bg-blue-100
                flex items-center
                justify-center
                text-2xl
                group-hover:scale-110
                transition"
              >

                👥

              </div>


              <p
                class="font-extrabold
                text-gray-700
                mt-4"
              >

                Member

              </p>


              <p
                class="text-xs
                text-gray-400
                mt-1"
              >

                Kelola data member

              </p>

            </NuxtLink>


            <!-- TIKET -->

            <NuxtLink
              to="/petugas/tiket"
              class="group
              rounded-2xl
              bg-green-50
              border border-green-100
              p-5
              hover:bg-green-100
              hover:-translate-y-1
              transition"
            >

              <div
                class="w-12 h-12
                rounded-2xl
                bg-green-100
                flex items-center
                justify-center
                text-2xl
                group-hover:scale-110
                transition"
              >

                🎫

              </div>


              <p
                class="font-extrabold
                text-gray-700
                mt-4"
              >

                Tiket

              </p>


              <p
                class="text-xs
                text-gray-400
                mt-1"
              >

                Lihat data tiket

              </p>

            </NuxtLink>


            <!-- LAPORAN -->

            <NuxtLink
              to="/petugas/laporan"
              class="group
              rounded-2xl
              bg-purple-50
              border border-purple-100
              p-5
              hover:bg-purple-100
              hover:-translate-y-1
              transition"
            >

              <div
                class="w-12 h-12
                rounded-2xl
                bg-purple-100
                flex items-center
                justify-center
                text-2xl
                group-hover:scale-110
                transition"
              >

                📋

              </div>


              <p
                class="font-extrabold
                text-gray-700
                mt-4"
              >

                Laporan

              </p>


              <p
                class="text-xs
                text-gray-400
                mt-1"
              >

                Lihat laporan parkir

              </p>

            </NuxtLink>

          </div>

        </div>


        <!-- ================================================= -->
        <!-- GRAFIK + STATUS -->
        <!-- ================================================= -->

        <div
          class="grid
          grid-cols-1
          xl:grid-cols-3
          gap-6"
        >


          <!-- ================================================= -->
          <!-- GRAFIK -->
          <!-- ================================================= -->

          <div
            class="xl:col-span-2
            bg-white
            rounded-3xl
            border border-gray-100
            shadow-sm
            p-7"
          >

            <div
              class="flex
              flex-col
              sm:flex-row
              sm:items-center
              sm:justify-between
              gap-3
              mb-7"
            >

              <div>

                <h2
                  class="text-xl
                  font-extrabold
                  text-[#0B2A1D]"
                >

                  📈 Aktivitas Parkir

                </h2>

                <p
                  class="text-sm
                  text-gray-400
                  mt-1"
                >

                  Kendaraan masuk dan keluar
                  selama 7 hari terakhir

                </p>

              </div>


              <span
                class="px-4 py-2
                rounded-full
                bg-green-100
                text-green-700
                text-xs
                font-bold"
              >

                LIVE

              </span>

            </div>


            <!-- LEGEND -->

            <div
              class="flex
              items-center
              gap-5
              mb-5
              text-xs
              font-semibold"
            >

              <div
                class="flex
                items-center
                gap-2"
              >

                <span
                  class="w-3 h-3
                  rounded-full
                  bg-green-600"
                ></span>

                Masuk

              </div>


              <div
                class="flex
                items-center
                gap-2"
              >

                <span
                  class="w-3 h-3
                  rounded-full
                  bg-red-500"
                ></span>

                Keluar

              </div>

            </div>


            <!-- CHART -->

            <div
              class="h-72
              flex
              items-end
              justify-between
              gap-3
              border-b border-gray-100
              px-2"
            >

              <button
                v-for="item in grafik"
                :key="item.tanggal"
                type="button"
                @click="detailHari(item)"
                class="flex-1
                h-full
                flex
                flex-col
                items-center
                justify-end
                group
                cursor-pointer"
              >

                <div
                  class="flex
                  items-end
                  gap-1
                  h-full
                  w-full
                  justify-center"
                >

                  <!-- MASUK -->

                  <div
                    class="w-[35%]
                    max-w-[28px]
                    bg-gradient-to-t
                    from-[#0B2A1D]
                    to-[#4D9B70]
                    rounded-t-lg
                    group-hover:opacity-70
                    transition-all"
                    :style="{
                      height: grafikHeight(item.masuk)
                    }"
                  ></div>


                  <!-- KELUAR -->

                  <div
                    class="w-[35%]
                    max-w-[28px]
                    bg-gradient-to-t
                    from-red-600
                    to-red-300
                    rounded-t-lg
                    group-hover:opacity-70
                    transition-all"
                    :style="{
                      height: grafikHeight(item.keluar)
                    }"
                  ></div>

                </div>


                <span
                  class="text-xs
                  text-gray-400
                  mt-3
                  font-semibold"
                >

                  {{ item.hari }}

                </span>

              </button>

            </div>


            <!-- DETAIL -->

            <div
              v-if="hariDipilih"
              class="mt-5
              p-4
              rounded-2xl
              bg-green-50
              border border-green-100"
            >

              <div
                class="flex
                items-center
                justify-between"
              >

                <div>

                  <p
                    class="text-sm
                    font-extrabold
                    text-green-800"
                  >

                    {{ hariDipilih.hari }}

                  </p>

                  <p
                    class="text-xs
                    text-green-600
                    mt-1"
                  >

                    Detail aktivitas parkir.

                  </p>

                </div>


                <div
                  class="flex
                  gap-5
                  text-sm"
                >

                  <span
                    class="font-bold
                    text-green-700"
                  >

                    🟢 {{ hariDipilih.masuk }} masuk

                  </span>


                  <span
                    class="font-bold
                    text-red-600"
                  >

                    🔴 {{ hariDipilih.keluar }} keluar

                  </span>

                </div>

              </div>

            </div>

          </div>


          <!-- ================================================= -->
          <!-- STATUS SISTEM -->
          <!-- ================================================= -->

          <div
            class="bg-white
            rounded-3xl
            border border-gray-100
            shadow-sm
            p-7"
          >

            <div
              class="flex
              items-center
              justify-between
              mb-6"
            >

              <div>

                <h2
                  class="text-xl
                  font-extrabold
                  text-[#0B2A1D]"
                >

                  Status Sistem

                </h2>

                <p
                  class="text-sm
                  text-gray-400
                  mt-1"
                >

                  Kondisi layanan parkir

                </p>

              </div>


              <div
                class="w-11 h-11
                rounded-2xl
                bg-green-100
                flex items-center
                justify-center"
              >

                🟢

              </div>

            </div>


            <div class="space-y-3">


              <!-- SISTEM PARKIR -->

              <div
                class="w-full
                flex items-center
                justify-between
                p-4
                rounded-2xl
                bg-green-50"
              >

                <div
                  class="flex
                  items-center
                  gap-3"
                >

                  <span
                    class="w-10 h-10
                    rounded-xl
                    bg-green-100
                    flex items-center
                    justify-center"
                  >

                    🅿️

                  </span>


                  <div>

                    <p
                      class="font-bold
                      text-gray-700"
                    >

                      Sistem Parkir

                    </p>

                    <p
                      class="text-xs
                      text-gray-400"
                    >

                      {{ kendaraanMasuk }}
                      kendaraan di dalam

                    </p>

                  </div>

                </div>


                <span
                  class="text-xs
                  font-bold
                  text-green-600"
                >

                  Online

                </span>

              </div>


              <!-- SISTEM TIKET -->

              <NuxtLink
                to="/petugas/tiket"
                class="w-full
                flex items-center
                justify-between
                p-4
                rounded-2xl
                bg-blue-50
                hover:bg-blue-100
                transition"
              >

                <div
                  class="flex
                  items-center
                  gap-3"
                >

                  <span
                    class="w-10 h-10
                    rounded-xl
                    bg-blue-100
                    flex items-center
                    justify-center"
                  >

                    🎫

                  </span>


                  <div>

                    <p
                      class="font-bold
                      text-gray-700"
                    >

                      Sistem Tiket

                    </p>

                    <p
                      class="text-xs
                      text-gray-400"
                    >

                      {{ totalTiket }}
                      tiket tercatat

                    </p>

                  </div>

                </div>


                <span
                  class="text-xs
                  font-bold
                  text-blue-600"
                >

                  Aktif

                </span>

              </NuxtLink>


              <!-- MEMBER -->

              <NuxtLink
                to="/petugas/member/select"
                class="w-full
                flex items-center
                justify-between
                p-4
                rounded-2xl
                bg-purple-50
                hover:bg-purple-100
                transition"
              >

                <div
                  class="flex
                  items-center
                  gap-3"
                >

                  <span
                    class="w-10 h-10
                    rounded-xl
                    bg-purple-100
                    flex items-center
                    justify-center"
                  >

                    👥

                  </span>


                  <div>

                    <p
                      class="font-bold
                      text-gray-700"
                    >

                      Data Member

                    </p>

                    <p
                      class="text-xs
                      text-gray-400"
                    >

                      {{ jumlahMember }}
                      member aktif

                    </p>

                  </div>

                </div>


                <span
                  class="text-xs
                  font-bold
                  text-purple-600"
                >

                  Aktif

                </span>

              </NuxtLink>


              <!-- TRANSAKSI -->

              <NuxtLink
                to="/petugas/transaksi"
                class="w-full
                flex items-center
                justify-between
                p-4
                rounded-2xl
                bg-yellow-50
                hover:bg-yellow-100
                transition"
              >

                <div
                  class="flex
                  items-center
                  gap-3"
                >

                  <span
                    class="w-10 h-10
                    rounded-xl
                    bg-yellow-100
                    flex items-center
                    justify-center"
                  >

                    💳

                  </span>


                  <div>

                    <p
                      class="font-bold
                      text-gray-700"
                    >

                      Transaksi

                    </p>

                    <p
                      class="text-xs
                      text-gray-400"
                    >

                      {{ transaksiSelesai }}
                      transaksi selesai

                    </p>

                  </div>

                </div>


                <span
                  class="text-xs
                  font-bold
                  text-yellow-600"
                >

                  Aktif

                </span>

              </NuxtLink>

            </div>

          </div>

        </div>


        <!-- ================================================= -->
        <!-- INFO -->
        <!-- ================================================= -->

        <div
          class="mt-6
          grid
          grid-cols-1
          md:grid-cols-3
          gap-5"
        >


          <!-- INFO 1 -->

          <div
            class="bg-white
            rounded-3xl
            border border-gray-100
            shadow-sm
            p-6"
          >

            <div
              class="flex
              items-center
              gap-4"
            >

              <div
                class="w-12 h-12
                rounded-2xl
                bg-red-100
                flex items-center
                justify-center
                text-xl"
              >

                🔴

              </div>


              <div>

                <p
                  class="text-xs
                  text-gray-400"
                >

                  Operasional

                </p>

                <p
                  class="font-extrabold
                  text-[#0B2A1D]"
                >

                  Scan Keluar Aktif

                </p>

              </div>

            </div>


            <p
              class="text-xs
              text-gray-500
              mt-4"
            >

              Petugas dapat melakukan scan tiket
              untuk memproses kendaraan keluar.

            </p>

          </div>


          <!-- INFO 2 -->

          <div
            class="bg-white
            rounded-3xl
            border border-gray-100
            shadow-sm
            p-6"
          >

            <div
              class="flex
              items-center
              gap-4"
            >

              <div
                class="w-12 h-12
                rounded-2xl
                bg-green-100
                flex items-center
                justify-center
                text-xl"
              >

                🟢

              </div>


              <div>

                <p
                  class="text-xs
                  text-gray-400"
                >

                  Kapasitas

                </p>

                <p
                  class="font-extrabold
                  text-[#0B2A1D]"
                >

                  {{ kapasitasParkir }} Kendaraan

                </p>

              </div>

            </div>


            <p
              class="text-xs
              text-gray-500
              mt-4"
            >

              Kapasitas maksimum area parkir
              yang digunakan sistem.

            </p>

          </div>


          <!-- INFO 3 -->

          <div
            class="bg-white
            rounded-3xl
            border border-gray-100
            shadow-sm
            p-6"
          >

            <div
              class="flex
              items-center
              gap-4"
            >

              <div
                class="w-12 h-12
                rounded-2xl
                bg-blue-100
                flex items-center
                justify-center
                text-xl"
              >

                ⚡

              </div>


              <div>

                <p
                  class="text-xs
                  text-gray-400"
                >

                  Data Tiket

                </p>

                <p
                  class="font-extrabold
                  text-[#0B2A1D]"
                >

                  {{ totalTiket }} Tiket

                </p>

              </div>

            </div>


            <p
              class="text-xs
              text-gray-500
              mt-4"
            >

              Total tiket yang tersimpan
              di dalam sistem.

            </p>

          </div>

        </div>


        <!-- ================================================= -->
        <!-- FOOTER -->
        <!-- ================================================= -->

        <div
          class="mt-8
          flex
          flex-col
          md:flex-row
          justify-between
          items-center
          gap-3
          text-sm
          text-gray-400"
        >

          <p>
            © 2026 PARKIR PLAZA ANDALAS
          </p>

          <p>
            Dashboard Petugas • Data Real-Time
          </p>

        </div>

      </div>

    </main>

  </div>
</template>


<script setup lang="ts">

import {
  ref,
  computed,
  onMounted,
  onUnmounted
} from 'vue'

import { useRouter } from 'vue-router'


/* ================================================= */
/* ROUTER */
/* ================================================= */

const router = useRouter()

const { $api } = useNuxtApp()


/* ================================================= */
/* DATA */
/* ================================================= */

const tiket = ref<any[]>([])

const members = ref<any[]>([])

const hariDipilih = ref<any>(null)

const kapasitasParkir = 170

let intervalRefresh:
  ReturnType<typeof setInterval> | null = null


/* ================================================= */
/* KENDARAAN MASUK / SEDANG PARKIR */
/* ================================================= */

const kendaraanMasuk = computed(() => {

  return tiket.value.filter(
    item =>
      String(item.status || '').toLowerCase() === 'masuk'
  ).length

})


/* ================================================= */
/* KENDARAAN KELUAR */
/* ================================================= */

const kendaraanKeluar = computed(() => {

  return tiket.value.filter(
    item =>
      String(item.status || '').toLowerCase() === 'keluar'
  ).length

})


/* ================================================= */
/* MEMBER AKTIF */
/* ================================================= */

const jumlahMember = computed(() => {

  return members.value.filter(item => {

    return String(
      item.status || ''
    ).toLowerCase() === 'lunas'

  }).length

})


/* ================================================= */
/* TOTAL TIKET */
/* ================================================= */

const totalTiket = computed(() => {

  return tiket.value.length

})


/* ================================================= */
/* TRANSAKSI SELESAI */
/* ================================================= */

const transaksiSelesai = computed(() => {

  return tiket.value.filter(
    item =>
      String(item.status || '').toLowerCase() === 'keluar'
  ).length

})


/* ================================================= */
/* PENDAPATAN OTOMATIS */
/* ================================================= */

const pendapatan = computed(() => {

  return tiket.value.reduce(
    (total, item) => {

      const tarif = Number(
        item.tarif ??
        item.total_harga ??
        item.jumlah_bayar ??
        item.harga ??
        0
      )

      return total + tarif

    },
    0
  )

})


/* ================================================= */
/* KAPASITAS PARKIR */
/* ================================================= */

const persentaseParkir = computed(() => {

  if (!kapasitasParkir) {
    return 0
  }

  return Math.min(

    100,

    Math.round(

      (
        kendaraanMasuk.value /
        kapasitasParkir
      ) * 100

    )

  )

})


/* ================================================= */
/* FORMAT RUPIAH */
/* ================================================= */

const formatRupiah = (
  angka: number
) => {

  return new Intl.NumberFormat(
    'id-ID',
    {
      style: 'currency',
      currency: 'IDR',
      maximumFractionDigits: 0
    }
  ).format(angka)

}


/* ================================================= */
/* NAMA HARI */
/* ================================================= */

const namaHari = [

  'Min',
  'Sen',
  'Sel',
  'Rab',
  'Kam',
  'Jum',
  'Sab'

]


/* ================================================= */
/* GRAFIK 7 HARI */
/* ================================================= */

const grafik = computed(() => {

  const hasil: any[] = []


  for (
    let i = 6;
    i >= 0;
    i--
  ) {

    const tanggal = new Date()

    tanggal.setHours(
      0,
      0,
      0,
      0
    )

    tanggal.setDate(
      tanggal.getDate() - i
    )


    /* =============================== */
    /* JUMLAH MASUK */
    /* =============================== */

    const masuk =
      tiket.value.filter(item => {

        if (!item.waktu_masuk) {
          return false
        }

        const waktu =
          new Date(item.waktu_masuk)

        return (

          waktu.getFullYear() ===
          tanggal.getFullYear()

          &&

          waktu.getMonth() ===
          tanggal.getMonth()

          &&

          waktu.getDate() ===
          tanggal.getDate()

        )

      }).length


    /* =============================== */
    /* JUMLAH KELUAR */
    /* =============================== */

    const keluar =
      tiket.value.filter(item => {

        if (!item.waktu_keluar) {
          return false
        }

        const waktu =
          new Date(item.waktu_keluar)

        return (

          waktu.getFullYear() ===
          tanggal.getFullYear()

          &&

          waktu.getMonth() ===
          tanggal.getMonth()

          &&

          waktu.getDate() ===
          tanggal.getDate()

        )

      }).length


    hasil.push({

      tanggal:
        tanggal.toISOString(),

      hari:
        i === 0
          ? 'Hari ini'
          : namaHari[
              tanggal.getDay()
            ],

      masuk,

      keluar

    })

  }


  return hasil

})


/* ================================================= */
/* TINGGI GRAFIK */
/* ================================================= */

const grafikHeight = (
  nilai: number
) => {

  const semuaNilai =
    grafik.value.flatMap(
      item => [
        item.masuk,
        item.keluar
      ]
    )


  const maksimum =
    Math.max(
      ...semuaNilai,
      1
    )


  if (nilai === 0) {
    return '4px'
  }


  return Math.max(

    8,

    Math.round(
      (nilai / maksimum) * 85
    )

  ) + '%'

}


/* ================================================= */
/* DETAIL GRAFIK */
/* ================================================= */

const detailHari = (
  item: any
) => {

  hariDipilih.value =
    hariDipilih.value === item
      ? null
      : item

}


/* ================================================= */
/* AMBIL TIKET */
/* ================================================= */

const ambilTiket = async () => {

  try {

    const response =
      await $api.get('/tiket')


    tiket.value =
      response.data?.data || []


    console.log(
      'Data tiket:',
      tiket.value
    )

  } catch (error) {

    console.error(
      'Gagal mengambil data tiket:',
      error
    )

  }

}


/* ================================================= */
/* AMBIL MEMBER */
/* ================================================= */

const ambilMember = async () => {

  try {

    const response =
      await $api.get('/members')


    members.value =
      response.data?.data || []


    console.log(
      'Data member:',
      members.value
    )

  } catch (error) {

    console.error(
      'Gagal mengambil data member:',
      error
    )

  }

}


/* ================================================= */
/* LOAD DATA */
/* ================================================= */

const loadData = async () => {

  await Promise.all([

    ambilTiket(),

    ambilMember()

  ])

}


/* ================================================= */
/* LOGOUT */
/* ================================================= */

const logout = () => {

  localStorage.removeItem('role')

  localStorage.removeItem('email')

  router.push('/')

}


/* ================================================= */
/* MOUNTED */
/* ================================================= */

onMounted(async () => {

  const role =
    localStorage.getItem('role')


  if (role !== 'petugas') {

    router.push('/')

    return

  }


  await loadData()


  intervalRefresh =
    setInterval(
      loadData,
      5000
    )

})


/* ================================================= */
/* UNMOUNTED */
/* ================================================= */

onUnmounted(() => {

  if (intervalRefresh) {

    clearInterval(
      intervalRefresh
    )

  }

})

</script>