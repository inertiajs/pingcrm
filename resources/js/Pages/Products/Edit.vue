<template>
  <div>
    <Head title="Edit Product" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/products">Products</Link>
      <span class="text-indigo-400 font-medium">/</span> Edit
    </h1>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Name" />
          <text-input v-model="form.description" :error="form.errors.description" class="pb-8 pr-6 w-full lg:w-1/2" label="Description" />
          <text-input v-model="form.price" :error="form.errors.price" class="pb-8 pr-6 w-full lg:w-1/2" label="Price" />
          <text-input v-model="form.quantity" :error="form.errors.quantity" class="pb-8 pr-6 w-full lg:w-1/2" label="Quantity" />
        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Update Product</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import TextInput from '@/Shared/TextInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'
import Layout from '@/Shared/Layout.vue'

export default {
  components: {
    Head,
    Link,
    TextInput,
    LoadingButton,
  },
  layout: Layout,
  props: {
    product: Object, // Receive the product data as a prop
  },
  data() {
    return {
      form: {
        name: this.product.name,
        description: this.product.description,
        price: this.product.price,
        quantity: this.product.quantity,
        errors: {},
        processing: false,
      },
    }
  },
  methods: {
    async update() {
      this.form.processing = true
      try {
        await this.$inertia.put(`/products/${this.product.id}`, this.form)
      } catch (e) {
        this.form.errors = e.response.data.errors
      } finally {
        this.form.processing = false
      }
    },
  },
}
</script>

<style scoped>
/* Add any specific styles here */
</style>
