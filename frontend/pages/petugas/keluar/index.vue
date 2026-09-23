<template>
  <div
    class="min-h-screen bg-gradient-to-br from-teal-800 via-teal-700 to-slate-800 flex items-center justify-center p-6"
  >

    <!-- =====================================================
         TAMPILAN AWAL
    ====================================================== -->

    <div
      v-if="halaman === 'awal'"
      class="w-full max-w-md rounded-[35px] bg-white/90 backdrop-blur-md p-10 shadow-2xl"
    >

      <!-- HEADER -->
      <div class="text-center">

        <h1 class="text-3xl font-extrabold tracking-wide text-slate-700">
          PARKIR
        </h1>

        <h2 class="mt-1 text-3xl font-extrabold tracking-wide text-slate-700">
          PLAZA ANDALAS
        </h2>

      </div>


      <!-- =====================================================
           TOMBOL PRINT NON MEMBER
      ====================================================== -->

      <div class="mt-10 text-center">

        <p class="text-base font-medium text-slate-600">
          Tekan tombol PRINT untuk
        </p>

        <p class="text-base font-medium text-slate-600">
          mengambil tiket
        </p>

        <button
          @click="printTiket"
          class="mt-5 rounded-full bg-lime-600 px-12 py-4 text-lg font-bold text-white shadow-lg transition hover:bg-lime-700 active:scale-95"
        >
          PRINT
        </button>

      </div>


      <!-- GARIS -->
      <div class="my-8 border-t-2 border-slate-500"></div>


      <!-- =====================================================
           SCANNER MEMBER
      ====================================================== -->

      <div class="text-center">

        <p class="text-base font-medium text-slate-600">
          Scan kartu Member Untuk
        </p>

        <p class="text-base font-medium text-slate-600">
          Buka Pintu
        </p>


        <!--
          INPUT INI BUKAN KAMERA.

          Scanner fisik akan mengetikkan kode
          ke input ini lalu mengirim ENTER.
        -->

        <input
          ref="scannerInput"
          v-model="kodeScan"
          @keydown.enter.prevent="prosesScan"
          @input="handleScannerInput"
          type="text"
          autocomplete="off"
          autofocus
          class="mt-5 w-full rounded-2xl border-2 border-slate-300 bg-white px-5 py-4 text-center text-lg font-semibold text-slate-700 outline-none transition focus:border-teal-500 focus:ring-4 focus:ring-teal-100"
          placeholder=""
        />

        <p class="mt-3 text-xs text-slate-500">
          Silakan scan menggunakan alat scanner
        </p>

      </div>

    </div>


    <!-- =====================================================
         MODAL MEMBER
    ====================================================== -->

    <div
      v-if="halaman === 'member'"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-5 backdrop-blur-sm"
    >

      <div class="w-full max-w-xl rounded-[30px] bg-white p-8 shadow-2xl">

        <!-- ICON -->

        <div class="flex justify-center">

          <div class="flex h-16 w-16 items-center justify-center rounded-full bg-green-100">

            <span class="text-4xl text-green-600">
              ✓
            </span>

          </div>

        </div>


        <!-- JUDUL -->

        <h2 class="mt-5 text-center text-3xl font-extrabold text-green-700">
          Member Terdeteksi
        </h2>

        <p class="mt-2 text-center text-slate-500">
          Silakan isi nomor polisi kendaraan
        </p>


        <!-- DATA MEMBER -->

        <div class="mt-8 space-y-4">

          <div class="flex items-center justify-between border-b pb-3">

            <span class="text-slate-500">
              Nama
            </span>

            <span class="font-bold text-slate-700">
              {{ memberData.nama_member }}
            </span>

          </div>


          <div
            v-if="memberData.nama_perusahaan"
            class="flex items-center justify-between border-b pb-3"
          >

            <span class="text-slate-500">
              Perusahaan
            </span>

            <span class="font-bold text-slate-700">
              {{ memberData.nama_perusahaan }}
            </span>

          </div>


          <div class="flex items-center justify-between border-b pb-3">

            <span class="text-slate-500">
              Status
            </span>

            <span class="font-bold text-green-600">
              {{ memberData.status }}
            </span>

          </div>


          <div class="flex items-center justify-between">

            <span class="text-slate-500">
              Berlaku sampai
            </span>

            <span class="font-bold text-slate-700">
              {{ memberData.tanggal_expired || '-' }}
            </span>

          </div>

        </div>


        <!-- NOMOR POLISI -->

        <div class="mt-8">

          <label class="mb-2 block font-bold text-slate-700">
            Nomor Polisi
          </label>

          <input
            ref="platInput"
            v-model="nomorPolisi"
            type="text"
            autocomplete="off"
            @keydown.enter.prevent="prosesMember"
            class="w-full rounded-2xl border-2 border-slate-300 px-5 py-4 text-center text-xl font-bold uppercase tracking-wider outline-none focus:border-green-500 focus:ring-4 focus:ring-green-100"
            placeholder="B 1234 ABC"
          />

        </div>


        <!-- OK -->

        <button
          @click="prosesMember"
          :disabled="!nomorPolisi.trim() || loading"
          class="mt-5 w-full rounded-2xl bg-green-600 py-4 text-lg font-bold text-white transition hover:bg-green-700 disabled:cursor-not-allowed disabled:bg-slate-300"
        >
          {{ loading ? 'MEMPROSES...' : 'OK' }}
        </button>


        <!-- BATAL -->

        <button
          @click="kembaliAwal"
          class="mt-3 w-full py-3 font-semibold text-slate-500 hover:text-slate-700"
        >
          BATAL
        </button>

      </div>

    </div>


    <!-- =====================================================
         MODAL NON MEMBER / PEMBAYARAN
    ====================================================== -->

    <div
      v-if="halaman === 'non-member'"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-5 backdrop-blur-sm"
    >

      <div class="w-full max-w-xl rounded-[30px] bg-white p-8 shadow-2xl">

        <!-- ICON -->

        <div class="flex justify-center">

          <div class="flex h-16 w-16 items-center justify-center rounded-full bg-blue-100">

            <span class="text-3xl font-bold text-blue-600">
              Rp
            </span>

          </div>

        </div>


        <!-- JUDUL -->

        <h2 class="mt-5 text-center text-3xl font-extrabold text-blue-700">
          Pembayaran Parkir
        </h2>

        <p class="mt-2 text-center text-slate-500">
          Non Member
        </p>


        <!-- INFORMASI TIKET -->

        <div class="mt-8 space-y-4">

          <div class="flex justify-between border-b pb-3">

            <span class="text-slate-500">
              Tiket
            </span>

            <span class="font-bold text-slate-700">
              {{ tiketData.tiket || kodeScan }}
            </span>

          </div>


          <div class="flex justify-between border-b pb-3">

            <span class="text-slate-500">
              Durasi
            </span>

            <span class="font-bold text-slate-700">
              {{ tiketData.durasi || '1 Jam' }}
            </span>

          </div>


          <div class="flex justify-between border-b pb-3">

            <span class="text-slate-500">
              Tarif
            </span>

            <span class="font-bold text-slate-700">
              Rp {{ formatRupiah(tiketData.tarif || 3000) }} / Jam
            </span>

          </div>


          <div class="flex justify-between">

            <span class="font-bold text-slate-700">
              Total Bayar
            </span>

            <span class="text-xl font-extrabold text-red-500">
              Rp {{ formatRupiah(totalBayar) }}
            </span>

          </div>

        </div>


        <!-- NOMOR POLISI -->

        <div class="mt-7">

          <label class="mb-2 block font-bold text-slate-700">
            Nomor Polisi
          </label>

          <input
            v-model="nomorPolisi"
            type="text"
            autocomplete="off"
            class="w-full rounded-2xl border-2 border-slate-300 px-5 py-4 text-center text-xl font-bold uppercase tracking-wider outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
            placeholder="B 1234 ABC"
          />

        </div>


        <!-- UANG -->

        <div class="mt-5">

          <label class="mb-2 block font-bold text-slate-700">
            Uang Dibayar
          </label>

          <input
            ref="uangInput"
            v-model.number="uangDibayar"
            @keydown.enter.prevent="bayarNonMember"
            type="number"
            min="0"
            class="w-full rounded-2xl border-2 border-slate-300 px-5 py-4 text-center text-xl font-bold outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
            placeholder="Masukkan uang"
          />

        </div>


        <!-- KEMBALIAN -->

        <div
          v-if="uangDibayar >= totalBayar"
          class="mt-4 rounded-2xl bg-green-50 p-4 text-center"
        >

          <p class="text-sm text-green-600">
            Kembalian
          </p>

          <p class="text-xl font-extrabold text-green-700">
            Rp {{ formatRupiah(uangDibayar - totalBayar) }}
          </p>

        </div>


        <!-- BAYAR -->

        <button
          @click="bayarNonMember"
          :disabled="uangDibayar < totalBayar || loading"
          class="mt-5 w-full rounded-2xl bg-blue-600 py-4 text-lg font-bold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:bg-slate-300"
        >
          {{ loading ? 'MEMPROSES...' : 'BAYAR' }}
        </button>


        <!-- BATAL -->

        <button
          @click="kembaliAwal"
          class="mt-3 w-full py-3 font-semibold text-slate-500 hover:text-slate-700"
        >
          BATAL
        </button>

      </div>

    </div>


    <!-- =====================================================
         HASIL MEMBER BERHASIL
    ====================================================== -->

    <div
      v-if="halaman === 'member-berhasil'"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-5 backdrop-blur-sm"
    >

      <div class="w-full max-w-xl rounded-[30px] bg-white p-8 text-center shadow-2xl">

        <!-- ICON -->

        <div class="flex justify-center">

          <div class="flex h-20 w-20 items-center justify-center rounded-full bg-green-100">

            <span class="text-5xl font-bold text-green-600">
              ✓
            </span>

          </div>

        </div>


        <h2 class="mt-5 text-3xl font-extrabold text-green-700">
          MEMBER VALID
        </h2>


        <p class="mt-2 text-slate-500">
          Member berhasil diverifikasi.
        </p>


        <!-- DETAIL -->

        <div class="mt-7 rounded-2xl bg-slate-50 p-5 text-left">

          <div class="flex justify-between border-b pb-3">

            <span class="text-slate-500">
              Nama
            </span>

            <span class="font-bold text-slate-700">
              {{ memberData.nama_member }}
            </span>

          </div>


          <div class="mt-4 flex justify-between border-b pb-3">

            <span class="text-slate-500">
              Plat Nomor
            </span>

            <span class="font-bold uppercase text-slate-700">
              {{ nomorPolisi }}
            </span>

          </div>


          <div class="mt-4 flex justify-between">

            <span class="text-slate-500">
              Status
            </span>

            <span class="font-bold text-green-600">
              LUNAS
            </span>

          </div>

        </div>


        <!-- GATE -->

        <div class="mt-5 rounded-2xl bg-green-100 p-5">

          <p class="text-2xl font-extrabold text-green-700">
            GATE TERBUKA
          </p>

          <p class="mt-1 text-sm text-green-700">
            Silakan melanjutkan perjalanan.
          </p>

        </div>


        <button
          @click="kembaliAwal"
          class="mt-6 w-full rounded-2xl bg-green-600 py-4 text-lg font-bold text-white hover:bg-green-700"
        >
          SELESAI
        </button>

      </div>

    </div>


    <!-- =====================================================
         PEMBAYARAN BERHASIL
    ====================================================== -->

    <div
      v-if="halaman === 'pembayaran-berhasil'"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-5 backdrop-blur-sm"
    >

      <div class="w-full max-w-xl rounded-[30px] bg-white p-8 text-center shadow-2xl">

        <!-- ICON -->

        <div class="flex justify-center">

          <div class="flex h-20 w-20 items-center justify-center rounded-full bg-green-100">

            <span class="text-5xl font-bold text-green-600">
              ✓
            </span>

          </div>

        </div>


        <!-- JUDUL -->

        <h2 class="mt-5 text-3xl font-extrabold text-green-700">
          PEMBAYARAN BERHASIL
        </h2>


        <p class="mt-2 text-slate-500">
          Pembayaran parkir telah berhasil.
        </p>


        <!-- DETAIL PEMBAYARAN -->

        <div class="mt-7 rounded-2xl bg-slate-50 p-5 text-left">

          <div class="flex justify-between border-b pb-3">

            <span class="text-slate-500">
              Plat Nomor
            </span>

            <span class="font-bold uppercase text-slate-700">
              {{ nomorPolisi }}
            </span>

          </div>


          <div class="mt-4 flex justify-between border-b pb-3">

            <span class="text-slate-500">
              Total Bayar
            </span>

            <span class="font-bold text-green-700">
              Rp {{ formatRupiah(totalBayar) }}
            </span>

          </div>


          <div class="mt-4 flex justify-between">

            <span class="text-slate-500">
              Kembalian
            </span>

            <span class="font-bold text-green-700">
              Rp {{ formatRupiah(uangDibayar - totalBayar) }}
            </span>

          </div>

        </div>


        <!-- GATE TERBUKA -->

        <div class="mt-5 rounded-2xl bg-green-100 p-5">

          <p class="text-2xl font-extrabold text-green-700">
            GATE TERBUKA
          </p>

          <p class="mt-1 text-sm text-green-700">
            Silakan melanjutkan perjalanan.
          </p>

        </div>


        <!-- SELESAI -->

        <button
          @click="kembaliAwal"
          class="mt-6 w-full rounded-2xl bg-green-600 py-4 text-lg font-bold text-white transition hover:bg-green-700"
        >
          SELESAI
        </button>

      </div>

    </div>


    <!-- =====================================================
         NOTIFIKASI
    ====================================================== -->

    <div
      v-if="pesan"
      class="fixed bottom-6 left-1/2 z-[100] w-[90%] max-w-md -translate-x-1/2 rounded-2xl bg-slate-900 px-6 py-4 text-center font-semibold text-white shadow-xl"
    >
      {{ pesan }}
    </div>

  </div>
