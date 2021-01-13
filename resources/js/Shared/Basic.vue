<template>
  <v-app>
    <v-content class="background">
      <v-container class="fill-height" fluid>
        <!-- <flash-messages /> -->
        <slot />
      </v-container>
      <!-- <Footer /> -->
    </v-content>
  </v-app>
</template>

<script>
// import Footer from '~/components/layout/Footer'

export default {
  name: 'BasicLayout',
  components: {
    // Footer,
  },
}
</script>
