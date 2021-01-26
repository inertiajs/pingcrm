<template>
  <v-app id="inspire">
    <v-app-bar app color="#151635" dark>
      <v-app-bar-nav-icon />

      <v-toolbar-title
        class="text-subtitle-1 text-md-h5 text-uppercase font-weight-bold"
        style="color:#d61523;"
      >
        Simulador Terrentro
      </v-toolbar-title>

      <v-spacer />

      <v-btn icon>
        <v-icon>mdi-dots-vertical</v-icon>
      </v-btn>
    </v-app-bar>

    <v-main class="grey lighten-3">
      <v-container>
        <v-row>
          <v-col cols="12" sm="10" offset-sm="1">
            <v-sheet min-height="70vh" rounded="lg">
              <!--  -->
            </v-sheet>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
export default {
  //
}
</script>
<style scoped></style>
