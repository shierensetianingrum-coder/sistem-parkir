<template>

  <div class="min-h-screen flex items-center justify-center relative overflow-hidden">

    <!-- BACKGROUND -->
    <div
      class="absolute inset-0 bg-linear-to-br from-green-700 to-green-900"
    ></div>

    <div class="absolute inset-0 bg-blue-900/40"></div>


    <!-- CARD -->
    <div
      class="
        relative z-10
        w-105
        min-h-162.5
        bg-white/40
        backdrop-blur-md
        rounded-3xl
        shadow-2xl
        flex
        flex-col
        items-center
        pt-14
        pb-8
      "
    >

      <!-- JUDUL -->
      <h1
        class="
          text-white
          text-3xl
          font-bold
          text-center
          drop-shadow-lg
        "
      >
        PARKIR<br>
        PLAZA ANDALAS
      </h1>


      <!-- INFORMASI TIKET -->
      <p
        class="
          mt-8
          text-gray-700
          text-sm
          text-center
          font-semibold
        "
      >
        Pilih jenis kendaraan untuk<br>
        mengambil tiket
      </p>


      <!-- PILIH JENIS KENDARAAN -->
      <div class="mt-4 flex gap-3">

        <!-- MOTOR -->
        <button
          type="button"
          @click="printTicket('motor')"
          :disabled="loadingPrint"
          class="
            w-28
            rounded-xl
            bg-white/80
            shadow-md
            px-3
            py-3
            text-center
            hover:bg-green-100
            hover:ring-2
            hover:ring-green-500
            active:scale-95
            transition
            disabled:opacity-50
          "
        >

          <p class="text-xs text-gray-600 font-semibold">
            🏍️ MOTOR
          </p>

          <p class="text-green-800 font-bold">
            Rp3.000
          </p>

          <p class="text-[10px] text-gray-500 mt-1">
            Klik pilih
          </p>

        </button>


        <!-- MOBIL -->
        <button
          type="button"
          @click="printTicket('mobil')"
          :disabled="loadingPrint"
          class="
            w-28
            rounded-xl
            bg-white/80
            shadow-md
            px-3
            py-3
            text-center
            hover:bg-blue-100
            hover:ring-2
            hover:ring-blue-500
            active:scale-95
            transition
            disabled:opacity-50
          "
        >

          <p class="text-xs text-gray-600 font-semibold">
            🚗 MOBIL
          </p>

          <p class="text-blue-800 font-bold">
            Rp5.000
          </p>

          <p class="text-[10px] text-gray-500 mt-1">
            Klik pilih
          </p>

        </button>

      </div>


      <!-- STATUS PRINT -->
      <p
        v-if="loadingPrint"
        class="
          mt-3
          text-xs
          text-gray-600
          font-semibold
        "
      >
        Membuat tiket...
      </p>


      <!-- GARIS PEMISAH -->
      <div
        class="
          w-44
          border-t-2
          border-black
          mt-8
        "
      ></div>


      <!-- INFORMASI SCAN MEMBER -->
      <p
        class="
          mt-8
          text-gray-700
          text-sm
          text-center
          font-semibold
        "
      >
        Scan kartu Member Untuk<br>
        Buka Pintu
      </p>


      <!-- INPUT SCAN KARTU -->
      <input
        ref="scanInput"
        v-model="scanCard"
        autofocus
        type="text"
        placeholder="Scan kartu..."
        class="
          mt-5
          w-44
          h-14
          rounded-xl
          bg-white
          text-center
          text-xl
          shadow-lg
          outline-none
          focus:ring-2
          focus:ring-green-600
        "
        @keyup.enter="openGate"
      />


      <!-- HASIL TIKET -->
      <div
        v-if="tiket"
        class="
          mt-5
          w-64
          rounded-2xl
          bg-white/90
          shadow-lg
          p-4
          text-center
        "
      >

        <!-- JUDUL HASIL -->
        <p
          class="
            text-green-700
            font-bold
            text-base
          "
        >
          ✓ Tiket berhasil dibuat
        </p>


        <!-- LABEL KODE -->
        <p
          class="
            mt-2
            text-xs
            text-gray-500
          "
        >
          Kode Tiket
        </p>


        <!-- KODE TIKET -->
        <p
          class="
            text-2xl
            font-bold
            text-green-900
          "
        >
          {{ tiket.kode_tiket }}
        </p>


        <!-- JENIS KENDARAAN -->
        <p
          v-if="tiket.jenis_kendaraan"
          class="
            mt-2
            text-sm
            font-semibold
            text-gray-700
          "
        >
          {{
            tiket.jenis_kendaraan === "motor"
              ? "🏍️ Motor"
              : tiket.jenis_kendaraan === "mobil"
                ? "🚗 Mobil"
                : "Member"
          }}
        </p>


        <!-- TARIF -->
        <p
          v-if="tiket.jenis_kendaraan !== 'member'"
          class="
            mt-1
            text-sm
            font-bold
            text-green-700
          "
        >
          Tarif:
          Rp{{
            Number(tiket.tarif || 0).toLocaleString("id-ID")
          }}
        </p>


        <!-- INFO KELUAR -->
        <p
          class="
            mt-2
            text-xs
            text-gray-500
          "
        >
          Gunakan tiket ini saat keluar.
        </p>

      </div>


      <!-- BUTTON KEMBALI -->
      <button
        type="button"
        @click="router.push('/')"
        class="
          mt-6
          w-44
          h-11
          rounded-full
          bg-gray-600
          text-white
          font-bold
          shadow-lg
          hover:bg-gray-700
          transition
        "
      >
        ← Kembali
      </button>

    </div>

  </div>

