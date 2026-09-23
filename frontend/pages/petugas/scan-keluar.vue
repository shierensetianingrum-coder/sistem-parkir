<template>
  <div
    class="min-h-screen bg-gradient-to-br from-[#F0F7F3] via-white to-[#E8F3EC] font-sans"
  >
    <!-- HEADER -->
    <header
      class="sticky top-0 z-40 bg-white/90 backdrop-blur-xl border-b border-gray-200/70"
    >
      <div
        class="max-w-[1500px] mx-auto px-6 lg:px-10 h-20 flex items-center justify-between"
      >
        <div class="flex items-center gap-4">
          <button
            @click="navigateTo('/petugas')"
            class="group flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#0B2A1D] text-white hover:bg-[#166534] transition shadow-md"
          >
            <span class="text-lg group-hover:-translate-x-1 transition">
              ←
            </span>

            <span class="font-semibold">
              Dashboard
            </span>
          </button>

          <div class="hidden sm:block h-9 w-px bg-gray-200"></div>

          <div class="flex items-center gap-3">
            <div
              class="w-11 h-11 rounded-2xl bg-gradient-to-br from-[#0B2A1D] to-[#2E8B57] text-white flex items-center justify-center shadow-lg text-xl font-extrabold"
            >
              P
            </div>

            <div>
              <h1 class="font-extrabold text-gray-800">
                PARKIR PLAZA ANDALAS
              </h1>

              <p class="text-xs text-gray-500">
                Operasional Parkir
              </p>
            </div>
          </div>
        </div>

        <div class="flex items-center gap-3">
          <div
            class="hidden sm:flex items-center gap-2 px-4 py-2 rounded-full bg-red-50 border border-red-200"
          >
            <span
              class="w-2.5 h-2.5 rounded-full bg-red-500 animate-pulse"
            ></span>

            <span class="text-sm font-semibold text-red-700">
              Mode Scan Keluar
            </span>
          </div>

          <button
            @click="handleLogout"
            class="px-4 py-2.5 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 transition"
          >
            🚪 Logout
          </button>
        </div>
      </div>
    </header>

    <!-- MAIN -->
    <main class="max-w-[1500px] mx-auto px-6 lg:px-10 py-8">
      <!-- TITLE -->
      <div class="mb-8">
        <div
          class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-red-100 text-red-700 text-xs font-bold mb-4"
        >
          🔴 OPERASIONAL
        </div>

        <h1
          class="text-4xl lg:text-5xl font-extrabold text-[#0B2A1D]"
        >
          Scan Kendaraan Keluar
        </h1>

        <p class="text-gray-500 mt-3 text-lg">
          Periksa tiket kendaraan, cocokkan nomor polisi,
          hitung pembayaran, dan proses kendaraan keluar
          di PARKIR PLAZA ANDALAS.
        </p>
      </div>

      <!-- CONTENT -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-7">
        <!-- FORM -->
        <div
          class="lg:col-span-2 bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/50 p-7 lg:p-9"
        >
          <div class="flex items-center gap-4 mb-7">
            <div
              class="w-14 h-14 rounded-2xl bg-red-100 flex items-center justify-center text-2xl"
            >
              🔴
            </div>

            <div>
              <h2 class="text-2xl font-extrabold text-gray-800">
                Pemeriksaan Kendaraan
              </h2>

              <p class="text-gray-500 mt-1">
                Isi nomor polisi terlebih dahulu,
                lalu scan tiket atau kartu member.
              </p>
            </div>
          </div>

          <!-- ERROR -->
          <div
            v-if="errorMessage"
            class="mb-5 rounded-2xl border border-red-200 bg-red-50 p-4 text-red-700"
          >
            <div class="flex items-start gap-3">
              <span class="text-xl">⚠️</span>

              <div>
                <p class="font-bold">
                  Proses gagal
                </p>

                <p class="text-sm mt-1">
                  {{ errorMessage }}
                </p>
              </div>
            </div>
          </div>

          <!-- NOMOR POLISI -->
          <div
            class="mt-5 rounded-2xl border-2 border-dashed border-blue-300 bg-blue-50/50 p-4"
          >
            <div class="flex items-center gap-3 mb-3">
              <span class="text-xl">🚗</span>

              <div>
                <p class="font-bold text-blue-800">
                  Nomor Polisi Kendaraan
                </p>

                <p class="text-xs text-blue-600">
                  Wajib diisi sebelum melakukan scan
                </p>
              </div>
            </div>

            <input
              ref="platInput"
              v-model="nomorPolisi"
              @input="handlePlatInput"
              @keydown.enter.prevent="fokusScanner"
              type="text"
              placeholder="Contoh: B 1222 TC"
              autocomplete="off"
              class="w-full bg-white border-2 border-gray-200 rounded-2xl px-5 py-5 text-lg font-bold uppercase outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition"
            />
          </div>

          <!-- SCANNER -->
          <div
            class="mt-5 rounded-2xl border-2 border-dashed border-red-300 bg-red-50/50 p-4"
          >
            <div class="flex items-center gap-3 mb-3">
              <span class="text-xl">🎫</span>

              <div>
                <p class="font-bold text-red-800">
                  Scan Tiket / Kartu Member
                </p>

                <p class="text-xs text-red-600">
                  {{
                    nomorPolisi.trim()
                      ? 'Scanner siap digunakan'
                      : 'Isi nomor polisi terlebih dahulu'
                  }}
                </p>
              </div>
            </div>

            <input
              ref="scanner"
              v-model="kodeTiket"
              :disabled="!nomorPolisi.trim()"
              @keydown.enter.prevent="cekTiket"
              type="text"
              autocomplete="off"
              :placeholder="
                nomorPolisi.trim()
                  ? 'Scan kode tiket atau QR member...'
                  : '🔒 Isi nomor polisi terlebih dahulu...'
              "
              class="w-full bg-white border-2 border-gray-200 rounded-2xl px-5 py-5 text-lg font-semibold outline-none transition disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-not-allowed disabled:border-gray-300 focus:border-red-500 focus:ring-4 focus:ring-red-100"
            />
          </div>

          <!-- BUTTON CEK -->
          <button
            @click="cekTiket"
            :disabled="
              loading ||
              !nomorPolisi.trim() ||
              !kodeTiket.trim()
            "
            class="w-full mt-4 py-4 rounded-2xl bg-gradient-to-r from-[#0B2A1D] to-[#166534] hover:from-[#166534] hover:to-[#15803D] text-white font-extrabold text-lg shadow-lg shadow-green-200 transition disabled:opacity-40 disabled:cursor-not-allowed"
          >
            {{
              loading
                ? 'Memeriksa...'
                : !nomorPolisi.trim()
                  ? '🔒 Isi Nomor Polisi Dahulu'
                  : '🔍 Periksa Kendaraan'
            }}
          </button>

          <!-- ================= MEMBER ================= -->
          <div
            v-if="
              tiketDitemukan &&
              tiket.is_member &&
              !gateTerbuka
            "
            class="mt-7"
          >
            <div
              class="rounded-3xl bg-gradient-to-r from-green-50 to-white border border-green-200 p-6"
            >
              <div
                class="flex items-center justify-between gap-4 mb-6"
              >
                <div class="flex items-center gap-4">
                  <div
                    class="w-12 h-12 rounded-full bg-green-600 text-white flex items-center justify-center text-xl font-bold"
                  >
                    ✓
                  </div>

                  <div>
                    <h3
                      class="font-extrabold text-green-800 text-lg"
                    >
                      Member Terdeteksi
                    </h3>

                    <p class="text-sm text-green-600">
                      Data member dan kendaraan ditemukan.
                    </p>
                  </div>
                </div>

                <span
                  class="px-3 py-1.5 rounded-full bg-green-100 text-green-700 text-xs font-bold"
                >
                  MEMBER
                </span>
              </div>

              <div
                class="grid grid-cols-1 md:grid-cols-2 gap-4"
              >
                <div
                  class="bg-white rounded-2xl p-4 border border-gray-100"
                >
                  <p
                    class="text-xs text-gray-400 uppercase font-bold"
                  >
                    Kode Member
                  </p>

                  <p
                    class="font-extrabold text-gray-800 mt-1"
                  >
                    {{ tiket.kode_member || '-' }}
                  </p>
                </div>

                <div
                  class="bg-white rounded-2xl p-4 border border-gray-100"
                >
                  <p
                    class="text-xs text-gray-400 uppercase font-bold"
                  >
                    Nama Member
                  </p>

                  <p
                    class="font-extrabold text-gray-800 mt-1"
                  >
                    {{ tiket.nama_member || '-' }}
                  </p>
                </div>

                <div
                  class="bg-white rounded-2xl p-4 border border-gray-100"
                >
                  <p
                    class="text-xs text-gray-400 uppercase font-bold"
                  >
                    Nomor Polisi
                  </p>

                  <p
                    class="font-extrabold text-gray-800 mt-1 uppercase"
                  >
                    {{
                      tiket.nomor_polisi ||
                      nomorPolisi ||
                      '-'
                    }}
                  </p>
                </div>

                <div
                  class="bg-white rounded-2xl p-4 border border-gray-100"
                >
                  <p
                    class="text-xs text-gray-400 uppercase font-bold"
                  >
                    Berlaku Sampai
                  </p>

                  <p
                    class="font-extrabold text-gray-800 mt-1"
                  >
                    {{ tiket.tanggal_expired || '-' }}
                  </p>
                </div>
              </div>

              <div
                class="mt-6 p-6 rounded-3xl bg-[#0B2A1D] text-white"
              >
                <div
                  class="flex items-center justify-between"
                >
                  <div>
                    <p class="text-green-200 text-sm">
                      Total Pembayaran
                    </p>

                    <p
                      class="text-3xl font-extrabold mt-1"
                    >
                      Rp 0
                    </p>

                    <p
                      class="text-green-200 text-xs mt-1"
                    >
                      Member tidak dikenakan tarif parkir
                    </p>
                  </div>

                  <div class="text-5xl">
                    🎫
                  </div>
                </div>
              </div>

              <button
                @click="prosesMemberKeluar"
                :disabled="loading"
                class="w-full mt-6 py-4 rounded-2xl bg-gradient-to-r from-[#0B2A1D] to-[#166534] hover:from-[#166534] hover:to-[#15803D] text-white font-extrabold text-lg shadow-lg shadow-green-200 transition disabled:opacity-50"
              >
                {{
                  loading
                    ? 'Membuka Gate...'
                    : '🚧 Buka Gate Member'
                }}
              </button>
            </div>
          </div>

          <!-- ================= NON MEMBER ================= -->
          <div
            v-if="
              tiketDitemukan &&
              !tiket.is_member &&
              !gateTerbuka
            "
            class="mt-7"
          >
            <div
              class="rounded-3xl bg-gradient-to-r from-green-50 to-white border border-green-200 p-6"
            >
              <div
                class="flex items-center justify-between gap-4 mb-6"
              >
                <div class="flex items-center gap-4">
                  <div
                    class="w-12 h-12 rounded-full bg-green-600 text-white flex items-center justify-center text-xl font-bold"
                  >
                    ✓
                  </div>

                  <div>
                    <h3
                      class="font-extrabold text-green-800 text-lg"
                    >
                      Tiket Ditemukan
                    </h3>

                    <p class="text-sm text-green-600">
                      Tiket aktif ditemukan di database.
                    </p>
                  </div>
                </div>

                <span
                  class="px-3 py-1.5 rounded-full bg-green-100 text-green-700 text-xs font-bold"
                >
                  AKTIF
                </span>
              </div>

              <div
                class="grid grid-cols-1 md:grid-cols-2 gap-4"
              >
                <div
                  class="bg-white rounded-2xl p-4 border border-gray-100"
                >
                  <p
                    class="text-xs text-gray-400 uppercase font-bold"
                  >
                    Kode Tiket
                  </p>

                  <p
                    class="font-extrabold text-gray-800 mt-1"
                  >
                    {{ tiket.kode_tiket || '-' }}
                  </p>
                </div>

                <div
                  class="bg-white rounded-2xl p-4 border border-gray-100"
                >
                  <p
                    class="text-xs text-gray-400 uppercase font-bold"
                  >
                    Nomor Polisi
                  </p>

                  <p
                    class="font-extrabold text-gray-800 mt-1 uppercase"
                  >
                    {{
                      tiket.nomor_polisi ||
                      nomorPolisi ||
                      '-'
                    }}
                  </p>
                </div>

                <div
                  class="bg-white rounded-2xl p-4 border border-gray-100"
                >
                  <p
                    class="text-xs text-gray-400 uppercase font-bold"
                  >
                    Jenis Kendaraan
                  </p>

                  <p
                    class="font-extrabold text-gray-800 mt-1 capitalize"
                  >
                    {{ tiket.jenis_kendaraan || '-' }}
                  </p>
                </div>

                <div
                  class="bg-white rounded-2xl p-4 border border-gray-100"
                >
                  <p
                    class="text-xs text-gray-400 uppercase font-bold"
                  >
                    Jam Masuk
                  </p>

                  <p
                    class="font-extrabold text-gray-800 mt-1"
                  >
                    {{
                      formatTanggal(
                        tiket.waktu_masuk
                      )
                    }}
                  </p>
                </div>
              </div>

              <div
                class="mt-6 p-6 rounded-3xl bg-[#0B2A1D] text-white"
              >
                <div
                  class="flex items-center justify-between"
                >
                  <div>
                    <p
                      class="text-green-200 text-sm"
                    >
                      Total Pembayaran
                    </p>

                    <p
                      class="text-3xl font-extrabold mt-1"
                    >
                      {{ formatRupiah(totalBayar) }}
                    </p>
                  </div>

                  <div class="text-5xl">
                    💳
                  </div>
                </div>
              </div>
            </div>

            <!-- PEMBAYARAN -->
            <div
              class="mt-6 rounded-3xl border border-gray-200 bg-white p-6"
            >
              <h3
                class="font-extrabold text-gray-800 text-lg mb-5"
              >
                💳 Pembayaran
              </h3>

              <div class="mb-6">
                <p
                  class="text-sm font-bold text-gray-700 mb-3"
                >
                  Metode Pembayaran
                </p>

                <div
                  class="grid grid-cols-1 md:grid-cols-3 gap-3"
                >
                  <button
                    @click="
                      metodePembayaran = 'cash'
                    "
                    type="button"
                    class="p-4 rounded-2xl border-2 transition"
                    :class="
                      metodePembayaran === 'cash'
                        ? 'border-green-600 bg-green-50'
                        : 'border-gray-200 hover:border-green-300'
                    "
                  >
                    <div class="text-2xl mb-2">
                      💵
                    </div>

                    <p class="font-bold text-gray-800">
                      Cash
                    </p>

                    <p class="text-xs text-gray-500">
                      Tunai
                    </p>
                  </button>

                  <button
                    @click="
                      metodePembayaran = 'atm'
                    "
                    type="button"
                    class="p-4 rounded-2xl border-2 transition"
                    :class="
                      metodePembayaran === 'atm'
                        ? 'border-green-600 bg-green-50'
                        : 'border-gray-200 hover:border-green-300'
                    "
                  >
                    <div class="text-2xl mb-2">
                      💳
                    </div>

                    <p class="font-bold text-gray-800">
                      ATM
                    </p>

                    <p class="text-xs text-gray-500">
                      Kartu / Debit
                    </p>
                  </button>

                  <button
                    @click="
                      metodePembayaran = 'qris'
                    "
                    type="button"
                    class="p-4 rounded-2xl border-2 transition"
                    :class="
                      metodePembayaran === 'qris'
                        ? 'border-green-600 bg-green-50'
                        : 'border-gray-200 hover:border-green-300'
                    "
                  >
                    <div class="text-2xl mb-2">
                      📱
                    </div>

                    <p class="font-bold text-gray-800">
                      QRIS
                    </p>

                    <p class="text-xs text-gray-500">
                      Pembayaran digital
                    </p>
                  </button>
                </div>
              </div>

              <!-- CASH -->
              <div
                v-if="
                  metodePembayaran === 'cash'
                "
                class="rounded-2xl bg-gray-50 border border-gray-200 p-5"
              >
                <label
                  class="block text-sm font-bold text-gray-700 mb-2"
                >
                  Uang Dibayar
                </label>

                <input
                  v-model.number="uangDibayar"
                  type="number"
                  min="0"
                  placeholder="Masukkan jumlah uang..."
                  class="w-full border-2 border-gray-200 rounded-2xl px-5 py-4 text-lg font-bold focus:outline-none focus:border-green-600 focus:ring-4 focus:ring-green-100"
                />

                <div
                  class="mt-4 p-4 rounded-2xl bg-white border border-gray-200"
                >
                  <div
                    class="flex justify-between items-center"
                  >
                    <span
                      class="text-sm text-gray-500"
                    >
                      Kembalian
                    </span>

                    <span
                      class="text-xl font-extrabold"
                      :class="
                        Number(
                          uangDibayar || 0
                        ) >= totalBayar
                          ? 'text-green-600'
                          : 'text-red-600'
                      "
                    >
                      {{
                        formatRupiah(
                          kembalian
                        )
                      }}
                    </span>
                  </div>
                </div>
              </div>

              <!-- ATM / QRIS -->
              <div
                v-else
                class="rounded-2xl bg-green-50 border border-green-200 p-5"
              >
                <div class="flex gap-3">
                  <span class="text-2xl">
                    ✓
                  </span>

                  <div>
                    <p
                      class="font-bold text-green-800"
                    >
                      Pembayaran
                      {{
                        metodePembayaran.toUpperCase()
                      }}
                    </p>

                    <p
                      class="text-sm text-green-700 mt-1"
                    >
                      Pastikan pembayaran sudah diterima
                      sebelum membuka gate.
                    </p>
                  </div>
                </div>
              </div>

              <!-- PROSES -->
              <button
                @click="prosesPembayaran"
                :disabled="
                  loading ||
                  (
                    metodePembayaran === 'cash' &&
                    Number(uangDibayar || 0) <
                      totalBayar
                  )
                "
                class="w-full mt-6 py-4 rounded-2xl bg-gradient-to-r from-[#0B2A1D] to-[#166534] hover:from-[#166534] hover:to-[#15803D] text-white font-extrabold text-lg shadow-lg shadow-green-200 transition disabled:opacity-50 disabled:cursor-not-allowed"
              >
                {{
                  loading
                    ? 'Memproses...'
                    : '🚗 Bayar & Buka Gate'
                }}
              </button>
            </div>
          </div>

          <!-- SUCCESS -->
          <div
            v-if="gateTerbuka"
            class="mt-7 rounded-3xl border-2 border-green-300 bg-gradient-to-br from-green-50 via-white to-green-100 p-8 text-center"
          >
            <div
              class="mx-auto w-20 h-20 rounded-full bg-green-600 text-white flex items-center justify-center text-4xl shadow-xl"
            >
              ✓
            </div>

            <h2
              class="mt-5 text-3xl font-extrabold text-green-800"
            >
              Kendaraan Berhasil Keluar
            </h2>

            <p
              class="mt-2 text-green-700 font-semibold"
            >
              {{
                tiketTerakhir?.is_member
                  ? 'Member berhasil keluar.'
                  : 'Pembayaran berhasil.'
              }}
            </p>

            <div
              class="mt-5 inline-flex items-center gap-3 px-6 py-4 rounded-2xl bg-[#0B2A1D] text-white"
            >
              <span class="text-2xl">
                🚧
              </span>

              <span class="font-extrabold text-lg">
                GATE DIBUKA
              </span>
            </div>

            <div
              v-if="tiketTerakhir"
              class="mt-5 text-sm text-gray-600 space-y-1"
            >
              <p>
                Plat:
                <strong>
                  {{
                    tiketTerakhir.nomor_polisi ||
                    nomorPolisi ||
                    '-'
                  }}
                </strong>
              </p>

              <p>
                Total:
                <strong>
                  {{
                    formatRupiah(
                      tiketTerakhir.total || 0
                    )
                  }}
                </strong>
              </p>
            </div>

            <p class="text-sm text-gray-500 mt-5">
              Silakan kendaraan melanjutkan perjalanan.
            </p>

            <button
              @click="resetForm"
              class="mt-6 px-6 py-3 rounded-xl bg-[#0B2A1D] text-white font-bold hover:bg-[#166534] transition"
            >
              🔄 Scan Kendaraan Berikutnya
            </button>
          </div>
        </div>

        <!-- PANEL KANAN -->
        <div class="space-y-6">
          <!-- STATUS -->
          <div
            class="rounded-3xl p-7 bg-gradient-to-br from-[#071C13] via-[#0B2A1D] to-[#166534] text-white shadow-xl"
          >
            <div
              class="flex items-center justify-between"
            >
              <div>
                <p class="text-green-200 text-sm">
                  Status Sistem
                </p>

                <h2
                  class="text-3xl font-extrabold mt-2"
                >
                  {{
                    gateTerbuka
                      ? 'GATE TERBUKA'
                      : 'SIAP'
                  }}
                </h2>
              </div>

              <div
                class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center text-2xl"
              >
                {{
                  gateTerbuka
                    ? '🟢'
                    : '🔴'
                }}
              </div>
            </div>

            <div
              class="mt-6 pt-5 border-t border-white/10"
            >
              <div class="flex items-center gap-2">
                <span
                  class="w-3 h-3 rounded-full animate-pulse bg-green-400"
                ></span>

                <span
                  class="text-sm text-green-100"
                >
                  {{
                    gateTerbuka
                      ? 'Gate siap dilewati'
                      : nomorPolisi.trim()
                        ? 'Scanner siap digunakan'
                        : 'Menunggu nomor polisi'
                  }}
                </span>
              </div>
            </div>
          </div>

          <!-- ALUR -->
          <div
            class="bg-white rounded-3xl p-7 shadow-lg border border-gray-100"
          >
            <h3
              class="font-extrabold text-gray-800 text-lg mb-6"
            >
              📌 Alur Kendaraan Keluar
            </h3>

            <div class="space-y-5">
              <div class="flex gap-4">
                <div
                  class="w-9 h-9 rounded-full bg-red-100 text-red-700 flex items-center justify-center font-bold shrink-0"
                >
                  1
                </div>

                <div>
                  <p class="font-bold text-gray-800">
                    Input nomor plat
                  </p>

                  <p
                    class="text-xs text-gray-500 mt-1"
                  >
                    Wajib diisi terlebih dahulu.
                  </p>
                </div>
              </div>

              <div class="flex gap-4">
                <div
                  class="w-9 h-9 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold shrink-0"
                >
                  2
                </div>

                <div>
                  <p class="font-bold text-gray-800">
                    Scan tiket / member
                  </p>

                  <p
                    class="text-xs text-gray-500 mt-1"
                  >
                    Scanner aktif setelah nomor plat diisi.
                  </p>
                </div>
              </div>

              <div class="flex gap-4">
                <div
                  class="w-9 h-9 rounded-full bg-yellow-100 text-yellow-700 flex items-center justify-center font-bold shrink-0"
                >
                  3
                </div>

                <div>
                  <p class="font-bold text-gray-800">
                    Pembayaran
                  </p>

                  <p
                    class="text-xs text-gray-500 mt-1"
                  >
                    Member Rp0, non-member melakukan pembayaran.
                  </p>
                </div>
              </div>

              <div class="flex gap-4">
                <div
                  class="w-9 h-9 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-bold shrink-0"
                >
                  ✓
                </div>

                <div>
                  <p class="font-bold text-gray-800">
                    Gate dibuka
                  </p>

                  <p
                    class="text-xs text-gray-500 mt-1"
                  >
                    Status kendaraan berubah menjadi keluar.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- PERHATIAN -->
          <div
            class="bg-white rounded-3xl p-7 shadow-lg border border-gray-100"
          >
            <h3
              class="font-extrabold text-gray-800 mb-4"
            >
              💡 Perhatian
            </h3>

            <div
              class="space-y-3 text-sm text-gray-600"
            >
              <p>
                • Isi nomor plat sebelum melakukan scan.
              </p>

              <p>
                • Scanner tidak dapat digunakan sebelum plat diisi.
              </p>

              <p>
                • Pastikan kode tiket atau member benar.
              </p>

              <p>
                • Member tidak dikenakan tarif keluar.
              </p>

              <p>
                • Jangan proses tiket yang sudah keluar.
              </p>
            </div>
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
  nextTick,
  onMounted
} from 'vue'

