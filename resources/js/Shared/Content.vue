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
</template>

<script>
export default {
  props: {
    invoice: Object,
    contact: Object,
    isPdfGeneration: Boolean
  }
}
</script>
