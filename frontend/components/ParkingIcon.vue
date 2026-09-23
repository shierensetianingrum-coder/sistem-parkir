<script setup lang="ts">
import { computed } from 'vue'

const props = defineProps<{
  name: string
  class?: string
}>()

const ICON_PATHS: Record<string, string> = {
  gate: 'M4 21V6a1 1 0 011-1h3v16M20 21V6a1 1 0 00-1-1h-3v16M8 21h8M8 10h.01M8 14h.01M16 10h.01M16 14h.01',
  users: 'M17 20v-1a4 4 0 00-4-4H7a4 4 0 00-4 4v1M13 9a3 3 0 100-6 3 3 0 000 6zM21 20v-1a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75',
  user: 'M12 12a4 4 0 100-8 4 4 0 000 8zM4 20v-1a6 6 0 016-6h4a6 6 0 016 6v1',
  shield: 'M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6l7-3z',
  mail: 'M4 6h16a1 1 0 011 1v10a1 1 0 01-1 1H4a1 1 0 01-1-1V7a1 1 0 011-1zM3 7l9 6 9-6',
  lock: 'M6 11V8a6 6 0 1112 0v3M5 11h14v9a1 1 0 01-1 1H6a1 1 0 01-1-1v-9z',
  eye: 'M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7zM12 15a3 3 0 100-6 3 3 0 000 6z',
  eyeOff: 'M3 3l18 18M10.6 10.6a3 3 0 004.24 4.24M9.9 5.1A10.7 10.7 0 0112 5c6.5 0 10 7 10 7a13.2 13.2 0 01-3.1 4M6.2 6.2C4 7.7 2 12 2 12a13.3 13.3 0 004.6 5.3',
  alert: 'M12 8v5M12 16h.01M10.3 3.9L2.6 17a1 1 0 00.9 1.5h17a1 1 0 00.9-1.5L13.7 3.9a1 1 0 00-1.7 0z',
  check: 'M20 6L9 17l-5-5',
  close: 'M18 6L6 18M6 6l12 12',
  home: 'M4 11.5L12 4l8 7.5M6 10v9a1 1 0 001 1h4v-6h2v6h4a1 1 0 001-1v-9',
  ticket: 'M4 8a2 2 0 012-2h12a2 2 0 012 2v2a1 1 0 000 4v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2a1 1 0 000-4V8zM9 6v12',
  chart: 'M4 20V10M10 20V4M16 20v-7M22 20H2',
  logout: 'M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9',
  search: 'M11 19a8 8 0 100-16 8 8 0 000 16zM21 21l-4.35-4.35',
  plus: 'M12 5v14M5 12h14',
  car: 'M5 17h14M6 17a2 2 0 104 0M14 17a2 2 0 104 0M4 17l1.5-5.5A2 2 0 017.4 10h9.2a2 2 0 011.9 1.5L20 17M4 17v-1M20 17v-1',
  camera: 'M4 8h3l2-2h6l2 2h3a1 1 0 011 1v9a1 1 0 01-1 1H4a1 1 0 01-1-1V9a1 1 0 011-1zM12 17a4 4 0 100-8 4 4 0 000 8z',
}

const path = computed(() => ICON_PATHS[props.name] || '')
</script>

<template>
  <svg
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-width="1.75"
    stroke-linecap="round"
    stroke-linejoin="round"
    :class="props.class"
    aria-hidden="true"
  >
    <path :d="path" />
  </svg>
</template>