const { $api } = useNuxtApp()

// =====================================================
// STATE
// =====================================================

const kodeTiket = ref('')
const nomorPolisi = ref('')

const loading = ref(false)
const tiketDitemukan = ref(false)
const gateTerbuka = ref(false)

const errorMessage = ref('')

const tiket = ref<any>({})
const tiketTerakhir = ref<any>(null)

const metodePembayaran =
  ref<'cash' | 'atm' | 'qris'>('cash')

const uangDibayar = ref<number>(0)

const scanner =
  ref<HTMLInputElement | null>(null)

const platInput =
  ref<HTMLInputElement | null>(null)

// =====================================================
// INPUT PLAT
// =====================================================

const handlePlatInput = () => {
  nomorPolisi.value =
    nomorPolisi.value.toUpperCase()

  errorMessage.value = ''

  kodeTiket.value = ''

  tiket.value = {}

  tiketDitemukan.value = false

  gateTerbuka.value = false

  tiketTerakhir.value = null
}

// =====================================================
// FOKUS SCANNER
// =====================================================

const fokusScanner = async () => {
  if (!nomorPolisi.value.trim()) {
    platInput.value?.focus()
    return
  }

  await nextTick()

  scanner.value?.focus()
}

// =====================================================
// TOTAL
// =====================================================

