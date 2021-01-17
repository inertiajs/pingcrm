<template>
  <portal to="modal">
    <v-dialog
      v-model="show"
      transition="dialog-bottom-transition"
      :max-width="maxWidth"
      :persistent="persistent"
      @click:outside="persistent ? null : close()"
    >
      <template v-slot:default>
        <v-card flat>
          <slot />
        </v-card>
      </template>
    </v-dialog>
  </portal>
</template>

<script>
export default {
  props: {
    show: {
      type: Boolean,
      default: false,
    },
    maxWidth: {
      type: String,
      default: '600',
    },
    closeable: {
      type: Boolean,
      default: true,
    },
    persistent: {
      type: Boolean,
      default: false,
    },
  },

  methods: {
    close() {
      if (this.closeable) {
        this.$emit('close')
      }
    },
  },
}
</script>
