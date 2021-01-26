<template>
  <v-app>
    <v-main class="grey lighten-3">
      <flash-messages />
      <slot />
      <!-- <Footer /> -->
    </v-main>
    <portal-target name="modal" multiple />
  </v-app>
</template>

<script>
import FlashMessages from '@/Shared/FlashMessages.vue'

export default {
  name: 'BasicLayout',
  components: {
    FlashMessages,
  },
}
</script>
