<template>
  <div class="min-h-screen bg-[#F3F7F5] font-sans">

    <!-- ================================================= -->
    <!-- HEADER FULL SCREEN -->
    <!-- ================================================= -->

    <header class="sticky top-0 z-40 bg-white border-b border-gray-100 shadow-sm">

      <div
        class="px-6 md:px-8 py-5
        flex items-center justify-between"
      >

        <!-- KIRI -->
        <div class="flex items-center gap-4">

          <!-- DASHBOARD -->
          <button
            @click="router.push('/petugas')"
            class="px-4 py-2.5 rounded-xl
            bg-[#0B2A1D]
            hover:bg-[#164A31]
            text-white
            font-semibold
            transition"
          >
            ← Dashboard
          </button>

          <div class="h-8 w-px bg-gray-200"></div>

          <!-- LOGO -->
          <div class="flex items-center gap-3">

            <div
              class="w-11 h-11 rounded-xl
              bg-[#0B2A1D]
              flex items-center justify-center
              text-xl"
            >
              🅿️
            </div>

            <div>

              <h1 class="font-bold text-lg text-[#0B2A1D]">
                PARKIR PLAZA ANDALAS
              </h1>

              <p class="text-xs text-green-600">
                Petugas Panel
              </p>

            </div>

          </div>

        </div>

        <!-- KANAN -->
        <div class="flex items-center gap-4">

          <div
            class="hidden sm:flex
            items-center gap-2
            px-4 py-2 rounded-xl
            bg-green-50"
          >

            <span
              class="w-2.5 h-2.5
              rounded-full bg-green-500"
            ></span>

            <span
              class="text-sm
              font-semibold text-green-700"
            >
              Transaksi Aktif
            </span>

          </div>

          <!-- LOGOUT -->
          <button
            @click="logout"
            class="px-4 py-2.5
            rounded-xl
            bg-red-50
            hover:bg-red-100
            text-red-600
            font-semibold
            transition"
          >
            🚪 Logout
          </button>

        </div>

      </div>

    </header>


    <!-- ================================================= -->
    <!-- CONTENT -->
    <!-- ================================================= -->

    <main class="px-6 md:px-8 py-8">

      <div class="max-w-[1500px] mx-auto">

        <!-- ================================================= -->
        <!-- HEADER PAGE -->
        <!-- ================================================= -->

        <div class="mb-8">

          <p class="text-sm text-gray-400 mb-1">
            Petugas / Kelola Transaksi
          </p>

          <h1
            class="text-3xl
            font-bold
            text-[#0B2A1D]"
          >
            Kelola Transaksi 💳
          </h1>

          <p class="text-gray-500 mt-1">
            Kelola transaksi kendaraan member dan non-member.
          </p>

        </div>


        <!-- ================================================= -->
        <!-- SEARCH & FILTER -->
        <!-- ================================================= -->

        <div
          class="bg-white
          rounded-2xl
          shadow-sm
          border border-gray-100
          p-5
          mb-8"
        >

          <div
            class="flex flex-col
            md:flex-row
            gap-4"
          >

            <!-- SEARCH -->
            <div class="relative flex-1">

              <span
                class="absolute
                left-4
                top-1/2
                -translate-y-1/2
                text-gray-400"
              >
                🔎
              </span>

              <input
                v-model="keyword"
                type="text"
                placeholder="Cari nomor polisi, kode tiket, atau nama member..."
                class="w-full
                pl-11 pr-4 py-3
                border border-gray-200
                rounded-xl
                outline-none
                focus:ring-2
                focus:ring-green-500"
              />

            </div>


            <!-- STATUS -->
            <select
              v-model="filterStatus"
              class="px-4 py-3
              border border-gray-200
              rounded-xl
              outline-none
              focus:ring-2
              focus:ring-green-500
              bg-white"
            >

              <option value="semua">
                Semua Status
              </option>

              <option value="aktif">
                Aktif
              </option>

              <option value="selesai">
                Selesai
              </option>

            </select>


            <!-- REFRESH -->
            <button
              @click="ambilTransaksi"
              class="px-5 py-3
              rounded-xl
              bg-[#0B2A1D]
              text-white
              font-semibold
              hover:bg-[#164A31]
              transition"
            >
              🔄 Refresh
            </button>

          </div>

        </div>


        <!-- ================================================= -->
        <!-- RINGKASAN -->
        <!-- ================================================= -->

        <div
          class="grid
          grid-cols-1
          md:grid-cols-3
          gap-6
          mb-8"
        >

          <!-- MEMBER -->
          <div
            class="bg-white
            rounded-2xl
            p-6
            border border-gray-100
            shadow-sm"
          >

            <div
              class="flex
              items-center
              justify-between"
            >

              <div>

                <p class="text-sm text-gray-400">
                  Transaksi Member
                </p>

                <h2
                  class="text-3xl
                  font-bold
                  text-[#0B2A1D]
                  mt-2"
                >
                  {{ memberFilter.length }}
                </h2>

              </div>

              <div
                class="w-12 h-12
                rounded-xl
                bg-green-100
                flex items-center
                justify-center
                text-xl"
              >
                👤
              </div>

            </div>

          </div>


          <!-- NON MEMBER -->
          <div
            class="bg-white
            rounded-2xl
            p-6
            border border-gray-100
            shadow-sm"
          >

            <div
              class="flex
              items-center
              justify-between"
            >

              <div>

                <p class="text-sm text-gray-400">
                  Transaksi Non-Member
                </p>

                <h2
                  class="text-3xl
                  font-bold
                  text-blue-600
                  mt-2"
                >
                  {{ nonMemberFilter.length }}
                </h2>

              </div>

              <div
                class="w-12 h-12
                rounded-xl
                bg-blue-100
                flex items-center
                justify-center
                text-xl"
              >
                🚗
              </div>

            </div>

          </div>


          <!-- TOTAL -->
          <div
            class="bg-white
            rounded-2xl
            p-6
            border border-gray-100
            shadow-sm"
          >

            <div
              class="flex
              items-center
              justify-between"
            >

              <div>

                <p class="text-sm text-gray-400">
                  Total Transaksi
                </p>

                <h2
                  class="text-3xl
                  font-bold
                  text-green-600
                  mt-2"
                >
                  {{
                    memberFilter.length +
                    nonMemberFilter.length
                  }}
                </h2>

              </div>

              <div
                class="w-12 h-12
                rounded-xl
                bg-green-100
                flex items-center
                justify-center
                text-xl"
              >
                💳
              </div>

            </div>

          </div>

        </div>


        <!-- ================================================= -->
        <!-- LOADING -->
        <!-- ================================================= -->

        <div
          v-if="loading"
          class="mb-6
          bg-white
          rounded-2xl
          border border-gray-100
          p-5
          text-center
          text-gray-500"
        >
          ⏳ Memuat transaksi...
        </div>


        <!-- ================================================= -->
        <!-- ERROR -->
        <!-- ================================================= -->

        <div
          v-if="errorMessage"
          class="mb-6
          bg-red-50
          border border-red-200
          text-red-700
          rounded-2xl
          p-4"
        >
          {{ errorMessage }}
        </div>


        <!-- ================================================= -->
        <!-- TRANSAKSI MEMBER -->
        <!-- ================================================= -->

        <div
          class="bg-white
          rounded-2xl
          shadow-sm
          border border-gray-100
          overflow-hidden
          mb-8"
        >

          <!-- HEADER -->
          <div
            class="px-6 py-5
            border-b border-gray-100
            flex items-center
            justify-between"
          >

            <div>

              <div
                class="flex
                items-center
                gap-2"
              >

                <span class="text-2xl">
                  👤
                </span>

                <h2
                  class="text-lg
                  font-bold
                  text-gray-800"
                >
                  Transaksi Member
                </h2>

              </div>

              <p class="text-sm text-gray-500 mt-1">
                Kendaraan yang masuk menggunakan member.
              </p>

            </div>

            <span
              class="px-3 py-1
              rounded-full
              bg-green-100
              text-green-700
              text-sm
              font-semibold"
            >
              {{ memberFilter.length }} Data
            </span>

          </div>


          <!-- TABLE -->
          <div class="overflow-x-auto">

            <table class="w-full">

              <thead class="bg-green-50">

                <tr>

                  <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                    No
                  </th>

                  <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                    Nama Member
                  </th>

                  <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                    Kode Member
                  </th>

                  <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                    Nomor Polisi
                  </th>

                  <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                    Kendaraan
                  </th>

                  <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                    Jam Masuk
                  </th>

                  <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                    Jam Keluar
                  </th>

                  <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                    Status
                  </th>

                </tr>

              </thead>


              <tbody class="divide-y divide-gray-100">

                <tr
                  v-for="(item, index) in memberFilter"
                  :key="'member-' + item.id"
                  class="hover:bg-gray-50 transition"
                >

                  <td class="px-6 py-4 text-sm text-gray-600">
                    {{ index + 1 }}
                  </td>


                  <td class="px-6 py-4">

                    <p class="font-semibold text-gray-800">
                      {{ item.nama_member }}
                    </p>

                    <p class="text-xs text-gray-400">
                      {{ item.nama_perusahaan || '-' }}
                    </p>

                  </td>


                  <td class="px-6 py-4">

                    <span
                      class="px-3 py-1
                      rounded-lg
                      bg-green-100
                      text-green-700
                      font-semibold
                      text-sm"
                    >
                      {{ item.kode_member }}
                    </span>

                  </td>


                  <td class="px-6 py-4">

                    <span
                      class="px-3 py-1
                      rounded-lg
                      bg-gray-100
                      text-gray-700
                      font-semibold"
                    >
                      {{ item.nomor_polisi || '-' }}
                    </span>

                  </td>


                  <td class="px-6 py-4 text-sm text-gray-600">

                    <span v-if="item.jenis_kendaraan === 'member'">
                      👤 Member
                    </span>

                    <span v-else-if="item.jenis_kendaraan">
                      {{ item.jenis_kendaraan }}
                    </span>

                    <span v-else>
                      -
                    </span>

                  </td>


                  <td class="px-6 py-4 text-sm text-gray-600">
                    {{ item.jam_masuk || '-' }}
                  </td>


                  <td class="px-6 py-4 text-sm text-gray-600">
                    {{ item.jam_keluar || '-' }}
                  </td>


                  <td class="px-6 py-4">

                    <span
                      v-if="item.status === 'aktif'"
                      class="inline-flex
                      px-3 py-1
                      rounded-full
                      text-xs
                      font-semibold
                      bg-blue-100
                      text-blue-700"
                    >
                      Aktif
                    </span>

                    <span
                      v-else
                      class="inline-flex
                      px-3 py-1
                      rounded-full
                      text-xs
                      font-semibold
                      bg-green-100
                      text-green-700"
                    >
                      Selesai
                    </span>

                  </td>

                </tr>


                <!-- KOSONG -->
                <tr v-if="memberFilter.length === 0">

                  <td
                    colspan="8"
                    class="px-6 py-14 text-center"
                  >

                    <div class="text-5xl mb-3">
                      👤
                    </div>

                    <p class="font-semibold text-gray-700">
                      Tidak ada transaksi member
                    </p>

                    <p class="text-sm text-gray-400 mt-1">
                      Transaksi member akan muncul di sini.
                    </p>

                  </td>

                </tr>

              </tbody>

            </table>

          </div>

        </div>


        <!-- ================================================= -->
        <!-- TRANSAKSI NON MEMBER -->
        <!-- ================================================= -->

        <div
          class="bg-white
          rounded-2xl
          shadow-sm
          border border-gray-100
          overflow-hidden"
        >

          <!-- HEADER -->
          <div
            class="px-6 py-5
            border-b border-gray-100
            flex items-center
            justify-between"
          >

            <div>

              <div
                class="flex
                items-center
                gap-2"
              >

                <span class="text-2xl">
                  🚗
                </span>

                <h2
                  class="text-lg
                  font-bold
                  text-gray-800"
                >
                  Transaksi Non-Member
                </h2>

              </div>

              <p class="text-sm text-gray-500 mt-1">
                Kendaraan yang menggunakan tiket parkir.
              </p>

            </div>

            <span
              class="px-3 py-1
              rounded-full
              bg-blue-100
              text-blue-700
              text-sm
              font-semibold"
            >
              {{ nonMemberFilter.length }} Data
            </span>

          </div>


          <!-- TABLE -->
          <div class="overflow-x-auto">

            <table class="w-full">

              <thead class="bg-blue-50">

                <tr>

                  <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                    No
                  </th>

                  <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                    Kode Tiket
                  </th>

                  <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                    Nomor Polisi
                  </th>

                  <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                    Kendaraan
                  </th>

                  <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                    Jam Masuk
                  </th>

                  <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                    Jam Keluar
                  </th>

                  <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                    Total
                  </th>

                  <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                    Status
                  </th>

                </tr>

              </thead>


              <tbody class="divide-y divide-gray-100">

                <tr
                  v-for="(item, index) in nonMemberFilter"
                  :key="'non-' + item.id"
                  class="hover:bg-gray-50 transition"
                >

                  <td class="px-6 py-4 text-sm text-gray-600">
                    {{ index + 1 }}
                  </td>


                  <td class="px-6 py-4">

                    <span
                      class="font-semibold
                      text-gray-800"
                    >
                      {{ item.kode_tiket }}
                    </span>

                  </td>


                  <td class="px-6 py-4">

                    <span
                      class="px-3 py-1
                      rounded-lg
                      bg-gray-100
                      text-gray-700
                      font-semibold"
                    >
                      {{ item.nomor_polisi || '-' }}
                    </span>

                  </td>


                  <td class="px-6 py-4 text-sm text-gray-600">

                    <span
                      v-if="
                        String(item.jenis_kendaraan)
                          .toLowerCase() === 'motor'
                      "
                    >
                      🏍️ Motor
                    </span>

                    <span
                      v-else-if="
                        String(item.jenis_kendaraan)
                          .toLowerCase() === 'mobil'
                      "
                    >
                      🚗 Mobil
                    </span>

                    <span v-else>
                      -
                    </span>

                  </td>


                  <td class="px-6 py-4 text-sm text-gray-600">
                    {{ item.jam_masuk || '-' }}
                  </td>


                  <td class="px-6 py-4 text-sm text-gray-600">
                    {{ item.jam_keluar || '-' }}
                  </td>


                  <td class="px-6 py-4 font-semibold text-[#0B2A1D]">
                    {{ formatRupiah(item.total) }}
                  </td>


                  <td class="px-6 py-4">

                    <span
                      v-if="item.status === 'aktif'"
                      class="inline-flex
                      px-3 py-1
                      rounded-full
                      text-xs
                      font-semibold
                      bg-blue-100
                      text-blue-700"
                    >
                      Aktif
                    </span>

                    <span
                      v-else
                      class="inline-flex
                      px-3 py-1
                      rounded-full
                      text-xs
                      font-semibold
                      bg-green-100
                      text-green-700"
                    >
                      Selesai
                    </span>

                  </td>

                </tr>


                <!-- KOSONG -->
                <tr v-if="nonMemberFilter.length === 0">

                  <td
                    colspan="8"
                    class="px-6 py-14 text-center"
                  >

                    <div class="text-5xl mb-3">
                      🚗
                    </div>

                    <p class="font-semibold text-gray-700">
                      Tidak ada transaksi non-member
                    </p>

                    <p class="text-sm text-gray-400 mt-1">
                      Transaksi non-member akan muncul di sini.
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

        <div
          class="mt-6
          text-center
          text-sm
          text-gray-400"
        >
          PARKIR PLAZA ANDALAS • Kelola Transaksi Petugas
        </div>

      </div>

    </main>

  </div>
</template>


<script setup lang="ts">

import {
  computed,
  onMounted,
  onUnmounted,
  ref
} from 'vue'

import { useRouter } from 'vue-router'


/* ================================================= */
/* ROUTER */
/* ================================================= */

const router = useRouter()


/* ================================================= */
/* API */
/* ================================================= */

const API = 'http://127.0.0.1:8000/api'


/* ================================================= */
/* DATA */
/* ================================================= */

const transaksiMember = ref<any[]>([])

const transaksiNonMember = ref<any[]>([])


/* ================================================= */
/* FILTER */
/* ================================================= */

const keyword = ref('')

const filterStatus = ref('semua')


/* ================================================= */
/* LOADING */
/* ================================================= */

const loading = ref(false)

const errorMessage = ref('')


/* ================================================= */
/* AUTO REFRESH */
/* ================================================= */

let intervalTransaksi: ReturnType<typeof setInterval> | null = null


/* ================================================= */
/* FILTER MEMBER */
/* ================================================= */

const memberFilter = computed(() => {

  const teks = keyword.value
    .toLowerCase()
    .trim()


  return transaksiMember.value.filter((item) => {

    const cocokKeyword =
      !teks ||

      String(item.nama_member || '')
        .toLowerCase()
        .includes(teks) ||

      String(item.nama_perusahaan || '')
        .toLowerCase()
        .includes(teks) ||

      String(item.kode_member || '')
        .toLowerCase()
        .includes(teks) ||

      String(item.nomor_polisi || '')
        .toLowerCase()
        .includes(teks)


    const cocokStatus =
      filterStatus.value === 'semua' ||
      item.status === filterStatus.value


    return cocokKeyword && cocokStatus

  })

})


/* ================================================= */
/* FILTER NON MEMBER */
/* ================================================= */

const nonMemberFilter = computed(() => {

  const teks = keyword.value
    .toLowerCase()
    .trim()


  return transaksiNonMember.value.filter((item) => {

    const cocokKeyword =
      !teks ||

      String(item.kode_tiket || '')
        .toLowerCase()
        .includes(teks) ||

      String(item.nomor_polisi || '')
        .toLowerCase()
        .includes(teks) ||

      String(item.jenis_kendaraan || '')
        .toLowerCase()
        .includes(teks)


    const cocokStatus =
      filterStatus.value === 'semua' ||
      item.status === filterStatus.value


    return cocokKeyword && cocokStatus

  })

})


/* ================================================= */
/* FORMAT RUPIAH */
/* ================================================= */

function formatRupiah(value: number) {

  return new Intl.NumberFormat(
    'id-ID',
    {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0
    }
  ).format(Number(value || 0))

}


/* ================================================= */
/* FORMAT JAM */
/* ================================================= */

function formatJam(waktu: any) {

  if (!waktu) {
    return '-'
  }


  const tanggal = new Date(waktu)


  if (isNaN(tanggal.getTime())) {
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


/* ================================================= */
/* AMBIL TRANSAKSI */
/* ================================================= */

async function ambilTransaksi() {

  try {

    loading.value = true

    errorMessage.value = ''


    const response = await fetch(
      `${API}/tiket`
    )


    if (!response.ok) {

      throw new Error(
        'Gagal mengambil data tiket'
      )

    }


    const hasil = await response.json()


    /*
      BACKEND KITA:

      {
        success: true,
        data: [...]
      }
    */

    const semuaTiket =
      Array.isArray(hasil.data)
        ? hasil.data
        : []


    /* ================================================= */
    /* TRANSAKSI MEMBER */
    /* ================================================= */

    transaksiMember.value =
      semuaTiket
        .filter((item: any) => item.member_id)
        .map((item: any) => {

          const member =
            item.member || {}


          return {

            id:
              item.id,

            nama_member:
              member.nama_member || '-',

            nama_perusahaan:
              member.nama_perusahaan || '-',

            kode_member:
              member.kode_member || '-',

            nomor_polisi:
              item.nomor_polisi || '-',

            jenis_kendaraan:
              item.jenis_kendaraan || 'member',

            jam_masuk:
              formatJam(item.waktu_masuk),

            jam_keluar:
              formatJam(item.waktu_keluar),

            status:
              item.status === 'masuk'
                ? 'aktif'
                : 'selesai',

            kode_tiket:
              item.kode_tiket,

            total:
              Number(item.tarif || 0),

            waktu_masuk:
              item.waktu_masuk,

            waktu_keluar:
              item.waktu_keluar

          }

        })


    /* ================================================= */
    /* TRANSAKSI NON MEMBER */
    /* ================================================= */

    transaksiNonMember.value =
      semuaTiket
        .filter((item: any) => !item.member_id)
        .map((item: any) => {

          return {

            id:
              item.id,

            kode_tiket:
              item.kode_tiket || '-',

            nomor_polisi:
              item.nomor_polisi || '-',

            jenis_kendaraan:
              item.jenis_kendaraan || '-',

            jam_masuk:
              formatJam(item.waktu_masuk),

            jam_keluar:
              formatJam(item.waktu_keluar),

            total:
              Number(item.tarif || 0),

            status:
              item.status === 'masuk'
                ? 'aktif'
                : 'selesai',

            waktu_masuk:
              item.waktu_masuk,

            waktu_keluar:
              item.waktu_keluar

          }

        })


  }
  catch (error) {

    console.error(
      'Gagal mengambil transaksi:',
      error
    )


    errorMessage.value =
      'Gagal mengambil data transaksi dari server.'


    transaksiMember.value = []

    transaksiNonMember.value = []

  }
  finally {

    loading.value = false

  }

}


/* ================================================= */
/* LOGOUT */
/* ================================================= */

function logout() {

  localStorage.removeItem('role')

  localStorage.removeItem('email')

  router.push('/')

}


/* ================================================= */
/* LOAD HALAMAN */
/* ================================================= */

onMounted(() => {

  const role =
    localStorage.getItem('role')


  if (
    role &&
    role !== 'petugas'
  ) {

    router.push('/')

    return

  }


  /* Ambil data pertama kali */

  ambilTransaksi()


  /*
    AUTO REFRESH

    Setiap 3 detik data dicek lagi.
    Jadi transaksi baru dari Scan Masuk
    akan muncul otomatis.
  */

  intervalTransaksi =
    setInterval(() => {

      ambilTransaksi()

    }, 3000)

})


/* ================================================= */
/* HENTIKAN AUTO REFRESH */
/* ================================================= */

onUnmounted(() => {

  if (intervalTransaksi) {

    clearInterval(intervalTransaksi)

    intervalTransaksi = null

  }

})

</script>