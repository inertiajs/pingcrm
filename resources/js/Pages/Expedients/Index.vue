<template>
  <v-card flat>
    <v-breadcrumbs :items="breadcrumbs" class="overline pb-0">
      <template v-slot:divider>
        <v-icon>mdi-chevron-right</v-icon>
      </template>
    </v-breadcrumbs>
    <search-filter v-model="form.search" @reset="reset">
      <v-col cols="12" md="3" class="pa-1">
        <v-select
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
    <v-row class="text-end px-4" no-gutters justify="end" align="center">
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
              <v-card color="grey lighten-2" :elevation="hover ? 12 : 2">
                <v-toolbar flat>
                  <v-toolbar-title class="grey--text">
                    {{ `#${expedient.id.toString().padStart(5, 0)}` }}
                  </v-toolbar-title>

                  <v-spacer />

                  <v-btn icon>
                    <v-icon>mdi-magnify</v-icon>
                  </v-btn>

                  <v-btn icon>
                    <v-icon>mdi-apps</v-icon>
                  </v-btn>

                  <v-btn icon>
                    <v-icon>mdi-dots-vertical</v-icon>
                  </v-btn>
                </v-toolbar>

                <v-divider />

                <v-card-title class="text-h6 text--primary">
                  {{ expedient.name }}
                </v-card-title>
                <v-card-text>
                  <div>Word of the Day</div>
                  <p class="display-1 text--primary">
                    el·ee·mos·y·nar·y
                  </p>
                  <p>adjective</p>
                  <div class="text--primary">
                    relating to or dependent on charity; charitable.<br>
                    "an eleemosynary educational institution."
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
// import DataTableWrapper from '@/Shared/DataTableWrapper'
import mapValues from 'lodash/mapValues'
import pickBy from 'lodash/pickBy'
import throttle from 'lodash/throttle'
import SearchFilter from '@/Shared/SearchFilter'
import Pagination from '@/Shared/Pagination'

export default {
  metaInfo: { title: 'Expedientes' },
  layout: Layout,
  components: { SearchFilter, Pagination },
  props: { expedients: Object, filters: Object },
  data() {
    return {
      headers: [
        { text: 'ID', width: '75', value: 'id' },
        { text: 'Nombre', value: 'name' },
        {
          text: '',
          align: 'end',
          width: '250',
          value: 'action',
          sortable: false,
        },
      ],
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
        page: this.filters.page | 1,
      },
      items: [
        { text: '(Vacio)', value: '' },
        { divider: true },
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
    edit(_expedient) {
      this.$inertia.visit(this.route('expedients.edit', _expedient))
    },
  },
}
</script>
