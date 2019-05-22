<template>
  <layout title="Dashboard">
    <h1 class="mb-8 font-bold text-3xl">Dashboard</h1>
    <p class="mb-12 leading-normal">Hey there! Welcome to Ping CRM, a demo app designed to help illustrate how <a class="text-indigo-500 underline hover:text-orange-600" href="https://github.com/inertiajs">Inertia.js</a> works.</p>
    <div>
      <inertia-link class="btn-indigo-500" href="/500">500 error</inertia-link>
      <inertia-link class="btn-indigo-500" href="/404">404 error</inertia-link>
    </div>
  </layout>
</template>

<script>
import Layout from '@/Shared/Layout'

export default {
  components: {
    Layout,
  },
}
</script>
