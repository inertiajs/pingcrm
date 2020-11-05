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

<template>
  <teleport to="body">
    <transition :name="!firstPage ? 'modal' : null" appear>
      <div ref="mask" class="modal-mask px-2 sm:px-4 md-full:px-6 fixed inset-0 w-full h-full flex justify-between items-center" @mousedown="clickToClose">
        <div class="modal-container mx-auto flex flex-col rounded-md bg-white w-full shadow-lg overflow-hidden" :style="{ 'max-width': maxWidth + 'px' }">
          <slot />
        </div>
      </div>
    </transition>
  </teleport>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { usePage } from '@inertiajs/inertia-vue3'

export default {
  props: {
    maxWidth: {
      type: Number,
      default: 650,
    },
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

    return {
      mask,
      firstPage,
      clickToClose,
    };
  },
}
</script>
