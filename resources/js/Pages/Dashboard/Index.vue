<template>
  <div>
    <Head title="Dashboard" />
    <h1 class="mb-8 text-3xl font-bold">Acceuil</h1>
    <p class="mb-8 leading-normal">Salut! Soyez la bienvenue sur Foniva, retrouver les informations sur les agences à partir de cet espace de recherche <a class="text-indigo-500 hover:text-orange-600 underline" href="https://sbee.bj" target="_blank">SBEE</a>.</p>
  </div>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'

export default {
  components: {
    Head,
  },
  layout: Layout,
}
</script>
