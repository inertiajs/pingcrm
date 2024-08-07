<template>
  <div>
    <Head title="Products" />
    <h1 class="mb-8 text-3xl font-bold">Products</h1>
    <div class="flex items-center justify-between mb-6">
      <!-- <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
        <label class="block text-gray-700">Trashed:</label>
        <select v-model="form.trashed" class="form-select mt-1 w-full">
          <option :value="null" />
          <option value="with">With Trashed</option>
          <option value="only">Only Trashed</option>
        </select>
      </search-filter> -->
      <Link class="btn-indigo" href="/products/create">
        <span>Create</span>
        <span class="hidden md:inline">&nbsp;Organization</span>
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
import Pagination from '@/Shared/Pagination.vue'
import Layout from '@/Shared/Layout.vue'


export default {
  components: {
    Head,
    Link,
    Pagination,
  },
  props: {
    products: Object,
  },
  layout: Layout,
}
</script>
