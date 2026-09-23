<template>
  <div class="min-h-screen bg-[#F3F7F5] font-sans">

    <!-- ================================================= -->
    <!-- HEADER -->
    <!-- ================================================= -->

    <header class="sticky top-0 z-40 bg-white border-b border-gray-100 shadow-sm">

      <div class="px-8 py-5 flex items-center justify-between">

        <!-- KIRI -->
        <div class="flex items-center gap-4">

          <button
            @click="router.push('/petugas')"
            class="px-4 py-2.5 rounded-xl
            bg-[#0B2A1D] hover:bg-[#164A31]
            text-white font-semibold transition"
          >
            ← Dashboard
          </button>

          <div class="h-8 w-px bg-gray-200"></div>

          <div class="flex items-center gap-3">

            <div
              class="w-11 h-11 rounded-xl
              bg-[#0B2A1D] flex items-center
              justify-center text-xl"
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
            class="hidden sm:flex items-center gap-2
            px-4 py-2 rounded-xl bg-green-50"
          >

            <span
              class="w-2.5 h-2.5 rounded-full bg-green-500"
            ></span>

            <span class="text-sm font-semibold text-green-700">
              {{ tiketAktif }} Tiket Aktif
            </span>

          </div>

          <button
            @click="logout"
            class="px-4 py-2.5 rounded-xl
            bg-red-50 hover:bg-red-100
            text-red-600 font-semibold transition"
          >
            🚪 Logout
          </button>

        </div>

      </div>

    </header>


    <!-- ================================================= -->
    <!-- MAIN -->
    <!-- ================================================= -->

    <main class="px-6 md:px-8 py-8">

      <div class="max-w-[1500px] mx-auto">

        <!-- ================================================= -->
        <!-- JUDUL -->
        <!-- ================================================= -->

        <div
          class="flex flex-col md:flex-row
          md:items-center md:justify-between
          gap-5 mb-8"
        >

          <div>

            <p class="text-sm text-gray-400">
              Petugas / Tiket
            </p>

            <h1
              class="text-3xl font-bold
              text-[#0B2A1D] mt-2"
            >
              Tiket Parkir 🎫
            </h1>

            <p class="text-gray-500 mt-1">
              Kelola dan lihat tiket kendaraan PARKIR PLAZA ANDALAS.
            </p>

          </div>

          <!-- CETAK TIKET TERAKHIR -->
          <button
            v-if="tiket.length > 0"
            @click="bukaTiketTerakhir"
            class="px-6 py-3 rounded-xl
            bg-[#0B2A1D] text-white
            font-semibold hover:bg-[#164A31]
            transition shadow-lg"
          >
            🖨️ Cetak Tiket Terakhir
          </button>

        </div>


        <!-- ================================================= -->
        <!-- LOADING -->
        <!-- ================================================= -->

        <div
          v-if="loading"
          class="bg-white rounded-2xl
          border border-gray-100 shadow-sm
          p-8 mb-8 text-center"
        >

          <div class="text-3xl mb-3">
            ⏳
          </div>

          <p class="text-gray-500">
            Memuat data tiket...
          </p>

        </div>


        <!-- ================================================= -->
        <!-- ERROR -->
        <!-- ================================================= -->

        <div
          v-if="errorMessage"
          class="bg-red-50 border border-red-200
          rounded-2xl p-5 mb-8"
        >

          <div class="flex items-center justify-between gap-4">

            <div>

              <p class="font-semibold text-red-700">
                Gagal mengambil data tiket
              </p>

              <p class="text-sm text-red-600 mt-1">
                {{ errorMessage }}
              </p>

            </div>

            <button
              @click="loadTiket"
              class="px-4 py-2 rounded-xl
              bg-red-600 hover:bg-red-700
              text-white font-semibold"
            >
              Coba Lagi
            </button>

          </div>

        </div>


        <!-- ================================================= -->
        <!-- STATISTIK -->
        <!-- ================================================= -->

        <div
          class="grid grid-cols-1
          md:grid-cols-3 gap-6 mb-8"
        >

          <!-- TIKET HARI INI -->
          <div
            class="bg-white rounded-2xl p-6
            border border-gray-100 shadow-sm
            hover:shadow-md transition"
          >

            <div class="flex justify-between items-start">

              <div>

                <p class="text-sm text-gray-400">
                  Tiket Hari Ini
                </p>

                <h2
                  class="text-3xl font-bold
                  text-[#0B2A1D] mt-2"
                >
                  {{ tiketHariIni }}
                </h2>

              </div>

              <div
                class="w-12 h-12 rounded-xl
                bg-green-100 flex items-center
                justify-center text-xl"
              >
                🎫
              </div>

            </div>

          </div>


          <!-- TIKET AKTIF -->
          <div
            class="bg-white rounded-2xl p-6
            border border-gray-100 shadow-sm
            hover:shadow-md transition"
          >

            <div class="flex justify-between items-start">

              <div>

                <p class="text-sm text-gray-400">
                  Tiket Aktif
                </p>

                <h2
                  class="text-3xl font-bold
                  text-green-600 mt-2"
                >
                  {{ tiketAktif }}
                </h2>

              </div>

              <div
                class="w-12 h-12 rounded-xl
                bg-green-100 flex items-center
                justify-center text-xl"
              >
                🟢
              </div>

            </div>

          </div>


          <!-- KENDARAAN KELUAR -->
          <div
            class="bg-white rounded-2xl p-6
            border border-gray-100 shadow-sm
            hover:shadow-md transition"
          >

            <div class="flex justify-between items-start">

              <div>

                <p class="text-sm text-gray-400">
                  Kendaraan Keluar
                </p>

                <h2
                  class="text-3xl font-bold
                  text-[#0B2A1D] mt-2"
                >
                  {{ tiketKeluar }}
                </h2>

              </div>

              <div
                class="w-12 h-12 rounded-xl
                bg-green-100 flex items-center
                justify-center text-xl"
              >
                🚗
              </div>

            </div>

          </div>

        </div>


        <!-- ================================================= -->
        <!-- TABLE -->
        <!-- ================================================= -->

        <div
          class="bg-white rounded-2xl
          shadow-sm border border-gray-100
          overflow-hidden"
        >

          <!-- HEADER TABLE -->
          <div
            class="p-7 border-b
            flex flex-col md:flex-row
            md:items-center md:justify-between
            gap-3"
          >

            <div>

              <h2
                class="text-xl font-bold
                text-[#0B2A1D]"
              >
                Daftar Tiket
              </h2>

              <p class="text-sm text-gray-400 mt-1">
                Tiket parkir yang dibuat oleh petugas.
              </p>

            </div>

            <span
              class="px-4 py-2 rounded-full
              bg-green-100 text-green-700
              text-sm font-semibold"
            >
              {{ tiket.length }} Tiket
            </span>

          </div>


          <!-- TABLE -->
          <div class="overflow-x-auto">

            <table class="w-full">

              <thead class="bg-[#F7FAF8]">

                <tr>

                  <th
                    class="text-left px-6 py-4
                    text-sm font-semibold text-gray-600"
                  >
                    Kode Tiket
                  </th>

                  <th
                    class="text-left px-6 py-4
                    text-sm font-semibold text-gray-600"
                  >
                    Nomor Polisi
                  </th>

                  <th
                    class="text-left px-6 py-4
                    text-sm font-semibold text-gray-600"
                  >
                    Jam Masuk
                  </th>

                  <th
                    class="text-left px-6 py-4
                    text-sm font-semibold text-gray-600"
                  >
                    Status
                  </th>

                  <th
                    class="text-left px-6 py-4
                    text-sm font-semibold text-gray-600"
                  >
                    Aksi
                  </th>

                </tr>

              </thead>


              <tbody class="divide-y divide-gray-100">

                <tr
                  v-for="item in tiket"
                  :key="item.id || item.kode"
                  class="hover:bg-[#F8FBF9] transition"
                >

                  <!-- KODE -->
                  <td
                    class="px-6 py-4
                    font-semibold text-[#0B2A1D]"
                  >
                    {{ item.kode }}
                  </td>


                  <!-- PLAT -->
                  <td
                    class="px-6 py-4
                    font-medium"
                  >
                    {{ item.plat || '-' }}
                  </td>


                  <!-- JAM -->
                  <td
                    class="px-6 py-4
                    text-gray-600"
                  >
                    {{ item.jam || '-' }}
                  </td>


                  <!-- STATUS -->
                  <td class="px-6 py-4">

                    <span
                      v-if="item.status === 'aktif'"
                      class="px-3 py-1 rounded-full
                      text-xs font-semibold
                      bg-green-100 text-green-700"
                    >
                      Aktif
                    </span>

                    <span
                      v-else
                      class="px-3 py-1 rounded-full
                      text-xs font-semibold
                      bg-gray-100 text-gray-600"
                    >
                      Keluar
                    </span>

                  </td>


                  <!-- AKSI -->
                  <td class="px-6 py-4">

                    <button
                      @click="lihatTiket(item)"
                      class="px-4 py-2 rounded-lg
                      bg-[#0B2A1D] text-white
                      text-sm hover:bg-[#164A31]
                      transition"
                    >
                      👁️ Lihat
                    </button>

                  </td>

                </tr>


                <!-- KOSONG -->
                <tr v-if="!loading && tiket.length === 0">

                  <td
                    colspan="5"
                    class="px-6 py-12
                    text-center text-gray-400"
                  >

                    <div class="text-4xl mb-3">
                      🎫
                    </div>

                    <p>
                      Belum ada tiket parkir.
                    </p>

                    <p class="text-xs mt-2">
                      Tiket akan muncul setelah kendaraan melakukan Scan Masuk.
                    </p>

                  </td>

                </tr>

              </tbody>

            </table>

          </div>

        </div>


        <!-- FOOTER -->
        <div
          class="mt-6 text-center
          text-sm text-gray-400"
        >
          PARKIR PLAZA ANDALAS • Tiket Petugas
        </div>

      </div>

    </main>


    <!-- ================================================= -->
    <!-- MODAL TIKET -->
    <!-- ================================================= -->

    <div
      v-if="tiketDipilih"
      class="fixed inset-0 bg-black/50
      flex items-center justify-center
      z-[100] p-4"
      @click.self="tiketDipilih = null"
    >

      <div
        class="bg-white rounded-3xl
        shadow-2xl overflow-hidden
        w-full max-w-[430px]"
      >

        <!-- TIKET -->
        <div
          id="ticket-print"
          class="bg-white p-8"
        >

          <!-- LOGO -->
          <div class="text-center">

            <div
              class="w-16 h-16 mx-auto rounded-2xl
              bg-[#0B2A1D] text-white
              flex items-center justify-center
              text-3xl mb-3"
            >
              🅿️
            </div>

            <h2
              class="text-2xl font-bold
              text-[#0B2A1D]"
            >
              PARKIR PLAZA ANDALAS
            </h2>

            <p class="text-gray-500 text-sm mt-1">
              TIKET PARKIR
            </p>

          </div>


          <div
            class="border-t border-dashed
            my-6"
          ></div>


          <!-- DETAIL -->
          <div class="space-y-4">

            <div class="flex justify-between gap-4">

              <span class="text-gray-500">
                Kode Tiket
              </span>

              <b class="text-[#0B2A1D]">
                {{ tiketDipilih.kode }}
              </b>

            </div>


            <div class="flex justify-between gap-4">

              <span class="text-gray-500">
                No. Polisi
              </span>

              <b>
                {{ tiketDipilih.plat || '-' }}
              </b>

            </div>


            <div class="flex justify-between gap-4">

              <span class="text-gray-500">
                Jam Masuk
              </span>

              <b>
                {{ tiketDipilih.jam || '-' }}
              </b>

            </div>


            <div class="flex justify-between gap-4">

              <span class="text-gray-500">
                Status
              </span>

              <b
                :class="
                  tiketDipilih.status === 'aktif'
                    ? 'text-green-600'
                    : 'text-gray-500'
                "
              >
                {{
                  tiketDipilih.status === 'aktif'
                    ? 'Aktif'
                    : 'Keluar'
                }}
              </b>

            </div>

          </div>


          <!-- QR -->
          <div class="mt-7 flex flex-col items-center">

            <canvas
              ref="qrPreview"
              width="180"
              height="180"
              class="border border-gray-200 rounded-xl p-2"
            ></canvas>

            <p class="text-xs text-gray-400 mt-2">
              Scan QR untuk kendaraan keluar
            </p>

          </div>


          <div
            class="border-t border-dashed
            my-6"
          ></div>


          <!-- PESAN -->
          <div class="text-center">

            <p class="text-xs text-gray-400">
              Simpan tiket ini sampai kendaraan keluar.
            </p>

            <p class="text-xs text-gray-400 mt-1">
              Terima kasih telah menggunakan
              PARKIR PLAZA ANDALAS.
            </p>

          </div>

        </div>


        <!-- BUTTON -->
        <div
          class="p-5 bg-gray-50
          border-t border-gray-100"
        >

          <div class="grid grid-cols-2 gap-3">

            <!-- PDF -->
            <button
              @click="cetakPDF"
              class="py-3 rounded-xl
              bg-[#0B2A1D]
              hover:bg-[#164A31]
              text-white font-semibold
              transition"
            >
              🖨️ PDF
            </button>


            <!-- PNG -->
            <button
              @click="simpanPNG"
              class="py-3 rounded-xl
              bg-green-100
              hover:bg-green-200
              text-green-700
              font-semibold transition"
            >
              🖼️ PNG
            </button>

          </div>


          <!-- TUTUP -->
          <button
            @click="tiketDipilih = null"
            class="w-full mt-3 py-3
            rounded-xl bg-gray-200
            hover:bg-gray-300
            text-gray-700 font-semibold
            transition"
          >
            Tutup
          </button>

        </div>

      </div>

    </div>

  </div>
</template>


<script setup lang="ts">

import {
  ref,
  computed,
  onMounted,
  nextTick
} from 'vue'

import {
  useRouter
} from 'vue-router'

import QRCode from 'qrcode'

import {
  jsPDF
} from 'jspdf'


/* ================================================= */
/* ROUTER */
/* ================================================= */

const router = useRouter()

const {
  $api
} = useNuxtApp()


/* ================================================= */
/* QR */
/* ================================================= */

const qrPreview =
  ref<HTMLCanvasElement | null>(null)


/* ================================================= */
/* TIKET DIPILIH */
/* ================================================= */

const tiketDipilih =
  ref<any>(null)


/* ================================================= */
/* LOADING */
/* ================================================= */

const loading =
  ref(false)


/* ================================================= */
/* ERROR */
/* ================================================= */

const errorMessage =
  ref('')


/* ================================================= */
/* DATA TIKET */
/* ================================================= */

const tiket =
  ref<any[]>([])


/* ================================================= */
/* FORMAT TIKET */
/* ================================================= */

const formatTiket = (item: any) => {

  const kode =
    item.kode_tiket ??
    item.kode ??
    item.ticket_code ??
    item.kodeTicket ??
    '-'


  const plat =
    item.nomor_polisi ??
    item.no_polisi ??
    item.plat_nomor ??
    item.plat ??
    item.nomorPolisi ??
    '-'


  /* JAM MASUK */

  let jam = '-'

  const waktu =
    item.waktu_masuk ??
    item.jam_masuk ??
    item.created_at ??
    item.createdAt


  if (waktu) {

    try {

      const tanggal =
        new Date(waktu)

      if (!isNaN(tanggal.getTime())) {

        jam =
          tanggal.toLocaleTimeString(
            'id-ID',
            {
              hour: '2-digit',
              minute: '2-digit'
            }
          )

      }

    } catch {

      jam = String(waktu)

    }

  }


  /* STATUS */

  let status =
    String(
      item.status ??
      item.status_tiket ??
      item.status_parkir ??
      'masuk'
    ).toLowerCase()


  /*
   * DATABASE:
   *
   * masuk     = masih parkir
   * aktif     = masih parkir
   * parkir    = masih parkir
   *
   * keluar    = sudah keluar
   * selesai   = sudah selesai
   */

  if (
    status === 'masuk' ||
    status === 'aktif' ||
    status === 'active' ||
    status === 'parkir'
  ) {

    status = 'aktif'

  }


  if (
    status === 'keluar' ||
    status === 'selesai' ||
    status === 'paid' ||
    status === 'sudah_keluar'
  ) {

    status = 'keluar'

  }


  return {

    ...item,

    id:
      item.id ?? null,

    kode,

    plat,

    jam,

    status

  }

}


/* ================================================= */
/* LOAD TIKET DARI DATABASE */
/* ================================================= */

const loadTiket = async () => {

  loading.value = true

  errorMessage.value = ''

  try {

    const response =
      await $api.get('/tiket')


    console.log(
      'RESPONSE API TIKET:',
      response
    )


    let data: any =
      response.data


    console.log(
      'BODY API TIKET:',
      data
    )


    if (
      data &&
      Array.isArray(data.data)
    ) {

      data =
        data.data

    }


    if (
      !Array.isArray(data)
    ) {

      console.error(
        'FORMAT DATA TIKET TIDAK VALID:',
        data
      )

      data = []

    }


    tiket.value =
      data.map(
        (item: any) =>
          formatTiket(item)
      )


    console.log(
      'TIKET YANG DITAMPILKAN:',
      tiket.value
    )


  } catch (error: any) {

    console.error(
      'ERROR LOAD TIKET:',
      error
    )


    errorMessage.value =
      error?.response?.data?.message ??
      error?.data?.message ??
      error?.message ??
      'Tidak dapat terhubung ke server.'


    tiket.value = []


  } finally {

    loading.value = false

  }

}


/* ================================================= */
/* TIKET AKTIF */
/* ================================================= */

const tiketAktif =
  computed(() => {

    return tiket.value.filter(
      item =>
        item.status === 'aktif'
    ).length

  })


/* ================================================= */
/* TIKET KELUAR */
/* ================================================= */

const tiketKeluar =
  computed(() => {

    return tiket.value.filter(
      item =>
        item.status === 'keluar'
    ).length

  })


/* ================================================= */
/* TIKET HARI INI */
/* ================================================= */

const tiketHariIni =
  computed(() => {

    const sekarang =
      new Date()


    const tahun =
      sekarang.getFullYear()


    const bulan =
      sekarang.getMonth()


    const hari =
      sekarang.getDate()


    return tiket.value.filter(
      item => {

        const waktu =
          item.waktu_masuk ??
          item.jam_masuk ??
          item.created_at ??
          item.createdAt


        if (!waktu) {

          return false

        }


        const tanggal =
          new Date(waktu)


        if (
          isNaN(
            tanggal.getTime()
          )
        ) {

          return false

        }


        return (
          tanggal.getFullYear() === tahun &&
          tanggal.getMonth() === bulan &&
          tanggal.getDate() === hari
        )

      }
    ).length

  })


/* ================================================= */
/* DATA QR */
/* ================================================= */

const dataQR = () => {

  if (
    !tiketDipilih.value
  ) {

    return ''

  }


  /*
   * PENTING:
   *
   * QR SEKARANG HANYA MENYIMPAN
   * KODE TIKET.
   *
   * Contoh isi QR:
   *
   * AABC12
   *
   * BUKAN lagi:
   *
   * {
   *   sistem: ...,
   *   tiket_id: ...,
   *   nomor_polisi: ...,
   *   status: ...
   * }
   */

  return String(
    tiketDipilih.value.kode
  )
    .trim()
    .toUpperCase()

}


/* ================================================= */
/* BUAT QR */
/* ================================================= */

const buatQR = async () => {

  if (
    !qrPreview.value ||
    !tiketDipilih.value
  ) {

    return

  }


  try {

    /*
     * Bersihkan canvas terlebih dahulu
     * supaya QR lama tidak tertinggal.
     */

    const context =
      qrPreview.value.getContext('2d')

    if (context) {

      context.clearRect(
        0,
        0,
        qrPreview.value.width,
        qrPreview.value.height
      )

    }


    await QRCode.toCanvas(

      qrPreview.value,

      dataQR(),

      {
        width: 160,

        margin: 2,

        errorCorrectionLevel: 'M',

        color: {
          dark: '#0B2A1D',
          light: '#FFFFFF'
        }

      }

    )

  } catch (error) {

    console.error(
      'ERROR QR:',
      error
    )

  }

}


/* ================================================= */
/* LIHAT TIKET */
/* ================================================= */

const lihatTiket =
  async (item: any) => {

    tiketDipilih.value =
      item

    await nextTick()

    await buatQR()

  }


/* ================================================= */
/* TIKET TERAKHIR */
/* ================================================= */

const bukaTiketTerakhir =
  async () => {

    if (
      tiket.value.length === 0
    ) {

      alert(
        'Belum ada tiket.'
      )

      return

    }


    tiketDipilih.value =
      tiket.value[0]


    await nextTick()

    await buatQR()

  }


/* ================================================= */
/* CANVAS TIKET */
/* ================================================= */

const buatCanvasTiket =
  async (): Promise<HTMLCanvasElement> => {

    if (
      !tiketDipilih.value
    ) {

      throw new Error(
        'Tiket belum dipilih.'
      )

    }


    const canvas =
      document.createElement(
        'canvas'
      )


    const width =
      800


    const height =
      1050


    canvas.width =
      width


    canvas.height =
      height


    const ctx =
      canvas.getContext(
        '2d'
      )


    if (!ctx) {

      throw new Error(
        'Canvas tidak tersedia.'
      )

    }


    /* BACKGROUND */

    ctx.fillStyle =
      '#FFFFFF'


    ctx.fillRect(
      0,
      0,
      width,
      height
    )


    /* HEADER */

    ctx.fillStyle =
      '#0B2A1D'


    ctx.fillRect(
      0,
      0,
      width,
      210
    )


    /* LOGO */

    ctx.fillStyle =
      '#FFFFFF'


    ctx.font =
      'bold 72px Arial'


    ctx.textAlign =
      'center'


    ctx.fillText(
      'P',
      width / 2,
      100
    )


    /* NAMA PARKIR */

    ctx.font =
      'bold 36px Arial'


    ctx.fillText(
      'PARKIR PLAZA ANDALAS',
      width / 2,
      155
    )


    ctx.font =
      '22px Arial'


    ctx.fillText(
      'TIKET PARKIR',
      width / 2,
      190
    )


    /* DETAIL */

    ctx.textAlign =
      'left'


    ctx.fillStyle =
      '#6B7280'


    ctx.font =
      '24px Arial'


    ctx.fillText(
      'Kode Tiket',
      70,
      275
    )


    ctx.fillText(
      'No. Polisi',
      70,
      330
    )


    ctx.fillText(
      'Jam Masuk',
      70,
      385
    )


    ctx.fillText(
      'Status',
      70,
      440
    )


    ctx.textAlign =
      'right'


    ctx.fillStyle =
      '#0B2A1D'


    ctx.font =
      'bold 26px Arial'


    ctx.fillText(
      tiketDipilih.value.kode,
      730,
      275
    )


    ctx.fillText(
      tiketDipilih.value.plat || '-',
      730,
      330
    )


    ctx.fillText(
      tiketDipilih.value.jam || '-',
      730,
      385
    )


    ctx.fillText(
      tiketDipilih.value.status === 'aktif'
        ? 'Aktif'
        : 'Keluar',
      730,
      440
    )


    /* GARIS */

    ctx.strokeStyle =
      '#D1D5DB'


    ctx.setLineDash([
      10,
      10
    ])


    ctx.beginPath()


    ctx.moveTo(
      70,
      490
    )


    ctx.lineTo(
      730,
      490
    )


    ctx.stroke()


    ctx.setLineDash([])


    /* ================================================= */
    /* QR */
    /* ================================================= */

    const qrCanvas =
      document.createElement(
        'canvas'
      )


    /*
     * QR JUGA MENGGUNAKAN dataQR()
     *
     * Jadi QR PDF/PNG isinya sama:
     *
     * AABC12
     */

    await QRCode.toCanvas(

      qrCanvas,

      dataQR(),

      {
        width: 300,

        margin: 2,

        errorCorrectionLevel: 'M',

        color: {
          dark: '#0B2A1D',
          light: '#FFFFFF'
        }

      }

    )


    const qrSize =
      300


    const qrX =
      (width - qrSize) / 2


    const qrY =
      530


    ctx.drawImage(
      qrCanvas,
      qrX,
      qrY,
      qrSize,
      qrSize
    )


    /* QR TEXT */

    ctx.textAlign =
      'center'


    ctx.fillStyle =
      '#6B7280'


    ctx.font =
      '20px Arial'


    ctx.fillText(
      'Scan QR untuk kendaraan keluar',
      width / 2,
      865
    )


    /* GARIS BAWAH */

    ctx.strokeStyle =
      '#D1D5DB'


    ctx.setLineDash([
      10,
      10
    ])


    ctx.beginPath()


    ctx.moveTo(
      70,
      905
    )


    ctx.lineTo(
      730,
      905
    )


    ctx.stroke()


    ctx.setLineDash([])


    /* PESAN */

    ctx.fillStyle =
      '#6B7280'


    ctx.font =
      '18px Arial'


    ctx.fillText(
      'Simpan tiket ini sampai kendaraan keluar.',
      width / 2,
      950
    )


    ctx.fillText(
      'Terima kasih telah menggunakan PARKIR PLAZA ANDALAS.',
      width / 2,
      985
    )


    return canvas

  }


/* ================================================= */
/* CETAK PDF */
/* ================================================= */

const cetakPDF =
  async () => {

    if (
      !tiketDipilih.value
    ) {

      alert(
        'Pilih tiket terlebih dahulu.'
      )

      return

    }


    try {

      const canvas =
        await buatCanvasTiket()


      const imgData =
        canvas.toDataURL(
          'image/png',
          1.0
        )


      const pdf =
        new jsPDF({

          orientation:
            'portrait',

          unit:
            'mm',

          format:
            [80, 120]

        })


      const pdfWidth =
        80


      const pdfHeight =
        (canvas.height /
          canvas.width) *
        pdfWidth


      pdf.addImage(

        imgData,

        'PNG',

        0,

        0,

        pdfWidth,

        pdfHeight,

        undefined,

        'FAST'

      )


      pdf.save(
        `Tiket-PARKIR-PLAZA-ANDALAS-${tiketDipilih.value.kode}.pdf`
      )


    } catch (error) {

      console.error(
        'ERROR PDF:',
        error
      )


      alert(
        'PDF gagal dibuat. Coba ulangi lagi.'
      )

    }

  }


/* ================================================= */
/* SIMPAN PNG */
/* ================================================= */

const simpanPNG =
  async () => {

    if (
      !tiketDipilih.value
    ) {

      alert(
        'Pilih tiket terlebih dahulu.'
      )

      return

    }


    try {

      const canvas =
        await buatCanvasTiket()


      const link =
        document.createElement(
          'a'
        )


      link.download =
        `Tiket-PARKIR-PLAZA-ANDALAS-${tiketDipilih.value.kode}.png`


      link.href =
        canvas.toDataURL(
          'image/png',
          1.0
        )


      document.body.appendChild(
        link
      )


      link.click()


      document.body.removeChild(
        link
      )


    } catch (error) {

      console.error(
        'ERROR PNG:',
        error
      )


      alert(
        'PNG gagal dibuat. Coba ulangi lagi.'
      )

    }

  }


/* ================================================= */
/* LOGOUT */
/* ================================================= */

const logout = () => {

  localStorage.removeItem(
    'role'
  )


  localStorage.removeItem(
    'email'
  )


  router.push('/')

}


/* ================================================= */
/* MOUNTED */
/* ================================================= */

onMounted(
  async () => {

    const role =
      localStorage.getItem(
        'role'
      )


    if (
      role !== 'petugas'
    ) {

      router.push('/')

      return

    }


    await loadTiket()

  }
)

</script>