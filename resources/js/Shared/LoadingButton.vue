<template>
  <button :disabled="loading" class="flex items-center">
    <div v-if="loading" class="btn-spinner mr-2" />
    <slot />
  </button>
</template>

<script setup>
const props = defineProps({
  loading: Boolean,
})
</script>
