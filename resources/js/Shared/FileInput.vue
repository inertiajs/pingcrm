<template>
  <v-file-input
    v-model="value"
    :accept="accept"
    :label="label"
    :placeholder="placeholder"
    chips
    multiple
    counter
    show-size
    outlined
    filled
    clearable
    :error-messages="errorMessages"
  />
</template>

<script>
export default {
  props: {
    value: File,
    label: String,
    accept: String,
    errorMessages: String,
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
    },
  },
  methods: {
    browse() {
      this.$refs.file.click()
    },
    change(e) {
      this.$emit('input', e.target.files[0])
    },
    remove() {
      this.$emit('input', null)
    },
  },
}
</script>
