<template>
  <div>
    <Head title="Products" />
    <h1 class="mb-8 text-3xl font-bold">Products</h1>
    <div class="flex items-center justify-between mb-6">
      <!-- Search Field -->
      <div class="flex-1 max-w-md mr-4">
        <input
          type="search"
          v-model="search"
          placeholder="Search products..."
          class="form-input w-1/2 px-4 py-2 border rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        />
      </div>
      <!-- Create Button -->
      <Link class="btn-indigo" href="/products/create">
        <span>Create</span>
        <span class="hidden md:inline">&nbsp;Product</span>
      </Link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <thead>
          <tr class="text-left font-bold">
            <th class="pb-4 pt-6 px-6">Name</th>
            <th class="pb-4 pt-6 px-6">Description</th>
            <th class="pb-4 pt-6 px-6">Price</th>
            <th class="pb-4 pt-6 px-6">Quantity</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in products.data" :key="product.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t px-6 py-4">{{ product.name }}</td>
            <td class="border-t px-6 py-4">{{ product.description }}</td>
            <td class="border-t px-6 py-4">৳{{ product.price }}</td>
            <td class="border-t px-6 py-4">{{ product.quantity }}</td>
            <td class="w-px border-t">
              <Link class="flex items-center px-4" :href="`/products/${product.id}/edit`" tabindex="-1">
                <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
              </Link>
            </td>
          </tr>
          <tr v-if="products.data.length === 0">
            <td class="px-6 py-4 border-t" colspan="4">No products found.</td>
          </tr>
        </tbody>
      </table>
    </div>
    <pagination class="mt-6" :links="products.links" />
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
    SearchFilter
  },
  props: {
    products: Object,
  },
  layout: Layout,
  data() {
    return {
      search: '',
    }
  },
  watch: {
    search(newSearch) {
      this.$inertia.get('/products', { search: newSearch }, { preserveState: true });
    },
  },
}
</script>
