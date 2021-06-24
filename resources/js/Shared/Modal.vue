<template>
  <transition name="modal" :appear="$dialog.appear">
    <div v-if="$dialog.open" ref="mask" class="modal-mask px-2 sm:px-4 md-full:px-6 fixed inset-0 w-full h-full flex justify-between items-center" @mousedown="clickToClose">
      <div class="modal-container mx-auto flex flex-col rounded-md bg-white w-full shadow-lg overflow-hidden" :style="{ 'max-width': maxWidth + 'px' }">
        <slot />
      </div>
    </div>
  </transition>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { usePage } from '@inertiajs/inertia-vue3'

export default {
  dialogKey: 'modal',
  props: {
    maxWidth: {
      type: Number,
      default: 650,
    },
  },
  setup() {
    const mask = ref(null)

    function escapeToClose(event) {
      event.stopPropagation()
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
      Inertia.closeDialog()
    }

    onMounted(() => document.addEventListener('keydown', escapeToClose))
    onUnmounted(() => document.removeEventListener('keydown', escapeToClose))

    return {
      mask,
      clickToClose,
    };
  },
}
</script>

<style scoped>
.modal-mask {
  z-index: 1000;
  background-color: rgba(0, 0, 0, 0.6);
  transition: opacity 0.3s ease;
}

.modal-container {
  max-height: 80vh;
  transition: transform 0.2s ease, max-width 0.1s ease;
}

.modal-enter-from {
  opacity: 0;
}

.modal-leave-to {
  opacity: 0;
}

.modal-leave-from {
  transform: scale(1);
  opacity: 1;
}

.modal-enter-from .modal-container,
.modal-leave-to .modal-container {
  transform: scale(1.1);
}
</style>