const totalBayar = computed(() => {
  if (tiket.value?.is_member) {
    return 0
  }

  if (tiket.value?.total !== undefined) {
    return Number(tiket.value.total)
  }

  if (tiket.value?.total_bayar !== undefined) {
    return Number(tiket.value.total_bayar)
  }

  if (tiket.value?.tarif !== undefined) {
    return Number(tiket.value.tarif)
  }

  const jenis =
    String(
      tiket.value?.jenis_kendaraan || ''
    ).toLowerCase()

  if (jenis === 'motor') {
    return 3000
  }

  if (jenis === 'mobil') {
    return 5000
  }

  return 0
})

// =====================================================
// KEMBALIAN
// =====================================================

const kembalian = computed(() => {
  const bayar =
    Number(uangDibayar.value || 0)

  const total =
    Number(totalBayar.value || 0)

  return Math.max(
    0,
    bayar - total
  )
})

// =====================================================
// RUPIAH
// =====================================================

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
  ).format(
    Number(angka || 0)
  )
}

// =====================================================
// TANGGAL
// =====================================================

const formatTanggal = (
  tanggal: any
) => {
  if (!tanggal) {
    return '-'
  }

  try {
    return new Intl.DateTimeFormat(
      'id-ID',
      {
        dateStyle: 'medium',
        timeStyle: 'short'
      }
    ).format(
      new Date(tanggal)
    )
  } catch {
    return String(tanggal)
  }
}

