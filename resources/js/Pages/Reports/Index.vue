<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Reports</h1>

    <div class="flex">
      <!-- Reports sidebar -->
      <div class="bg-white rounded shadow overflow-x-auto w-1/4">
        <table class="w-full whitespace-no-wrap">
          <tr v-for="(report, date) in reports" :key="date" class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t">
              <inertia-link class="px-6 py-4 flex items-center" :href="route('reports.show', date)" :only="['report']" tabindex="-1">
                New leads {{ date }}
              </inertia-link>
            </td>
            <td class="border-t w-px">
              <inertia-link class="px-4 flex items-center" :href="route('reports.show', date)" :only="['report']" tabindex="-1">
                <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
              </inertia-link>
            </td>
          </tr>
          <tr v-if="reports.length === 0">
            <td class="border-t px-6 py-4" colspan="4">No reports found.</td>
          </tr>
        </table>
      </div>
      <!-- End reports sidebar -->

      <div class="w-3/4 pl-8">
        <div v-if="report">
          <h2 class="mb-4 font-bold text-2xl">New leads {{ report.date }}</h2>

          <!-- Report stats -->
          <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div class="bg-white overflow-hidden shadow rounded-lg">
              <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                  <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                    <!-- Heroicon name: users -->
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                  </div>
                  <div class="ml-5 w-0 flex-1">
                    <dl>
                      <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                        New leads
                      </dt>
                      <dd class="flex items-baseline">
                        <div class="text-2xl leading-8 font-semibold text-gray-900">
                          {{ report.contacts.length }}
                        </div>
                      </dd>
                    </dl>
                  </div>
                </div>
              </div>
            </div>
            <div class="bg-white overflow-hidden shadow rounded-lg">
              <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                  <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                    <!-- Heroicon name: map -->
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                  </div>
                  <div class="ml-5 w-0 flex-1">
                    <dl>
                      <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                        Regions
                      </dt>
                      <dd class="flex items-baseline">
                        <div class="text-2xl leading-8 font-semibold text-gray-900">
                          {{ numberOfRegions }}
                        </div>
                      </dd>
                    </dl>
                  </div>
                </div>
              </div>
            </div>
            <div class="bg-white overflow-hidden shadow rounded-lg">
              <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                  <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                    <!-- Heroicon name: office-building -->
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                  </div>
                  <div class="ml-5 w-0 flex-1">
                    <dl>
                      <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                        Organizations
                      </dt>
                      <dd class="flex items-baseline">
                        <div class="text-2xl leading-8 font-semibold text-gray-900">
                          {{ numberOfOrganizations }}
                        </div>
                      </dd>
                    </dl>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- End report stats -->

          <div class="bg-white rounded shadow overflow-x-auto mt-5">
            <table class="w-full whitespace-no-wrap">
              <tr class="text-left font-bold">
                <th class="px-6 pt-6 pb-4">Name</th>
                <th class="px-6 pt-6 pb-4">Organization</th>
                <th class="px-6 pt-6 pb-4">City</th>
                <th class="px-6 pt-6 pb-4" colspan="2">Phone</th>
              </tr>
              <tr v-for="contact in report.contacts" :key="contact.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                <td class="border-t">
                  <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('contacts.edit', contact.id)">
                    {{ contact.name }}
                    <icon v-if="contact.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
                  </inertia-link>
                </td>
                <td class="border-t">
                  <inertia-link class="px-6 py-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
                    <div v-if="contact.organization">
                      {{ contact.organization.name }}
                    </div>
                  </inertia-link>
                </td>
                <td class="border-t">
                  <inertia-link class="px-6 py-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
                    {{ contact.city }}
                  </inertia-link>
                </td>
                <td class="border-t">
                  <inertia-link class="px-6 py-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
                    {{ contact.phone }}
                  </inertia-link>
                </td>
                <td class="border-t w-px">
                  <inertia-link class="px-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
                    <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
                  </inertia-link>
                </td>
              </tr>
            </table>
          </div>
        </div>
        <div v-else>
          <h2 class="mb-4 font-bold text-2xl">Please select a report</h2>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import countBy from 'lodash/countBy'

export default {
  metaInfo: { title: 'Reports' },
  props: {
    reports: Object,
    report: Object,
  },
  components: {
    Icon,
  },
  layout: Layout,
  computed: {
    numberOfRegions() {
      return Object.keys(countBy(this.report.contacts, contact => contact.region)).length
    },
    numberOfOrganizations() {
      return Object.keys(countBy(this.report.contacts, contact => contact.organization.id)).length
    },
  },
}
</script>
