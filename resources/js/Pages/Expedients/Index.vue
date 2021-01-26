<template>
  <v-card flat>
    <breadcrumbs :breadcrumbs="breadcrumbs" />

    <search-filter v-model="form.search" @reset="reset">
      <v-col cols="12" md="3" class="pa-1">
        <v-select
          v-if="$page.props.auth.user.admin"
          v-model="form.trashed"
          :items="items"
          label="Filtro Elminados:"
          dense
          hide-details
          outlined
        />
      </v-col>
      <v-col cols="12" md="3" class="pa-1">
        <v-text-field
          v-model="form.search"
          label="Filtro:"
          placeholder=""
          outlined
          dense
          append-icon="mdi-magnify"
          hide-details
        />
      </v-col>
    </search-filter>
    <v-row
      v-if="$page.props.auth.user.admin"
      class="text-end px-4"
      no-gutters
      justify="end"
      align="center"
    >
      <v-col cols="12" md="3" class="pa-2">
        <v-btn @click="create()">Crear Expediente</v-btn>
      </v-col>
    </v-row>

    <v-card-text>
      <v-row>
        <template v-if="expedients.data.length >= 1">
          <v-col
            v-for="expedient in expedients.data"
            :key="expedient.id"
            cols="12"
            md="6"
          >
            <v-hover v-slot="{ hover }">
              <v-card color="grey lighten-3" :elevation="hover ? 12 : 2" shaped>
                <v-toolbar>
                  <v-toolbar-title class="grey--text">
                    {{ `#${expedient.id.toString().padStart(5, 0)}` }}
                    <v-chip v-if="expedient.deleted_at" label color="warning">
                      Eliminado
                    </v-chip>
                  </v-toolbar-title>

                  <v-spacer />

                  <v-btn
                    v-if="$page.props.auth.user.admin"
                    icon
                    @click="adminExpedient(expedient.id)"
                  >
                    <v-icon>mdi-eye</v-icon>
                  </v-btn>

                  <v-btn icon @click="show(expedient.id)">
                    <v-icon>mdi-apps</v-icon>
                  </v-btn>

                  <v-menu
                    v-if="$page.props.auth.user.admin"
                    offset-y
                    bottom
                    left
                  >
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn icon v-bind="attrs" v-on="on">
                        <v-icon>mdi-dots-vertical</v-icon>
                      </v-btn>
                    </template>

                    <v-list dense>
                      <v-list-item
                        v-if="!expedient.deleted_at"
                        dense
                        class="error"
                        @click="destroy(expedient.id)"
                      >
                        <span class="overline white--text">Eliminar</span>
                      </v-list-item>
                      <v-list-item
                        v-if="expedient.deleted_at"
                        dense
                        class="orange"
                        @click="restore(expedient.id)"
                      >
                        <span class="overline white--text">Restore</span>
                      </v-list-item>
                    </v-list>
                  </v-menu>
                </v-toolbar>

                <v-divider />

                <v-card-title class="text-h6 text--primary text-uppercase">
                  <span class="orange--text font-weight-black">
                    {{ expedient.name }}
                  </span>
                </v-card-title>
                <v-card-text class="indigo--text font-weight-medium">
                  <div class="overline">
                    Fecha Creacion:
                    {{
                      Intl.DateTimeFormat('es-MX', {
                        dateStyle: 'long',
                      }).format(new Date(expedient.created_at))
                    }}
                  </div>
                  <p class="display-1 text--primary mb-0 font-weight-black">
                    {{ expedient.owner_user.name }}
                  </p>
                  <p>{{ expedient.owner_user.email }}</p>
                  <div class="font-italic">
                    {{ expedient.template }}
                  </div>
                </v-card-text>
              </v-card>
            </v-hover>
          </v-col>
        </template>
        <template v-else>
          <v-col>
            <v-banner class="accent lighten-2 overline text-center" single-line>
              <v-icon slot="icon" size="36">
                mdi-information
              </v-icon>
              Sin resultados
            </v-banner>
          </v-col>
        </template>
      </v-row>
    </v-card-text>
    <Pagination
      v-if="expedients.links.length > 1"
      :links="expedients.links"
      :page="form.page"
      route="expedients"
      @input="v => (form.page = v)"
    />
  </v-card>
</template>

<script>
import Layout from '@/Shared/Layout'
import { mapValues, pickBy, throttle } from 'lodash'
import SearchFilter from '@/Shared/SearchFilter'
import Pagination from '@/Shared/Pagination'
import Breadcrumbs from '@/Shared/Breadcrumbs'

export default {
  metaInfo: { title: 'Expedientes' },
  layout: Layout,
  components: { SearchFilter, Pagination, Breadcrumbs },
  props: { expedients: Object, filters: Object },
  data() {
    return {
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
        page: this.filters.page | 1,
      },
      items: [
        { text: '(Vacio)', value: '' },
        { text: 'Con', value: 'with' },
        { text: 'Solamente', value: 'only' },
      ],
      breadcrumbs: [{ text: 'Expedientes', disabled: false }],
    }
  },

  watch: {
    form: {
      handler: throttle(function() {
        let query = pickBy(this.form)
        this.$inertia.replace(
          this.route(
            'expedients',
            Object.keys(query).length ? query : { remember: 'forget' }
          )
        )
      }, 150),
      deep: true,
    },
  },
  methods: {
    search(value) {
      // eslint-disable-next-line no-console
      console.log(value, 'input')
    },
    reset() {
      this.form = mapValues(this.form, () => null)
      this.form.page = 1
    },
    create() {
      this.$inertia.visit(this.route('expedients.create'))
    },
    adminExpedient(_expedient_id) {
      this.$inertia.visit(this.route('expedients.documents', _expedient_id))
    },
    show(_expedient_id) {
      this.$inertia.visit(this.route('expedients.show', _expedient_id))
    },
    destroy(_expedient_id) {
      if (confirm('Seguro en Eliminar este Expediente?')) {
        this.$inertia.delete(this.route('expedients.destroy', _expedient_id))
      }
    },
    restore(_expedient_id) {
      if (confirm('Seguro en Restaurar este Expediente?')) {
        this.$inertia.put(this.route('expedients.restore', _expedient_id))
      }
    },
  },
}
</script>
