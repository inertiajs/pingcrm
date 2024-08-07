<template>
  <div>
    <Head title="Reports" />
    <h1 class="mb-8 text-3xl font-bold">Reports</h1>
    <div v-if="organizations.data.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      <Card
        v-for="organization in organizations.data"
        :key="organization.id"
        :id="organization.id"
        :name="organization.name"
        :city="organization.city"
        :phone="organization.phone"
        :owner="organization.owner"
      />
    </div>
    <div v-else class="text-center py-4">
      <p class="text-gray-600">No organizations found.</p>
    </div>
    <pagination class="mt-6" :links="organizations.links" />
  </div>
</template>

<script>
import { Head } from '@inertiajs/vue3'
import Layout from '@/Shared/Layout.vue'
import Card from '@/Shared/Card.vue'
import Pagination from '@/Shared/Pagination.vue'
export default {
  components: {
    Head,
    Pagination,
    Card
  },
  props: {
    organizations: {
      type: Object,
      required: true
    }
  },
  mounted() {
    console.log(this.organizations.data);
  },
  layout: Layout,
}
</script>
