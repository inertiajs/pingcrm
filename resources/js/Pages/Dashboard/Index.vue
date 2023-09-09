<template>
  <div>
    <Head title="Dashboard" />
    <h1 class="mb-8 text-3xl font-bold">Dashboard</h1>
    <p class="mb-8 leading-normal">Hey there! Welcome to Ping CRM, a demo app designed to help illustrate how <a class="text-indigo-500 hover:text-orange-600 underline" href="https://inertiajs.com">Inertia.js</a> works.</p>

    <!-- some statistic cards -->
    <div class="row-3 flex flex-row gap-3">
      <Organizations :orgs="organizations" />
      <Contacts :contacts="customers" />
      <Users :users="users"/>
      <Reports :reports="reports" />
      <!-- // end statistic cards -->
     

    </div>
  </div>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'
import Users from '@/Shared/Cards/Users'
import Contacts from '@/Shared/Cards/Contacts'
import Reports from '@/Shared/Cards/Reports'
import Organizations from '@/Shared/Cards/Organizations'

export default {
  props: ['users','organizations','reports','customers'],

  components: {
    Head,
    Users,
    Contacts,
    Reports,
    Organizations,
  },
  layout: Layout,
}
</script>
