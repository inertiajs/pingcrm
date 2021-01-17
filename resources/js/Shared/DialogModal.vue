<template>
  <modal
    :show="show"
    :max-width="maxWidth"
    :closeable="closeable"
    :persistent="persistent"
    @close="close"
  >
    <v-card-title>
      <slot name="title" />
      <v-spacer />
      <v-btn icon @click="close()">
        <v-icon color="red">mdi-close</v-icon>
      </v-btn>
    </v-card-title>

    <v-card-text>
      <slot name="content" />
    </v-card-text>

    <v-card-actions>
      <slot name="footer" />
    </v-card-actions>
  </modal>
</template>

<script>
import Modal from './Modal'

export default {
  components: {
    Modal,
  },

  props: {
    show: { type: Boolean, default: false },
    maxWidth: { type: String, default: '600' },
    closeable: { type: Boolean, default: true },
    persistent: { type: Boolean, default: false },
  },

  methods: {
    close() {
      this.$emit('close')
    },
  },
}
</script>