</template>


<script setup lang="ts">

import {
  ref,
  nextTick,
  onMounted,
  onBeforeUnmount
} from 'vue'


// =====================================================
// API
// =====================================================

const API = 'http://127.0.0.1:8000/api'


// =====================================================
// HALAMAN
// =====================================================

const halaman = ref<
  'awal' |
  'member' |
  'non-member' |
  'member-berhasil' |
  'pembayaran-berhasil'
>('awal')


// =====================================================
// INPUT SCANNER
// =====================================================

const kodeScan = ref('')

const scannerInput =
  ref<HTMLInputElement | null>(null)


// =====================================================
// INPUT MEMBER / PLAT
// =====================================================

const platInput =
  ref<HTMLInputElement | null>(null)

const nomorPolisi =
  ref('')


// =====================================================
// MEMBER DATA
// =====================================================

const memberData =
  ref<any>({})


// =====================================================
// TIKET NON MEMBER
// =====================================================

const tiketData =
  ref<any>({})

const totalBayar =
  ref(3000)

const uangDibayar =
  ref(0)

const uangInput =
  ref<HTMLInputElement | null>(null)


// =====================================================
// LAIN-LAIN
// =====================================================

const loading =
  ref(false)

const pesan =
  ref('')

let timerPesan: any = null


