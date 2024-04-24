<script setup>
import { v4 as uuid } from 'uuid';

defineOptions({
  inheritAttrs: false
});

defineProps({
  id: {
    type: String,
    default() {
      return `text-input-${uuid()}`
    },
  },
  type: {
    type: String,
    default: 'text',
  },
  error: String,
  label: String,
  modelValue: String,
});

defineEmits(['update:modelValue']);
</script>
<template>
  <div :class="$attrs.class">
    <label v-if="label" class="form-label" :for="id">{{ label }}:</label>
    <input :id="id" ref="input" v-bind="{ ...$attrs, class: null }" class="form-input" :class="{ error: error }" :type="type" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />
    <div v-if="error" class="form-error">{{ error }}</div>
  </div>
</template>