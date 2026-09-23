<template>
  <div
    class="min-h-screen flex items-center justify-center relative overflow-hidden"
  >
    <!-- BACKGROUND -->
    <div
      class="absolute inset-0 bg-gradient-to-br from-[#0B6B63] via-[#0A5E58] to-[#06443F]"
    ></div>

    <div
      class="absolute inset-0 bg-black/10"
    ></div>

    <!-- CARD -->
    <div
      class="
        relative
        z-10
        w-[455px]
        min-h-[730px]
        bg-white/45
        backdrop-blur-md
        rounded-[28px]
        shadow-2xl
        flex
        flex-col
        items-center
        pt-14
        pb-8
      "
    >

      <!-- =====================================================
           HEADER
      ====================================================== -->

      <h1
        class="
          text-white
          text-[34px]
          leading-tight
          font-bold
          text-center
          drop-shadow-lg
        "
      >
        PARKIR<br />
        PLAZA ANDALAS
      </h1>


      <!-- =====================================================
           PILIH KENDARAAN
      ====================================================== -->

      <p
        class="
          mt-8
          text-gray-700
          text-[15px]
          text-center
          font-semibold
        "
      >
        Pilih jenis kendaraan untuk<br />
        mengambil tiket
      </p>


      <div
        class="
          mt-5
          flex
          gap-3
        "
      >

        <!-- MOTOR -->

        <button
          type="button"
          @click="printTicket('motor')"
          :disabled="loadingPrint"
          class="
            w-[120px]
            h-[90px]
            rounded-xl
            bg-white/90
            shadow-md
            flex
            flex-col
            items-center
            justify-center
            hover:bg-green-100
            hover:ring-2
            hover:ring-green-500
            active:scale-95
            transition
            disabled:opacity-50
            disabled:cursor-not-allowed
          "
        >
          <span
            class="
              text-[13px]
              text-gray-600
              font-semibold
            "
          >
            🏍️ MOTOR
          </span>

          <span
            class="
              text-green-700
              text-[17px]
              font-bold
            "
          >
            Rp3.000
          </span>

          <span
            class="
              text-[11px]
              text-gray-500
            "
          >
            Klik pilih
          </span>
        </button>


        <!-- MOBIL -->

        <button
          type="button"
          @click="printTicket('mobil')"
          :disabled="loadingPrint"
          class="
            w-[120px]
            h-[90px]
            rounded-xl
            bg-white/90
            shadow-md
            flex
            flex-col
            items-center
            justify-center
            hover:bg-blue-100
            hover:ring-2
            hover:ring-blue-500
            active:scale-95
            transition
            disabled:opacity-50
            disabled:cursor-not-allowed
          "
        >
          <span
            class="
              text-[13px]
              text-gray-600
              font-semibold
            "
          >
            🚗 MOBIL
          </span>

          <span
            class="
              text-blue-700
              text-[17px]
              font-bold
            "
          >
            Rp5.000
          </span>

          <span
            class="
              text-[11px]
              text-gray-500
            "
          >
            Klik pilih
          </span>
        </button>

      </div>


      <!-- LOADING PRINT -->

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


      <!-- GARIS -->

      <div
        class="
          w-[190px]
          border-t-2
          border-black
          mt-8
        "
      ></div>


      <!-- =====================================================
           SCAN
      ====================================================== -->

      <p
        class="
          mt-8
          text-gray-700
          text-[15px]
          text-center
          font-semibold
        "
      >
        Scan Kartu Member / Tiket<br />
        Untuk Buka Pintu
      </p>


      <!-- INPUT SCANNER -->

      <input
        ref="scanInput"
        v-model="scanCard"
        autofocus
        type="text"
        autocomplete="off"
        spellcheck="false"
        placeholder="Scan / ketik kode..."
        class="
          mt-5
          w-[260px]
          h-[60px]
          rounded-xl
          bg-white
          text-gray-800
          text-[18px]
          text-center
          shadow-lg
          outline-none
          border-2
          border-transparent
          focus:border-green-500
          focus:ring-2
          focus:ring-green-200
        "
        @keydown.enter.prevent="openGate"
      />


      <!-- PETUNJUK -->

      <p
        class="
          mt-2
          text-[12px]
          text-gray-600
          text-center
        "
      >
        Member: MBR-XXXXXX atau QR Member
      </p>

      <p
        class="
          text-[12px]
          text-gray-600
          text-center
        "
      >
        Tiket: AXXXXX
      </p>


      <!-- =====================================================
           HASIL
      ====================================================== -->

      <div
        v-if="tiket"
        class="
          mt-5
          w-[280px]
          rounded-2xl
          bg-white/95
          shadow-xl
          p-4
          text-center
        "
      >

        <!-- MEMBER -->

        <template
          v-if="tiket.jenis_kendaraan === 'member'"
        >

          <p
            class="
              text-green-700
              font-bold
              text-base
            "
          >
            ✓ Member terdeteksi
          </p>


          <p
            class="
              mt-3
              text-xs
              text-gray-500
            "
          >
            Kode Member
          </p>


          <p
            class="
              text-lg
              font-bold
              text-green-900
              break-all
            "
          >
            {{ tiket.kode_member }}
          </p>


          <p
            v-if="tiket.nama_member"
            class="
              mt-2
              text-sm
              font-semibold
              text-gray-700
            "
          >
            {{ tiket.nama_member }}
          </p>


          <p
            v-if="tiket.nama_perusahaan && tiket.nama_perusahaan !== '-'"
            class="
              text-xs
              text-gray-500
            "
          >
            {{ tiket.nama_perusahaan }}
          </p>


          <div
            class="
              mt-3
              border-t
              border-gray-200
              pt-3
            "
          >

            <p
              class="
                text-xs
                text-gray-500
              "
            >
              Tarif Parkir
            </p>

            <p
              class="
                text-xl
                font-bold
                text-green-700
              "
            >
              Rp0
            </p>

            <p
              class="
                mt-1
                text-[11px]
                text-gray-500
              "
            >
              Member tidak dikenakan tarif parkir
            </p>

          </div>

        </template>


        <!-- NON MEMBER -->

        <template
          v-else
        >

          <p
            class="
              text-green-700
              font-bold
              text-base
            "
          >
            ✓ Tiket terdeteksi
          </p>


          <p
            class="
              mt-2
              text-xs
              text-gray-500
            "
          >
            Kode Tiket
          </p>


          <p
            class="
              text-2xl
              font-bold
              text-green-900
            "
          >
            {{ tiket.kode_tiket }}
          </p>


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
                  : tiket.jenis_kendaraan
            }}
          </p>


          <p
            v-if="tiket.tarif !== undefined"
            class="
              mt-2
              text-sm
              font-bold
              text-green-700
            "
          >
            Tarif:
            Rp{{
              Number(
                tiket.tarif || 0
              ).toLocaleString("id-ID")
            }}
          </p>

        </template>


        <!-- INFO -->

        <p
          class="
            mt-3
            text-[11px]
            text-gray-500
          "
        >
          Pintu terbuka.
        </p>

      </div>


      <!-- KEMBALI -->

      <button
        type="button"
        @click="router.push('/')"
        class="
          mt-6
          w-[190px]
          h-[48px]
          rounded-full
          bg-gray-600
          text-white
          font-bold
          shadow-lg
          hover:bg-gray-700
          active:scale-95
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
  nextTick,
  onMounted,
  onBeforeUnmount,
} from "vue";