// =====================================================
// NOTIFIKASI
// =====================================================

function tampilPesan(text: string) {

  pesan.value = text

  clearTimeout(timerPesan)

  timerPesan = setTimeout(() => {

    pesan.value = ''

  }, 3000)

}


// =====================================================
// FORMAT RUPIAH
// =====================================================

function formatRupiah(
  angka: number
) {

  return new Intl.NumberFormat(
    'id-ID'
  ).format(
    Number(angka || 0)
  )

}


// =====================================================
// SCANNER
// =====================================================

function handleScannerInput() {

  /*
   * Scanner fisik bekerja seperti keyboard.
   *
   * Contoh:
   *
   * Scanner membaca:
   *
   * MEM001
   *
   * lalu mengirim ENTER.
   *
   * ENTER akan menjalankan prosesScan().
   */

}


// =====================================================
// PROSES SCAN
// =====================================================

async function prosesScan() {

  const kode =
    kodeScan.value.trim()


  if (!kode) return

  if (loading.value) return


  loading.value = true


  try {

    const response =
      await fetch(
        `${API}/gate/check-member`,
        {
          method: 'POST',

          headers: {
            'Content-Type':
              'application/json',

            'Accept':
              'application/json'
          },

          body: JSON.stringify({
            kode_member: kode
          })
        }
      )


    const data =
      await response.json()


    // =================================================
    // MEMBER
    // =================================================

    if (
      data.type === 'member' &&
      data.success === true
    ) {

      memberData.value =
        data.member


      nomorPolisi.value = ''


      halaman.value =
        'member'


      await nextTick()


      platInput.value?.focus()


      return

    }


    // =================================================
    // NON MEMBER
    // =================================================

    if (
      data.type === 'non-member'
    ) {

      tiketData.value =
        data.tiket || {}


      totalBayar.value =
        Number(
          data.total_bayar ||
          data.tiket?.total_bayar ||
          3000
        )


      nomorPolisi.value = ''

      uangDibayar.value = 0


      halaman.value =
        'non-member'


      await nextTick()


      uangInput.value?.focus()


      return

    }


    // =================================================
    // MEMBER TIDAK VALID
    // =================================================

    tampilPesan(
      data.message ||
      'Member tidak dapat digunakan.'
    )

  }

  catch (error) {

    console.error(error)

    tampilPesan(
      'Tidak dapat terhubung ke server.'
    )

  }

  finally {

    loading.value = false

  }

}


