<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
  modelValue: File,
  label: String,
  accept: String,
  errors: {
    type: Array,
    default: () => [],
  },
});

const file = ref(null);

const emit = defineEmits(['update:modelValue']);

watch(() => props.modelValue, (value) => {
  if (!value) {
    file.value = '';
  }
}, { immediate: true });

const filesize = (size) => {
  var i = Math.floor(Math.log(size) / Math.log(1024))
  return (size / Math.pow(1024, i)).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i]
};

const browse = () => {
  file.value.click()
};

const change = (e) => {
  emit('update:modelValue', e.target.files[0])
};

const remove = () => {
  emit('update:modelValue', null)
};

</script>
<template>
  <div>
    <label v-if="label" class="form-label">{{ label }}:</label>
    <div class="form-input p-0" :class="{ error: errors.length }">
      <input ref="file" type="file" :accept="accept" class="hidden" @change="change" />
      <div v-if="!modelValue" class="p-2">
        <button type="button" class="px-4 py-1 text-white text-xs font-medium bg-gray-500 hover:bg-gray-700 rounded-sm" @click="browse">Browse</button>
      </div>
      <div v-else class="flex items-center justify-between p-2">
        <div class="flex-1 pr-1">
          {{ modelValue.name }} <span class="text-gray-500 text-xs">({{ filesize(modelValue.size) }})</span>
        </div>
        <button type="button" class="px-4 py-1 text-white text-xs font-medium bg-gray-500 hover:bg-gray-700 rounded-sm" @click="remove">Remove</button>
      </div>
    </div>
    <div v-if="errors.length" class="form-error">{{ errors[0] }}</div>
  </div>
</template>