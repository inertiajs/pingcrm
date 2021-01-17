<template>
  <v-app id="inspire">
    <v-app-bar app color="white" flat>
      <v-avatar
        :color="
          $vuetify.breakpoint.smAndDown ? 'grey darken-1 shrink' : 'transparent'
        "
        size="32"
      />
      <v-tabs
        v-if="$page.props.tabs"
        v-model="active"
        centered
        color="grey darken-1"
      >
        <v-tab
          v-for="tab in $page.props.tabs"
          :key="tab.label"
          @click="click(tab)"
        >
          {{ tab.label }}
        </v-tab>
      </v-tabs>
      <v-menu offset-y open-on-hover>
        <template v-slot:activator="{ on, attrs }">
          <v-avatar
            class="hidden-sm-and-down"
            color="grey darken-1 shrink"
            size="36"
            v-bind="attrs"
            v-on="on"
          >
            <img
              v-if="$page.props.auth.user.photo"
              :src="$page.props.auth.user.photo"
              :alt="$page.props.auth.user.name"
            >
          </v-avatar>
        </template>
        <v-list>
          <v-list-item v-for="(item, index) in items" :key="index">
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
    </v-app-bar>

    <v-main class="grey lighten-3">
      <v-container>
        <v-row align="center" justify="center" class="ma-0">
          <v-col cols="12" sm="10">
            <v-sheet rounded="lg">
              <!-- <h4>{{ url() }} {{ active }}</h4> -->
              <slot />
            </v-sheet>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
    <!-- Modal Portal -->
    <portal-target name="modal" multiple />
  </v-app>
</template>

<script>
export default {
  data: () => ({
    showUserMenu: false,
    accounts: null,
    active: null,
    items: [{ title: 'Account' }, { title: 'Logout' }],
  }),
  mounted() {
    for (const key in this.$page.props.tabs) {
      if (!this.$page.props.tabs[key].route) {
        this.active = parseInt(key)
        return
      }
    }
  },
  methods: {
    url() {
      return location.pathname.substr(1)
    },
    hideDropdownMenus() {
      this.showUserMenu = false
    },
    click(tab) {
      this.$inertia.visit(this.route(tab.route))
    },
  },
}
</script>