import jsPDF from "jspdf";

import QRCode from "qrcode";


/* =====================================================
   ROUTER & API
===================================================== */

const router = useRouter();

const { $api } = useNuxtApp() as any;


/* =====================================================
   STATE
===================================================== */

const scanCard = ref("");

const tiket = ref<any>(null);

const scanInput =
  ref<HTMLInputElement | null>(null);

const loadingPrint = ref(false);

let sedangScan = false;


/* =====================================================
   FOKUS INPUT
===================================================== */

const fokusScanner = async () => {

  await nextTick();

  scanInput.value?.focus();

};


/* =====================================================
   BERSIHKAN KODE MEMBER
   SUPPORT:

   1. MBR-XXXXXX

   2. TOKEN QR:
      a-4132-93fe-34166c03e464

   3. JSON QR
===================================================== */

const bersihkanKodeMember = (
  value: string
) => {

  const raw =
    String(value || "").trim();


  if (!raw) {
    return "";
  }


  /* =================================================
     JSON
  ================================================== */

  try {

    const json =
      JSON.parse(raw);


    const kemungkinan = [

      json?.kode_member,

      json?.data?.kode_member,

      json?.member?.kode_member,

      json?.token,

      json?.data?.token,

      json?.qr_code,

      json?.data?.qr_code,

      json?.kode,

      json?.data?.kode,

    ];


    for (
      const item of kemungkinan
    ) {

      if (
        item === null ||
        item === undefined
      ) {
        continue;
      }


      const kode =
        String(item)
          .trim()
          .replace(
            /[\r\n\t]/g,
            ""
          );


      if (kode) {
        return kode;
      }

    }

  } catch {
    // Bukan JSON.
  }


  /* =================================================
     BERSIHKAN
  ================================================== */

  const hasil =
    raw
      .replace(
        /[\r\n\t]/g,
        ""
      )
      .trim();


  /* =================================================
     MBR-XXXXXX
  ================================================== */

  const mbr =
    hasil.match(
      /MBR-[A-Z0-9]+/i
    );


  if (mbr?.[0]) {

    return mbr[0]
      .toUpperCase()
      .trim();

  }


  /* =================================================
     TOKEN QR MEMBER

     CONTOH:
     a-4132-93fe-34166c03e464
  ================================================== */

  const token =
    hasil.match(
      /^[a-z0-9]+-[a-z0-9]+-[a-z0-9]+-[a-z0-9]+-[a-z0-9]+$/i
    );


  if (token?.[0]) {

    return token[0]
      .trim();

  }


  /*
   * Kalau format token lebih panjang/
   * sedikit berbeda, tetap ambil
   * pola yang mirip token.
   */

  const tokenDalamTeks =
    hasil.match(
      /\b[a-z0-9]+-[a-z0-9]+-[a-z0-9]+-[a-z0-9]+-[a-z0-9]+\b/i
    );


  if (tokenDalamTeks?.[0]) {

    return tokenDalamTeks[0]
      .trim();

  }


  return "";

};


