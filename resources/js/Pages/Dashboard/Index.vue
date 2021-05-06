<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Dashboard</h1>
    <p class="mb-8 leading-normal">Hey there! Welcome to Marketing With HMA</p>
    <div class="mb-8 flex">
      <inertia-link class="btn-indigo" href="/users">Users</inertia-link>
      <inertia-link class="btn-indigo ml-1" href="/profiles">Profiles</inertia-link>
    </div>
    
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'

export default {
  metaInfo: { title: 'Dashboard' },
  layout: Layout,
}
</script>
