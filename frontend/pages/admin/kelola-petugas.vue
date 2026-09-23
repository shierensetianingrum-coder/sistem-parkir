<template>
  <div class="min-h-screen bg-[#F3F7F5] font-sans">

    <!-- ================================================= -->
    <!-- HEADER FULL SCREEN -->
    <!-- ================================================= -->

    <header
      class="sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-gray-200 shadow-sm"
    >
      <div class="max-w-[1700px] mx-auto px-8 py-5">

        <div class="flex items-center justify-between gap-4">

          <!-- KIRI -->
          <div class="flex items-center gap-4">

            <button
              @click="router.push('/admin')"
              class="flex items-center gap-2 px-4 py-2.5 rounded-xl
                     bg-[#0B2A1D] text-white hover:bg-[#164A31]
                     transition font-semibold shadow-sm"
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
                <h1 class="font-black text-lg text-[#0B2A1D] tracking-tight">
                  PARKIR PLAZA ANDALAS
                </h1>

                <p class="text-xs text-gray-400">
                  Super Admin Panel • Kelola Petugas
                </p>
              </div>

            </div>

          </div>


          <!-- KANAN -->
          <div class="flex items-center gap-4">

            <div class="hidden md:flex items-center gap-2">

              <div
                class="w-10 h-10 rounded-full
                       bg-gradient-to-br from-green-300 to-green-600
                       flex items-center justify-center
                       text-white shadow-sm"
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


    <!-- ================================================= -->
    <!-- MAIN -->
    <!-- ================================================= -->

    <main class="px-8 py-8">

      <div class="max-w-[1700px] mx-auto">

        <!-- HEADER HALAMAN -->

        <div
          class="flex flex-col md:flex-row md:items-center
                 md:justify-between gap-5 mb-8"
        >

          <div>

            <div class="flex items-center gap-2 text-sm text-gray-400">

              <button
                @click="router.push('/admin')"
                class="hover:text-green-700 transition"
              >
                Dashboard
              </button>

              <span>/</span>

              <span class="text-green-700 font-medium">
                Kelola Petugas
              </span>

            </div>

            <h1 class="text-3xl font-black text-gray-800 mt-2">
              Kelola Petugas 👥
            </h1>

            <p class="text-gray-500 mt-1">
              Kelola akun petugas yang dapat mengakses
              sistem PARKIR PLAZA ANDALAS.
            </p>

          </div>


          <!-- TAMBAH -->

          <button
            @click="bukaTambah"
            class="flex items-center justify-center gap-2
                   px-5 py-3 rounded-xl
                   bg-[#0B2A1D] hover:bg-[#164A31]
                   text-white font-semibold shadow-lg
                   hover:shadow-xl transition"
          >
            <span class="text-xl">+</span>
            Tambah Petugas
          </button>

        </div>


        <!-- ================================================= -->
        <!-- STAT CARD -->
        <!-- ================================================= -->

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

          <!-- TOTAL -->

          <div
            class="bg-white rounded-2xl p-6
                   border border-gray-100 shadow-sm
                   hover:shadow-md transition"
          >

            <div class="flex items-center justify-between">

              <div>

                <p class="text-sm text-gray-500">
                  Total Petugas
                </p>

                <h2 class="text-3xl font-black text-gray-800 mt-2">
                  {{ petugas.length }}
                </h2>

                <p class="text-xs text-gray-400 mt-1">
                  Akun terdaftar
                </p>

              </div>

              <div
                class="w-12 h-12 rounded-2xl
                       bg-green-100 flex items-center
                       justify-center text-2xl"
              >
                👥
              </div>

            </div>

          </div>


          <!-- AKTIF -->

          <div
            class="bg-white rounded-2xl p-6
                   border border-gray-100 shadow-sm
                   hover:shadow-md transition"
          >

            <div class="flex items-center justify-between">

              <div>

                <p class="text-sm text-gray-500">
                  Petugas Aktif
                </p>

                <h2 class="text-3xl font-black text-green-700 mt-2">
                  {{ jumlahAktif }}
                </h2>

                <p class="text-xs text-green-600 mt-1">
                  Siap bertugas
                </p>

              </div>

              <div
                class="w-12 h-12 rounded-2xl
                       bg-green-100 flex items-center
                       justify-center text-2xl"
              >
                🟢
              </div>

            </div>

          </div>


          <!-- NONAKTIF -->

          <div
            class="bg-white rounded-2xl p-6
                   border border-gray-100 shadow-sm
                   hover:shadow-md transition"
          >

            <div class="flex items-center justify-between">

              <div>

                <p class="text-sm text-gray-500">
                  Petugas Nonaktif
                </p>

                <h2 class="text-3xl font-black text-red-600 mt-2">
                  {{ jumlahNonaktif }}
                </h2>

                <p class="text-xs text-red-500 mt-1">
                  Tidak dapat bertugas
                </p>

              </div>

              <div
                class="w-12 h-12 rounded-2xl
                       bg-red-100 flex items-center
                       justify-center text-2xl"
              >
                🔴
              </div>

            </div>

          </div>

        </div>


        <!-- ================================================= -->
        <!-- TABLE -->
        <!-- ================================================= -->

        <div
          class="bg-white rounded-2xl
                 border border-gray-100 shadow-sm
                 overflow-hidden"
        >

          <!-- TABLE HEADER -->

          <div
            class="px-7 py-6 border-b border-gray-100
                   flex flex-col md:flex-row
                   md:items-center md:justify-between gap-4"
          >

            <div>

              <h2 class="text-xl font-black text-gray-800">
                Daftar Petugas
              </h2>

              <p class="text-sm text-gray-400 mt-1">
                Data akun petugas PARKIR PLAZA ANDALAS.
              </p>

            </div>


            <!-- SEARCH -->

            <div class="relative">

              <span
                class="absolute left-4 top-1/2
                       -translate-y-1/2 text-gray-400"
              >
                🔍
              </span>

              <input
                v-model="search"
                type="text"
                placeholder="Cari petugas..."
                class="w-full md:w-72 pl-11 pr-4 py-3
                       rounded-xl border border-gray-200
                       outline-none
                       focus:ring-2 focus:ring-green-500
                       focus:border-green-500 transition"
              />

            </div>

          </div>


          <!-- TABLE -->

          <div class="overflow-x-auto">

            <table class="w-full">

              <thead class="bg-[#F7FAF8]">

                <tr>

                  <th class="text-left px-7 py-4 text-xs
                             uppercase tracking-wider
                             text-gray-500 font-semibold">
                    No
                  </th>

                  <th class="text-left px-7 py-4 text-xs
                             uppercase tracking-wider
                             text-gray-500 font-semibold">
                    Petugas
                  </th>

                  <th class="text-left px-7 py-4 text-xs
                             uppercase tracking-wider
                             text-gray-500 font-semibold">
                    Email
                  </th>

                  <!-- NOMOR HP -->
                  <th class="text-left px-7 py-4 text-xs
                             uppercase tracking-wider
                             text-gray-500 font-semibold">
                    Nomor HP
                  </th>

                  <th class="text-left px-7 py-4 text-xs
                             uppercase tracking-wider
                             text-gray-500 font-semibold">
                    Status
                  </th>

                  <th class="text-left px-7 py-4 text-xs
                             uppercase tracking-wider
                             text-gray-500 font-semibold">
                    Aksi
                  </th>

                </tr>

              </thead>


              <tbody class="divide-y divide-gray-100">

                <tr
                  v-for="(item, index) in petugasTerfilter"
                  :key="item.id"
                  class="hover:bg-[#F7FAF8] transition"
                >

                  <!-- NO -->

                  <td class="px-7 py-5">
                    <span class="text-gray-500">
                      {{ index + 1 }}
                    </span>
                  </td>


                  <!-- PETUGAS -->

                  <td class="px-7 py-5">

                    <div class="flex items-center gap-3">

                      <div
                        class="w-11 h-11 rounded-full
                               bg-gradient-to-br from-green-300
                               to-green-600
                               flex items-center
                               justify-center text-lg
                               text-white shadow-sm"
                      >
                        👤
                      </div>

                      <div>

                        <p class="font-semibold text-gray-800">
                          {{ item.nama }}
                        </p>

                        <p class="text-xs text-gray-400">
                          ID: {{ item.id }}
                        </p>

                      </div>

                    </div>

                  </td>


                  <!-- EMAIL -->

                  <td class="px-7 py-5">

                    <p class="text-gray-600">
                      {{ item.email }}
                    </p>

                  </td>


                  <!-- NOMOR HP -->

                  <td class="px-7 py-5">

                    <p class="text-gray-600">
                      {{ item.no_hp || '-' }}
                    </p>

                  </td>


                  <!-- STATUS -->

                  <td class="px-7 py-5">

                    <span
                      v-if="item.status === 'aktif'"
                      class="inline-flex items-center gap-2
                             px-3 py-1.5 rounded-full
                             bg-green-100 text-green-700
                             text-xs font-semibold"
                    >
                      <span>●</span>
                      Aktif
                    </span>

                    <span
                      v-else
                      class="inline-flex items-center gap-2
                             px-3 py-1.5 rounded-full
                             bg-red-100 text-red-700
                             text-xs font-semibold"
                    >
                      <span>●</span>
                      Nonaktif
                    </span>

                  </td>


                  <!-- AKSI -->

                  <td class="px-7 py-5">

                    <div class="flex items-center gap-2">

                      <button
                        @click="bukaEdit(item)"
                        class="px-3 py-2 rounded-lg
                               bg-blue-50 text-blue-600
                               hover:bg-blue-100 transition"
                        title="Edit"
                      >
                        ✏️
                      </button>

                      <button
                        @click="ubahStatus(item)"
                        class="px-3 py-2 rounded-lg
                               bg-yellow-50 text-yellow-600
                               hover:bg-yellow-100 transition"
                        title="Ubah status"
                      >
                        🔄
                      </button>

                      <button
                        @click="hapusPetugas(item.id)"
                        class="px-3 py-2 rounded-lg
                               bg-red-50 text-red-600
                               hover:bg-red-100 transition"
                        title="Hapus"
                      >
                        🗑️
                      </button>

                    </div>

                  </td>

                </tr>


                <!-- KOSONG -->

                <tr v-if="petugasTerfilter.length === 0">

                  <td colspan="6" class="px-7 py-14 text-center">

                    <div class="text-5xl mb-4">
                      👥
                    </div>

                    <p class="font-semibold text-gray-700">
                      Petugas tidak ditemukan
                    </p>

                    <p class="text-sm text-gray-400 mt-1">
                      Coba gunakan kata pencarian lain.
                    </p>

                  </td>

                </tr>

              </tbody>

            </table>

          </div>

        </div>


        <!-- FOOTER -->

        <div class="text-center py-8">

          <p class="text-xs text-gray-400">
            © 2026 PARKIR PLAZA ANDALAS • Super Admin
          </p>

        </div>

      </div>

    </main>


    <!-- ================================================= -->
    <!-- MODAL TAMBAH / EDIT -->
    <!-- ================================================= -->

    <div
      v-if="showModal"
      class="fixed inset-0 bg-black/40
             backdrop-blur-sm z-[100]
             flex items-center justify-center p-6"
      @click.self="tutupModal"
    >

      <div
        class="bg-white rounded-3xl
               w-full max-w-lg p-7 shadow-2xl"
      >

        <!-- HEADER MODAL -->

        <div class="flex items-center justify-between mb-6">

          <div>

            <h2 class="text-2xl font-bold text-gray-800">
              {{ modeEdit ? 'Edit Petugas' : 'Tambah Petugas' }}
            </h2>

            <p class="text-sm text-gray-400 mt-1">
              {{
                modeEdit
                  ? 'Perbarui data petugas.'
                  : 'Tambahkan akun petugas baru.'
              }}
            </p>

          </div>

          <button
            @click="tutupModal"
            class="w-10 h-10 rounded-xl
                   bg-gray-100 hover:bg-gray-200"
          >
            ✕
          </button>

        </div>


        <!-- NAMA -->

        <div class="mb-4">

          <label
            class="block text-sm font-semibold
                   text-gray-700 mb-2"
          >
            Nama Petugas
          </label>

          <input
            v-model="form.nama"
            type="text"
            placeholder="Masukkan nama petugas"
            class="w-full px-4 py-3 rounded-xl
                   border border-gray-200 outline-none
                   focus:ring-2 focus:ring-green-500"
          />

        </div>


        <!-- EMAIL -->

        <div class="mb-4">

          <label
            class="block text-sm font-semibold
                   text-gray-700 mb-2"
          >
            Email
          </label>

          <input
            v-model="form.email"
            type="email"
            placeholder="petugas@example.com"
            class="w-full px-4 py-3 rounded-xl
                   border border-gray-200 outline-none
                   focus:ring-2 focus:ring-green-500"
          />

        </div>


        <!-- NOMOR HP -->

        <div class="mb-4">

          <label
            class="block text-sm font-semibold
                   text-gray-700 mb-2"
          >
            Nomor HP
          </label>

          <input
            v-model="form.no_hp"
            type="tel"
            inputmode="numeric"
            placeholder="Contoh: 081234567890"
            class="w-full px-4 py-3 rounded-xl
                   border border-gray-200 outline-none
                   focus:ring-2 focus:ring-green-500"
          />

        </div>


        <!-- PASSWORD -->

        <div class="mb-4">

          <label
            class="block text-sm font-semibold
                   text-gray-700 mb-2"
          >
            Password
          </label>

          <input
            v-model="form.password"
            type="password"
            :placeholder="
              modeEdit
                ? 'Kosongkan jika tidak ingin mengubah'
                : 'Masukkan password'
            "
            class="w-full px-4 py-3 rounded-xl
                   border border-gray-200 outline-none
                   focus:ring-2 focus:ring-green-500"
          />

        </div>


        <!-- STATUS -->

        <div class="mb-6">

          <label
            class="block text-sm font-semibold
                   text-gray-700 mb-2"
          >
            Status
          </label>

          <select
            v-model="form.status"
            class="w-full px-4 py-3 rounded-xl
                   border border-gray-200 outline-none
                   focus:ring-2 focus:ring-green-500"
          >

            <option value="aktif">
              Aktif
            </option>

            <option value="nonaktif">
              Nonaktif
            </option>

          </select>

        </div>


        <!-- BUTTON -->

        <div class="flex gap-3">

          <button
            @click="tutupModal"
            class="flex-1 py-3 rounded-xl
                   bg-gray-100 hover:bg-gray-200
                   text-gray-700 font-semibold"
          >
            Batal
          </button>

          <button
            @click="simpanPetugas"
            :disabled="loading"
            class="flex-1 py-3 rounded-xl
                   bg-[#0B2A1D] hover:bg-[#164A31]
                   text-white font-semibold
                   disabled:opacity-50"
          >
            {{
              loading
                ? 'Menyimpan...'
                : modeEdit
                  ? 'Simpan Perubahan'
                  : 'Tambah Petugas'
            }}
          </button>

        </div>

      </div>

    </div>

  </div>
</template>


<script setup lang="ts">

const router = useRouter()

// =================================================
// API
// =================================================

const config = useRuntimeConfig()

const apiBase = config.public.apiBase || 'http://127.0.0.1:8000/api'


// =================================================
// TIPE DATA
// =================================================

interface Petugas {
  id: number
  nama: string
  email: string
  no_hp: string
  status: string
}


// =================================================
// DATA PETUGAS
// =================================================

const petugas = ref<Petugas[]>([])

const loading = ref(false)


// =================================================
// SEARCH
// =================================================

const search = ref('')


// =================================================
// MODAL
// =================================================

const showModal = ref(false)

const modeEdit = ref(false)

const editId = ref<number | null>(null)


// =================================================
// FORM
// =================================================

const form = ref({
  nama: '',
  email: '',
  no_hp: '',
  password: '',
  status: 'aktif'
})


// =================================================
// AMBIL DATA PETUGAS
// =================================================

const ambilPetugas = async () => {

  try {

    const response: any = await $fetch(`${apiBase}/petugas`)

    if (response.success) {

      petugas.value = response.data.map((item: any) => ({
        id: item.id,
        nama: item.name,
        email: item.email,
        no_hp: item.no_hp || '',
        status: 'aktif'
      }))

    }

  } catch (error) {

    console.error(error)

    alert('Gagal mengambil data petugas.')

  }

}


// =================================================
// FILTER
// =================================================

const petugasTerfilter = computed(() => {

  const keyword = search.value
    .toLowerCase()
    .trim()

  if (!keyword) {
    return petugas.value
  }

  return petugas.value.filter((item) =>
    item.nama.toLowerCase().includes(keyword) ||
    item.email.toLowerCase().includes(keyword) ||
    item.no_hp.toLowerCase().includes(keyword)
  )

})


// =================================================
// JUMLAH AKTIF
// =================================================

const jumlahAktif = computed(() => {

  return petugas.value.filter(
    item => item.status === 'aktif'
  ).length

})


// =================================================
// JUMLAH NONAKTIF
// =================================================

const jumlahNonaktif = computed(() => {

  return petugas.value.filter(
    item => item.status === 'nonaktif'
  ).length

})


// =================================================
// CEK LOGIN + AMBIL DATA
// =================================================

onMounted(async () => {

  const role = localStorage.getItem('role')

  if (role !== 'admin') {

    router.push('/')

    return

  }

  await ambilPetugas()

})


// =================================================
// TAMBAH
// =================================================

const bukaTambah = () => {

  modeEdit.value = false

  editId.value = null

  form.value = {
    nama: '',
    email: '',
    no_hp: '',
    password: '',
    status: 'aktif'
  }

  showModal.value = true

}


// =================================================
// EDIT
// =================================================

const bukaEdit = (item: Petugas) => {

  modeEdit.value = true

  editId.value = item.id

  form.value = {
    nama: item.nama,
    email: item.email,
    no_hp: item.no_hp,
    password: '',
    status: item.status
  }

  showModal.value = true

}


// =================================================
// TUTUP MODAL
// =================================================

const tutupModal = () => {

  showModal.value = false

}


// =================================================
// SIMPAN
// =================================================

const simpanPetugas = async () => {

  if (
    !form.value.nama.trim() ||
    !form.value.email.trim() ||
    !form.value.no_hp.trim()
  ) {

    alert('Nama, email, dan nomor HP wajib diisi.')

    return

  }


  // ===============================================
  // TAMBAH
  // ===============================================

  if (!modeEdit.value) {

    if (!form.value.password.trim()) {

      alert('Password wajib diisi saat menambahkan petugas.')

      return

    }

    loading.value = true

    try {

      const response: any = await $fetch(`${apiBase}/petugas`, {
        method: 'POST',

        body: {
          name: form.value.nama,
          email: form.value.email,
          no_hp: form.value.no_hp,
          password: form.value.password
        }
      })

      if (response.success) {

        alert('Petugas berhasil ditambahkan.')

        await ambilPetugas()

        tutupModal()

      }

    } catch (error: any) {

      console.error(error)

      if (error?.data?.errors) {

        const errors = error.data.errors

        const pesan = Object.values(errors)
          .flat()
          .join('\n')

        alert(pesan)

      } else {

        alert('Gagal menambahkan petugas.')

      }

    } finally {

      loading.value = false

    }

    return

  }


  // ===============================================
  // EDIT
  // ===============================================

  if (editId.value === null) return

  loading.value = true

  try {

    const body: any = {
      name: form.value.nama,
      email: form.value.email,
      no_hp: form.value.no_hp
    }

    if (form.value.password.trim()) {
      body.password = form.value.password
    }

    const response: any = await $fetch(
      `${apiBase}/petugas/${editId.value}`,
      {
        method: 'PUT',
        body
      }
    )

    if (response.success) {

      alert('Data petugas berhasil diperbarui.')

      await ambilPetugas()

      tutupModal()

    }

  } catch (error: any) {

    console.error(error)

    if (error?.data?.errors) {

      const errors = error.data.errors

      const pesan = Object.values(errors)
        .flat()
        .join('\n')

      alert(pesan)

    } else {

      alert('Gagal memperbarui data petugas.')

    }

  } finally {

    loading.value = false

  }

}


// =================================================
// UBAH STATUS
// =================================================

const ubahStatus = (item: Petugas) => {

  item.status =
    item.status === 'aktif'
      ? 'nonaktif'
      : 'aktif'

}


// =================================================
// HAPUS
// =================================================

const hapusPetugas = async (id: number) => {

  const yakin = confirm(
    'Apakah kamu yakin ingin menghapus petugas ini?'
  )

  if (!yakin) return

  try {

    const response: any = await $fetch(
      `${apiBase}/petugas/${id}`,
      {
        method: 'DELETE'
      }
    )

    if (response.success) {

      alert('Petugas berhasil dihapus.')

      await ambilPetugas()

    }

  } catch (error) {

    console.error(error)

    alert('Gagal menghapus petugas.')

  }

}


// =================================================
// LOGOUT
// =================================================

const logout = () => {

  localStorage.removeItem('role')

  localStorage.removeItem('email')

  router.push('/')

}

</script>