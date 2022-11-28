<template>
  <div>
    <Head title="Acceuil" />
    <h1 class="mb-12 text-center text-3xl font-bold">Rechercher Quartier...</h1>
    <div class="flex flex-col items-center justify-center mb-6">
      <search-filter v-model="form.search" :has-filter="false" :is-combobox="true" class="max-w-xxl w-full h-20" @reset="reset">
        <template #result>
          <div v-if="zones.length > 0" class="flex flex-col w-full">
            <!-- Agence list -->
            <div v-for="(zone, index) in zones" :key="index" class="w-full hover:bg-indigo-400 border-b border-gray-100 rounded-t cursor-pointer">
              <div class="relative flex items-center p-2 pl-2 w-full hover:text-white border-l-2 hover:border-indigo-100 border-transparent">
                <Link class="flex items-center w-full" :href="`/resultats/${zone.lib_area}`">
                  <div class="mx-2 my-1 w-2/3">
                    <span class="font-bold">{{ zone.lib_com }}</span>
                    <span class="font-bold">-></span>
                    <span class="font-bold">{{ zone.lib_arr }}</span>
                    <span class="font-bold">-></span>
                    <span class="font-bold">{{ zone.lib_area }}</span>
                  </div>
                  <!-- <div class="w-1/4">
                    <span class="text-xs font-semibold text-white px-2 py-1 rounded-lg" :class="zone.id === 1 ? 'bg-yellow-500' : 'bg-indigo-500'">{{ zone.id }}</span>
                  </div> -->
                </Link>
              </div>
            </div>
            <!-- Agence list end -->
          </div>
          <div v-else-if="zones.length == 0 && !emptyField" class="p-4">
            <p class="text-gray-400 italic">Ce quartier n'existe pas dans nos enregistrements </p>
          </div>
        </template>
      </search-filter>
      <p v-if="emptyField" class="text-muted italic py-4">Aucune donnée disponible</p>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'
import pickBy from 'lodash/pickBy'
import throttle from 'lodash/throttle'
import SearchFilter from '@/Shared/SearchFilter'
import mapValues from 'lodash/mapValues'

export default {
  components: {
    Head,
    Link,
    SearchFilter,
  },
  layout: Layout,
  props: {
    filters: Object,
    zones: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.isSearching = true
        this.$inertia.get('/', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  computed: {
    emptyField() {
      return this.form.search === null || this.form.search === ''
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