// =====================================================
// BERSIHKAN HASIL SCAN
//
// BISA MEMBACA:
// 1. UUID / TOKEN MEMBER
//    a36733d2-45ea-4132-93fe-34166c03e464
//
// 2. KODE MEMBER
//    MBR-XXXXXX
//
// 3. KODE TIKET
//    A12345
//
// 4. JSON DARI QR
// =====================================================

const bersihkanHasilScan = (
  raw: string
): string => {
  const text =
    String(raw || '')
      .trim()

  if (!text) {
    return ''
  }

  // ===================================================
  // JIKA HASIL SCAN BERUPA JSON
  // ===================================================

  try {
    const json =
      JSON.parse(text)

    if (
      json &&
      typeof json === 'object'
    ) {
      const kemungkinan = [
        json.token,
        json.member_token,
        json.kode_member,
        json.data?.token,
        json.data?.member_token,
        json.data?.kode_member,
        json.member?.token,
        json.member?.member_token,
        json.member?.kode_member,

        json.kode_tiket,
        json.data?.kode_tiket,
        json.ticket_code,
        json.data?.ticket_code,
        json.kode,
        json.data?.kode,
        json.qr_code,
        json.data?.qr_code
      ]

      for (
        const item of kemungkinan
      ) {
        if (
          item === null ||
          item === undefined
        ) {
          continue
        }

        const hasil =
          String(item).trim()

        if (hasil) {
          return hasil
        }
      }
    }
  } catch {
    // bukan JSON, lanjut
  }

  return text
}

