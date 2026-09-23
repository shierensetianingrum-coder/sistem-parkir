<script setup lang="ts">
const props = defineProps<{
  title: string
  subtitle: string
  theme: 'petugas' | 'admin'
}>()

defineEmits<{
  back: []
}>()
</script>

<template>
  <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
      <h1 class="font-['Space_Grotesk'] text-2xl font-semibold text-slate-800">
        {{ props.title }}
      </h1>

      <p class="mt-1 text-sm text-slate-500">
        {{ props.subtitle }}
      </p>
    </div>

    <button
      type="button"
      class="inline-flex items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-white shadow-md transition active:scale-95"
      :class="props.theme === 'admin' ? 'bg-indigo-600 hover:bg-indigo-700' : 'bg-[#1D5C3D] hover:bg-[#143D2B]'"
      @click="$emit('back')"
    >
      <span aria-hidden="true">&larr;</span>
      Kembali ke dashboard
    </button>
  </div>
</template>
