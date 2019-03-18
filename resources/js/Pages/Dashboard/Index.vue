<template>
  <layout title="Dashboard">
    <h1 class="mb-8 font-bold text-3xl">Dashboard</h1>
    <div class="mt-16">
      <inertia-link class="btn-indigo" href="/500">500 error</inertia-link>
      <inertia-link class="btn-indigo" href="/404">404 error</inertia-link>
    </div>
  </layout>
</template>

<script>
import { InertiaLink } from 'inertia-vue'
import Layout from '@/Shared/Layout'

export default {
  components: {
    Layout,
    InertiaLink,
  },
}
</script>