// =====================================================
// CEK APAKAH TOKEN MEMBER
// =====================================================

const adalahTokenMember = (
  value: string
): boolean => {
  const text =
    String(value || '')
      .trim()

  if (!text) {
    return false
  }

  const upper =
    text.toUpperCase()

  // MBR-XXXX
  if (
    /^MBR-[A-Z0-9]+$/.test(
      upper
    )
  ) {
    return true
  }

  // UUID
  if (
    /^[0-9A-F]{8}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{12}$/i.test(
      text
    )
  ) {
    return true
  }

  return false
}

// =====================================================
// CEK APAKAH KODE TIKET NON MEMBER
// =====================================================

const adalahKodeTiket = (
  value: string
): boolean => {
  const text =
    String(value || '')
      .trim()
      .toUpperCase()

  return /^A[A-Z0-9]{5}$/.test(
    text
  )
}

// =====================================================
// AMBIL KODE TIKET
// =====================================================

const ambilKodeTiket = (
  raw: string
): string => {
  const text =
    String(raw || '').trim()

  if (!text) {
    return ''
  }

  // JSON
  try {
    const json =
      JSON.parse(text)

    if (
      json &&
      typeof json === 'object'
    ) {
      const kemungkinan = [
        json.kode_tiket,
        json.data?.kode_tiket,

        json.ticket_code,
        json.data?.ticket_code,

        json.kode,
        json.data?.kode,

        json.qr_code,
        json.data?.qr_code
      ]

      for (
        const item of kemungkinan
      ) {
        if (
          item === null ||
          item === undefined
        ) {
          continue
        }

        const hasil =
          String(item)
            .trim()
            .toUpperCase()

        if (
          /^A[A-Z0-9]{5}$/.test(
            hasil
          )
        ) {
          return hasil
        }
      }
    }
  } catch {
    // bukan JSON
  }

  // Label KODE TIKET
  const labelMatch =
    text.match(
      /KODE[\s_-]*TIKET[\s:=-]*(A[A-Z0-9]{5})/i
    )

  if (labelMatch?.[1]) {
    return labelMatch[1]
      .trim()
      .toUpperCase()
  }

  // A12345
  const genericMatch =
    text.match(
      /\bA[A-Z0-9]{5}\b/i
    )

  if (genericMatch?.[0]) {
    return genericMatch[0]
      .trim()
      .toUpperCase()
  }

  // tanpa spasi
  const tanpaSpasi =
    text
      .replace(/\s+/g, '')
      .toUpperCase()

  if (
    /^A[A-Z0-9]{5}$/.test(
      tanpaSpasi
    )
  ) {
    return tanpaSpasi
  }

  return ''
}

