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
        <v-btn @click="create()">Crear Plantilla</v-btn>
      </v-col>
    </v-row>

    <v-card-text>
      <data-table-wrapper
        :items="templates.data"
        :headers="headers"
        :links="templates.links"
        with-search
        sort-by="name"
      >
        <template #item="{ item }">
          <tr>
            <td>
              {{ item.id }}
            </td>
            <td class="text-no-wrap">
              {{ item.name }}
            </td>
            <td class="text-no-wrap text-center">
              {{ item.requirements_count }}
            </td>
            <td class="text-right">
              <v-chip v-if="item.deleted_at" color="warning" outlined x-small>
                Eliminado
              </v-chip>

              <v-btn text icon small @click="edit(item.id)">
                <v-icon small>mdi-pencil</v-icon>
              </v-btn>
            </td>
          </tr>
        </template>
      </data-table-wrapper>
    </v-card-text>
    <Pagination
      v-if="templates.links.length > 1"
      :links="templates.links"
      :page="form.page"
      route="templates"
      @input="v => (form.page = v)"
    />
  </v-card>
</template>

<script>
import Layout from '@/Shared/Layout'
import DataTableWrapper from '@/Shared/DataTableWrapper'
import mapValues from 'lodash/mapValues'
import pickBy from 'lodash/pickBy'
import throttle from 'lodash/throttle'
import SearchFilter from '@/Shared/SearchFilter'
import Pagination from '@/Shared/Pagination'

export default {
  metaInfo: { title: 'Plantillas' },
  layout: Layout,
  components: { DataTableWrapper, SearchFilter, Pagination },
  props: { templates: Object, filters: Object },
  data() {
    return {
      headers: [
        { text: 'ID', width: '75', value: 'id' },
        { text: 'Nombre', value: 'name' },
        {
          text: 'Requisitos',
          value: 'requirements_count',
          align: 'center',
          width: '200',
        },
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
      breadcrumbs: [{ text: 'Plantillas', disabled: false }],
    }
  },

  watch: {
    form: {
      handler: throttle(function() {
        let query = pickBy(this.form)
        this.$inertia.replace(
          this.route(
            'templates',
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
      this.$inertia.visit(this.route('templates.create'))
    },
    edit(_template) {
      this.$inertia.visit(this.route('templates.edit', _template))
    },
  },
}
</script>