/* =====================================================
   BERSIHKAN KODE TIKET
===================================================== */

const bersihkanKodeTiket = (
  value: string
) => {

  let hasil =
    String(value || "")
      .toUpperCase()
      .trim();


  if (!hasil) {
    return "";
  }


  /* =================================================
     JSON
  ================================================== */

  try {

    const json =
      JSON.parse(hasil);


    const kemungkinan = [

      json?.kode_tiket,

      json?.data?.kode_tiket,

      json?.ticket_code,

      json?.data?.ticket_code,

      json?.kode,

      json?.data?.kode,

      json?.qr_code,

      json?.data?.qr_code,

    ];


    for (
      const item of kemungkinan
    ) {

      if (
        item === null ||
        item === undefined
      ) {
        continue;
      }


      const kode =
        String(item)
          .trim()
          .toUpperCase()
          .replace(
            /[\r\n\t\s]/g,
            ""
          );


      if (
        /^A[A-Z0-9]{5}$/.test(
          kode
        )
      ) {

        return kode;

      }

    }

  } catch {
    // Bukan JSON.
  }


  /* =================================================
     LABEL KODE TIKET
  ================================================== */

  const kodeDenganLabel =
    hasil.match(
      /KODE\s*TIKET\s*[:=-]?\s*(A[A-Z0-9]{5})/i
    );


  if (
    kodeDenganLabel?.[1]
  ) {

    return kodeDenganLabel[1]
      .toUpperCase()
      .trim();

  }


  /* =================================================
     HAPUS SPASI
  ================================================== */

  const tanpaSpasi =
    hasil.replace(
      /[\s\r\n\t]/g,
      ""
    );


  /* =================================================
     KODE LANGSUNG
  ================================================== */

  const kodeLangsung =
    tanpaSpasi.match(
      /^A[A-Z0-9]{5}$/i
    );


  if (
    kodeLangsung?.[0]
  ) {

    return kodeLangsung[0]
      .toUpperCase()
      .trim();

  }


  /* =================================================
     CARI KODE DI DALAM TEKS
  ================================================== */

  const kodeDiDalamTeks =
    hasil.match(
      /\bA[A-Z0-9]{5}\b/i
    );


  if (
    kodeDiDalamTeks?.[0]
  ) {

    return kodeDiDalamTeks[0]
      .toUpperCase()
      .trim();

  }


  return "";

};


