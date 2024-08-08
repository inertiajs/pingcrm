<template>
  <div class="overflow-x-auto bg-white" ref="invoiceContent">
    <hr>
    <div class="px-8 py-4">
      <p class="flex justify-end px-8 py-4 text-sm italic">Issued Date: {{ new
        Date(invoice.created_at).toLocaleDateString() }}</p>
      <h1 class="text-xl font-bold text-center">Invoice #{{ invoice.number }}</h1>

      <p class="text-lg font-semibold text-center">Organization: {{ invoice.organization_name }}</p>
      <p class="text-lg font-semibold text-center">Contact: {{ invoice.contact_first_name + " " +
        invoice.contact_last_name }}</p>
      <p class="text-sm font-italic text-center">{{ contact.phone }} | {{ contact.email }}</p>

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
    <!-- PDF Generation Date -->
    <div v-if="isPdfGeneration" class="flex justify-between text-green-700 px-8 py-4 text-sm italic">
      This PDF is generated at {{ new Date().toLocaleString() }}
    </div>
  </div>
  <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
    <loading-button :loading="isLoading" class="btn-indigo" @click="downloadInvoice">
      Download Invoice
    </loading-button>
  </div>

</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import Layout from '@/Shared/Layout.vue'
import TextInput from '@/Shared/TextInput.vue'
import SelectInput from '@/Shared/SelectInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'
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
  data() {
    return {
      isPdfGeneration: false,
      isLoading: false,
    }
  },
  methods: {
    async downloadInvoice() {
      this.isLoading = true
      await new Promise((resolve) => setTimeout(resolve, 1000));
      try {
        this.generatePDF()
      } catch (error) {
        console.error(error)
      } finally {
        this.isLoading = false
      }
    },
    async generatePDF() {
      this.isPdfGeneration = true
      await this.$nextTick();
      const element = this.$refs.invoiceContent
      var opt = {
        margin: 1,
        filename: `${this.invoice.number}.pdf`,
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: [8, 8], orientation: 'portrait' }
      };
      html2pdf(element, opt);
      this.isPdfGeneration = false
    },
  }

}
</script>
