<template>
  <div>

    <Head title="Organizations" />
    <h1 class="mb-8 text-3xl font-bold">Organizations</h1>
    <div class="flex items-center justify-between mb-6">
      <search-filter v-model="form.search" class="mr-4 w-2/5 max-w-md" @reset="reset">
        <label class="block text-gray-700">Trashed:</label>
        <select v-model="form.trashed" class="form-select mt-1 w-full">
          <option :value="null" />
          <option value="with">With Trashed</option>
          <option value="only">Only Trashed</option>
        </select>
      </search-filter>
      <div>
        <!-- Button to trigger the modal -->
        <button @click="showModal = true" class="btn-indigo-light ml-24 px-4">
          <font-awesome-icon icon="table-cells" fade />
          Visible Columns
        </button>

        <!-- Modal pop-up -->
        <div v-if="showModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
          <div class="bg-white rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-xl font-bold mb-4">Select Columns</h2>

            <div class="grid grid-cols-2 gap-4">
              <div v-for="column in columns" :key="column.name" class="flex items-center">
                <input type="checkbox" v-model="column.visible" class="mr-2" />
                <label>{{ column.label }}</label>
              </div>
            </div>

            <div class="flex justify-end mt-6">
              <button @click="applyChanges" class="btn-green px-4 py-2">Apply</button>
              <button @click="showModal = false" class="ml-4 btn-red px-4 py-2">Cancel</button>
            </div>
          </div>
        </div>

      </div>
      <Link class="btn-indigo" href="/organizations/create">
      <span>Create</span>
      <span class="hidden md:inline">&nbsp;Organization</span>
      </Link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <thead>
          <tr class="text-left font-bold text-sm">
            <th class="pb-4 pt-6 pl-3">Name</th>
            <th class="pb-4 pt-6 pl-3">Phone</th>
            <th class="pb-4 pt-6 pl-3">Email</th>
            <th class="pb-4 pt-6 pl-3">Address</th>
            <th class="pb-4 pt-6 pl-3">City</th>
            <th class="pb-4 pt-6 pl-3">Region</th>
            <th class="pb-4 pt-6 pl-3">Country</th>
            <th class="pb-4 pt-6 pl-6">Postal Code</th>


          </tr>
        </thead>
        <tbody>
          <tr v-for="organization in organizations.data" :key="organization.id"
            class="hover:bg-gray-100 focus-within:bg-gray-100 text-sm">
            <td class="border-t">
              <Link class="flex items-center pl-3 py-4 focus:text-indigo-500"
                :href="`/organizations/${organization.id}/edit`">
              {{ organization.name }}
              <icon v-if="organization.deleted_at" name="trash" class="shrink-0 ml-2 w-3 h-3 fill-gray-400" />
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center pl-3 py-4" :href="`/organizations/${organization.id}/edit`" tabindex="-1">
              {{ organization.phone }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center pl-3 py-4" :href="`/organizations/${organization.id}/edit`" tabindex="-1">
              {{ organization.email }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center pl-3 py-4" :href="`/organizations/${organization.id}/edit`" tabindex="-1">
              {{ organization.address }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center pl-3 py-4" :href="`/organizations/${organization.id}/edit`" tabindex="-1">
              {{ organization.city }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center pl-3 py-4" :href="`/organizations/${organization.id}/edit`" tabindex="-1">
              {{ organization.region }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items center pl-3 py-4" :href="`/organizations/${organization.id}/edit`" tabindex="-1">
              {{ organization.country }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-start pl-6 py-4" :href="`/organizations/${organization.id}/edit`" tabindex="-1">
              {{ organization.postal_code }}
              </Link>
            </td>
            <td class="w-px border-t">
              <Link class="flex items-center pl-3" :href="`/organizations/${organization.id}/edit`" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
              </Link>
            </td>
          </tr>
          <tr v-if="organizations.data.length === 0">
            <td class="px-6 py-4 border-t" colspan="4">No organizations found.</td>
          </tr>
        </tbody>
      </table>
    </div>
    <pagination class="mt-6" :links="organizations.links" />
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import Icon from '@/Shared/Icon.vue'
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout.vue'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination.vue'
import SearchFilter from '@/Shared/SearchFilter.vue'

export default {
  components: {
    Head,
    Icon,
    Link,
    Pagination,
    SearchFilter,
  },
  layout: Layout,
  props: {
    filters: Object,
    organizations: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
      },
      showModal: false,
      columns: [
        { name: 'name', label: 'Name', visible: true },
        { name: 'phone', label: 'Phone', visible: true },
        { name: 'email', label: 'Email', visible: true },
        { name: 'address', label: 'Address', visible: true },
        { name: 'city', label: 'City', visible: true },
        { name: 'region', label: 'Region', visible: true },
        { name: 'country', label: 'Country', visible: true },
        { name: 'postal_code', label: 'Postal Code', visible: true },
      ],

    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/organizations', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
    applyChanges() {
      this.showModal = false
    },
  },
}
</script>