// =====================================================
// CARI DATA MEMBER
//
// PENTING:
// QR MEMBER KAMU BERISI UUID/TOKEN
// CONTOH:
// a36733d2-45ea-4132-93fe-34166c03e464
//
// Jadi jangan dipaksa menjadi MBR-XXXX.
// =====================================================

const cekMemberDariToken =
  async (
    token: string,
    plat: string
  ) => {
    let member: any = null

    let responseMember: any = null

    // =================================================
    // CARA 1
    // Endpoint yang dipakai saat scan member
    // =================================================

    try {
      responseMember =
        await $api.post(
          '/member/check',
          {
            token: token
          }
        )

      const body =
        responseMember?.data

      const berhasil =
        body?.success === true ||
        body?.status === true

      if (berhasil) {
        member =
          body?.data?.member ||
          body?.data ||
          body?.member ||
          null
      }
    } catch (error) {
      console.warn(
        'member/check gagal:',
        error
      )
    }

    // =================================================
    // CARA 2
    // Cadangan / endpoint gate
    // =================================================

    if (!member) {
      try {
        responseMember =
          await $api.post(
            '/gate/check-member',
            {
              token: token,
              kode_member: token
            }
          )

        const body =
          responseMember?.data

        const berhasil =
          body?.success === true ||
          body?.status === true

        if (berhasil) {
          member =
            body?.data?.member ||
            body?.data ||
            body?.member ||
            null
        }
      } catch (error) {
        console.warn(
          'gate/check-member gagal:',
          error
        )
      }
    }

    if (!member) {
      throw new Error(
        'Kartu member tidak ditemukan. Pastikan QR member masih terdaftar.'
      )
    }

    // =================================================
    // CARI TIKET AKTIF MEMBER
    // =================================================

    let tiketResponse: any

    try {
      tiketResponse =
        await $api.post(
          '/tiket/scan-keluar',
          {
            // kirim semua kemungkinan supaya
            // backend bisa memakai field yang sesuai
            token: token,

            kode_member:
              member.kode_member ||
              token,

            member_id:
              member.id,

            nomor_polisi:
              plat
          }
        )
    } catch (error: any) {
      throw new Error(
        error?.response?.data?.message ||
        'Member belum memiliki kendaraan yang sedang parkir.'
      )
    }

    const tiketData =
      tiketResponse?.data

    const berhasil =
      tiketData?.success === true ||
      tiketData?.status === true

    if (!berhasil) {
      throw new Error(
        tiketData?.message ||
        'Member tidak sedang berada di dalam parkir.'
      )
    }

    const tiketAktif =
      tiketData?.data?.tiket ||
      tiketData?.tiket ||
      tiketData?.data

    if (!tiketAktif) {
      throw new Error(
        'Tiket aktif member tidak ditemukan.'
      )
    }

    // =================================================
    // HASIL MEMBER
    // =================================================

    return {
      ...tiketAktif,

      is_member: true,

      member_id:
        member.id,

      kode_member:
        member.kode_member ||
        token,

      token_member:
        token,

      nama_member:
        member.nama_member ||
        member.nama ||
        '-',

      nama_perusahaan:
        member.nama_perusahaan ||
        '-',

      status_member:
        member.status ||
        'lunas',

      tanggal_expired:
        member.tanggal_expired ||
        member.tanggal_berlaku_sampai ||
        '-',

      nomor_polisi:
        tiketAktif.nomor_polisi ||
        plat,

      total: 0,

      total_bayar: 0
    }
  }

