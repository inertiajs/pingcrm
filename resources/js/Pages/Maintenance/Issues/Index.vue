<template>
  <div>
    <Head title="Pannes" />
    <h1 class="mb-8 text-3xl font-bold">Pannes</h1>
    <div class="flex items-center justify-between mb-6">
      <search-filter v-model="form.search" :has-filter="false" class="mr-4 w-full max-w-md" @reset="reset" />
      <!-- <Link class="btn-indigo" href="/pannes/create">
        <span>Ajouter</span>
        <span class="hidden md:inline">&nbsp;Panne</span>
      </Link> -->
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <thead>
          <tr class="text-left font-bold">
            <th class="pb-4 pt-6 px-6">Date d'Incident</th>
            <th class="pb-4 pt-6 px-6">Heure d'Incident</th>
            <th class="pb-4 pt-6 px-6">Heure estimée de resolution</th>
            <th class="pb-4 pt-6 px-6">Zones</th>
            <th class="pb-4 pt-6 px-6" colspan="2">Description</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="issue in issues.data" :key="issue.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t">
              <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/pannes/${issue.id}/edit`" tabindex="-1">
                {{ issue.intervention_date }}
                <icon v-if="issue.deleted_at" name="trash" class="flex-shrink-0 ml-2 w-3 h-3 fill-gray-400" />
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/pannes/${issue.id}/edit`" tabindex="-1">
                {{ issue.from }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" :href="`/pannes/${issue.id}/edit`" tabindex="-1">
                {{ issue.to }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex flex-col justify-start py-4" :href="`/pannes/${issue.id}/edit`" tabindex="-1">
                <div>
                  {{ countZoneByKey(issue.zones, 'departement_id') == 0 ? 'Tous les' : countZoneByKey(issue.zones, 'departement_id') }}
                  <span class="pl-1">Département(s)</span>
                </div>
                <div class="pt-2">
                  {{ countZoneByKey(issue.zones, 'commune_id') == 0 ? 'Toutes les' : countZoneByKey(issue.zones, 'commune_id') }}
                  <span class="pl-1">Commune(s)</span>
                </div>
                <div class="pt-2">
                  {{ countZoneByKey(issue.zones, 'arrondissement_id') == 0 ? 'Tous les' : countZoneByKey(issue.zones, 'arrondissement_id') }}
                  <span class="pl-1">Arrondissement(s)</span>
                </div>
                <div class="pt-2">
                  {{ countZoneByKey(issue.zones, 'area_id') == 0 ? 'Tous les' : countZoneByKey(issue.zones, 'area_id') }}
                  <span class="pl-1">Quartier(s)</span>
                </div>
              </Link>
            </td>
            <td class="border-t w-2/6">
              <Link class="flex items-center px-6 py-4 whitespace-normal" :href="`/pannes/${issue.id}/edit`" tabindex="-1">
                {{ issue.description }}
              </Link>
            </td>
            <td class="w-px border-t">
              <Link class="flex items-center px-4" :href="`/issues/${issue.id}/edit`" tabindex="-1">
                <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
              </Link>
            </td>
          </tr>
          <tr v-if="issues.data.length === 0">
            <td class="px-6 py-4 border-t" colspan="6">Pas de pannes trouvées.</td>
          </tr>
        </tbody>
      </table>
    </div>
    <pagination class="mt-6" :links="issues.links" />
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Icon from '@/Shared/Icon'
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout'
import throttle from 'lodash/throttle'
import groupBy from 'lodash/groupBy'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'
import SearchFilter from '@/Shared/SearchFilter'

export default {
  components: {
    Head,
    Icon,
    Link,
    Pagination,
    SearchFilter,
  },
  layout: Layout,
  props: {
    filters: {
      type: Object,
      default: () => ({
        search: '',
        type: 'issue',
      }),
    },
    issues: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        type: this.filters.type,
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/pannes', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    countZoneByKey(zones, key) {
      const keys = Object.keys(groupBy(zones, key))
      if(keys.length > 0 && keys.includes('null')) keys.splice(keys.indexOf('null'), 1)

      return keys.length
    },
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
