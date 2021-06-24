<template>
  <teleport to="#content">
    <transition name="slideout" :appear="$dialog.appear">
      <div v-if="$dialog.open" class="slideout absolute px-2 sm:px-6 md-full:px-6 fixed top-0 right-0 w-1/3 h-full overflow-y-auto bg-white shadow-xl border-l" style="z-index: 100000;">
        <slot />
      </div>
    </transition>
  </teleport>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { usePage } from '@inertiajs/inertia-vue3'

export default {
  dialogKey: 'slideout',
  setup() {
    function escapeToClose(event) {
      if (event.keyCode == 27) {
        Inertia.closeDialog()
      }
    }

    onMounted(() => document.addEventListener('keydown', escapeToClose))
    onUnmounted(() => document.removeEventListener('keydown', escapeToClose))
  },
}
</script>

<style scoped>
.slideout {
  transition: all 0.2s ease, max-width 0.1s ease;
}

.slideout-enter-from,
.slideout-leave-to {
  opacity: 0;
  margin-right: -100px;
}

.slideout-leave-from {
  opacity: 1;
  margin-right: 0;
}
</style>