</template>


<script setup lang="ts">

import {
  ref,
  nextTick
} from "vue";

import jsPDF from "jspdf";

import QRCode from "qrcode";


const router = useRouter();

const { $api } = useNuxtApp() as any;


// =====================================================
// STATE
// =====================================================

const scanCard = ref("");

const tiket = ref<any>(null);

const scanInput =
  ref<HTMLInputElement | null>(null);


// =====================================================
// PRINT
// =====================================================

const loadingPrint =
  ref(false);


// =====================================================
// BUAT TIKET NON MEMBER
// =====================================================

const buatTiket = async (
  jenisKendaraan: "motor" | "mobil"
) => {

  try {

    const response =
      await $api.post(
        "/tiket",
        {
          jenis_kendaraan:
            jenisKendaraan
        }
      );


    tiket.value =
      response.data.data;


    return tiket.value;

  } catch (error: any) {

    console.log(
      "Gagal membuat tiket:",
      error
    );


    const message =
      error?.response?.data?.message ||
      "Gagal membuat tiket.";


    alert(message);


    return null;

  }

};


// =====================================================
// PRINT TIKET NON MEMBER
// =====================================================

const printTicket = async (
  jenisKendaraan: "motor" | "mobil"
) => {

  if (loadingPrint.value) {
    return;
  }


  loadingPrint.value = true;


  try {

    // =================================================
    // BUAT TIKET
    // =================================================

    const data =
      await buatTiket(
        jenisKendaraan
      );


    if (!data) {
      return;
    }


    // =================================================
    // NOMOR TIKET
    // =================================================

    const nomorTiket =
      data.kode_tiket;


    // =================================================
    // TARIF
    // =================================================

    const tarif =
      jenisKendaraan === "motor"
        ? 3000
        : 5000;


    // =================================================
    // QR CODE
    // =================================================

    const qrData = `
PARKIR PLAZA ANDALAS

Kode Tiket : ${nomorTiket}

Jenis Kendaraan : ${
      jenisKendaraan === "motor"
        ? "Motor"
        : "Mobil"
    }

Tarif : Rp${tarif.toLocaleString("id-ID")}

Waktu Masuk : ${
      data.waktu_masuk || "-"
    }

Status : ${
      data.status || "masuk"
    }
`;


    const qrImage =
      await QRCode.toDataURL(
        qrData
      );


    // =================================================
    // PDF
    // =================================================

    const pdf =
      new jsPDF({
        orientation: "portrait",
        unit: "mm",
        format: [80, 140],
      });


    // =================================================
    // JUDUL
    // =================================================

    pdf.setFontSize(12);

    pdf.text(
      "PARKIR",
      40,
      12,
      {
        align: "center",
      }
    );


    pdf.text(
      "PLAZA ANDALAS",
      40,
      20,
      {
        align: "center",
      }
    );


    // =================================================
    // ALAMAT
    // =================================================

    pdf.setFontSize(7);

    pdf.text(
      "Jl. Dr. KRT Radjiman Widyodiningrat",
      40,
      30,
      {
        align: "center",
      }
    );


    pdf.text(
      "Jakarta Timur",
      40,
      35,
      {
        align: "center",
      }
    );


    // =================================================
    // QR CODE
    // =================================================

    pdf.addImage(
      qrImage,
      "PNG",
      25,
      45,
      30,
      30
    );


    // =================================================
    // KODE TIKET
    // =================================================

    pdf.setFontSize(16);

    pdf.text(
      nomorTiket,
      40,
      85,
      {
        align: "center",
      }
    );


    // =================================================
    // INFORMASI
    // =================================================

    pdf.setFontSize(8);

    pdf.text(
      `
Informasi :

Kendaraan : ${
        jenisKendaraan === "motor"
          ? "Motor"
          : "Mobil"
      }

Tarif : Rp${
        tarif.toLocaleString("id-ID")
      }

Member
Rp. 150.000 / bulan

Terima Kasih
`,
      40,
      100,
      {
        align: "center",
      }
    );


    // =================================================
    // SIMPAN PDF
    // =================================================

    pdf.save(
      `Tiket-${nomorTiket}.pdf`
    );


  } catch (error) {

    console.log(
      "Gagal print:",
      error
    );


    alert(
      "Gagal mencetak tiket."
    );

  } finally {

    loadingPrint.value = false;

  }

};


