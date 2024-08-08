<template>
  <InvoiceContent ref="invoiceContent" :invoice="invoice" :contact="contact" :isPdfGeneration="isPdfGeneration" />
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
import InvoiceContent from '@/Shared/Content.vue'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    InvoiceContent,
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
      const element = this.$refs.invoiceContent.$el;
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