/* =====================================================
   CEK TIKET NON MEMBER
===================================================== */

const adalahTiketNonMember = (
  value: string
) => {

  const hasil =
    String(value || "")
      .toUpperCase()
      .trim();


  /*
   * Kalau ada MBR,
   * jangan dianggap tiket.
   */

  if (
    /MBR-[A-Z0-9]+/i.test(
      hasil
    )
  ) {

    return false;

  }


  const kode =
    bersihkanKodeTiket(
      hasil
    );


  return /^A[A-Z0-9]{5}$/.test(
    kode
  );

};


/* =====================================================
   BUAT TIKET NON MEMBER
===================================================== */

const buatTiket = async (
  jenisKendaraan:
    "motor" | "mobil"
) => {

  try {

    console.log(
      "MEMBUAT TIKET:",
      jenisKendaraan
    );


    const response =
      await $api.post(
        "/tiket",
        {
          jenis_kendaraan:
            jenisKendaraan,
        }
      );


    console.log(
      "HASIL BUAT TIKET:",
      response.data
    );


    const dataTiket =
      response?.data?.data?.tiket ||
      response?.data?.tiket ||
      response?.data?.data;


    if (!dataTiket) {

      console.error(
        "DATA TIKET TIDAK DITEMUKAN:",
        response.data
      );


      alert(
        "Tiket berhasil dibuat, tetapi data tiket tidak terbaca."
      );


      return null;

    }


    tiket.value =
      dataTiket;


    return dataTiket;

  } catch (
    error: any
  ) {

    console.error(
      "BUAT TIKET ERROR:",
      error
    );


    const message =
      error?.response?.data?.message ||
      error?.data?.message ||
      "Gagal membuat tiket.";


    alert(message);


    return null;

  }

};


/* =====================================================
   PRINT TIKET
===================================================== */

