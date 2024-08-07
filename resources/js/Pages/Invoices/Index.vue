<template>
  <div>
    <Head title="Invoices" />
    <h1 class="mb-8 text-3xl font-bold">Invoices</h1>
    <div class="flex items-center justify-between mb-6">
      <!-- Search Field -->
      <div class="flex-1 max-w-md mr-4">
        <input
          type="search"
          v-model="search"
          placeholder="Search invoices..."
          class="form-input w-1/2 px-4 py-2 border rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        />
      </div>
      <!-- Create Button -->
      <Link class="btn-indigo" href="/invoices/create">
        <span>Create</span>
        <span class="hidden md:inline">&nbsp;Invoice</span>
      </Link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <thead>
          <tr class="text-left font-bold">
            <th class="pb-4 pt-6 px-6">Number</th>
            <th class="pb-4 pt-6 px-6">Amount</th>
            <th class="pb-4 pt-6 px-6">Organization</th>
            <th class="pb-4 pt-6 px-6">Contact</th>
            <th class="pb-4 pt-6 px-6" colspan="2">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="invoice in invoices.data" :key="invoice.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t px-6 py-4">{{ invoice.number }}</td>
            <td class="border-t px-6 py-4">৳{{ invoice.amount }}</td>
            <td class="border-t px-6 py-4">{{ invoice.organization.name }}</td>
            <!-- <td class="border-t px-6 py-4">{{ invoice.contact.name }}</td> -->
            <td class="w-px border-t">
              <Link class="flex items-center px-4" :href="`/invoices/${invoice.id}/edit`" tabindex="-1">
                <icon name="edit" class="block w-6 h-6 fill-gray-400" />
              </Link>
            </td>
            <td class="w-px border-t">
              <Link class="flex items-center px-4" :href="`/invoices/${invoice.id}`" tabindex="-1">
                <icon name="view" class="block w-6 h-6 fill-gray-400" />
              </Link>
            </td>
          </tr>
          <tr v-if="invoices.data.length === 0">
            <td class="px-6 py-4 border-t" colspan="6">No invoices found.</td>
          </tr>
        </tbody>
      </table>
    </div>
    <pagination class="mt-6" :links="invoices.links" />
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import Icon from '@/Shared/Icon.vue'
import Layout from '@/Shared/Layout.vue'
import Pagination from '@/Shared/Pagination.vue'
import SearchFilter from '@/Shared/SearchFilter.vue'

export default {
  components: {
    Head,
    Icon,
    Link,
    Pagination,
    SearchFilter
  },
  props: {
    invoices: Object,
  },
  layout: Layout,
  data() {
    return {
      search: '',
    }
  },
  watch: {
    search(newSearch) {
      this.$inertia.get('/invoices', { search: newSearch }, { preserveState: true });
    },
  },

  //console log invoices on startup
  mounted() {
    console.log(this.invoices)
  }

}
</script>
