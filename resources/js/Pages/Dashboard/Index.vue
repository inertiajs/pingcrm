<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Dashboard</h1>


    <p class="mb-8 leading-normal">Hey there! Welcome to Ping CRM, a demo app designed to help illustrate how <a class="text-indigo-500 underline hover:text-orange-600" href="https://inertiajs.com">Inertia.js</a> works.</p>

    <p class="mb-8 leading-normal">Hey there! Welcome to Marketing With HMA</p>
    <div class="mb-8 flex">
      <inertia-link class="btn-indigo" href="/users">Users</inertia-link>
      <inertia-link class="btn-indigo ml-1" href="/profiles">Profiles</inertia-link>
    </div>



    <p class="mb-8 leading-normal">Hey there! Welcome to Ping CRM, a demo app designed to help illustrate how <a class="text-indigo-500 underline hover:text-orange-600" href="https://inertiajs.com">Inertia.js</a> works.</p>

  </div>
</template>

<script>
import Layout from '@/Shared/Layout'

export default {
  metaInfo: { title: 'Dashboard' },
  layout: Layout,
}
</script>
