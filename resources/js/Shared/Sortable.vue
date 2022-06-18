<script>
export default {
  inheritAttrs: false,
}
</script>
<script setup>
import { useAttrs } from 'vue'
import Icon from '@/Shared/Icon'

const props = defineProps({
  field: {
    type: String,
    default: null,
  },
})

const attrs = useAttrs()

const emit = defineEmits(['update:modelValue'])

const select = () => {
  emit('update:modelValue', {
    field: props.field,
    direction: attrs.modelValue && attrs.modelValue.direction === 'asc' ? 'desc' : 'asc',
  })
}
</script>
<template>
  <div :class="$attrs.class" class="cursor-pointer" @click="select">
    <slot />
    <div v-if="$attrs.modelValue && field == $attrs.modelValue.field" class="inline-block align-middle ml-1">
      <icon v-if="$attrs.modelValue.direction === 'asc'" name="arrow-down" class="block w-4 h-4 fill-gray-400" />
      <icon v-else name="arrow-up" class="block w-4 h-4 fill-gray-400" />
    </div>
  </div>
</template>
