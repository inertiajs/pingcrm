<template>
  <div>
    <Head title="Create Invoice" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/invoices">Invoices</Link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <!-- Organization Dropdown -->
          <select-input v-model="form.organization_id" :error="form.errors.organization_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Organization">
            <option v-for="org in organizations" :key="org.id" :value="org.id">{{ org.name }}</option>
          </select-input>

          <!-- Contact Dropdown -->
          <select-input v-model="form.contact_id" :error="form.errors.contact_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Contact">
            <option v-for="contact in contacts" :key="contact.id" :value="contact.id">{{ contact.first_name + " " + contact.last_name}}</option>
          </select-input>

          <!-- Product Dropdown -->
         <select-input v-model="form.product_id" :error="form.errors.product_id" class="pb-8 pr-6 w-full lg:w-full" label="Product">
            <option value="" >Select a product</option>
            <option v-for="product in availableProducts" :key="product.id" :value="product.id">{{ product.name }}</option>
          </select-input>
        </div>

        <!-- Products Table -->
        <div class="overflow-x-auto">
          <hr>
          <div v-if="form.organization_id && form.contact_id" class="px-8 py-4">
            <h1 class="text-xl font-bold text-center">Invoice</h1>
            <p class="text-lg font-semibold text-center">Organization: {{ organizations.find(org => org.id === form.organization_id).name }}</p>
            <p class="text-lg font-semibold text-center">Contact: {{ contacts.find(contact => contact.id === form.contact_id).first_name + " " + contacts.find(contact => contact.id === form.contact_id).last_name }}</p>
            <p class="text-sm font-italic text-center">{{ contacts.find(contact => contact.id === form.contact_id).phone }} | {{ contacts.find(contact => contact.id === form.contact_id).email }}</p>
          </div>
          <table v-if="addedProducts.length > 0" class="w-full whitespace-nowrap">
            <thead>
              <tr>
                <th class="pb-4 pt-6 px-6">Product</th>
                <th class="pb-4 pt-6 px-6">Price</th>
                <th class="pb-4 pt-6 px-6">Quantity</th>
                <th class="pb-4 pt-6 px-6">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(product, index) in addedProducts" :key="index" class="hover:bg-gray-100 focus-within:bg-gray-100 text-center">
                <td class="border-t px-6 py-4">{{ product.name }}</td>
                <td class="border-t px-6 py-4">৳{{ product.price }}</td>
                <td class="border-t px-6 py-4">
                  <input type="number" v-model="product.quantity" min="1" class="form-input w-16 mx-auto text-center" />
                </td>
                <td class="border-t px-6 py-4">
                  <button @click="removeProduct(index)" class="text-red-500 hover:text-red-700">Remove</button>
                </td>
              </tr>
              <tr v-if="addedProducts.length === 0">
                <td class="px-6 py-4 border-t" colspan="4">No products added.</td>
              </tr>
            </tbody>
          </table>

          <!-- Total Amount -->
          <div v-if="addedProducts.length > 0" class="flex justify-end px-8 py-4">
            <div class="font-bold text-lg">Total Amount: ৳{{ totalAmount }}</div>
          </div>
        </div>

        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Invoice</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import Layout from '@/Shared/Layout.vue'
import TextInput from '@/Shared/TextInput.vue'
import SelectInput from '@/Shared/SelectInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'
import axios from 'axios'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
  },
  layout: Layout,
  props: {
    organizations: Array,
    products: Array,
  },
  data() {
    return {
      form: this.$inertia.form({
        organization_id: null,
        contact_id: null,
        product_id: null,
        number: null,
        amount: null,
        added_products: [] // List of products added to the invoice
      }),
      contacts: [],
      addedProducts: [], // List of products added to the invoice
    }
  },
  computed: {
    availableProducts() {
      // Filter out the products that have already been added to the invoice
      return this.products.filter(product => !this.addedProducts.some(p => p.id === product.id))
    },
    totalAmount() {
      // Calculate the total amount based on added products and their quantities
      return this.addedProducts.reduce((total, product) => total + (product.price * product.quantity), 0)
    }
  },
  watch: {
    'form.organization_id': async function(newOrgId) {
      if (newOrgId) {
        try {
          const response = await axios.get(`/organizations/${newOrgId}/contacts`)
          this.contacts = response.data
        } catch (error) {
          console.error('Failed to fetch contacts:', error)
        }
      } else {
        this.contacts = []
      }
    },
    'form.product_id': function(newProductId) {
      if (newProductId) {
        const selectedProduct = this.products.find(p => p.id === newProductId)
        if (selectedProduct && !this.addedProducts.some(p => p.id === selectedProduct.id)) {
          this.addedProducts.push({ ...selectedProduct, quantity: 1 }) // Add product with default quantity
          this.form.product_id = null // Reset the product dropdown
        }
      }
    },
    addedProducts: {
      handler(newProducts) {
        // Update form's added_products field whenever addedProducts changes
        this.form.added_products = newProducts
      },
      deep: true
    }
  },
  methods: {
    store() {
      this.form.number = Math.floor(Math.random() * 90000) + 10000; // Generate a random invoice number
      this.form.amount = this.totalAmount; // Set the total amount in the form

      this.form.post('/invoices')
        .then(() => {
          // Reset added products after successful creation
          this.addedProducts = []
        })
        .catch(error => {
          console.error('Failed to create invoice:', error)
        })
    },
    removeProduct(index) {
      this.addedProducts.splice(index, 1) // Remove product from the list
    }
  }
}
</script>