// =====================================================
// PROSES MEMBER
// =====================================================

async function prosesMember() {

  if (
    !nomorPolisi.value.trim()
  ) {

    tampilPesan(
      'Nomor polisi wajib diisi.'
    )

    return

  }


  loading.value = true


  try {

    const response =
      await fetch(
        `${API}/gate/member`,
        {
          method: 'POST',

          headers: {
            'Content-Type':
              'application/json',

            'Accept':
              'application/json'
          },

          body: JSON.stringify({

            member_id:
              memberData.value.id,

            nomor_polisi:
              nomorPolisi.value
                .toUpperCase()

          })
        }
      )


    const data =
      await response.json()


    if (
      response.ok &&
      data.success
    ) {

      /*
       * MEMBER BERHASIL
       */

      halaman.value =
        'member-berhasil'

    }

    else {

      tampilPesan(
        data.message ||
        'Member tidak valid.'
      )

    }

  }

  catch (error) {

    console.error(error)

    tampilPesan(
      'Gagal membuka gate.'
    )

  }

  finally {

    loading.value = false

  }

}


// =====================================================
// PEMBAYARAN NON MEMBER
// =====================================================

async function bayarNonMember() {

  if (
    !nomorPolisi.value.trim()
  ) {

    tampilPesan(
      'Nomor polisi wajib diisi.'
    )

    return

  }


  if (
    uangDibayar.value <
    totalBayar.value
  ) {

    tampilPesan(
      'Uang pembayaran belum cukup.'
    )

    return

  }


  loading.value = true


  try {

    const response =
      await fetch(
        `${API}/gate/non-member`,
        {
          method: 'POST',

          headers: {
            'Content-Type':
              'application/json',

            'Accept':
              'application/json'
          },

          body: JSON.stringify({

            kode_tiket:
              tiketData.value.tiket ||
              kodeScan.value,

            nomor_polisi:
              nomorPolisi.value
                .toUpperCase(),

            uang_dibayar:
              uangDibayar.value,

            total_bayar:
              totalBayar.value

          })
        }
      )


    const data =
      await response.json()


    if (
      response.ok &&
      data.success
    ) {

      /*
       * PEMBAYARAN BERHASIL
       *
       * Sekarang pindah ke halaman
       * pembayaran berhasil.
       */

      halaman.value =
        'pembayaran-berhasil'

    }

    else {

      tampilPesan(
        data.message ||
        'Pembayaran gagal.'
      )

    }

  }

  catch (error) {

    console.error(error)

    tampilPesan(
      'Gagal memproses pembayaran.'
    )

  }

  finally {

    loading.value = false

  }

}


// =====================================================
// PRINT TIKET
// =====================================================

function printTiket() {

  tampilPesan(
    'Fitur print tiket akan diproses.'
  )

}


// =====================================================
// KEMBALI KE AWAL
// =====================================================

async function kembaliAwal() {

  halaman.value =
    'awal'


  kodeScan.value = ''

  nomorPolisi.value = ''

  uangDibayar.value = 0

  memberData.value = {}

  tiketData.value = {}

  totalBayar.value = 3000


  await nextTick()


  scannerInput.value?.focus()

}


// =====================================================
// FOCUS SCANNER
// =====================================================

function fokusScanner() {

  if (
    halaman.value === 'awal'
  ) {

    scannerInput.value?.focus()

  }

}


// =====================================================
// MOUNTED
// =====================================================

onMounted(
  async () => {

    await nextTick()

    fokusScanner()

  }
)


// =====================================================
// BEFORE UNMOUNT
// =====================================================

onBeforeUnmount(() => {

  clearTimeout(timerPesan)

})

</script>