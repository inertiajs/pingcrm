<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">RuleCategory</h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" @reset="reset">
        <label class="block text-gray-700">Trashed:</label>
        <select v-model="form.trashed" class="mt-1 w-full form-select">
          <option :value="null" />
          <option value="with">With Trashed</option>
          <option value="only">Only Trashed</option>
        </select>
      </search-filter>
    
      <inertia-link class="btn-indigo" :href="route('rulecategory.create')">
        <span>Create</span>
        <span class="hidden md:inline">RuleCategory</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Name</th>
          <th class="px-6 pt-6 pb-4">Description</th>
          <th class="px-6 pt-6 pb-4">Category</th>
          <th class="px-6 pt-6 pb-4">Instructor ID</th>
          <th class="px-6 pt-6 pb-4">Parent ID</th>
          <th class="px-6 pt-6 pb-4">Priority</th>
          
        </tr>
        <tr v-for="rulecategory in rulecategory.data" :key="rulecategory.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('rulecategory.edit', rulecategory.id)">
              {{ rulecategory.name }}
              <icon v-if="rulecategory.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('rulecategory.edit', rulecategory.id)" tabindex="-1">
              {{ rulecategory.description }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('rulecategory.edit', rulecategory.id)" tabindex="-1">
              {{ rulecategory.Category }}
            </inertia-link>
          </td>
           <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('rulecategory.edit', rulecategory.id)" tabindex="-1">
              {{ rulecategory.instructor_id }}
            </inertia-link>
          </td>
           <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('rulecategory.edit', rulecategory.id)" tabindex="-1">
              {{ rulecategory.parent_id }}
            </inertia-link>
          </td>
           <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('rulecategory.edit', rulecategory.id)" tabindex="-1">
              {{ rulecategory.priority }}
            </inertia-link>
          </td>

          <td class="border-t w-px">
            <inertia-link class="px-4 flex items-center" :href="route('rulecategory.edit', rulecategory.id)" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </inertia-link>
          </td>
        </tr>
        <tr v-if="rulecategory.data.length === 0">
          <td class="border-t px-6 py-4" colspan="4">No rulecategory found.</td>
        </tr>
      </table>
    </div>
    <pagination class="mt-6" :links="rulecategory.links" />
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
  metaInfo: { title: 'RuleCategory' },
  components: {
    Icon,
    Pagination,
    SearchFilter,
  },
  layout: Layout,
  props: {
    rulecategory: Object,
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
        this.$inertia.replace(this.route('RuleCategory', Object.keys(query).length ? query : { remember: 'forget' }))
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
