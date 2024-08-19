<template>
  <div>

    <Head title="Contacts" />
    <h1 class="mb-8 text-3xl font-bold">Contacts</h1>
    <div class="flex items-center justify-between mb-6">
      <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
        <label class="block text-gray-700">Trashed:</label>
        <select v-model="form.trashed" class="form-select mt-1 w-full">
          <option :value="null" />
          <option value="with">With Trashed</option>
          <option value="only">Only Trashed</option>
        </select>
      </search-filter>
      <div>
        <button @click="showModal = true" class="btn-indigo mx-4 px-3 py-2" title="Add New Columns">
          <font-awesome-icon icon="table-cells" />
        </button>
        <div v-if="showModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
          <div class="bg-white rounded-lg shadow-lg p-4 w-72">
            <h2 class="text-xl font-bold mb-4">Add New Columns</h2>
            <div class="flex flex-col">
              <div class="flex items-center justify-between">
                <label for="name" class="block text-sm font-medium text-gray-700">Column Name</label>
                <input type="text" id="name"
                  class="mt-1 block w-1/2 py-1  px-2 text-base border-2 border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" />
              </div>
              <div class="flex items-center justify-between mt-4">
                <label for="type" class="block text-sm font-medium text-gray-700">Data Type</label>
                <select id="type"
                  class="mt-1 block w-1/2 py-2text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                  <option>string</option>
                  <option>number</option>
                  <option>date</option>
                  <option>boolean</option>
                </select>
              </div>
            </div>



            <div class="flex justify-end mt-6">
              <button @click="applyChanges" class="btn-green px-4 py-2">Apply</button>
              <button @click="showModal = false" class="ml-4 btn-red px-4 py-2">Cancel</button>
            </div>
          </div>
        </div>
        <button class="btn-indigo mr-4  px-3 py-2" title="Import CSV" @click="triggerFileInput">
          <font-awesome-icon icon="file-import" />
        </button>
        <input type="file" ref="fileInput" accept=".csv" @change="handleFileUpload" style="display: none;" />

        <div v-if="showCsvModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
          <div class="bg-white rounded-lg shadow-lg p-6 w-1/3 max-w-4xl relative">

            <h2 class="text-xl font-bold mb-4">CSV Columns</h2>
            <button @click="handleCancel" class="absolute top-2 right-2 bg-transparent px-3 py-1 mr-2" title="Go Back">
              <font-awesome-icon icon="xmark" class="text-black" />
            </button>

            <table class="w-full table-auto border-collapse">
              <thead>
                <tr>
                  <th class="border font-bold text-left p-2">CSV Column</th>
                  <th class="border font-bold text-left p-2">DB Column</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="csvColumn in csvColumns" :key="csvColumn" :class="{
                  'bg-green-500': matchingColumn(csvColumn),
                  'bg-yellow-500': !matchingColumn(csvColumn)
                }">
                  <td class="border p-2">{{ csvColumn }}</td>
                  <td class="border p-2 w-1/2">
                    <select v-model="selectedDbColumns[csvColumn]" style="width: 120px; background-color:transparent;">
                      <option v-if="matchingColumn(csvColumn)">
                        {{ matchingColumn(csvColumn).name }}
                      </option>
                      <option v-else v-for="dbColumn in availableDbColumns(csvColumn)" :key="dbColumn.name"
                        :value="dbColumn.name">
                        {{ dbColumn.name }}
                      </option>
                    </select>

                  </td>
                </tr>
              </tbody>
            </table>

            <div class="flex justify-end mt-6">
              <button @click="handleCancel" class="btn-red px-4 py-2">Cancel</button>
              <button @click="applyCsvChanges" class="ml-4 btn-green px-4 py-2">Continue</button>

            </div>
          </div>
        </div>

        <div v-if="PreviewModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50">
          <div class="bg-white rounded-lg shadow-lg p-6 w-auto min-h-1/2 max-w-4xl relative">
            <!-- Back Button -->
            <button @click="handleCancel" class="absolute top-2 right-2 bg-transparent px-3 py-1 mr-2">
              <font-awesome-icon icon="xmark" class="text-black" />
            </button>
            <h2 class="text-xl font-bold mb-4">Preview Data <span class="text-xs">(Upto 100 Rows)</span></h2>
            <!-- Preview Table -->
            <div class="bg-white rounded-md shadow overflow-x-auto max-h-64">
              <table class="w-full table-auto border-collapse">
                <thead>
                  <tr>
                    <th v-for="csvColumn in csvColumns" :key="csvColumn" class="border-b font-bold text-left p-2">
                      <span v-if="selectedDbColumns[csvColumn] || matchingColumn(csvColumn)">{{
                        matchingColumn(csvColumn) ? matchingColumn(csvColumn).name : selectedDbColumns[csvColumn]
                      }}</span>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(row, rowIndex) in csvData.slice(0, 100)" :key="rowIndex">
                    <td v-for="csvColumn in csvColumns" :key="csvColumn" class="border-b p-2">
                      <span v-if="selectedDbColumns[csvColumn] || matchingColumn(csvColumn)">{{
                        getValueForColumn(row, csvColumn) !== 'N/A' ? getValueForColumn(row, csvColumn) : ''
                      }}</span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- Organization Dropdown -->
            <div class="mt-4">
              <label for="organization" class="block text-sm font-medium text-gray-700">Select Organization</label>
              <select id="organization" v-model="selectedOrganization"
                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option disabled value="">Please select an organization</option>
                <option v-for="organization in organizations" :key="organization.id" :value="organization.id">
                  {{ organization.name }}
                </option>
              </select>
            </div>
            <!-- Buttons -->
            <div class="flex justify-end mt-6">
              <button @click="goBack" class="btn-yellow px-4 py-2 mr-auto">
                Back
              </button>
              <button @click="handleCancel" class="ml-4 btn-red px-4 py-2">Cancel</button>
              <button @click="applyPreviewChanges" class="btn-green px-4 py-2 ml-4">Import</button>
            </div>
          </div>
        </div>

        <Link class="btn-indigo   px-3 py-2" href="/contacts/create" title="Create Contact">
        <font-awesome-icon icon="plus" />
        </Link>
      </div>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="pb-4 pt-6 px-6">Name</th>
          <th class="pb-4 pt-6 px-6">Organization</th>
          <th class="pb-4 pt-6 px-6">City</th>
          <th class="pb-4 pt-6 px-6" colspan="2">Phone</th>
        </tr>
        <tr v-for="contact in contacts.data" :key="contact.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/contacts/${contact.id}/edit`">
            {{ contact.name }}
            <icon v-if="contact.deleted_at" name="trash" class="shrink-0 ml-2 w-3 h-3 fill-gray-400" />
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/contacts/${contact.id}/edit`" tabindex="-1">
            <div v-if="contact.organization">
              {{ contact.organization.name }}
            </div>
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/contacts/${contact.id}/edit`" tabindex="-1">
            {{ contact.city }}
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/contacts/${contact.id}/edit`" tabindex="-1">
            {{ contact.phone }}
            </Link>
          </td>
          <td class="w-px border-t">
            <Link class="flex items-center px-4" :href="`/contacts/${contact.id}/edit`" tabindex="-1">
            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </Link>
          </td>
        </tr>
        <tr v-if="contacts.data.length === 0">
          <td class="px-6 py-4 border-t" colspan="4">No contacts found.</td>
        </tr>
      </table>
    </div>
    <pagination class="mt-6" :links="contacts.links" />
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
import Papa from 'papaparse'

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
    contacts: Object,
    organizations: Object
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
      },
      showModal: false,
      showCsvModal: false,
      PreviewModal: false,
      csvData: [],
      csvColumns: [],
      selectedDbColumns: {},
      selectedOrganization: '',
      columns: [
        { name: 'name', label: 'Name' },
        { name: 'organization', label: 'Organization' },
        { name: 'city', label: 'City' },
        { name: 'phone', label: 'Phone' },
      ],
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/contacts', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
    triggerFileInput() {
      this.$refs.fileInput.click();
    },
    handleFileUpload(event) {
      const file = event.target.files[0];
      if (file) {
        Papa.parse(file, {
          header: true,
          complete: (results) => {
            console.log("CSV file contents:", results.meta.fields);
            this.csvColumns = results.meta.fields;
            this.csvData = results.data;
            this.showCsvModal = true
            console.log(this.csvData)
          },
          error: (error) => {
            console.error("Error parsing CSV file:", error);
          }
        });
      }
    },
    matchingColumn(csvColumn) {
      return this.columns.find(col => col.name === csvColumn);
    },
    availableDbColumns(csvColumn) {
      const selected = new Set(Object.values(this.selectedDbColumns));
      return this.columns.filter(col => !selected.has(col.name) || col.name === this.selectedDbColumns[csvColumn]);
    },

    mapCsvToDbColumns() {
      return this.csvData.map(row => {
        let mappedRow = {};
        for (let csvColumn of this.csvColumns) {
          let dbColumn = this.selectedDbColumns[csvColumn];
          if (dbColumn) {
            mappedRow[dbColumn] = row[csvColumn];
          }
        }

        if (this.selectedOrganization) {
          mappedRow.organization_id = this.selectedOrganization;
        }

        return mappedRow;
      });
    },

    applyCsvChanges() {
      const dataToInsert = this.mapCsvToDbColumns();
      console.log(dataToInsert)
      this.showCsvModal = false
      this.PreviewModal = true
    },

    getValueForColumn(row, csvColumn) {
      return row[csvColumn] || 'N/A';
    },

    async applyPreviewChanges() {
      const dataToInsert = this.mapCsvToDbColumns();
      console.log(dataToInsert)

      this.$inertia.post('/contacts/import-csv', { data: dataToInsert }, {
        onSuccess: () => {
          this.PreviewModal = false;
          window.location.reload();
        },
        onError: (error) => {
          console.error("Error occurred while processing data:", error);
        }
      });

    },

    goBack() {
      this.PreviewModal = false;
      this.showCsvModal = true;
    },
    handleCancel() {
      window.location.reload()
    },

    applyChanges() {
      const name = document.getElementById('name').value;
      const type = document.getElementById('type').value;

      this.$inertia.post('/contacts/add-column', { name, type }, {
        onSuccess: () => {
          this.showModal = false;
          window.location.reload();
        },
        onError: (error) => {
          console.error("Error occurred while adding column:", error);
        }
      });

    },

  },
}
</script>
