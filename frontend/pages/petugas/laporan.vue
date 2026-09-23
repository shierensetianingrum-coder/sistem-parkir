<template>
  <div class="min-h-screen bg-[#F3F7F5] font-sans">

    <!-- HEADER FULL SCREEN -->
    <header class="sticky top-0 z-40 bg-white border-b border-gray-100 shadow-sm">
      <div class="px-8 py-5 flex items-center justify-between">

        <div class="flex items-center gap-4">

          <!-- KEMBALI KE DASHBOARD -->
          <button
            @click="navigateTo('/petugas')"
            class="px-4 py-2.5 rounded-xl bg-[#0B2A1D] hover:bg-[#164A31] text-white font-semibold transition"
          >
            ← Dashboard
          </button>

          <div class="h-8 w-px bg-gray-200"></div>

          <div>
            <h1 class="font-bold text-lg text-[#0B2A1D]">
              Sistem Parkir
            </h1>

            <p class="text-xs text-green-600">
              Petugas Panel
            </p>
          </div>

        </div>

        <div class="flex items-center gap-4">

          <div class="hidden sm:flex items-center gap-2 px-4 py-2 rounded-xl bg-green-50">

            <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>

            <span class="text-sm font-semibold text-green-700">
              Laporan Aktif
            </span>

          </div>

          <button
            @click="logout"
            class="px-4 py-2.5 rounded-xl bg-red-50 hover:bg-red-100 text-red-600 font-semibold transition"
          >
            🚪 Logout
          </button>

        </div>

      </div>
    </header>


    <!-- KONTEN UTAMA -->
    <main class="px-6 md:px-8 py-8">

      <div class="max-w-[1500px] mx-auto">

        <!-- JUDUL -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5 mb-8">

          <div>

            <p class="text-sm text-gray-400">
              Petugas / Laporan
            </p>

            <h1 class="text-3xl font-bold text-[#0B2A1D] mt-2">
              Laporan Parkir 📋
            </h1>

            <p class="text-gray-500 text-sm mt-1">
              Ringkasan transaksi dan aktivitas parkir
            </p>

          </div>

          <button
            @click="exportData"
            class="px-5 py-3 rounded-2xl bg-[#0B2A1D] hover:bg-[#164A31] text-white font-semibold transition shadow-lg flex items-center gap-2"
          >
            📥 Export Excel
          </button>

        </div>


        <!-- FILTER LAPORAN -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 mb-8">

          <div class="flex items-center gap-3 mb-5">

            <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
              🔎
            </div>

            <div>

              <h2 class="font-bold text-[#0B2A1D]">
                Filter Laporan
              </h2>

              <p class="text-xs text-gray-400">
                Pilih periode dan jenis kendaraan
              </p>

            </div>

          </div>


          <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <!-- TANGGAL MULAI -->
            <div>

              <label class="block text-xs font-semibold text-gray-500 mb-2">
                TANGGAL MULAI
              </label>

              <input
                v-model="startDate"
                type="date"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0B2A1D]"
              />

            </div>


            <!-- TANGGAL SELESAI -->
            <div>

              <label class="block text-xs font-semibold text-gray-500 mb-2">
                TANGGAL SELESAI
              </label>

              <input
                v-model="endDate"
                type="date"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0B2A1D]"
              />

            </div>


            <!-- JENIS KENDARAAN -->
            <div>

              <label class="block text-xs font-semibold text-gray-500 mb-2">
                JENIS KENDARAAN
              </label>

              <select
                v-model="selectedVehicle"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-[#0B2A1D] bg-white"
              >

                <option value="all">
                  Semua Kendaraan
                </option>

                <option value="Motor">
                  Motor
                </option>

                <option value="Mobil">
                  Mobil
                </option>

              </select>

            </div>


            <!-- BUTTON FILTER -->
            <div class="flex items-end">

              <button
                @click="filterData"
                class="w-full py-3 rounded-xl bg-green-600 hover:bg-green-700 text-white font-semibold transition"
              >
                Filter Laporan
              </button>

            </div>

          </div>

        </div>


        <!-- STATISTIK -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

          <!-- TOTAL TRANSAKSI -->
          <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">

            <div class="flex items-center justify-between">

              <div>

                <p class="text-sm font-medium text-gray-400">
                  Total Transaksi
                </p>

                <h3 class="text-3xl font-bold text-[#0B2A1D] mt-2">
                  {{ filteredList.length }}
                </h3>

              </div>

              <div class="w-12 h-12 rounded-2xl bg-green-50 flex items-center justify-center text-2xl">
                🚗
              </div>

            </div>

          </div>


          <!-- TOTAL PENDAPATAN -->
          <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">

            <div class="flex items-center justify-between">

              <div>

                <p class="text-sm font-medium text-gray-400">
                  Total Pendapatan
                </p>

                <h3 class="text-2xl font-bold text-green-600 mt-2">
                  Rp {{ totalPendapatan.toLocaleString('id-ID') }}
                </h3>

              </div>

              <div class="w-12 h-12 rounded-2xl bg-green-50 flex items-center justify-center text-2xl">
                💰
              </div>

            </div>

          </div>


          <!-- RATA-RATA -->
          <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">

            <div class="flex items-center justify-between">

              <div>

                <p class="text-sm font-medium text-gray-400">
                  Rata-rata / Hari
                </p>

                <h3 class="text-2xl font-bold text-[#0B2A1D] mt-2">
                  Rp {{ rataRataPendapatan.toLocaleString('id-ID') }}
                </h3>

              </div>

              <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-2xl">
                📊
              </div>

            </div>

          </div>

        </div>


        <!-- TABEL LAPORAN -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">

          <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3 mb-6">

            <div>

              <h2 class="text-lg font-bold text-[#0B2A1D]">
                Detail Laporan Parkir
              </h2>

              <p class="text-sm text-gray-400 mt-1">
                Data aktivitas kendaraan
              </p>

            </div>

            <span class="text-xs font-semibold px-3 py-2 rounded-full bg-green-50 text-green-700">
              {{ filteredList.length }} Data Ditemukan
            </span>

          </div>


          <div class="overflow-x-auto">

            <table class="w-full text-left border-collapse">

              <thead>

                <tr class="border-b border-gray-100 text-xs font-semibold text-gray-400 uppercase">

                  <th class="py-3 px-4">
                    Plat Nomor
                  </th>

                  <th class="py-3 px-4">
                    Jenis
                  </th>

                  <th class="py-3 px-4">
                    Waktu Masuk
                  </th>

                  <th class="py-3 px-4">
                    Waktu Keluar
                  </th>

                  <th class="py-3 px-4">
                    Durasi
                  </th>

                  <th class="py-3 px-4">
                    Total Biaya
                  </th>

                  <th class="py-3 px-4">
                    Status
                  </th>

                </tr>

              </thead>


              <tbody class="divide-y divide-gray-50 text-sm">

                <tr
                  v-for="(item, index) in filteredList"
                  :key="item.id || index"
                  class="hover:bg-gray-50 transition"
                >

                  <!-- PLAT -->
                  <td class="py-4 px-4 font-bold text-[#0B2A1D]">
                    {{ item.plat }}
                  </td>


                  <!-- JENIS -->
                  <td class="py-4 px-4">

                    <span
                      class="px-2.5 py-1 rounded-lg text-xs font-semibold"
                      :class="
                        item.jenis === 'Mobil'
                          ? 'bg-blue-50 text-blue-600'
                          : item.jenis === 'Member'
                            ? 'bg-green-50 text-green-600'
                            : 'bg-orange-50 text-orange-600'
                      "
                    >
                      {{ item.jenis }}
                    </span>

                  </td>


                  <!-- MASUK -->
                  <td class="py-4 px-4 text-gray-500">
                    {{ item.masuk }}
                  </td>


                  <!-- KELUAR -->
                  <td class="py-4 px-4 text-gray-500">
                    {{ item.keluar || '-' }}
                  </td>


                  <!-- DURASI -->
                  <td class="py-4 px-4 text-gray-500">
                    {{ item.durasi || '-' }}
                  </td>


                  <!-- BIAYA -->
                  <td class="py-4 px-4 font-semibold text-[#0B2A1D]">
                    Rp {{ item.biaya.toLocaleString('id-ID') }}
                  </td>


                  <!-- STATUS -->
                  <td class="py-4 px-4">

                    <span
                      class="px-3 py-1 rounded-full text-xs font-semibold"
                      :class="
                        item.status === 'Selesai'
                          ? 'bg-green-100 text-green-700'
                          : 'bg-yellow-100 text-yellow-700'
                      "
                    >
                      {{ item.status }}
                    </span>

                  </td>

                </tr>


                <!-- KOSONG -->
                <tr v-if="filteredList.length === 0">

                  <td
                    colspan="7"
                    class="py-12 text-center text-gray-400"
                  >

                    <div class="text-4xl mb-3">
                      📋
                    </div>

                    Tidak ada data laporan yang sesuai filter.

                  </td>

                </tr>

              </tbody>

            </table>

          </div>

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


// =========================================================
// API
// =========================================================

const API = 'http://127.0.0.1:8000/api'


// =========================================================
// FILTER
// =========================================================

const startDate = ref('')
const endDate = ref('')
const selectedVehicle = ref('all')


// =========================================================
// DATA LAPORAN
// =========================================================

const laporanList = ref<any[]>([])


// =========================================================
// AUTO REFRESH
// =========================================================

let interval: ReturnType<typeof setInterval> | null = null


// =========================================================
// FORMAT WAKTU
// =========================================================

const formatWaktu = (tanggal: any) => {

  if (!tanggal) {
    return '-'
  }

  const date = new Date(tanggal)

  if (isNaN(date.getTime())) {
    return '-'
  }

  return date.toLocaleString('id-ID', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}


// =========================================================
// FORMAT TANGGAL UNTUK FILTER
// =========================================================

const tanggalUntukFilter = (tanggal: any) => {

  if (!tanggal) {
    return ''
  }

  const date = new Date(tanggal)

  if (isNaN(date.getTime())) {
    return ''
  }

  const tahun = date.getFullYear()

  const bulan = String(
    date.getMonth() + 1
  ).padStart(2, '0')

  const hari = String(
    date.getDate()
  ).padStart(2, '0')

  return `${tahun}-${bulan}-${hari}`
}


// =========================================================
// HITUNG DURASI
// =========================================================

const hitungDurasi = (
  waktuMasuk: any,
  waktuKeluar: any
) => {

  if (
    !waktuMasuk ||
    !waktuKeluar
  ) {
    return '-'
  }

  const masuk =
    new Date(waktuMasuk)

  const keluar =
    new Date(waktuKeluar)

  if (
    isNaN(masuk.getTime()) ||
    isNaN(keluar.getTime())
  ) {
    return '-'
  }

  const selisih =
    keluar.getTime() -
    masuk.getTime()

  const totalMenit =
    Math.max(
      0,
      Math.floor(
        selisih / 60000
      )
    )

  const jam =
    Math.floor(
      totalMenit / 60
    )

  const menit =
    totalMenit % 60

  if (jam > 0) {

    return `${jam} Jam ${menit} Menit`

  }

  return `${menit} Menit`
}


// =========================================================
// TENTUKAN TARIF
// =========================================================

const tentukanTarif = (tiket: any) => {

  /*
   * Member = gratis
   */
  if (
    tiket.member_id !== null &&
    tiket.member_id !== undefined
  ) {

    return 0

  }


  /*
   * Kalau database sudah punya tarif,
   * gunakan tarif tersebut.
   */
  const tarifDatabase =
    Number(tiket.tarif || 0)

  if (tarifDatabase > 0) {

    return tarifDatabase

  }


  /*
   * Kalau tarif database 0,
   * tentukan berdasarkan jenis kendaraan.
   */

  const jenis =
    String(
      tiket.jenis_kendaraan || ''
    ).toLowerCase().trim()


  if (jenis === 'motor') {

    return 3000

  }


  if (jenis === 'mobil') {

    return 5000

  }


  /*
   * Member tetap gratis.
   */

  if (jenis === 'member') {

    return 0

  }


  return 0
}


// =========================================================
// AMBIL DATA DARI DATABASE
// =========================================================

const ambilLaporan = async () => {

  try {

    const response =
      await fetch(
        `${API}/tiket`
      )


    if (!response.ok) {

      throw new Error(
        `HTTP Error ${response.status}`
      )

    }


    const hasil =
      await response.json()


    if (!hasil.success) {

      console.error(
        'API tiket gagal:',
        hasil
      )

      return

    }


    laporanList.value =
      (hasil.data || []).map(
        (tiket: any) => {

          // =================================================
          // JENIS KENDARAAN
          // =================================================

          let jenis = 'Member'

          const jenisDatabase =
            String(
              tiket.jenis_kendaraan || ''
            ).toLowerCase().trim()


          if (
            jenisDatabase === 'motor'
          ) {

            jenis = 'Motor'

          }

          else if (
            jenisDatabase === 'mobil'
          ) {

            jenis = 'Mobil'

          }

          else if (
            jenisDatabase === 'member'
          ) {

            jenis = 'Member'

          }

          else if (
            tiket.member_id === null ||
            tiket.member_id === undefined
          ) {

            jenis = 'Motor'

          }


          // =================================================
          // STATUS
          // =================================================

          const status =
            String(
              tiket.status || ''
            ).toLowerCase() === 'keluar'
              ? 'Selesai'
              : 'Parkir'


          // =================================================
          // BIAYA
          // =================================================

          /*
           * Kalau masih parkir:
           * belum dihitung sebagai pendapatan.
           */

          const biaya =
            String(
              tiket.status || ''
            ).toLowerCase() === 'keluar'
              ? tentukanTarif(tiket)
              : 0


          // =================================================
          // DATA
          // =================================================

          return {

            id: tiket.id,

            plat:
              tiket.nomor_polisi ||
              '-',

            jenis:
              jenis,

            masuk:
              formatWaktu(
                tiket.waktu_masuk
              ),

            keluar:
              tiket.waktu_keluar
                ? formatWaktu(
                    tiket.waktu_keluar
                  )
                : '-',

            durasi:
              hitungDurasi(
                tiket.waktu_masuk,
                tiket.waktu_keluar
              ),

            biaya:
              biaya,

            status:
              status,

            tanggalMasuk:
              tanggalUntukFilter(
                tiket.waktu_masuk
              )

          }

        }
      )


  } catch (error) {

    console.error(
      'Gagal mengambil laporan:',
      error
    )

  }

}


// =========================================================
// FILTER DATA
// =========================================================

const filteredList = computed(() => {

  return laporanList.value.filter(
    (item: any) => {

      // =====================================================
      // FILTER JENIS
      // =====================================================

      if (
        selectedVehicle.value !== 'all' &&
        item.jenis !==
          selectedVehicle.value
      ) {

        return false

      }


      // =====================================================
      // FILTER TANGGAL MULAI
      // =====================================================

      if (
        startDate.value &&
        item.tanggalMasuk <
          startDate.value
      ) {

        return false

      }


      // =====================================================
      // FILTER TANGGAL SELESAI
      // =====================================================

      if (
        endDate.value &&
        item.tanggalMasuk >
          endDate.value
      ) {

        return false

      }


      return true

    }
  )

})


// =========================================================
// TOTAL PENDAPATAN
// =========================================================

const totalPendapatan = computed(() => {

  return filteredList.value
    .filter(
      (item: any) =>
        item.status === 'Selesai'
    )
    .reduce(
      (
        total: number,
        item: any
      ) => {

        return total +
          Number(
            item.biaya || 0
          )

      },
      0
    )

})


// =========================================================
// RATA-RATA PENDAPATAN
// =========================================================

const rataRataPendapatan = computed(() => {

  const transaksiSelesai =
    filteredList.value.filter(
      (item: any) =>
        item.status === 'Selesai'
    )


  if (
    transaksiSelesai.length === 0
  ) {

    return 0

  }


  return Math.round(
    totalPendapatan.value /
    transaksiSelesai.length
  )

})


// =========================================================
// BUTTON FILTER
// =========================================================

const filterData = () => {

  console.log(
    'Filter laporan:',
    startDate.value,
    endDate.value,
    selectedVehicle.value
  )

}


// =========================================================
// EXPORT
// =========================================================

const exportData = () => {

  alert(
    'Export data laporan berhasil diproses!'
  )

}


// =========================================================
// LOGOUT
// =========================================================

const logout = () => {

  localStorage.removeItem('role')
  localStorage.removeItem('email')

  navigateTo('/login')

}


// =========================================================
// SAAT HALAMAN DIBUKA
// =========================================================

onMounted(() => {

  ambilLaporan()


  interval =
    setInterval(
      () => {

        ambilLaporan()

      },
      3000
    )

})


// =========================================================
// SAAT KELUAR HALAMAN
// =========================================================

onUnmounted(() => {

  if (interval) {

    clearInterval(interval)

    interval = null

  }

})

</script>