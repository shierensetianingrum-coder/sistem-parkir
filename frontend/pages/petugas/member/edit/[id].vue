<template>

<div
    class="
        min-h-screen
        bg-slate-100
        flex
        items-center
        justify-center
        p-5
    "
>

    <div
        class="
            bg-white
            p-8
            rounded-2xl
            shadow-xl
            w-full
            max-w-[450px]
        "
    >

        <h1
            class="
                text-2xl
                font-bold
                mb-6
                text-center
            "
        >
            Pembayaran Member
        </h1>


        <!-- INFORMASI MEMBER -->

        <div
            class="
                bg-slate-50
                rounded-xl
                p-4
                mb-6
                space-y-3
            "
        >

            <div>
                <p class="text-sm text-gray-500">
                    Kode Member
                </p>

                <p class="font-bold">
                    {{ form.kode_member }}
                </p>
            </div>


            <div>
                <p class="text-sm text-gray-500">
                    Nama Member
                </p>

                <p class="font-bold">
                    {{ form.nama_member }}
                </p>
            </div>


            <div>
                <p class="text-sm text-gray-500">
                    Perusahaan
                </p>

                <p class="font-bold">
                    {{ form.nama_perusahaan }}
                </p>
            </div>


            <div>
                <p class="text-sm text-gray-500">
                    Tagihan Bulanan
                </p>

                <p
                    class="
                        font-bold
                        text-blue-600
                        text-lg
                    "
                >
                    Rp
                    {{ formatRupiah(form.total_harga) }}
                </p>
            </div>


            <div>
                <p class="text-sm text-gray-500">
                    Pembayaran Saat Ini
                </p>

                <p
                    class="
                        font-bold
                        text-lg
                    "
                >
                    Rp
                    {{ formatRupiah(form.jumlah_bayar) }}
                </p>
            </div>


            <div>
                <p class="text-sm text-gray-500">
                    Status
                </p>

                <span
                    class="
                        inline-block
                        px-3
                        py-1
                        rounded-full
                        text-sm
                        font-bold
                    "
                    :class="
                        form.status === 'lunas'
                            ? 'bg-green-100 text-green-700'
                            : 'bg-red-100 text-red-700'
                    "
                >
                    {{ form.status }}
                </span>
            </div>

        </div>


        <!-- INPUT PEMBAYARAN -->

        <label
            class="
                block
                font-semibold
                mb-2
            "
        >
            Masukkan Pembayaran
        </label>


        <input
            v-model.number="form.jumlah_bayar"
            type="number"
            min="0"
            :max="form.total_harga"
            class="
                w-full
                p-3
                rounded-xl
                border
                border-gray-300
                mb-2
                focus:outline-none
                focus:ring-2
                focus:ring-green-500
            "
            placeholder="Masukkan jumlah pembayaran"
        />


        <p class="text-sm text-gray-500 mb-5">
            Maksimal pembayaran:
            Rp {{ formatRupiah(form.total_harga) }}
        </p>


        <!-- BUTTON SIMPAN -->

        <button
            @click="updatePembayaran"
            :disabled="loading"
            class="
                bg-green-600
                hover:bg-green-700
                disabled:bg-gray-400
                text-white
                w-full
                py-3
                rounded-xl
                font-bold
            "
        >

            {{
                loading
                    ? 'Menyimpan...'
                    : 'Simpan Pembayaran'
            }}

        </button>


        <!-- BUTTON KEMBALI -->

        <button
            @click="
                router.push(
                    '/petugas/member/select'
                )
            "
            class="
                bg-gray-500
                hover:bg-gray-600
                text-white
                w-full
                py-3
                rounded-xl
                font-bold
                mt-3
            "
        >
            Kembali
        </button>

    </div>

</div>

</template>


<script setup lang="ts">

const { $api } = useNuxtApp();

const router = useRouter();

const route = useRoute();


const loading = ref(false);


const form = reactive<any>({

    id: null,

    kode_member: "",

    nama_member: "",

    nama_perusahaan: "",

    total_harga: 0,

    jumlah_bayar: 0,

    kembalian: 0,

    status: "",

    tanggal_bayar: null,

    tanggal_mulai: null,

    tanggal_expired: null,

    tanggal_reset: null

});


// =========================================================
// AMBIL DATA MEMBER
// =========================================================

const getData = async () => {

    try {

        const res =
            await $api.get(
                `/members/${route.params.id}`
            );

        if (!res.data.status) {

            alert(
                res.data.message ||
                "Data member tidak ditemukan"
            );

            router.push(
                "/petugas/member/select"
            );

            return;
        }

        Object.assign(
            form,
            res.data.data
        );

    }

    catch (error: any) {

        console.error(
            "Gagal mengambil data member:",
            error
        );

        alert(
            error?.response?.data?.message ||
            "Gagal mengambil data member"
        );

    }

};


// =========================================================
// UPDATE PEMBAYARAN
// =========================================================

const updatePembayaran = async () => {

    /*
    |--------------------------------------------------------------------------
    | Validasi
    |--------------------------------------------------------------------------
    */

    const jumlahBayar =
        Number(
            form.jumlah_bayar || 0
        );

    const harga =
        Number(
            form.total_harga || 0
        );


    if (jumlahBayar < 0) {

        alert(
            "Pembayaran tidak boleh kurang dari 0"
        );

        return;
    }


    if (jumlahBayar > harga) {

        alert(
            "Pembayaran tidak boleh lebih dari Rp "
            + formatRupiah(harga)
        );

        return;
    }


    try {

        loading.value = true;


        const res =
            await $api.put(

                `/members/${route.params.id}/pembayaran`,

                {
                    jumlah_bayar:
                        jumlahBayar
                }

            );


        if (!res.data.status) {

            alert(
                res.data.message ||
                "Pembayaran gagal"
            );

            return;
        }


        alert(
            res.data.message ||
            "Pembayaran berhasil diperbarui"
        );


        router.push(
            "/petugas/member/select"
        );

    }

    catch (error: any) {

        console.error(
            "Gagal update pembayaran:",
            error
        );


        alert(
            error?.response?.data?.message ||
            "Gagal memperbarui pembayaran"
        );

    }

    finally {

        loading.value = false;

    }

};


// =========================================================
// FORMAT RUPIAH
// =========================================================

const formatRupiah = (
    angka: any
) => {

    return new Intl.NumberFormat(
        "id-ID"
    ).format(
        Number(angka || 0)
    );

};


// =========================================================
// LOAD
// =========================================================

onMounted(() => {

    getData();

});

</script>