// =====================================================
// CEK TIKET / MEMBER
// =====================================================

const cekTiket = async () => {
  errorMessage.value = ''

  const plat =
    nomorPolisi.value
      .trim()
      .toUpperCase()

  if (!plat) {
    await nextTick()

    platInput.value?.focus()

    return
  }

  if (!kodeTiket.value.trim()) {
    await nextTick()

    scanner.value?.focus()

    return
  }

  const hasilScan =
    bersihkanHasilScan(
      kodeTiket.value
    )

  if (!hasilScan) {
    errorMessage.value =
      'Kode tiket atau kartu member tidak terbaca.'

    return
  }

  loading.value = true

  tiketDitemukan.value = false

  tiket.value = {}

  gateTerbuka.value = false

  tiketTerakhir.value = null

  try {
    // =================================================
    // CEK MEMBER
    //
    // TERMASUK:
    // MBR-XXXX
    // UUID TOKEN
    // =================================================

    if (
      adalahTokenMember(
        hasilScan
      )
    ) {
      console.log(
        'SCAN MEMBER:',
        hasilScan
      )

      const hasilMember =
        await cekMemberDariToken(
          hasilScan,
          plat
        )

      tiket.value =
        hasilMember

      // tampilkan token asli di input
      kodeTiket.value =
        hasilScan

      tiketDitemukan.value =
        true

      uangDibayar.value = 0

      metodePembayaran.value =
        'cash'

      return
    }

    // =================================================
    // NON MEMBER
    //
    // TETAP PAKAI A12345
    // =================================================

    const kodeNonMember =
      ambilKodeTiket(
        hasilScan
      )

    if (
      !kodeNonMember ||
      !adalahKodeTiket(
        kodeNonMember
      )
    ) {
      throw new Error(
        'Kode tiket atau kartu member tidak dikenali.'
      )
    }

    console.log(
      'SCAN TIKET NON MEMBER:',
      kodeNonMember
    )

    const response =
      await $api.post(
        '/tiket/scan-keluar',
        {
          kode_tiket:
            kodeNonMember,

          nomor_polisi:
            plat
        }
      )

    const data =
      response?.data

    const berhasil =
      data?.success === true ||
      data?.status === true

    if (!berhasil) {
      throw new Error(
        data?.message ||
        `Tiket ${kodeNonMember} tidak ditemukan.`
      )
    }

    const hasil =
      data?.data?.tiket ||
      data?.tiket ||
      data?.data

    if (!hasil) {
      throw new Error(
        'Data tiket tidak ditemukan.'
      )
    }

    let tarif =
      Number(
        data?.data?.total ??
        data?.data?.total_bayar ??
        hasil?.total ??
        hasil?.total_bayar ??
        hasil?.tarif ??
        0
      )

    if (!tarif) {
      const jenis =
        String(
          hasil?.jenis_kendaraan ||
          ''
        ).toLowerCase()

      if (
        jenis === 'motor'
      ) {
        tarif = 3000
      } else if (
        jenis === 'mobil'
      ) {
        tarif = 5000
      }
    }

    tiket.value = {
      ...hasil,

      is_member: false,

      kode_tiket:
        hasil.kode_tiket ||
        kodeNonMember,

      total: tarif,

      total_bayar: tarif,

      nomor_polisi:
        hasil.nomor_polisi ||
        plat
    }

    kodeTiket.value =
      hasil.kode_tiket ||
      kodeNonMember

    tiketDitemukan.value =
      true

    metodePembayaran.value =
      'cash'

    uangDibayar.value = 0

  } catch (error: any) {
    console.error(
      'ERROR CEK TIKET:',
      error
    )

    console.error(
      'RESPONSE:',
      error?.response?.data
    )

    errorMessage.value =
      error?.response?.data?.message ||
      error?.message ||
      'Terjadi kesalahan saat memeriksa tiket.'

    tiket.value = {}

    tiketDitemukan.value =
      false

  } finally {
    loading.value = false
  }
}

