<template>
  <div class="p-6 max-w-md mx-auto">
    <div v-if="loading">Loading...</div>
    <div v-else-if="error" class="text-red-500">{{ error }}</div>

    <div v-else class="bg-white rounded-lg shadow p-6">
      <h1 class="text-xl font-bold text-center mb-4">Pembayaran Member</h1>

      <div class="bg-gray-50 rounded-lg p-4 space-y-3 mb-4">
        <div>
          <p class="text-xs text-gray-500">Kode Member</p>
          <p class="font-semibold">{{ member.kode_member }}</p>
        </div>
        <div>
          <p class="text-xs text-gray-500">Nama Member</p>
          <p class="font-semibold">{{ member.nama }}</p>
        </div>
        <div>
          <p class="text-xs text-gray-500">Perusahaan</p>
          <p class="font-semibold">{{ member.perusahaan || '-' }}</p>
        </div>
        <div>
          <p class="text-xs text-gray-500">Tagihan Bulanan</p>
          <p class="font-bold text-blue-600">Rp {{ formatRupiah(member.harga) }}</p>
        </div>
        <div>
          <p class="text-xs text-gray-500">Pembayaran Saat Ini</p>
          <p class="font-semibold">Rp {{ formatRupiah(member.dibayar) }}</p>
        </div>
        <div>
          <p class="text-xs text-gray-500">Status</p>
          <span
            :class="member.status_pembayaran === 'lunas'
              ? 'bg-green-100 text-green-700'
              : 'bg-red-100 text-red-700'"
            class="inline-block px-2 py-1 rounded text-xs font-semibold mt-1"
          >
            {{ member.status_pembayaran === 'lunas' ? 'lunas' : 'belum lunas' }}
          </span>
        </div>
      </div>

      <label class="block mb-1 font-medium text-sm">Masukkan Pembayaran</label>
      <input
        v-model.number="jumlahBayar"
        type="number"
        min="0"
        :max="member.harga"
        class="w-full border rounded px-3 py-2 mb-1"
      />
      <p class="text-xs text-gray-400 mb-4">
        Maksimal pembayaran: Rp {{ formatRupiah(member.harga) }}
      </p>

      <p v-if="errorBayar" class="text-red-500 text-sm mb-2">{{ errorBayar }}</p>

      <button
        @click="simpanPembayaran"
        :disabled="saving"
        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded disabled:opacity-50"
      >
        {{ saving ? 'Menyimpan...' : 'Simpan Pembayaran' }}
      </button>

      <NuxtLink
        to="/select"
        class="block text-center mt-3 text-sm text-gray-500 hover:underline"
      >
        Kembali
      </NuxtLink>
    </div>
  </div>
</template>

<script setup>
const config = useRuntimeConfig();
const router = useRouter();
const route = useRoute();

const id = route.params.id;

const member = ref({});
const jumlahBayar = ref(0);
const loading = ref(true);
const saving = ref(false);
const error = ref(null);
const errorBayar = ref(null);

async function fetchMember() {
  try {
    const res = await $fetch(`${config.public.apiBase}/members/${id}`);
    member.value = res.data;
    jumlahBayar.value = res.data.harga;
  } catch (err) {
    error.value = 'Gagal mengambil data member';
    console.error(err);
  } finally {
    loading.value = false;
  }
}

async function simpanPembayaran() {
  errorBayar.value = null;
  saving.value = true;

  try {
    await $fetch(`${config.public.apiBase}/members/${id}/bayar`, {
      method: 'POST',
      body: { jumlah_bayar: jumlahBayar.value },
    });

    router.push('/select');
  } catch (err) {
    errorBayar.value = 'Gagal menyimpan pembayaran';
    console.error(err);
  } finally {
    saving.value = false;
  }
}

function formatRupiah(angka) {
  return Number(angka || 0).toLocaleString('id-ID');
}

onMounted(() => {
  fetchMember();
});
</script>