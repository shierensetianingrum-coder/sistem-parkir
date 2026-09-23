<template>

  <div class="min-h-screen bg-[#F3F7F5] font-sans">

    <!-- ===================================================== -->
    <!-- HEADER -->
    <!-- ===================================================== -->

    <header
      class="sticky top-0 z-40 bg-white/95 backdrop-blur
             border-b border-gray-200 shadow-sm"
    >

      <div class="max-w-[1700px] mx-auto px-8 py-5">

        <div class="flex items-center justify-between gap-4">

          <!-- KIRI -->
          <div class="flex items-center gap-4">

            <button
              @click="router.push('/admin')"
              class="flex items-center gap-2 px-4 py-2.5
                     rounded-xl bg-[#0B2A1D] text-white
                     hover:bg-[#164A31] transition font-semibold"
            >
              ← Dashboard
            </button>

            <div class="hidden sm:block h-8 w-px bg-gray-200"></div>

            <div class="flex items-center gap-3">

              <div
                class="w-11 h-11 rounded-xl
                       bg-gradient-to-br from-[#0B2A1D] to-[#2E8B57]
                       flex items-center justify-center
                       text-white text-xl font-black shadow-md"
              >
                P
              </div>

              <div>

                <h1
                  class="font-black text-lg
                         text-[#0B2A1D] tracking-tight"
                >
                  PARKIR PLAZA ANDALAS
                </h1>

                <p class="text-xs text-gray-400">
                  Super Admin Panel • Laporan
                </p>

              </div>

            </div>

          </div>


          <!-- KANAN -->
          <div class="flex items-center gap-4">

            <div class="hidden md:flex items-center gap-2">

              <div
                class="w-9 h-9 rounded-full
                       bg-gradient-to-br from-green-300 to-green-600
                       flex items-center justify-center"
              >
                👤
              </div>

              <div>

                <p class="text-sm font-semibold text-gray-700">
                  Super Admin
                </p>

                <p class="text-xs text-gray-400">
                  admin@parkir.com
                </p>

              </div>

            </div>


            <button
              @click="logout"
              class="px-4 py-2.5 rounded-xl
                     bg-red-50 text-red-600
                     hover:bg-red-100 transition font-semibold"
            >
              🚪 Logout
            </button>

          </div>

        </div>

      </div>

    </header>


    <!-- ===================================================== -->
    <!-- MAIN -->
    <!-- ===================================================== -->

    <main class="px-8 py-8">

      <div class="w-full max-w-[1700px] mx-auto">


        <!-- ================================================= -->
        <!-- HEADER LAPORAN -->
        <!-- ================================================= -->

        <div
          class="flex flex-col md:flex-row
                 md:items-center md:justify-between
                 gap-5 mb-8"
        >

          <div>

            <div
              class="flex items-center gap-2
                     text-sm text-gray-400"
            >

              <button
                @click="router.push('/admin')"
                class="hover:text-green-700 transition"
              >
                Dashboard
              </button>

              <span>/</span>

              <span class="text-green-700 font-medium">
                Laporan
              </span>

            </div>


            <h1
              class="text-3xl font-black
                     text-gray-800 mt-2"
            >
              Laporan Parkir 📄
            </h1>


            <p class="text-gray-500 mt-1">
              Lihat dan pantau laporan aktivitas parkir
              PARKIR PLAZA ANDALAS.
            </p>

          </div>


          <!-- PERIODE -->
          <div
            class="flex items-center gap-3 bg-white
                   px-5 py-3 rounded-2xl shadow-sm
                   border border-gray-100"
          >

            <div
              class="w-11 h-11 rounded-xl bg-green-100
                     flex items-center justify-center text-xl"
            >
              📅
            </div>

            <div>

              <p class="text-xs text-gray-400">
                Periode laporan
              </p>

              <p class="text-sm font-bold text-gray-700">
                {{ periode }}
              </p>

            </div>

          </div>

        </div>


        <!-- ================================================= -->
        <!-- FILTER -->
        <!-- ================================================= -->

        <div
          class="bg-white rounded-2xl
                 border border-gray-100
                 shadow-sm p-6 mb-6"
        >

          <div
            class="flex flex-col lg:flex-row
                   lg:items-end gap-5"
          >

            <!-- PERIODE -->
            <div class="flex-1">

              <label
                class="block text-sm font-semibold
                       text-gray-700 mb-2"
              >
                Periode
              </label>

              <select
                v-model="periode"
                class="w-full px-4 py-3 rounded-xl
                       border border-gray-200
                       outline-none
                       focus:ring-2
                       focus:ring-green-500"
              >

                <option value="Hari Ini">
                  Hari Ini
                </option>

                <option value="Minggu Ini">
                  Minggu Ini
                </option>

                <option value="Bulan Ini">
                  Bulan Ini
                </option>

              </select>

            </div>


            <!-- TANGGAL MULAI -->
            <div class="flex-1">

              <label
                class="block text-sm font-semibold
                       text-gray-700 mb-2"
              >
                Tanggal Mulai
              </label>

              <input
                v-model="tanggalMulai"
                type="date"
                class="w-full px-4 py-3 rounded-xl
                       border border-gray-200
                       outline-none
                       focus:ring-2
                       focus:ring-green-500"
              />

            </div>


            <!-- TANGGAL AKHIR -->
            <div class="flex-1">

              <label
                class="block text-sm font-semibold
                       text-gray-700 mb-2"
              >
                Tanggal Akhir
              </label>

              <input
                v-model="tanggalAkhir"
                type="date"
                class="w-full px-4 py-3 rounded-xl
                       border border-gray-200
                       outline-none
                       focus:ring-2
                       focus:ring-green-500"
              />

            </div>


            <!-- BUTTON -->
            <button
              @click="buatLaporan"
              class="px-6 py-3 rounded-xl
                     bg-[#0B2A1D] text-white
                     font-semibold
                     hover:bg-[#164A31]
                     transition"
            >
              🔍 Tampilkan
            </button>

          </div>

        </div>


        <!-- ================================================= -->
        <!-- LOADING -->
        <!-- ================================================= -->

        <div
          v-if="loading"
          class="bg-white rounded-2xl
                 border border-gray-100
                 shadow-sm p-8 mb-6 text-center"
        >

          <div class="text-3xl mb-2">
            ⏳
          </div>

          <p class="text-gray-500">
            Mengambil data laporan...
          </p>

        </div>


        <!-- ================================================= -->
        <!-- ERROR -->
        <!-- ================================================= -->

        <div
          v-if="errorMessage"
          class="bg-red-50 border
                 border-red-200 text-red-700
                 rounded-2xl p-5 mb-6"
        >

          <p class="font-semibold">
            ⚠️ Terjadi kesalahan
          </p>

          <p class="text-sm mt-1">
            {{ errorMessage }}
          </p>

        </div>


        <!-- ================================================= -->
        <!-- STATISTIK -->
        <!-- ================================================= -->

        <div
          class="grid grid-cols-1 md:grid-cols-2
                 xl:grid-cols-4 gap-6 mb-6"
        >

          <!-- TOTAL TRANSAKSI -->
          <div
            class="bg-white rounded-2xl
                   border border-gray-100
                   shadow-sm p-6
                   hover:shadow-md transition"
          >

            <div class="flex justify-between">

              <div>

                <p class="text-sm text-gray-500">
                  Total Transaksi
                </p>

                <h2
                  class="text-3xl font-black
                         text-gray-800 mt-2"
                >
                  {{ totalTransaksi }}
                </h2>

              </div>

              <div
                class="w-12 h-12 rounded-2xl
                       bg-green-100
                       flex items-center
                       justify-center text-2xl"
              >
                💳
              </div>

            </div>

            <p
              class="text-xs text-green-600
                     mt-4 font-semibold"
            >
              Data tiket pada periode
            </p>

          </div>


          <!-- KENDARAAN -->
          <div
            class="bg-white rounded-2xl
                   border border-gray-100
                   shadow-sm p-6
                   hover:shadow-md transition"
          >

            <div class="flex justify-between">

              <div>

                <p class="text-sm text-gray-500">
                  Kendaraan
                </p>

                <h2
                  class="text-3xl font-black
                         text-gray-800 mt-2"
                >
                  {{ totalKendaraan }}
                </h2>

              </div>

              <div
                class="w-12 h-12 rounded-2xl
                       bg-blue-100
                       flex items-center
                       justify-center text-2xl"
              >
                🚗
              </div>

            </div>

            <p
              class="text-xs text-blue-600
                     mt-4 font-semibold"
            >
              Kendaraan masuk & keluar
            </p>

          </div>


          <!-- PENDAPATAN -->
          <div
            class="bg-white rounded-2xl
                   border border-gray-100
                   shadow-sm p-6
                   hover:shadow-md transition"
          >

            <div class="flex justify-between">

              <div>

                <p class="text-sm text-gray-500">
                  Total Pendapatan
                </p>

                <h2
                  class="text-2xl font-black
                         text-gray-800 mt-2"
                >
                  {{ formatRupiah(totalPendapatan) }}
                </h2>

              </div>

              <div
                class="w-12 h-12 rounded-2xl
                       bg-emerald-100
                       flex items-center
                       justify-center text-2xl"
              >
                💰
              </div>

            </div>

            <p
              class="text-xs text-green-600
                     mt-4 font-semibold"
            >
              Dari kendaraan yang sudah keluar
            </p>

          </div>


          <!-- MEMBER -->
          <div
            class="bg-white rounded-2xl
                   border border-gray-100
                   shadow-sm p-6
                   hover:shadow-md transition"
          >

            <div class="flex justify-between">

              <div>

                <p class="text-sm text-gray-500">
                  Member
                </p>

                <h2
                  class="text-3xl font-black
                         text-gray-800 mt-2"
                >
                  {{ totalMember }}
                </h2>

              </div>

              <div
                class="w-12 h-12 rounded-2xl
                       bg-purple-100
                       flex items-center
                       justify-center text-2xl"
              >
                👥
              </div>

            </div>

            <p
              class="text-xs text-purple-600
                     mt-4 font-semibold"
            >
              Transaksi member
            </p>

          </div>

        </div>


        <!-- ================================================= -->
        <!-- GRAFIK -->
        <!-- ================================================= -->

        <div
          class="bg-white rounded-2xl
                 border border-gray-100
                 shadow-sm p-7 mb-6"
        >

          <div
            class="flex justify-between
                   items-center mb-7"
          >

            <div>

              <h2
                class="text-xl font-black
                       text-gray-800"
              >
                Statistik Pendapatan
              </h2>

              <p class="text-sm text-gray-400 mt-1">
                Pendapatan parkir PARKIR PLAZA ANDALAS
                berdasarkan hari
              </p>

            </div>

            <span
              class="px-4 py-2 rounded-xl
                     bg-green-50 text-green-700
                     text-sm font-semibold"
            >
              {{ periode }}
            </span>

          </div>


          <!-- CHART -->

          <div
            class="h-72 flex items-end gap-5"
          >

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
                {{ formatRupiahSingkat(item.nilai) }}
              </p>


              <div
                class="w-full max-w-[65px]
                       bg-gradient-to-t
                       from-[#0B2A1D]
                       via-[#26704C]
                       to-[#73B894]
                       rounded-t-xl
                       hover:opacity-80
                       transition"
                :style="{
                  height: item.persen + '%'
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


        <!-- ================================================= -->
        <!-- TABEL -->
        <!-- ================================================= -->

        <div
          class="bg-white rounded-2xl
                 border border-gray-100
                 shadow-sm overflow-hidden mb-8"
        >

          <!-- HEADER -->
          <div
            class="p-6 border-b border-gray-100
                   flex flex-col md:flex-row
                   md:items-center
                   md:justify-between gap-4"
          >

            <div>

              <h2
                class="text-xl font-black
                       text-gray-800"
              >
                Detail Laporan
              </h2>

              <p class="text-sm text-gray-400 mt-1">
                Data transaksi parkir PARKIR PLAZA ANDALAS
              </p>

            </div>


            <button
              @click="cetakLaporan"
              class="px-5 py-3 rounded-xl
                     bg-[#0B2A1D]
                     text-white font-semibold
                     hover:bg-[#164A31]
                     transition"
            >
              🖨️ Cetak Laporan
            </button>

          </div>


          <!-- TABLE -->

          <div class="overflow-x-auto">

            <table class="w-full">

              <thead class="bg-[#F7FAF8]">

                <tr>

                  <th
                    class="text-left px-6 py-4
                           text-xs uppercase
                           tracking-wider
                           text-gray-500"
                  >
                    No
                  </th>

                  <th
                    class="text-left px-6 py-4
                           text-xs uppercase
                           tracking-wider
                           text-gray-500"
                  >
                    Kode Tiket
                  </th>

                  <th
                    class="text-left px-6 py-4
                           text-xs uppercase
                           tracking-wider
                           text-gray-500"
                  >
                    Tanggal
                  </th>

                  <th
                    class="text-left px-6 py-4
                           text-xs uppercase
                           tracking-wider
                           text-gray-500"
                  >
                    Plat Nomor
                  </th>

                  <th
                    class="text-left px-6 py-4
                           text-xs uppercase
                           tracking-wider
                           text-gray-500"
                  >
                    Jenis
                  </th>

                  <th
                    class="text-left px-6 py-4
                           text-xs uppercase
                           tracking-wider
                           text-gray-500"
                  >
                    Jam Masuk
                  </th>

                  <th
                    class="text-left px-6 py-4
                           text-xs uppercase
                           tracking-wider
                           text-gray-500"
                  >
                    Jam Keluar
                  </th>

                  <th
                    class="text-left px-6 py-4
                           text-xs uppercase
                           tracking-wider
                           text-gray-500"
                  >
                    Tarif
                  </th>

                  <th
                    class="text-left px-6 py-4
                           text-xs uppercase
                           tracking-wider
                           text-gray-500"
                  >
                    Status
                  </th>

                </tr>

              </thead>


              <tbody
                class="divide-y divide-gray-100"
              >

                <!-- DATA -->
                <tr
                  v-for="(item, index) in laporan"
                  :key="item.id"
                  class="hover:bg-green-50/40 transition"
                >

                  <td
                    class="px-6 py-5
                           text-sm text-gray-500"
                  >
                    {{ index + 1 }}
                  </td>


                  <td class="px-6 py-5">

                    <span
                      class="font-bold
                             text-[#0B2A1D]"
                    >
                      {{ item.kode_tiket }}
                    </span>

                  </td>


                  <td
                    class="px-6 py-5
                           text-sm text-gray-700"
                  >
                    {{ item.tanggal }}
                  </td>


                  <td class="px-6 py-5">

                    <span
                      class="font-bold
                             text-gray-800"
                    >
                      {{ item.plat }}
                    </span>

                  </td>


                  <td
                    class="px-6 py-5
                           text-sm text-gray-600"
                  >
                    {{ item.jenis }}
                  </td>


                  <td
                    class="px-6 py-5
                           text-sm text-gray-600"
                  >
                    {{ item.masuk }}
                  </td>


                  <td
                    class="px-6 py-5
                           text-sm text-gray-600"
                  >
                    {{ item.keluar }}
                  </td>


                  <td class="px-6 py-5">

                    <span
                      class="font-semibold
                             text-gray-800"
                    >
                      {{ item.tarif }}
                    </span>

                  </td>


                  <td class="px-6 py-5">

                    <span
                      v-if="
                        item.status_db === 'keluar'
                      "
                      class="px-3 py-1.5
                             rounded-full
                             text-xs font-semibold
                             bg-green-100
                             text-green-700"
                    >
                      Selesai
                    </span>


                    <span
                      v-else
                      class="px-3 py-1.5
                             rounded-full
                             text-xs font-semibold
                             bg-yellow-100
                             text-yellow-700"
                    >
                      Masih Parkir
                    </span>

                  </td>

                </tr>


                <!-- KOSONG -->
                <tr
                  v-if="
                    !loading &&
                    laporan.length === 0
                  "
                >

                  <td
                    colspan="9"
                    class="px-6 py-12
                           text-center"
                  >

                    <div
                      class="text-4xl mb-3"
                    >
                      📭
                    </div>

                    <p
                      class="font-semibold
                             text-gray-600"
                    >
                      Belum ada data laporan
                    </p>

                    <p
                      class="text-sm
                             text-gray-400 mt-1"
                    >
                      Tidak ada transaksi pada
                      periode yang dipilih.
                    </p>

                  </td>

                </tr>

              </tbody>

            </table>

          </div>

        </div>


        <!-- ================================================= -->
        <!-- FOOTER -->
        <!-- ================================================= -->

        <div class="text-center pb-8">

          <p class="text-xs text-gray-400">
            © 2026 PARKIR PLAZA ANDALAS • Super Admin
          </p>

        </div>

      </div>

    </main>

  </div>

</template>


<script setup lang="ts">

// =====================================================
// ROUTER
// =====================================================

const router = useRouter()


// =====================================================
// API
// =====================================================

const config = useRuntimeConfig()

const apiBase =
  config.public.apiBase ||
  'http://127.0.0.1:8000/api'


// =====================================================
// FILTER
// =====================================================

const periode = ref('Bulan Ini')

const tanggalMulai = ref('')

const tanggalAkhir = ref('')


// =====================================================
// DATA
// =====================================================

const semuaTiket =
  ref<any[]>([])

const laporan =
  ref<any[]>([])

const loading =
  ref(false)

const errorMessage =
  ref('')


// =====================================================
// TOTAL TRANSAKSI
// =====================================================

const totalTransaksi =
  computed(() => {

    return laporan.value.length

  })


// =====================================================
// TOTAL KENDARAAN
// =====================================================

const totalKendaraan =
  computed(() => {

    return laporan.value.length

  })


// =====================================================
// TOTAL PENDAPATAN
// =====================================================

const totalPendapatan =
  computed(() => {

    return laporan.value
      .filter(
        item =>
          item.status_db === 'keluar'
      )
      .reduce(
        (
          total,
          item
        ) => {

          return total +
            Number(
              item.tarif_db || 0
            )

        },
        0
      )

  })


// =====================================================
// TOTAL MEMBER
// =====================================================

const totalMember =
  computed(() => {

    return laporan.value.filter(
      item => !!item.member_id
    ).length

  })


// =====================================================
// FORMAT RUPIAH
// =====================================================

const formatRupiah =
  (angka: number) => {

    return new Intl.NumberFormat(
      'id-ID',
      {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0
      }
    ).format(angka)

  }


// =====================================================
// FORMAT RUPIAH SINGKAT
// =====================================================

const formatRupiahSingkat =
  (angka: number) => {

    if (angka >= 1000000) {

      return (
        'Rp ' +
        (
          angka / 1000000
        )
          .toFixed(1)
          .replace('.0', '') +
        ' Jt'
      )

    }


    if (angka >= 1000) {

      return (
        'Rp ' +
        Math.round(
          angka / 1000
        ) +
        ' Rb'
      )

    }


    return formatRupiah(
      angka
    )

  }


// =====================================================
// FORMAT TANGGAL
// =====================================================

const formatTanggal =
  (value: string | null) => {

    if (!value) {
      return '-'
    }


    const tanggal =
      new Date(value)


    if (
      isNaN(
        tanggal.getTime()
      )
    ) {

      return '-'

    }


    return tanggal.toLocaleDateString(
      'id-ID',
      {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
      }
    )

  }


// =====================================================
// FORMAT JAM
// =====================================================

const formatJam =
  (value: string | null) => {

    if (!value) {
      return '-'
    }


    const tanggal =
      new Date(value)


    if (
      isNaN(
        tanggal.getTime()
      )
    ) {

      return '-'

    }


    return tanggal.toLocaleTimeString(
      'id-ID',
      {
        hour: '2-digit',
        minute: '2-digit'
      }
    )

  }


// =====================================================
// AMBIL YYYY-MM-DD
// =====================================================

const tanggalKey =
  (value: string | null) => {

    if (!value) {
      return ''
    }


    return value.substring(
      0,
      10
    )

  }


// =====================================================
// TANGGAL HARI INI
// =====================================================

const tanggalHariIni =
  () => {

    const sekarang =
      new Date()


    const tahun =
      sekarang.getFullYear()


    const bulan =
      String(
        sekarang.getMonth() + 1
      ).padStart(2, '0')


    const hari =
      String(
        sekarang.getDate()
      ).padStart(2, '0')


    return (
      `${tahun}-${bulan}-${hari}`
    )

  }


// =====================================================
// FORMAT DATE INPUT
// =====================================================

const formatDateInput =
  (tanggal: Date) => {

    const tahun =
      tanggal.getFullYear()


    const bulan =
      String(
        tanggal.getMonth() + 1
      ).padStart(2, '0')


    const hari =
      String(
        tanggal.getDate()
      ).padStart(2, '0')


    return (
      `${tahun}-${bulan}-${hari}`
    )

  }


// =====================================================
// MAPPING TIKET
// =====================================================

const mappingTiket =
  (item: any) => {

    const member =
      item.member || null


    let jenis =
      'Member'


    if (!item.member_id) {

      const jenisDatabase =
        String(
          item.jenis_kendaraan || ''
        ).toLowerCase()


      if (
        jenisDatabase ===
        'motor'
      ) {

        jenis = 'Motor'

      }
      else if (
        jenisDatabase ===
        'mobil'
      ) {

        jenis = 'Mobil'

      }
      else {

        jenis = '-'

      }

    }


    return {

      id:
        item.id,

      kode_tiket:
        item.kode_tiket || '-',

      member_id:
        item.member_id || null,

      nama_member:
        member?.nama_member || '',

      plat:
        item.nomor_polisi || '-',

      jenis:
        jenis,

      masuk:
        formatJam(
          item.waktu_masuk
        ),

      keluar:
        formatJam(
          item.waktu_keluar
        ),

      tanggal:
        formatTanggal(
          item.waktu_masuk
        ),

      tarif:
        formatRupiah(
          Number(
            item.tarif || 0
          )
        ),

      tarif_db:
        Number(
          item.tarif || 0
        ),

      status_db:
        item.status,

      waktu_masuk:
        item.waktu_masuk,

      waktu_keluar:
        item.waktu_keluar

    }

  }


// =====================================================
// AMBIL DATA TIKET
// =====================================================

const ambilDataTiket =
  async () => {

    loading.value = true

    errorMessage.value = ''


    try {

      const response: any =
        await $fetch(
          `${apiBase}/tiket`
        )


      if (
        response &&
        response.success
      ) {

        semuaTiket.value =
          response.data || []


        buatLaporan()

      }
      else {

        errorMessage.value =
          'Data tiket tidak berhasil diambil.'

      }

    }
    catch (error: any) {

      console.error(
        'Gagal mengambil tiket:',
        error
      )


      errorMessage.value =
        'Gagal terhubung ke server Laravel. Pastikan backend Laravel sedang berjalan.'

    }
    finally {

      loading.value = false

    }

  }


// =====================================================
// BUAT LAPORAN
// =====================================================

const buatLaporan =
  () => {

    let mulai =
      tanggalMulai.value

    let akhir =
      tanggalAkhir.value


    // -------------------------------------------------
    // HARI INI
    // -------------------------------------------------

    if (
      periode.value ===
      'Hari Ini'
    ) {

      const hariIni =
        tanggalHariIni()


      mulai =
        hariIni

      akhir =
        hariIni

    }


    // -------------------------------------------------
    // MINGGU INI
    // -------------------------------------------------

    else if (
      periode.value ===
      'Minggu Ini'
    ) {

      const sekarang =
        new Date()


      const hari =
        sekarang.getDay()


      const selisih =
        hari === 0
          ? 6
          : hari - 1


      const senin =
        new Date(
          sekarang
        )


      senin.setDate(
        sekarang.getDate() -
        selisih
      )


      const minggu =
        new Date(
          senin
        )


      minggu.setDate(
        senin.getDate() + 6
      )


      mulai =
        formatDateInput(
          senin
        )


      akhir =
        formatDateInput(
          minggu
        )

    }


    // -------------------------------------------------
    // BULAN INI
    // -------------------------------------------------

    else if (
      periode.value ===
      'Bulan Ini'
    ) {

      const sekarang =
        new Date()


      const tahun =
        sekarang.getFullYear()


      const bulan =
        sekarang.getMonth()


      const awal =
        new Date(
          tahun,
          bulan,
          1
        )


      const akhirBulan =
        new Date(
          tahun,
          bulan + 1,
          0
        )


      mulai =
        formatDateInput(
          awal
        )


      akhir =
        formatDateInput(
          akhirBulan
        )

    }


    // -------------------------------------------------
    // SIMPAN FILTER
    // -------------------------------------------------

    tanggalMulai.value =
      mulai


    tanggalAkhir.value =
      akhir


    // -------------------------------------------------
    // FILTER TIKET
    // -------------------------------------------------

    const hasil =
      semuaTiket.value
        .filter(
          (item: any) => {

            const tanggal =
              tanggalKey(
                item.waktu_masuk
              )


            if (!tanggal) {
              return false
            }


            if (
              mulai &&
              tanggal < mulai
            ) {

              return false

            }


            if (
              akhir &&
              tanggal > akhir
            ) {

              return false

            }


            return true

          }
        )
        .map(
          mappingTiket
        )


    laporan.value =
      hasil

  }


// =====================================================
// GRAFIK
// =====================================================

const grafik =
  computed(() => {

    const hariNama: string[] = [

      'Sen',

      'Sel',

      'Rab',

      'Kam',

      'Jum',

      'Sab',

      'Min'

    ]


    // -----------------------------------------------
    // BUAT DATA 7 HARI
    // -----------------------------------------------

    const dataHari: {
      hari: string
      nilai: number
    }[] =
      hariNama.map(
        (nama: string) => {

          return {

            hari:
              nama,

            nilai:
              0

          }

        }
      )


    // -----------------------------------------------
    // HITUNG PENDAPATAN
    // -----------------------------------------------

    laporan.value.forEach(
      (item: any) => {

        // Hanya yang sudah keluar
        if (
          item.status_db !==
          'keluar'
        ) {

          return

        }


        // Tidak ada waktu keluar
        if (
          !item.waktu_keluar
        ) {

          return

        }


        const tanggal =
          new Date(
            item.waktu_keluar
          )


        // Tanggal tidak valid
        if (
          isNaN(
            tanggal.getTime()
          )
        ) {

          return

        }


        // Senin = 0
        // Selasa = 1
        // ...
        // Minggu = 6

        let index =
          tanggal.getDay() - 1


        // Minggu
        if (
          index < 0
        ) {

          index = 6

        }


        // -------------------------------------------
        // FIX TYPESCRIPT
        // -------------------------------------------

        const data =
          dataHari[index]


        if (data) {

          data.nilai =
            data.nilai +
            Number(
              item.tarif_db || 0
            )

        }

      }
    )


    // -----------------------------------------------
    // NILAI TERBESAR
    // -----------------------------------------------

    const nilaiMaksimal =
      Math.max(
        ...dataHari.map(
          item =>
            item.nilai
        ),
        1
      )


    // -----------------------------------------------
    // BUAT PERSENTASE
    // -----------------------------------------------

    return dataHari.map(
      (item) => {

        let persen =
          3


        if (
          item.nilai > 0
        ) {

          persen =
            Math.max(
              8,
              Math.round(
                (
                  item.nilai /
                  nilaiMaksimal
                ) * 100
              )
            )

        }


        return {

          hari:
            item.hari,

          nilai:
            item.nilai,

          persen:
            persen

        }

      }
    )

  })


// =====================================================
// CETAK
// =====================================================

const cetakLaporan =
  () => {

    window.print()

  }


// =====================================================
// LOGOUT
// =====================================================

const logout =
  () => {

    localStorage.removeItem(
      'role'
    )

    localStorage.removeItem(
      'email'
    )

    router.push('/')

  }


// =====================================================
// ON MOUNTED
// =====================================================

onMounted(() => {

  const role =
    localStorage.getItem(
      'role'
    )


  if (
    role !== 'admin'
  ) {

    router.push('/')

    return

  }


  ambilDataTiket()

})

</script>


<style>

@media print {

  header {
    display: none !important;
  }

  button,
  select,
  input {
    display: none !important;
  }

  main {
    margin-left: 0 !important;
    padding: 20px !important;
  }

}

</style>