<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue'
const props = defineProps({
  placement: {
    type: String,
    default: 'right',
  },
  width: {
    type: String,
    default: 'w-48',
  },
  autoClose: {
    type: Boolean,
    default: true,
  },
})
const closeOnEscape = (e) => {
  if (open.value && e.key === 'Escape') {
    open.value = false
  }
}

const alignmentClasses = computed(() => {
  if (props.placement === 'left') {
    return 'origin-top-left left-0'
  } else if (props.placement === 'right') {
    return 'origin-top-right right-0'
  } else {
    return 'origin-top'
  }
})

onMounted(() => document.addEventListener('keydown', closeOnEscape))
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape))

const open = ref(false)
</script>
<template>
  <div class="relative">
    <div class="flex w-full h-full cursor-pointer" @click="open = !open">
      <slot />
    </div>

    <!-- Full Screen Dropdown Overlay -->
    <div v-show="open" class="fixed z-40 inset-0" @click="open = false" />

    <transition enter-active-class="transition ease-out duration-200" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
      <div v-show="open" class="absolute z-50 rounded-md shadow-lg" :class="[width, alignmentClasses]" style="display: none" @click.stop="open = !autoClose">
        <div class="rounded-md ring-1 ring-black ring-opacity-5">
          <slot name="dropdown" />
        </div>
      </div>
    </transition>
  </div>
</template>
