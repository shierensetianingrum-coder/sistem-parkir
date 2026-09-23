<template>
  <div class="min-h-screen bg-[#F3F7F5] p-5 md:p-8">

    <!-- ================================================= -->
    <!-- HEADER -->
    <!-- ================================================= -->

    <div class="mb-7">

      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
          <div class="flex items-center gap-3 mb-2">

            <div
              class="
                w-12 h-12
                rounded-2xl
                bg-gradient-to-br
                from-[#0B2A1D]
                to-[#164A31]
                text-white
                flex
                items-center
                justify-center
                text-2xl
                shadow-lg
              "
            >
              👥
            </div>

            <div>
              <h1 class="text-3xl font-bold text-[#0B2A1D]">
                Data Member
              </h1>

              <p class="text-gray-500 text-sm">
                Kelola data dan pembayaran member parkir
              </p>
            </div>

          </div>
        </div>


        <!-- KEMBALI -->
        <button
          type="button"
          @click="router.push('/petugas')"
          class="
            flex
            items-center
            justify-center
            gap-2
            bg-[#0B2A1D]
            hover:bg-[#164A31]
            text-white
            px-5
            py-3
            rounded-xl
            font-semibold
            shadow-lg
            hover:shadow-xl
            transition
          "
        >
          ← Kembali ke Dashboard
        </button>

      </div>

    </div>


    <!-- ================================================= -->
    <!-- STATISTIK MEMBER -->
    <!-- ================================================= -->

    <div
      class="
        grid
        grid-cols-1
        sm:grid-cols-2
        xl:grid-cols-4
        gap-5
        mb-7
      "
    >

      <!-- TOTAL -->
      <div
        class="
          bg-white
          rounded-2xl
          p-5
          shadow-sm
          border
          border-gray-100
          hover:shadow-lg
          transition
        "
      >

        <div class="flex items-center justify-between">

          <div>
            <p class="text-sm text-gray-500 font-medium">
              Total Member
            </p>

            <h2 class="text-3xl font-bold text-[#0B2A1D] mt-2">
              {{ members.length }}
            </h2>

            <p class="text-xs text-gray-400 mt-1">
              Semua data member
            </p>
          </div>

          <div
            class="
              w-12 h-12
              rounded-xl
              bg-green-100
              text-green-700
              flex
              items-center
              justify-center
              text-xl
            "
          >
            👥
          </div>

        </div>

      </div>


      <!-- LUNAS -->
      <div
        class="
          bg-white
          rounded-2xl
          p-5
          shadow-sm
          border
          border-gray-100
          hover:shadow-lg
          transition
        "
      >

        <div class="flex items-center justify-between">

          <div>
            <p class="text-sm text-gray-500 font-medium">
              Member Lunas
            </p>

            <h2 class="text-3xl font-bold text-green-600 mt-2">
              {{ jumlahLunas }}
            </h2>

            <p class="text-xs text-gray-400 mt-1">
              Pembayaran selesai
            </p>
          </div>

          <div
            class="
              w-12 h-12
              rounded-xl
              bg-green-100
              text-green-600
              flex
              items-center
              justify-center
              text-xl
            "
          >
            ✓
          </div>

        </div>

      </div>


      <!-- BELUM LUNAS -->
      <div
        class="
          bg-white
          rounded-2xl
          p-5
          shadow-sm
          border
          border-gray-100
          hover:shadow-lg
          transition
        "
      >

        <div class="flex items-center justify-between">

          <div>
            <p class="text-sm text-gray-500 font-medium">
              Belum Lunas
            </p>

            <h2 class="text-3xl font-bold text-orange-500 mt-2">
              {{ jumlahBelumLunas }}
            </h2>

            <p class="text-xs text-gray-400 mt-1">
              Menunggu pembayaran
            </p>
          </div>

          <div
            class="
              w-12 h-12
              rounded-xl
              bg-orange-100
              text-orange-500
              flex
              items-center
              justify-center
              text-xl
            "
          >
            !
          </div>

        </div>

      </div>


      <!-- PENDAPATAN -->
      <div
        class="
          bg-white
          rounded-2xl
          p-5
          shadow-sm
          border
          border-gray-100
          hover:shadow-lg
          transition
        "
      >

        <div class="flex items-center justify-between">

          <div>
            <p class="text-sm text-gray-500 font-medium">
              Pendapatan Member
            </p>

            <h2 class="text-xl font-bold text-[#0B2A1D] mt-3">
              Rp {{ formatRupiah(totalPendapatan) }}
            </h2>

            <p class="text-xs text-gray-400 mt-1">
              Total pembayaran
            </p>
          </div>

          <div
            class="
              w-12 h-12
              rounded-xl
              bg-emerald-100
              text-emerald-700
              flex
              items-center
              justify-center
              text-xl
            "
          >
            Rp
          </div>

        </div>

      </div>

    </div>


    <!-- ================================================= -->
    <!-- TOOLBAR -->
    <!-- ================================================= -->

    <div
      class="
        bg-white
        rounded-2xl
        shadow-sm
        border
        border-gray-100
        p-5
        mb-5
      "
    >

      <div
        class="
          flex
          flex-col
          md:flex-row
          md:items-center
          md:justify-between
          gap-4
        "
      >

        <div>
          <h2 class="text-lg font-bold text-[#0B2A1D]">
            Daftar Member
          </h2>

          <p class="text-sm text-gray-500">
            Kelola data member Plaza Andalas
          </p>
        </div>


        <div class="flex flex-col sm:flex-row gap-3">

          <!-- SEARCH -->
          <div class="relative">

            <span
              class="
                absolute
                left-3
                top-1/2
                -translate-y-1/2
                text-gray-400
              "
            >
              🔎
            </span>

            <input
              v-model="search"
              type="text"
              placeholder="Cari member..."
              class="
                w-full
                sm:w-64
                pl-10
                pr-4
                py-3
                rounded-xl
                border
                border-gray-200
                outline-none
                focus:border-[#164A31]
                focus:ring-2
                focus:ring-green-100
                transition
              "
            />

          </div>


          <!-- TAMBAH -->
          <button
            type="button"
            @click="router.push('/petugas/member/tambah')"
            class="
              bg-[#0B2A1D]
              hover:bg-[#164A31]
              text-white
              px-5
              py-3
              rounded-xl
              font-semibold
              shadow
              transition
              whitespace-nowrap
            "
          >
            + Tambah Member
          </button>

        </div>

      </div>

    </div>


    <!-- ================================================= -->
    <!-- TABEL MEMBER -->
    <!-- ================================================= -->

    <div
      class="
        bg-white
        rounded-2xl
        shadow-sm
        border
        border-gray-100
        overflow-hidden
      "
    >

      <!-- TABLE HEADER -->
      <div
        class="
          px-6
          py-4
          bg-gradient-to-r
          from-[#0B2A1D]
          to-[#164A31]
          text-white
          flex
          items-center
          justify-between
        "
      >

        <div>
          <h2 class="font-bold">
            Data Member Terdaftar
          </h2>

          <p class="text-xs text-green-100 mt-1">
            {{ filteredMembers.length }} data ditampilkan
          </p>
        </div>

        <div
          class="
            px-3
            py-1.5
            rounded-full
            bg-white/10
            border
            border-white/10
            text-xs
          "
        >
          Plaza Andalas
        </div>

      </div>


      <div class="overflow-x-auto">

        <table class="w-full min-w-[1100px]">

          <thead>

            <tr
              class="
                border-b
                bg-[#F5F8F6]
                text-gray-600
              "
            >

              <th class="p-4 text-left text-sm">
                Kode
              </th>

              <th class="p-4 text-left text-sm">
                Nama Member
              </th>

              <th class="p-4 text-left text-sm">
                Perusahaan
              </th>

              <th class="p-4 text-left text-sm">
                Tagihan
              </th>

              <th class="p-4 text-left text-sm">
                Dibayar
              </th>

              <th class="p-4 text-left text-sm">
                Status
              </th>

              <th class="p-4 text-left text-sm">
                Expired
              </th>

              <th class="p-4 text-center text-sm">
                Aksi
              </th>

            </tr>

          </thead>


          <tbody>

            <tr
              v-for="item in filteredMembers"
              :key="item.id"
              class="
                border-b
                border-gray-100
                hover:bg-[#F7FAF8]
                transition
              "
            >

              <!-- KODE -->
              <td class="p-4">

                <span
                  class="
                    inline-flex
                    px-3
                    py-1.5
                    rounded-lg
                    bg-green-50
                    text-[#0B2A1D]
                    font-bold
                    text-sm
                  "
                >
                  {{ item.kode_member }}
                </span>

              </td>


              <!-- NAMA -->
              <td class="p-4">

                <div class="flex items-center gap-3">

                  <div
                    class="
                      w-9 h-9
                      rounded-full
                      bg-[#0B2A1D]
                      text-white
                      flex
                      items-center
                      justify-center
                      font-bold
                    "
                  >
                    {{ getInitial(item.nama_member) }}
                  </div>

                  <div>

                    <p class="font-semibold text-gray-800">
                      {{ item.nama_member }}
                    </p>

                    <p class="text-xs text-gray-400">
                      Member Parkir
                    </p>

                  </div>

                </div>

              </td>


              <!-- PERUSAHAAN -->
              <td class="p-4 text-gray-600">
                {{ item.nama_perusahaan || '-' }}
              </td>


              <!-- TAGIHAN -->
              <td class="p-4">

                <span class="font-semibold text-gray-700">
                  Rp {{ formatRupiah(item.total_harga) }}
                </span>

              </td>


              <!-- DIBAYAR -->
              <td class="p-4">

                <span class="font-semibold text-[#0B2A1D]">
                  Rp {{ formatRupiah(item.jumlah_bayar) }}
                </span>

              </td>


              <!-- STATUS -->
              <td class="p-4">

                <span
                  class="
                    inline-flex
                    items-center
                    gap-1.5
                    px-3
                    py-1.5
                    rounded-full
                    text-xs
                    font-bold
                  "
                  :class="
                    item.status === 'lunas'
                      ? 'bg-green-100 text-green-700'
                      : 'bg-red-100 text-red-700'
                  "
                >

                  <span>
                    {{
                      item.status === 'lunas'
                        ? '✓'
                        : '!'
                    }}
                  </span>

                  {{
                    item.status === 'lunas'
                      ? 'Lunas'
                      : item.status
                  }}

                </span>

              </td>


              <!-- EXPIRED -->
              <td class="p-4">

                <div class="flex items-center gap-2">

                  <span>📅</span>

                  <span class="text-gray-600">
                    {{ formatTanggal(item.tanggal_expired) }}
                  </span>

                </div>

              </td>


              <!-- AKSI -->
              <td class="p-4">

                <div
                  class="
                    flex
                    justify-center
                    gap-2
                  "
                >

                  <!-- DETAIL -->
                  <button
                    type="button"
                    @click.stop="lihatDetail(item.id)"
                    class="
                      bg-blue-600
                      hover:bg-blue-700
                      text-white
                      px-3
                      py-2
                      rounded-lg
                      text-sm
                      font-semibold
                      transition
                    "
                  >
                    Detail
                  </button>


                  <!-- EDIT -->
                  <button
                    type="button"
                    :disabled="item.status === 'lunas'"
                    @click.stop="edit(item.id)"
                    class="
                      bg-yellow-500
                      hover:bg-yellow-600
                      text-white
                      px-3
                      py-2
                      rounded-lg
                      text-sm
                      font-semibold
                      transition
                      disabled:opacity-40
                      disabled:cursor-not-allowed
                    "
                  >
                    Edit
                  </button>


                  <!-- HAPUS -->
                  <button
                    type="button"
                    :disabled="item.status === 'lunas'"
                    @click.stop="hapus(item.id)"
                    class="
                      bg-red-600
                      hover:bg-red-700
                      text-white
                      px-3
                      py-2
                      rounded-lg
                      text-sm
                      font-semibold
                      transition
                      disabled:opacity-40
                      disabled:cursor-not-allowed
                    "
                  >
                    Hapus
                  </button>

                </div>

              </td>

            </tr>


            <!-- KOSONG -->
            <tr v-if="filteredMembers.length === 0">

              <td
                colspan="8"
                class="p-14 text-center"
              >

                <div
                  class="
                    w-16
                    h-16
                    mx-auto
                    mb-4
                    rounded-2xl
                    bg-green-50
                    flex
                    items-center
                    justify-center
                    text-3xl
                  "
                >
                  👥
                </div>

                <h3 class="font-bold text-gray-700">
                  Tidak ada data member
                </h3>

                <p class="text-sm text-gray-400 mt-1">
                  {{
                    search
                      ? 'Member yang dicari tidak ditemukan.'
                      : 'Belum ada data member.'
                  }}
                </p>

              </td>

            </tr>

          </tbody>

        </table>

      </div>

    </div>


    <!-- ================================================= -->
    <!-- MODAL DETAIL MEMBER / KARTU KECIL -->
    <!-- ================================================= -->

    <div
      v-if="showModal"
      class="
        fixed
        inset-0
        bg-black/60
        backdrop-blur-sm
        flex
        items-center
        justify-center
        z-50
        p-5
      "
      @click.self="tutupModal"
    >

      <div class="w-full max-w-[330px]">

        <!-- KARTU MEMBER -->
        <div
          class="
            bg-white
            rounded-2xl
            shadow-2xl
            overflow-hidden
          "
        >

          <!-- HEADER TIKET -->
          <div
            class="
              bg-gradient-to-r
              from-[#0B2A1D]
              to-[#164A31]
              text-white
              px-5
              py-4
              text-center
            "
          >

            <h2 class="text-lg font-bold">
              PARKIR PLAZA ANDALAS
            </h2>

            <p class="text-[10px] text-green-100 mt-1 tracking-widest">
              KARTU MEMBER
            </p>

          </div>


          <!-- ISI KARTU -->
          <div class="p-5">

            <!-- QR -->
            <div class="flex justify-center mb-4">

              <div
                class="
                  p-2
                  bg-white
                  border
                  border-gray-200
                  rounded-xl
                  shadow-sm
                "
              >

                <img
                  v-if="qr"
                  :src="qr"
                  class="
                    w-32
                    h-32
                    object-contain
                  "
                />

                <div
                  v-else
                  class="
                    w-32
                    h-32
                    flex
                    items-center
                    justify-center
                    bg-gray-100
                    text-gray-400
                    text-xs
                    rounded-lg
                  "
                >
                  QR belum tersedia
                </div>

              </div>

            </div>


            <!-- KODE -->
            <div class="text-center mb-4">

              <p
                class="
                  text-[9px]
                  text-gray-400
                  uppercase
                  tracking-widest
                "
              >
                KODE MEMBER
              </p>

              <p
                class="
                  text-xl
                  font-bold
                  text-[#0B2A1D]
                  tracking-widest
                  mt-1
                "
              >
                {{ detailMember.kode_member || '-' }}
              </p>

            </div>


            <!-- GARIS -->
            <div class="border-t border-dashed border-gray-300 mb-4"></div>


            <!-- DATA MEMBER -->
            <div class="space-y-2.5 text-xs">

              <div class="flex justify-between gap-3">

                <span class="text-gray-500">
                  Nama
                </span>

                <span class="font-semibold text-right text-gray-800">
                  {{ detailMember.nama_member || '-' }}
                </span>

              </div>


              <div class="flex justify-between gap-3">

                <span class="text-gray-500">
                  Perusahaan
                </span>

                <span class="font-semibold text-right text-gray-800">
                  {{ detailMember.nama_perusahaan || '-' }}
                </span>

              </div>


              <div class="flex justify-between items-center gap-3">

                <span class="text-gray-500">
                  Status
                </span>

                <span
                  class="
                    px-2
                    py-1
                    rounded-full
                    text-[9px]
                    font-bold
                  "
                  :class="
                    detailMember.status === 'lunas'
                      ? 'bg-green-100 text-green-700'
                      : 'bg-red-100 text-red-700'
                  "
                >
                  {{
                    detailMember.status === 'lunas'
                      ? 'LUNAS'
                      : detailMember.status || '-'
                  }}
                </span>

              </div>


              <div class="flex justify-between gap-3">

                <span class="text-gray-500">
                  Berlaku
                </span>

                <span class="font-semibold text-right">
                  {{ formatTanggal(detailMember.tanggal_expired) }}
                </span>

              </div>

            </div>


            <!-- INFO -->
            <div
              class="
                mt-4
                bg-green-50
                border
                border-green-100
                rounded-xl
                p-3
                text-center
              "
            >

              <p class="text-[9px] text-green-700 leading-relaxed">
                Scan QR ini untuk akses masuk parkir
              </p>

            </div>


            <!-- DOWNLOAD -->
            <button
              type="button"
              @click="downloadMember"
              class="
                mt-4
                w-full
                bg-[#0B2A1D]
                hover:bg-[#164A31]
                text-white
                py-2.5
                rounded-xl
                font-semibold
                text-sm
                transition
              "
            >
              ⬇ Download Kartu Member
            </button>


            <!-- TUTUP -->
            <button
              type="button"
              @click="tutupModal"
              class="
                mt-2
                w-full
                bg-gray-100
                hover:bg-gray-200
                text-gray-600
                py-2.5
                rounded-xl
                font-semibold
                text-sm
                transition
              "
            >
              Tutup
            </button>

          </div>

        </div>

      </div>

    </div>

  </div>
</template>


<script setup lang="ts">

import {
  ref,
  computed,
  onMounted
} from "vue";


const { $api } = useNuxtApp();

const router = useRouter();


/* =========================================================
   DATA
========================================================= */

const members = ref<any[]>([]);

const search = ref("");

const showModal = ref(false);

const detailMember = ref<any>({});

const qr = ref("");



/* =========================================================
   FILTER MEMBER
========================================================= */

const filteredMembers = computed(() => {

  if (!search.value.trim()) {
    return members.value;
  }

  const keyword =
    search.value.toLowerCase().trim();

  return members.value.filter((item: any) => {

    return (
      String(item.kode_member || "")
        .toLowerCase()
        .includes(keyword) ||

      String(item.nama_member || "")
        .toLowerCase()
        .includes(keyword) ||

      String(item.nama_perusahaan || "")
        .toLowerCase()
        .includes(keyword)
    );

  });

});



/* =========================================================
   STATISTIK
========================================================= */

const jumlahLunas = computed(() => {

  return members.value.filter(
    (item: any) =>
      String(item.status || "").toLowerCase() === "lunas"
  ).length;

});


const jumlahBelumLunas = computed(() => {

  return members.value.filter(
    (item: any) =>
      String(item.status || "").toLowerCase() !== "lunas"
  ).length;

});


const totalPendapatan = computed(() => {

  return members.value.reduce(
    (total: number, item: any) => {

      return total + Number(
        item.jumlah_bayar || 0
      );

    },
    0
  );

});



/* =========================================================
   INITIAL NAMA
========================================================= */

const getInitial = (nama: any) => {

  if (!nama) {
    return "?";
  }

  return String(nama)
    .trim()
    .charAt(0)
    .toUpperCase();

};



/* =========================================================
   LOAD DATA MEMBER
========================================================= */

const load = async () => {

  try {

    const res =
      await $api.get("/members");

    console.log(
      "Data member:",
      res.data
    );

    members.value =
      res.data.data || [];

  }

  catch (error: any) {

    console.error(
      "Gagal mengambil member:",
      error
    );

    alert(
      error?.response?.data?.message ||
      "Gagal mengambil data member"
    );

  }

};



/* =========================================================
   DETAIL MEMBER
========================================================= */

const lihatDetail = async (
  id: number
) => {

  try {

    const res =
      await $api.get(
        `/members/${id}`
      );


    if (!res.data.status) {

      alert(
        res.data.message ||
        "Data member tidak ditemukan"
      );

      return;

    }


    detailMember.value =
      res.data.data;

    qr.value =
      res.data.data.qr;

    showModal.value =
      true;

  }

  catch (error: any) {

    console.error(
      "ERROR DETAIL MEMBER:",
      error
    );

    alert(
      error?.response?.data?.message ||
      "Gagal mengambil detail member"
    );

  }

};



/* =========================================================
   TUTUP MODAL
========================================================= */

const tutupModal = () => {

  showModal.value =
    false;

  detailMember.value =
    {};

  qr.value =
    "";

};



/* =========================================================
   EDIT
========================================================= */

const edit = (
  id: number
) => {

  router.push(
    `/petugas/member/edit/${id}`
  );

};



/* =========================================================
   HAPUS MEMBER
========================================================= */

const hapus = async (
  id: number
) => {

  if (
    !confirm(
      "Yakin hapus member?"
    )
  ) {

    return;

  }


  try {

    await $api.delete(
      `/members/${id}`
    );


    alert(
      "Member berhasil dihapus"
    );


    await load();

  }

  catch (error: any) {

    console.error(
      "Gagal hapus:",
      error
    );

    alert(
      error?.response?.data?.message ||
      "Gagal menghapus member"
    );

  }

};



/* =========================================================
   DOWNLOAD KARTU MEMBER
========================================================= */

const downloadMember = () => {

  if (
    !detailMember.value?.kode_member
  ) {

    alert(
      "Data member belum tersedia"
    );

    return;

  }


  if (!qr.value) {

    alert(
      "QR Code belum tersedia"
    );

    return;

  }


  const canvas =
    document.createElement(
      "canvas"
    );

  const ctx =
    canvas.getContext(
      "2d"
    );


  if (!ctx) {

    alert(
      "Browser tidak mendukung canvas"
    );

    return;

  }


  /* =====================================================
     UKURAN KARTU KECIL
  ===================================================== */

  canvas.width = 400;
  canvas.height = 600;


  /* =====================================================
     BACKGROUND
  ===================================================== */

  ctx.fillStyle =
    "white";

  ctx.fillRect(
    0,
    0,
    400,
    600
  );


  /* =====================================================
     HEADER
  ===================================================== */

  ctx.fillStyle =
    "#0B2A1D";

  ctx.fillRect(
    0,
    0,
    400,
    80
  );


  ctx.fillStyle =
    "white";

  ctx.textAlign =
    "center";

  ctx.font =
    "bold 23px Arial";

  ctx.fillText(
    "PARKIR PLAZA ANDALAS",
    200,
    38
  );


  ctx.font =
    "12px Arial";

  ctx.fillText(
    "KARTU MEMBER",
    200,
    60
  );


  /* =====================================================
     DATA ATAS
  ===================================================== */

  ctx.textAlign =
    "left";

  ctx.fillStyle =
    "#666";

  ctx.font =
    "11px Arial";

  ctx.fillText(
    "KODE MEMBER",
    35,
    115
  );


  ctx.fillStyle =
    "#0B2A1D";

  ctx.font =
    "bold 22px Arial";

  ctx.fillText(
    detailMember.value.kode_member,
    35,
    142
  );


  /* =====================================================
     QR
  ===================================================== */

  const img =
    new Image();


  img.onload = () => {

    ctx.drawImage(
      img,
      100,
      165,
      200,
      200
    );


    /* =================================================
       GARIS
    ================================================= */

    ctx.strokeStyle =
      "#dddddd";

    ctx.setLineDash([
      6,
      5
    ]);

    ctx.beginPath();

    ctx.moveTo(
      35,
      395
    );

    ctx.lineTo(
      365,
      395
    );

    ctx.stroke();

    ctx.setLineDash([]);


    /* =================================================
       DATA MEMBER
    ================================================= */

    ctx.fillStyle =
      "#666";

    ctx.font =
      "12px Arial";

    ctx.fillText(
      "Nama",
      35,
      425
    );

    ctx.fillText(
      "Perusahaan",
      35,
      455
    );

    ctx.fillText(
      "Status",
      35,
      485
    );

    ctx.fillText(
      "Berlaku Sampai",
      35,
      515
    );


    ctx.fillStyle =
      "#222";

    ctx.font =
      "bold 12px Arial";

    ctx.textAlign =
      "right";

    ctx.fillText(
      detailMember.value.nama_member || "-",
      365,
      425
    );

    ctx.fillText(
      detailMember.value.nama_perusahaan || "-",
      365,
      455
    );

    ctx.fillText(
      String(
        detailMember.value.status || "-"
      ).toUpperCase(),
      365,
      485
    );

    ctx.fillText(
      formatTanggal(
        detailMember.value.tanggal_expired
      ),
      365,
      515
    );


    /* =================================================
       FOOTER
    ================================================= */

    ctx.textAlign =
      "center";

    ctx.fillStyle =
      "#0B2A1D";

    ctx.font =
      "10px Arial";

    ctx.fillText(
      "Scan QR ini untuk akses masuk parkir",
      200,
      560
    );


    /* =================================================
       DOWNLOAD
    ================================================= */

    const link =
      document.createElement(
        "a"
      );

    link.download =
      `kartu-member-${detailMember.value.kode_member}.png`;

    link.href =
      canvas.toDataURL(
        "image/png"
      );

    link.click();

  };


  img.onerror = () => {

    alert(
      "QR Code gagal dimuat"
    );

  };


  img.src =
    qr.value;

};



/* =========================================================
   FORMAT RUPIAH
========================================================= */

const formatRupiah = (
  angka: any
) => {

  return new Intl.NumberFormat(
    "id-ID"
  ).format(
    Number(angka || 0)
  );

};



/* =========================================================
   FORMAT TANGGAL
========================================================= */

const formatTanggal = (
  tanggal: any
) => {

  if (!tanggal) {

    return "-";

  }


  return new Date(
    tanggal
  ).toLocaleDateString(
    "id-ID"
  );

};



/* =========================================================
   LOAD SAAT HALAMAN DIBUKA
========================================================= */

onMounted(
  load
);

</script>