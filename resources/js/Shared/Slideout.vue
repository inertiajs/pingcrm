<template>
  <teleport to="body">
    <div class="px-2 sm:px-6 md-full:px-6 fixed top-0 right-0 w-1/3 h-full overflow-y-auto bg-white shadow-xl border-l">
      <slot />
    </div>
  </teleport>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { usePage } from '@inertiajs/inertia-vue3'

export default {
  props: {
    closeUrl: {
      type: String,
    },
  },
  setup({ closeUrl }) {
    const mask = ref(null)
    const firstPage = usePage().url.value === usePage().inline?.value.url

    function escapeToClose(event) {
      if (event.keyCode == 27) {
        close()
      }
    }

    function clickToClose(event) {
      if (mask.value === event.target) {
        close()
      }
    }

    function close() {
      if (firstPage) {
        Inertia.get(closeUrl)
      } else {
        window.history.back()
      }
    }

    onMounted(() => document.addEventListener('keydown', escapeToClose))
    onUnmounted(() => document.removeEventListener('keydown', escapeToClose))
  },
}
</script>