// =====================================================
// SCAN KARTU MEMBER
// =====================================================

const openGate = async () => {

  if (!scanCard.value) {
    return;
  }


  // ===================================================
  // BERSIHKAN KODE MEMBER
  // ===================================================

  const kodeMember =
    scanCard.value
      .trim()
      .toUpperCase();


  try {

    // =================================================
    // CEK MEMBER
    // =================================================

    const response =
      await $api.post(
        "/gate/check-member",
        {
          kode_member:
            kodeMember,
        }
      );


    const data =
      response.data;


    // =================================================
    // KODE BUKAN MEMBER
    // =================================================

    if (
      data.type ===
      "non-member"
    ) {

      alert(
        data.message ||
        "Kartu tidak terdaftar sebagai member."
      );


      scanCard.value =
        "";


      await nextTick();


      scanInput.value?.focus();


      return;
    }


    // =================================================
    // MEMBER EXPIRED / BELUM LUNAS / ERROR
    // =================================================

    if (!data.success) {

      alert(
        data.message ||
        "Member tidak dapat masuk."
      );


      scanCard.value =
        "";


      await nextTick();


      scanInput.value?.focus();


      return;
    }


    // =================================================
    // MEMBER VALID
    // =================================================

    const member =
      data.data;


    if (!member) {

      alert(
        "Data member tidak ditemukan."
      );


      scanCard.value =
        "";


      await nextTick();


      scanInput.value?.focus();


      return;
    }


    // =================================================
    // BUAT TIKET MEMBER
    // =================================================

    const tiketResponse =
      await $api.post(
        "/gate/member",
        {
          member_id:
            member.id,

          nomor_polisi:
            "",
        }
      );


    const tiketData =
      tiketResponse.data;


    // =================================================
    // GAGAL BUAT TIKET
    // =================================================

    if (!tiketData.success) {

      alert(
        tiketData.message ||
        "Member tidak dapat masuk."
      );


      scanCard.value =
        "";


      await nextTick();


      scanInput.value?.focus();


      return;
    }


    // =================================================
    // SIMPAN TIKET MEMBER
    // =================================================

    tiket.value =
      tiketData.tiket ||
      tiketData.data;


    // =================================================
    // PINTU TERBUKA
    // =================================================

    alert(
      "Member terdeteksi.\nPintu terbuka."
    );


    // =================================================
    // KOSONGKAN INPUT
    // =================================================

    scanCard.value =
      "";


    await nextTick();


    scanInput.value?.focus();


  } catch (error: any) {

    console.log(
      "Gagal scan member:",
      error
    );


    // =================================================
    // AMBIL PESAN DARI BACKEND
    // =================================================

    const message =
      error?.response?.data?.message ||
      "Gagal memproses kartu member.";


    alert(
      message
    );


    scanCard.value =
      "";


    await nextTick();


    scanInput.value?.focus();

  }

};

</script>