// =====================================================
// PROSES MEMBER KELUAR
// =====================================================

const prosesMemberKeluar =
  async () => {
    if (!tiket.value?.id) {
      errorMessage.value =
        'ID tiket member tidak ditemukan.'

      return
    }

    errorMessage.value = ''

    loading.value = true

    try {
      const response =
        await $api.post(
          `/tiket/${tiket.value.id}/keluar`,
          {
            nomor_polisi:
              nomorPolisi.value.trim(),

            metode_pembayaran:
              'member',

            jumlah_bayar: 0
          }
        )

      const berhasil =
        response?.data?.success === true ||
        response?.data?.status === true

      if (!berhasil) {
        throw new Error(
          response?.data?.message ||
          'Member tidak dapat keluar.'
        )
      }

      const tiketKeluar =
        response?.data?.data?.tiket ||
        response?.data?.tiket ||
        tiket.value

      tiketTerakhir.value = {
        ...tiketKeluar,

        is_member: true,

        total: 0
      }

      gateTerbuka.value =
        true

      tiketDitemukan.value =
        false

    } catch (error: any) {
      console.error(
        'ERROR MEMBER KELUAR:',
        error
      )

      console.error(
        'RESPONSE:',
        error?.response?.data
      )

      errorMessage.value =
        error?.response?.data?.message ||
        error?.message ||
        'Member tidak dapat keluar.'

    } finally {
      loading.value = false
    }
  }

// =====================================================
// PEMBAYARAN NON MEMBER
// =====================================================

const prosesPembayaran =
  async () => {
    if (!tiketDitemukan.value) {
      return
    }

    // Member
    if (tiket.value?.is_member) {
      await prosesMemberKeluar()

      return
    }

    // Cash kurang
    if (
      metodePembayaran.value === 'cash' &&
      Number(uangDibayar.value || 0) <
        totalBayar.value
    ) {
      errorMessage.value =
        `Uang pembayaran kurang. Total yang harus dibayar ${formatRupiah(totalBayar.value)}.`

      return
    }

    const tiketId =
      tiket.value?.id

    if (!tiketId) {
      errorMessage.value =
        'ID tiket tidak ditemukan.'

      return
    }

    errorMessage.value = ''

    loading.value = true

    try {
      const response =
        await $api.post(
          `/tiket/${tiketId}/keluar`,
          {
            nomor_polisi:
              nomorPolisi.value.trim(),

            metode_pembayaran:
              metodePembayaran.value,

            jumlah_bayar:
              Number(
                uangDibayar.value || 0
              )
          }
        )

      const berhasil =
        response?.data?.success === true ||
        response?.data?.status === true

      if (!berhasil) {
        throw new Error(
          response?.data?.message ||
          'Kendaraan tidak dapat keluar.'
        )
      }

      const tiketKeluar =
        response?.data?.data?.tiket ||
        response?.data?.tiket ||
        tiket.value

      const totalKeluar =
        Number(
          response?.data?.data?.total ??
          response?.data?.data?.total_bayar ??
          totalBayar.value
        )

      tiketTerakhir.value = {
        ...tiketKeluar,

        is_member: false,

        total:
          totalKeluar
      }

      gateTerbuka.value =
        true

      tiketDitemukan.value =
        false

    } catch (error: any) {
      console.error(
        'ERROR KELUAR:',
        error
      )

      console.error(
        'RESPONSE:',
        error?.response?.data
      )

      errorMessage.value =
        error?.response?.data?.message ||
        error?.message ||
        'Kendaraan tidak dapat keluar.'

    } finally {
      loading.value = false
    }
  }

// =====================================================
// RESET
// =====================================================

const resetForm =
  async () => {
    kodeTiket.value = ''

    nomorPolisi.value = ''

    tiket.value = {}

    tiketTerakhir.value = null

    tiketDitemukan.value =
      false

    gateTerbuka.value =
      false

    errorMessage.value = ''

    uangDibayar.value = 0

    metodePembayaran.value =
      'cash'

    await nextTick()

    platInput.value?.focus()
  }

// =====================================================
// LOGOUT
// =====================================================

const handleLogout = () => {
  localStorage.removeItem('role')

  localStorage.removeItem('email')

  navigateTo('/')
}

// =====================================================
// MOUNTED
// =====================================================

onMounted(async () => {
  const role =
    localStorage.getItem('role')

  if (role !== 'petugas') {
    await navigateTo('/')

    return
  }

  await nextTick()

  setTimeout(() => {
    platInput.value?.focus()
  }, 300)
})
</script>