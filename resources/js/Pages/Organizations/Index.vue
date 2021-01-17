<template>
  <v-row>
    <v-col cols="12" class="mx-4 mt-2">
      <search-filter v-model="form.search" @reset="reset">
        <v-select v-model="form.trashed" :items="items" label="Trashed" />
        <v-text-field
          v-model="form.search"
          prepend-icon="mdi-magnify"
          placeholder="Search…"
          autocomplete="off"
          name="search"
          single-line
        />
      </search-filter>

      <!-- <v-row justify="end" dense> -->
      <!-- <v-col cols="auto" class="py-0"> -->
      <v-btn color="primary" @click="create">
        Create Organization
      </v-btn>
      <!-- </v-col> -->
      <!-- </v-row> -->
    </v-col>

    <v-col cols="12">
      <v-container>
        <data-table-wrapper
          :items="organizations.data"
          :headers="headers"
          :links="organizations.links"
          with-search
          sort-by="name"
        >
          <template #item="{ item }">
            <tr>
              <td>
                {{ item.name }}
              </td>
              <td>{{ item.city }}</td>
              <td>{{ item.phone }}</td>

              <td class="text-right">
                <template v-if="item.deleted_at">
                  <v-chip color="warning" outlined>
                    Deleted
                  </v-chip>
                </template>

                <v-btn text icon small @click="edit(item.id)">
                  <v-icon small>mdi-pencil</v-icon>
                </v-btn>
              </td>
            </tr>
          </template>
        </data-table-wrapper>
      </v-container>
    </v-col>
  </v-row>
</template>

<script>
import Layout from '@/Shared/Layout'
import DataTableWrapper from '@/Shared/DataTableWrapper'
import SearchFilter from '@/Shared/SearchFilter'
import mapValues from 'lodash/mapValues'
import pickBy from 'lodash/pickBy'
import throttle from 'lodash/throttle'

export default {
  metaInfo: { title: 'Organizaciones' },

  layout: (h, page) => h(Layout, [page]),
  components: { SearchFilter, DataTableWrapper },

  props: { organizations: Object, filters: Object },
  data() {
    return {
      headers: [
        { text: 'Nombre', value: 'name' },
        { text: 'Ciudad', value: 'city' },
        { text: 'Telfono', value: 'phone' },
        { text: 'Accion', sortable: false },
      ],
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
      },
      items: ['', 'with', 'only'],
    }
  },

  watch: {
    form: {
      handler: throttle(function() {
        let query = pickBy(this.form)
        this.$inertia.replace(
          this.route(
            'organizations',
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
    },
    create() {
      this.$inertia.visit(this.route('organizations.create'))
    },
    edit(_organisation) {
      this.$inertia.visit(this.route('organizations.edit', _organisation))
    },
  },
}
</script>
