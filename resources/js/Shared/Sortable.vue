<template>
  <div :class="$attrs.class" class="cursor-pointer" @click="select">
    <slot/>
    <div v-if="$attrs.modelValue && field == $attrs.modelValue.field" class="inline-block align-middle ml-1">
      <icon v-if="$attrs.modelValue.direction === 'asc'" name="arrow-down" class="block w-4 h-4 fill-gray-400" />
      <icon v-else name="arrow-up" class="block w-4 h-4 fill-gray-400" />
    </div>
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'

export default {
  components: {
    Icon,
  },
  inheritAttrs: false,
  props: {
    field: {
      type: String,
      default: null,
    },
  },
  emits: ['update:modelValue'],
  methods: {
    select() {
      this.$emit('update:modelValue', {
        field: this.field,
        direction: (this.$attrs.modelValue && this.$attrs.modelValue.direction === 'asc') ? 'desc' : 'asc'
      })
    },
  },
}
</script>
