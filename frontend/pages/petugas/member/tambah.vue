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
            Tambah Member
        </h1>


        <!-- NAMA -->

        <label
            class="
                block
                font-semibold
                mb-2
            "
        >
            Nama Member
        </label>

        <input
            v-model="form.nama_member"
            type="text"
            class="
                w-full
                p-3
                rounded-xl
                border
                border-gray-300
                mb-4
                focus:outline-none
                focus:ring-2
                focus:ring-blue-500
            "
            placeholder="Contoh: Anisa"
        />


        <!-- PERUSAHAAN -->

        <label
            class="
                block
                font-semibold
                mb-2
            "
        >
            Perusahaan
        </label>

        <input
            v-model="form.nama_perusahaan"
            type="text"
            class="
                w-full
                p-3
                rounded-xl
                border
                border-gray-300
                mb-4
                focus:outline-none
                focus:ring-2
                focus:ring-blue-500
            "
            placeholder="Contoh: SMKN 71 Jakarta"
        />


        <!-- HARGA MEMBER / BULAN -->

        <div
            class="
                bg-slate-50
                rounded-xl
                p-4
                mb-4
            "
        >

            <p class="text-sm text-gray-500">
                Harga Member / Bulan
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


        <!-- UANG BAYAR -->

        <label
            class="
                block
                font-semibold
                mb-2
            "
        >
            Uang Bayar
        </label>

        <input
            v-model.number="form.jumlah_bayar"
            type="number"
            min="0"
            class="
                w-full
                p-3
                rounded-xl
                border
                border-gray-300
                mb-4
                focus:outline-none
                focus:ring-2
                focus:ring-blue-500
            "
            placeholder="Masukkan uang bayar"
        />


        <!-- RINGKASAN -->

        <div
            class="
                bg-slate-50
                rounded-xl
                p-4
                mb-6
                space-y-1
            "
        >

            <p>
                <b>Harga :</b>
                Rp {{ formatRupiah(form.total_harga) }}
            </p>


            <p>
                <b>Uang Bayar :</b>
                Rp {{ formatRupiah(form.jumlah_bayar) }}
            </p>


            <p>
                <b>Kembalian :</b>
                Rp {{ formatRupiah(kembalian) }}
            </p>


            <p>

                <b>Status :</b>

                <span
                    :class="
                        status === 'lunas'
                            ? 'text-green-600'
                            : 'text-red-600'
                    "
                    class="font-bold"
                >
                    {{ status }}
                </span>

            </p>

        </div>


        <!-- BUTTON SIMPAN -->

        <button
            @click="simpan"
            :disabled="loading"
            class="
                bg-blue-600
                hover:bg-blue-700
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
                    : 'Simpan'
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

import {
    reactive,
    computed,
    ref
} from "vue";


const { $api } = useNuxtApp();

const router = useRouter();


const loading = ref(false);


// =========================================================
// FORM
// =========================================================
// Catatan: total_harga di-set sebagai harga member per bulan.
// Jika harga ini berasal dari server (bukan tetap Rp 150.000),
// ganti nilai default di bawah dengan hasil fetch API terkait
// (misal /pengaturan/harga-member) di dalam onMounted.
// =========================================================

const form = reactive<any>({

    nama_member: "",

    nama_perusahaan: "",

    total_harga: 150000,

    jumlah_bayar: 150000

});


// =========================================================
// KEMBALIAN & STATUS (live, mengikuti input)
// =========================================================

const kembalian = computed(() => {

    const bayar =
        Number(form.jumlah_bayar || 0);

    const harga =
        Number(form.total_harga || 0);

    const sisa =
        bayar - harga;

    return sisa > 0
        ? sisa
        : 0;

});


const status = computed(() => {

    const bayar =
        Number(form.jumlah_bayar || 0);

    const harga =
        Number(form.total_harga || 0);

    return bayar >= harga
        ? "lunas"
        : "belum lunas";

});


// =========================================================
// SIMPAN
// =========================================================

const simpan = async () => {

    /*
    |--------------------------------------------------------------------------
    | Validasi
    |--------------------------------------------------------------------------
    */

    if (!form.nama_member.trim()) {

        alert(
            "Nama member wajib diisi"
        );

        return;
    }


    if (!form.nama_perusahaan.trim()) {

        alert(
            "Nama perusahaan wajib diisi"
        );

        return;
    }


    const jumlahBayar =
        Number(form.jumlah_bayar || 0);


    if (jumlahBayar < 0) {

        alert(
            "Uang bayar tidak boleh kurang dari 0"
        );

        return;
    }


    try {

        loading.value = true;


        const res =
            await $api.post(

                "/members",

                {
                    nama_member:
                        form.nama_member,

                    nama_perusahaan:
                        form.nama_perusahaan,

                    total_harga:
                        form.total_harga,

                    jumlah_bayar:
                        jumlahBayar
                }

            );


        if (!res.data.status) {

            alert(
                res.data.message ||
                "Gagal menambahkan member"
            );

            return;
        }


        alert(
            res.data.message ||
            "Member berhasil ditambahkan"
        );


        router.push(
            "/petugas/member/select"
        );

    }

    catch (error: any) {

        console.error(
            "Gagal menambah member:",
            error
        );

        alert(
            error?.response?.data?.message ||
            "Gagal menambahkan member"
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

</script>