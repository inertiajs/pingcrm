<template>
  <v-card flat>
    <v-breadcrumbs :items="breadcrumbs" class="overline pb-0">
      <template v-slot:divider>
        <v-icon>mdi-chevron-right</v-icon>
      </template>
    </v-breadcrumbs>
    <search-filter v-model="form.search" class="overline" @reset="reset">
      <v-col cols="12" md="3" class="pa-1">
        <v-select
          v-model="form.trashed"
          :items="filtersOption.trashed"
          label="Filtro Eliminados:"
          dense
          hide-details
          outlined
          clearable
        />
      </v-col>
      <v-col cols="12" md="3" class="pa-1">
        <v-select
          v-model="form.role"
          :items="filtersOption.role"
          label="Filtro Roles:"
          dense
          hide-details
          outlined
          clearable
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
        <v-btn @click="create()">Crear Usuario</v-btn>
      </v-col>
    </v-row>

    <v-card-text>
      <data-table-wrapper
        :items="users.data"
        :headers="headers"
        :links="users.links"
        with-search
        sort-by="name"
      >
        <template #item="{ item }">
          <tr>
            <td>
              <v-avatar
                class="hidden-sm-and-down ma-1"
                color="grey darken-1 shrink"
                size="32"
              >
                <img v-if="item.photo" :src="item.photo" :alt="item.name">
              </v-avatar>
            </td>
            <td class="text-no-wrap">
              {{ item.name }}
            </td>
            <td class="text-no-wrap">
              {{ item.email }}
            </td>
            <td class="text-end">
              {{ item.owner ? 'Admin' : 'Usuario' }}
            </td>
            <td class="text-right">
              <v-icon v-if="item.deleted_at" color="warning">
                mdi-delete-restore
              </v-icon>
              <v-btn
                v-else-if="$page.props.auth.user.admin"
                text
                icon
                small
                @click="destroy(item.id)"
              >
                <v-icon color="error">
                  mdi-delete-alert-outline
                </v-icon>
              </v-btn>
              <v-btn text icon small @click="edit(item.id)">
                <v-icon small color="indigo">mdi-pencil</v-icon>
              </v-btn>
            </td>
          </tr>
        </template>
      </data-table-wrapper>
    </v-card-text>
    <Pagination
      v-if="users.links.length > 1"
      :links="users.links"
      :page="form.page"
      route="users"
      @input="v => (form.page = v)"
    />
  </v-card>
</template>

<script>
import Layout from '@/Shared/Layout'
import DataTableWrapper from '@/Shared/DataTableWrapper'
import SearchFilter from '@/Shared/SearchFilter'
import Pagination from '@/Shared/Pagination'
import { mapValues, pickBy, throttle } from 'lodash'

export default {
  metaInfo: { title: 'Usuarios' },
  layout: Layout,
  components: { DataTableWrapper, SearchFilter, Pagination },
  props: { users: Object, filters: Object },
  data() {
    return {
      headers: [
        { text: '', value: 'photo', sortable: false },
        { text: 'Nombre', value: 'name' },
        { text: 'Email', value: 'email' },
        { text: 'Rol', value: 'role', align: 'end', width: '75' },
        {
          text: '',
          align: 'end',
          width: '100',
          value: 'action',
          sortable: false,
        },
      ],
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
        role: this.filters.role,
        page: this.filters.page | 1,
      },
      filtersOption: {
        trashed: [
          { text: 'Con', value: 'with' },
          { text: 'Solamente', value: 'only' },
        ],
        role: [
          { text: 'Usuario', value: 'user' },
          { text: 'Admin', value: 'owner' },
        ],
      },
      breadcrumbs: [{ text: 'Usuarios' }],
    }
  },

  watch: {
    form: {
      handler: throttle(function() {
        let query = pickBy(this.form)
        this.$inertia.replace(
          this.route(
            'users',
            Object.keys(query).length ? query : { remember: 'forget' }
          )
        )
      }, 150),
      deep: true,
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
      this.form.page = 1
    },
    create() {
      this.$inertia.visit(this.route('users.create'))
    },
    edit(_user_id) {
      this.$inertia.visit(this.route('users.edit', _user_id))
    },
    destroy(_user_id) {
      if (confirm('Seguro en Eliminar el Usuario?')) {
        this.$inertia.delete(this.route('users.destroy', _user_id))
      }
    },
  },
}
</script>
