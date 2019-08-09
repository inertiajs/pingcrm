<template>
  <div>
    <label v-if="label" class="form-label">{{ label }}:</label>
    <div class="form-input p-0" :class="{ error: errors.length }">
      <input class="hidden" ref="file" type="file" @change="change" :accept="accept">
      <div v-if="!value" class="p-2">
        <button @click="browse" type="button" class="px-4 py-1 bg-grey-dark hover:bg-grey-darker rounded-sm text-xs font-medium text-white">
          Browse
        </button>
      </div>
      <div v-else class="flex items-center justify-between p-2">
        <div class="flex-1 pr-1">{{ value.name }} <span class="text-grey-dark text-xs">({{ filesize(value.size) }})</span></div>
        <button @click="remove" type="button" class="px-4 py-1 bg-grey-dark hover:bg-grey-darker rounded-sm text-xs font-medium text-white">
          Remove
        </button>
      </div>
    </div>
    <div v-if="errors.length" class="form-error">{{ errors[0] }}</div>
  </div>
</template>

<script>
export default {
  props: {
    id: {
      type: String,
      default() {
        return `text-input-${this._uid}`
      },
    },
    value: File,
    label: String,
    accept: String,
    errors: {
      type: Array,
      default: () => [],
    },
  },
  watch: {
    value(value) {
      if (!value) {
        this.$refs.file.value = ''
      }
    }
  },
  methods: {
    filesize(size) {
      var i = Math.floor(Math.log(size) / Math.log(1024))
      return (size / Math.pow(1024, i) ).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i]
    },
    browse() {
      this.$refs.file.click()
    },
    change(e) {
      this.$emit('input', e.target.files[0])
    },
    remove() {
      this.$emit('input', null)
    },
  }
}
</script>