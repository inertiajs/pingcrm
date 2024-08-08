<template>
  <div class="overflow-x-auto" ref="invoiceContent">
    <hr>
    <div class="px-8 py-4">
      <h1 class="text-xl font-bold text-center">Invoice</h1>
      <p class="text-lg font-semibold text-center">Organization: {{ invoice.organization_name }}</p>
      <p class="text-lg font-semibold text-center">Contact: {{ invoice.contact_first_name + " " +
        invoice.contact_last_name }}
      </p>
      <p class="text-sm font-italic text-center">{{ contact.phone
        }} | {{ contact.email }}</p>
    </div>
    <table class="w-full whitespace-nowrap">
      <thead>
        <tr>
          <th class="pb-4 pt-6 px-6">Product</th>
          <th class="pb-4 pt-6 px-6">Price</th>
          <th class="pb-4 pt-6 px-6">Quantity</th>
          <th class="pb-4 pt-6 px-6">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in invoice.items" :key="index"
          class="hover:bg-gray-100 focus-within:bg-gray-100 text-center">
          <td class="border-t px-6 py-4">{{ item.name }}</td>
          <td class="border-t px-6 py-4">৳{{ item.price }}</td>
          <td class="border-t px-6 py-4">{{ item.quantity }}</td>
          <td class="border-t px-6 py-4">৳{{ item.price * item.quantity }}</td>
        </tr>
      </tbody>
    </table>

    <!-- Total Amount -->
    <div class="flex justify-end px-8 py-4">
      <div class="font-bold text-lg">Total Amount: ৳{{ invoice.amount }}</div>
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
import html2pdf from 'html2pdf.js'

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
    invoice: Object,
    contact: Object,
  },
  mounted() {
    console.log(this.invoice)
  },
}
</script>
