<template>
  <v-app id="inspire">
    <v-app-bar app color="white" flat>
      <v-avatar
        :color="
          $vuetify.breakpoint.smAndDown ? 'grey darken-1 shrink' : 'transparent'
        "
        size="32"
      />

      <v-tabs centered class="ml-n9" color="grey darken-1">
        <v-tab v-for="link in links" :key="link">
          {{ link }}
        </v-tab>
      </v-tabs>

      <v-avatar
        class="hidden-sm-and-down"
        color="grey darken-1 shrink"
        size="32"
      />
    </v-app-bar>

    <v-main class="grey lighten-3">
      <v-container>
        <v-row align="center" justify="center" class="ma-0">
          <v-col cols="12" sm="10">
            <v-sheet min-height="70vh" rounded="lg">
              <slot />
            </v-sheet>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
export default {
  data: () => ({
    links: ['Expedientes', 'Requisitos', 'Plantillas', 'Clientes'],
    showUserMenu: false,
    accounts: null,
  }),
  methods: {
    url() {
      return location.pathname.substr(1)
    },
    hideDropdownMenus() {
      this.showUserMenu = false
    },
  },
}
</script>
