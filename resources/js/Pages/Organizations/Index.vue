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
        <button @click="showModal = true" class="btn-indigo mx-4" title="Visible Columns">
          <font-awesome-icon icon="table-cells" />
        </button>

        <!-- Modal pop-up -->
        <div v-if="showModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
          <div class="bg-white rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-xl font-bold mb-4">Select Columns</h2>

            <div class="grid grid-cols-2 gap-4">
              <div v-for="column in columns" :key="column.name" class="flex items-center">
                <input type="checkbox" v-model="column.visible" class="mr-2" :disabled="column.disabled" />
                <label>{{ column.label }}</label>
              </div>
            </div>

            <div class="flex justify-end mt-6">
              <button @click="applyChanges" class="btn-green px-4 py-2">Apply</button>
              <button @click="showModal = false" class="ml-4 btn-red px-4 py-2">Cancel</button>
            </div>
          </div>
        </div>

        <button class="btn-indigo mx-4" title="Visible Columns" @click="triggerFileInput">
          <font-awesome-icon icon="file-import" />
        </button>
        <input type="file" ref="fileInput" accept=".csv" @change="handleFileUpload" style="display: none;" />

        <Link class="btn-indigo mx-4" href="/organizations/create" title="Create Organization">
        <font-awesome-icon icon="plus" />
        </Link>
      </div>


    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto max-h-96">
      <table class="w-full whitespace-nowrap">
        <thead class="bg-white sticky top-0 z-10">
          <draggable v-model="columns" tag="tr" class="cursor-pointer text-left font-bold text-sm hover:cursor-grab">
            <template #item="{ element: column }">
              <th v-if="isVisible(column.name)" class="pb-4 pt-6 pl-3 sticky top-0 z-10">
                <font-awesome-icon icon="grip-vertical" />
                {{ column.label }}
              </th>
            </template>
          </draggable>
        </thead>
        <tbody>
          <tr v-for="organization in organizations.data" :key="organization.id"
            class="hover:bg-gray-100 focus-within:bg-gray-100 text-sm">
            <td v-for="column in columns" :key="column.name" class="border-t">
              <Link class="flex items-center pl-3 py-4 focus:text-indigo-500" v-if="isVisible(column.name)"
                :href="`/organizations/${organization.id}/edit`">
              {{ organization[column.name] }}
              <icon v-if="organization.deleted_at" name="trash" class="shrink-0 ml-2 w-3 h-3 fill-gray-400" />
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-4" :href="`/organizations/${organization.id}/edit`" tabindex="-1">
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
import { Head, Link, } from '@inertiajs/vue3'
import Icon from '@/Shared/Icon.vue'
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout.vue'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination.vue'
import SearchFilter from '@/Shared/SearchFilter.vue'
import draggable from 'vuedraggable'

export default {
  components: {
    Head,
    Icon,
    Link,
    Pagination,
    SearchFilter,
    draggable,
  },
  layout: Layout,
  props: {
    filters: Object,
    organizations: Object,
    visibleColumns: Array,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
      },
      showModal: false,
      columns: [
        { name: 'name', label: 'Name', visible: this.visibleColumns.includes('name') || true, disabled: true },
        { name: 'phone', label: 'Phone', visible: this.visibleColumns.includes('phone') || true, disabled: true },
        { name: 'email', label: 'Email', visible: this.visibleColumns.includes('email') || true, disabled: true },
        { name: 'address', label: 'Address', visible: this.visibleColumns.includes('address') },
        { name: 'city', label: 'City', visible: this.visibleColumns.includes('city') || true, disabled: true },
        { name: 'region', label: 'Region', visible: this.visibleColumns.includes('region') },
        { name: 'country', label: 'Country', visible: this.visibleColumns.includes('country') },
        { name: 'postal_code', label: 'Postal Code', visible: this.visibleColumns.includes('postal_code') },
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
    isVisible(columnName) {
      return this.columns.find(column => column.name === columnName).visible
    },
    applyChanges() {
      this.showModal = false;

      const selectedColumns = this.columns
        .filter(column => column.visible)
        .map(column => column.name);


      this.$inertia.post('/organizations/column', {
        columns: selectedColumns,
      });
    },
    triggerFileInput() {
      this.$refs.fileInput.click();
    },
    handleFileUpload(event) {
      const file = event.target.files[0];
      if (file) {
        // Handle the CSV file upload logic here
        console.log("CSV file selected:", file);
      }
    }
  },
}
</script>
