<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Budgets</h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
        <label class="block text-gray-700">Trashed:</label>
        <select v-model="form.trashed" class="mt-1 w-full form-select">
          <option :value="null" />
          <option value="with">With Trashed</option>
          <option value="only">Only Trashed</option>
        </select>
      </search-filter>
      <inertia-link class="btn-indigo" :href="route('budgets.create')">
        <span>Create</span>
        <span class="hidden md:inline">Budget</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Id</th>
          <th class="px-6 pt-6 pb-4">Project Name</th>
          <th class="px-6 pt-6 pb-4">Resources</th>
          <th class="px-6 pt-6 pb-4">Cost</th>
          <th class="px-6 pt-6 pb-4">Profit</th>
          <th class="px-6 pt-6 pb-4">Loss</th>
        </tr>
        <tr v-for="budget in budgets.data" :key="budget.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('budgets.edit', budget.id)">
            <icon v-if="budget.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
              {{ budget.id }}
            </inertia-link>
          </td>

          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('budgets.edit', budget.id)" tabindex="-1">
              {{ budget.project_name }}
            </inertia-link>
          </td>
          
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('budgets.edit', budget.id)" tabindex="-1">
              {{ budget.resources }}
            </inertia-link>
          </td>
          
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('budgets.edit', budget.id)" tabindex="-1">
              {{ budget.cost }}
            </inertia-link>
          </td>
          
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('budgets.edit', budget.id)" tabindex="-1">
              {{ budget.profit }}
            </inertia-link>
          </td>
          
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('budgets.edit', budget.id)" tabindex="-1">
              {{ budget.loss }}
            </inertia-link>
          </td>


          <td class="border-t w-px">
            <inertia-link class="px-4 flex items-center" :href="route('budgets.edit', budget.id)" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </inertia-link>
          </td>
        </tr>
        <tr v-if="budgets.data.length === 0">
          <td class="border-t px-6 py-4" colspan="4">No budgets found.</td>
        </tr>
      </table>
    </div>
    <pagination class="mt-6" :links="budgets.links" />
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'
import SearchFilter from '@/Shared/SearchFilter'

export default {
  metaInfo: { title: 'Budgets' },
  components: {
    Icon,
    Pagination,
    SearchFilter,
  },
  layout: Layout,
  props: {
    budgets: Object,
    filters: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
      },
    }
  },
  watch: {
    form: {
      handler: throttle(function() {
        let query = pickBy(this.form)
        this.$inertia.replace(this.route('budgets', Object.keys(query).length ? query : { remember: 'forget' }))
      }, 150),
      deep: true,
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
