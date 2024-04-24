<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue'

const props = defineProps({
  align: {
    type: String,
    default: 'right',
  },
  width: {
    type: String,
    default: '48',
  },
  contentClasses: {
    type: String,
    default: '',
  },
})

const closeOnEscape = (e) => {
  if (show.value && e.key === 'Escape') {
    show.value = false
  }
}

onMounted(() => document.addEventListener('keydown', closeOnEscape))
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape))

const widthClass = computed(() => {
  return {
    48: 'w-48',
  }[props.width.toString()]
})

const alignmentClasses = computed(() => {
  if (props.align === 'left') {
    return 'ltr:origin-top-left rtl:origin-top-right start-0'
  } else if (props.align === 'right') {
    return 'ltr:origin-top-right rtl:origin-top-left end-0'
  } else {
    return 'origin-top'
  }
})

const show = ref(false)
</script>

<template>
  <div class="relative">
    <div @click="show = !show" class="flex h-full cursor-pointer">
      <slot />
    </div>

    <!-- Full Screen Dropdown Overlay -->
    <div v-show="show" class="fixed inset-0 z-40" @click="show = false"></div>

    <Transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 scale-95" enter-to-class="opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
      <div v-show="show" class="absolute z-50 rounded-md shadow-lg" :class="[widthClass, alignmentClasses]" style="display: none" @click="show = false">
        <div class="rounded-md ring-1 ring-black ring-opacity-5" :class="contentClasses">
          <slot name="dropdown" />
        </div>
      </div>
    </Transition>
  </div>
</template>
