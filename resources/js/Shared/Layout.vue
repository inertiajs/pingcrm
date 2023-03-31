<template>
  <v-app id="inspire">
    <v-app-bar app color="white" flat>
      <v-menu offset-y open-on-hover>
        <template v-slot:activator="{ on, attrs }">
          <div class="d-flex d-flex-row align-center" v-bind="attrs" v-on="on">
            <v-avatar
              class="hidden-sm-and-down"
              color="grey darken-1 shrink"
              size="36"
            >
              <img
                v-if="$page.props.auth.user.photo"
                :src="$page.props.auth.user.photo"
                :alt="$page.props.auth.user.first_name"
              >
            </v-avatar>
            <v-chip label outlined class="overline ml-2">
              {{ $page.props.auth.user.first_name }}
            </v-chip>
          </div>
        </template>
        <v-list>
          <v-list-item>
            <v-list-item-title>
              <!-- {{ item.title }} -->
              <inertia-link
                class="overline"
                :href="route('logout')"
                method="post"
                as="button"
              >
                Cerrar Sesion
              </inertia-link>
            </v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>

      <v-tabs v-model="active" centered color="red darken-4">
        <template v-for="tab in $page.props.tabs">
          <v-tab v-if="tab.show" :key="tab.label" @click="click(tab)">
            {{ tab.label }}
          </v-tab>
        </template>
      </v-tabs>
    </v-app-bar>

    <v-main class="grey lighten-3">
      <v-container>
        <v-row align="center" justify="center" class="ma-0">
          <v-col cols="12">
            <v-sheet rounded="lg">
              <!-- <h4>{{ url() }} {{ active }}</h4> -->
              <flash-messages />
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
import FlashMessages from '@/Shared/FlashMessages'

export default {
  components: { FlashMessages },

  data: () => ({
    showUserMenu: false,
    accounts: null,
    active: null,
    items: [{ title: 'Logout', route: 'logout' }],
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