const printTicket = async (
  jenisKendaraan:
    "motor" | "mobil"
) => {

  if (
    loadingPrint.value
  ) {
    return;
  }


  loadingPrint.value =
    true;


  try {

    /* =================================================
       BUAT TIKET
    ================================================== */

    const data =
      await buatTiket(
        jenisKendaraan
      );


    if (!data) {
      return;
    }


    /* =================================================
       KODE TIKET
    ================================================== */

    const nomorTiket =
      String(
        data.kode_tiket || ""
      )
        .toUpperCase()
        .trim();


    if (!nomorTiket) {

      alert(
        "Kode tiket tidak ditemukan."
      );


      return;

    }


    /* =================================================
       TARIF
    ================================================== */

    const tarif =
      jenisKendaraan === "motor"
        ? 3000
        : 5000;


    /* =================================================
       QR
    ================================================== */

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
`.trim();


    const qrImage =
      await QRCode.toDataURL(
        qrData,
        {
          width: 500,
          margin: 1,
        }
      );


    /* =================================================
       PDF
    ================================================== */

    const pdf =
      new jsPDF({
        orientation:
          "portrait",

        unit:
          "mm",

        format:
          [80, 140],
      });


    /* =================================================
       HEADER PDF
    ================================================== */

    pdf.setFontSize(12);


    pdf.text(
      "PARKIR",
      40,
      12,
      {
        align:
          "center",
      }
    );


    pdf.text(
      "PLAZA ANDALAS",
      40,
      20,
      {
        align:
          "center",
      }
    );


    /* =================================================
       ALAMAT
    ================================================== */

    pdf.setFontSize(7);


    pdf.text(
      "Jl. Dr. KRT Radjiman Widyodiningrat",
      40,
      30,
      {
        align:
          "center",
      }
    );


    pdf.text(
      "Jakarta Timur",
      40,
      35,
      {
        align:
          "center",
      }
    );


    /* =================================================
       QR PDF
    ================================================== */

    pdf.addImage(
      qrImage,
      "PNG",
      25,
      45,
      30,
      30
    );


    /* =================================================
       KODE
    ================================================== */

    pdf.setFontSize(16);


    pdf.text(
      nomorTiket,
      40,
      85,
      {
        align:
          "center",
      }
    );


    /* =================================================
       INFORMASI
    ================================================== */

    pdf.setFontSize(8);


    const jenisText =
      jenisKendaraan === "motor"
        ? "Motor"
        : "Mobil";


    pdf.text(
      [
        "Informasi :",
        "",
        `Kendaraan : ${jenisText}`,
        `Tarif : Rp${tarif.toLocaleString("id-ID")}`,
        "",
        "Member",
        "Rp. 150.000 / bulan",
        "",
        "Terima Kasih",
      ],
      40,
      100,
      {
        align:
          "center",
      }
    );


    /* =================================================
       SIMPAN
    ================================================== */

    pdf.save(
      `Tiket-${nomorTiket}.pdf`
    );

  } catch (
    error: any
  ) {

    console.error(
      "PRINT ERROR:",
      error
    );


    alert(
      "Gagal mencetak tiket."
    );

  } finally {

    loadingPrint.value =
      false;


    await fokusScanner();

  }

};


/* =====================================================
   CEK TIKET NON MEMBER

   INI TETAP PAKAI ENDPOINT:
   /tiket/cek-masuk
===================================================== */

const cekTiketNonMember = async (
  nilaiScan: string
) => {

  const kodeTiket =
    bersihkanKodeTiket(
      nilaiScan
    );


  console.log(
    "HASIL SCAN TIKET:",
    nilaiScan
  );


  console.log(
    "KODE TIKET:",
    kodeTiket
  );


  if (!kodeTiket) {

    alert(
      "Kode tiket non-member tidak terbaca."
    );


    scanCard.value =
      "";


    return;

  }


  try {

    const response =
      await $api.post(
        "/tiket/cek-masuk",
        {
          kode_tiket:
            kodeTiket,
        }
      );


    const data =
      response.data;


    console.log(
      "HASIL CEK TIKET:",
      data
    );


    if (
      data?.success !== true &&
      data?.status !== true
    ) {

      alert(
        data?.message ||
        "Tiket tidak dapat digunakan."
      );


      return;

    }


    tiket.value =
      data?.data?.tiket ||
      data?.tiket ||
      data?.data ||
      null;


    alert(
      "Tiket terdeteksi."
    );


  } catch (
    error: any
  ) {

    console.error(
      "CEK TIKET ERROR:",
      error
    );


    console.error(
      "RESPONSE:",
      error?.response?.data
    );


    const message =
      error?.response?.data?.message ||
      error?.response?.data?.error ||
      error?.data?.message ||
      "Tiket tidak dapat digunakan.";


    alert(message);

  } finally {

    scanCard.value =
      "";

  }

};


/* =====================================================
   OPEN GATE

   MEMBER:
   - MBR-XXXXXX
   - TOKEN QR

   NON MEMBER:
   - AXXXXX
===================================================== */

const openGate = async () => {

  if (sedangScan) {
    return;
  }


  const nilaiScan =
    String(
      scanCard.value || ""
    ).trim();


  if (!nilaiScan) {

    await fokusScanner();

    return;

  }


  sedangScan =
    true;


  try {

    console.log(
      "================================="
    );

    console.log(
      "SCAN MASUK:",
      nilaiScan
    );

    console.log(
      "================================="
    );


    /* =================================================
       1. COBA DETEKSI MEMBER
    ================================================== */

    const kodeMember =
      bersihkanKodeMember(
        nilaiScan
      );


    console.log(
      "KODE MEMBER:",
      kodeMember
    );


    if (kodeMember) {

      console.log(
        ">>> MEMBER TERDETEKSI <<<"
      );


      /* =================================================
         A. MEMBER DENGAN MBR-XXXX
      ================================================== */

      if (
        kodeMember
          .toUpperCase()
          .startsWith("MBR-")
      ) {

        console.log(
          "MEMBER MBR"
        );


        const response =
          await $api.post(
            "/gate/check-member",
            {
              kode_member:
                kodeMember,
            }
          );


        console.log(
          "HASIL CHECK MEMBER:",
          response.data
        );


        const data =
          response?.data;


        if (
          data?.success !== true &&
          data?.status !== true
        ) {

          throw new Error(
            data?.message ||
            "Member tidak ditemukan."
          );

        }


        const member =
          data?.data?.member ||
          data?.member ||
          data?.data;


        if (!member?.id) {

          throw new Error(
            "Data member tidak ditemukan."
          );

        }


        /* =============================================
           GATE MEMBER
        ============================================== */

        const gateResponse =
          await $api.post(
            "/gate/member",
            {
              member_id:
                member.id,

              nomor_polisi:
                "",
            }
          );


        console.log(
          "HASIL GATE MEMBER:",
          gateResponse.data
        );


        const gateData =
          gateResponse?.data;


        if (
          gateData?.success !== true &&
          gateData?.status !== true
        ) {

          throw new Error(
            gateData?.message ||
            "Member tidak dapat masuk."
          );

        }


        const hasilTiket =
          gateData?.data?.tiket ||
          gateData?.tiket ||
          gateData?.data;


        tiket.value = {

          ...(hasilTiket || {}),

          id:
            hasilTiket?.id ||
            null,

          kode_tiket:
            hasilTiket?.kode_tiket ||
            member.kode_member ||
            kodeMember,

          kode_member:
            hasilTiket?.kode_member ||
            member.kode_member ||
            kodeMember,

          nama_member:
            hasilTiket?.nama_member ||
            member.nama_member ||
            "-",

          nama_perusahaan:
            hasilTiket?.nama_perusahaan ||
            member.nama_perusahaan ||
            "-",

          jenis_kendaraan:
            "member",

          tarif:
            0,

          status:
            hasilTiket?.status ||
            "masuk",

        };


        alert(
          "Member terdeteksi.\nPintu terbuka."
        );


        scanCard.value =
          "";


        return;

      }


      /* =================================================
         B. MEMBER DENGAN TOKEN QR

         CONTOH FOTO:
         a-4132-93fe-34166c03e464
      ================================================== */

      console.log(
        "MEMBER TOKEN QR"
      );


      const response =
        await $api.post(
          "/member/check",
          {
            token:
              kodeMember,
          }
        );


      console.log(
        "HASIL /member/check:",
        response.data
      );


      const data =
        response?.data;


      if (
        data?.success !== true &&
        data?.status !== true
      ) {

        throw new Error(
          data?.message ||
          "Member tidak ditemukan."
        );

      }


      const member =
        data?.data?.member ||
        data?.member ||
        data?.data;


      console.log(
        "DATA MEMBER:",
        member
      );


      if (!member?.id) {

        throw new Error(
          "Data member tidak ditemukan."
        );

      }


      /* =============================================
         GATE MEMBER
      ============================================== */

      const gateResponse =
        await $api.post(
          "/gate/member",
          {
            member_id:
              member.id,

            nomor_polisi:
              "",
          }
        );


      console.log(
        "HASIL /gate/member:",
        gateResponse.data
      );


      const gateData =
        gateResponse?.data;


      if (
        gateData?.success !== true &&
        gateData?.status !== true
      ) {

        throw new Error(
          gateData?.message ||
          "Member tidak dapat masuk."
        );

      }


      const hasilTiket =
        gateData?.data?.tiket ||
        gateData?.tiket ||
        gateData?.data;


      tiket.value = {

        ...(hasilTiket || {}),

        id:
          hasilTiket?.id ||
          null,

        kode_tiket:
          hasilTiket?.kode_tiket ||
          member.kode_member ||
          kodeMember,

        kode_member:
          hasilTiket?.kode_member ||
          member.kode_member ||
          "-",

        nama_member:
          hasilTiket?.nama_member ||
          member.nama_member ||
          "-",

        nama_perusahaan:
          hasilTiket?.nama_perusahaan ||
          member.nama_perusahaan ||
          "-",

        jenis_kendaraan:
          "member",

        tarif:
          0,

        status:
          hasilTiket?.status ||
          "masuk",

      };


      alert(
        "Member terdeteksi.\nPintu terbuka."
      );


      scanCard.value =
        "";


      return;

    }


    /* =================================================
       2. KALAU BUKAN MEMBER
          CEK TIKET NON-MEMBER
    ================================================== */

    if (
      adalahTiketNonMember(
        nilaiScan
      )
    ) {

      console.log(
        ">>> TIKET NON MEMBER <<<"
      );


      await cekTiketNonMember(
        nilaiScan
      );


      return;

    }


    /* =================================================
       3. TIDAK TERDETEKSI
    ================================================== */

    alert(
      "Kode member atau tiket tidak terbaca."
    );


    scanCard.value =
      "";


  } catch (
    error: any
  ) {

    console.error(
      "================================="
    );

    console.error(
      "SCAN ERROR:",
      error
    );

    console.error(
      "RESPONSE:",
      error?.response?.data
    );

    console.error(
      "================================="
    );


    const message =
      error?.response?.data?.message ||
      error?.response?.data?.error ||
      error?.data?.message ||
      error?.message ||
      "Gagal memproses scan.";


    alert(message);


    scanCard.value =
      "";


  } finally {

    sedangScan =
      false;


    await fokusScanner();

  }

};


/* =====================================================
   SCANNER FISIK
===================================================== */

let scannerBuffer =
  "";

let scannerTimer:
  ReturnType<typeof setTimeout> |
  null =
  null;


/* =====================================================
   HANDLE SCANNER
===================================================== */

const handleScanner = (
  event: KeyboardEvent
) => {

  /*
   * Kalau sedang mengetik di input,
   * jangan tangkap sebagai scanner global.
   */

  if (
    document.activeElement ===
    scanInput.value
  ) {

    return;

  }


  /* =================================================
     ENTER
  ================================================== */

  if (
    event.key === "Enter"
  ) {

    if (!scannerBuffer) {
      return;
    }


    event.preventDefault();


    scanCard.value =
      scannerBuffer;


    scannerBuffer =
      "";


    if (
      scannerTimer
    ) {

      clearTimeout(
        scannerTimer
      );


      scannerTimer =
        null;

    }


    openGate();


    return;

  }


  /* =================================================
     KARAKTER SCANNER
  ================================================== */

  if (
    event.key.length === 1
  ) {

    scannerBuffer +=
      event.key;


    if (
      scannerTimer
    ) {

      clearTimeout(
        scannerTimer
      );

    }


    scannerTimer =
      setTimeout(
        () => {

          scannerBuffer =
            "";

          scannerTimer =
            null;

        },
        500
      );

  }

};


/* =====================================================
   MOUNTED
===================================================== */

onMounted(() => {

  document.addEventListener(
    "keydown",
    handleScanner
  );


  nextTick(() => {

    scanInput.value?.focus();

  });

});


/* =====================================================
   UNMOUNTED
===================================================== */

onBeforeUnmount(() => {

  document.removeEventListener(
    "keydown",
    handleScanner
  );


  if (
    scannerTimer
  ) {

    clearTimeout(
      scannerTimer
    );


    scannerTimer =
      null;

  }

});

</script>