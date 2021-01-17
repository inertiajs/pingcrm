<template>
  <v-row class="px-4 text-center" no-gutters justify="end" align="center">
    <slot />
    <v-btn text small @click="$emit('reset')">reset </v-btn>
  </v-row>
</template>

<script>
export default {
  components: {},
  props: {
    value: String,
    maxWidth: {
      type: Number,
      default: 300,
    },
  },
}
</script>
