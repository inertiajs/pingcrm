<template>
  <div>
    <Head title="Recherche" />
    <div class="flex flex-col">
      <h2 class="mb-4 text-2xl font-bold">Résultat de la recherche..</h2>

      <div class="mb-6 border-b-2 border-dashed">
        <div class="flex flex-row items-center">
          <h4 class="pr-2 text-sm font-bold uppercase">Zone:</h4>
          <span class="mr-2 text-xs italic font-bold">{{ area.lib_area }}</span>
        </div>
        <div class="grid gap-4 grid-cols-1 mt-4 my-5 lg:grid-cols-2">
          <div v-if="hasCentre(area.agencies, 'COMMERCIAL').length" class="flex items-start p-4 bg-white rounded-xl shadow-lg">
            <div class="bg-indigo-50 flex items-center justify-center w-12 h-12 border border-indigo-100 rounded-full">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
            </div>

            <div class="ml-4">
              <h2 class="font-semibold">
                Centre Commercial - {{ hasCentre(area.agencies, 'COMMERCIAL')[0].name }} <span class="pl-3 text-gray-500 italic">({{ hasCentre(area.agencies, 'COMMERCIAL')[0].phone }})</span>
              </h2>
              <p class="mt-2 text-gray-500 text-sm"><span class="mr-2 underline font-bold">Adresse:</span>{{ hasCentre(area.agencies, 'TECHNIQUE')[0].address }}</p>
              <!-- <p class="mt-2 text-sm italic">Emplacement Géographique: Longitude, Latittude</p> -->
            </div>
          </div>

          <div v-else />
          <div v-if="hasCentre(area.agencies, 'TECHNIQUE').length" class="flex items-start p-4 bg-white rounded-xl shadow-lg">
            <div class="flex items-center justify-center w-12 h-12 bg-orange-50 border border-orange-100 rounded-full">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
            </div>

            <div class="ml-4">
              <h2 class="font-semibold">
                Centre Technique - {{ hasCentre(area.agencies, 'TECHNIQUE')[0].name }} <span class="pl-3 text-gray-500 italic">({{ hasCentre(area.agencies, 'TECHNIQUE')[0].phone }})</span>
              </h2>
              <p class="mt-2 text-gray-500 text-sm"><span class="mr-2 underline font-bold">Adresse:</span>{{ hasCentre(area.agencies, 'TECHNIQUE')[0].address }}</p>
              <!-- <p class="mt-2 text-sm italic">Emplacement Géographique: Longitude, Latittude</p> -->
            </div>
          </div>
          <div v-else />
        </div>
      </div>
      <div class="my-6 border-b-2 border-dashed" />
      <div class="grid gap-x-9 gap-y-2 grid-cols-1 lg:grid-cols-2">
        <div class="mb-6 border-b-2 border-dashed">
          <div class="flex flex-row items-center">
            <h4 class="pr-2 text-lg font-bold uppercase">Pannes en Cours:</h4>
          </div>
          <div class="inline-flex flex-col">
            <div v-for="issue in issues" :key="issue.id" class="flex items-start mb-3 mt-1 p-4 bg-white rounded-xl shadow-lg">
              <div class="flex items-center justify-center w-12 h-12 bg-yellow-50 border border-yellow-100 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-yellow-600">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </div>

              <div class="ml-4">
                <h2 class="pb-2 font-semibold">Panne:</h2>
                <p>{{ issue.description }}</p>
                <p class="mt-2 text-gray-500 text-sm"><span class="mr-2 underline font-bold">Signalé à:</span>{{ issue.from }} <span class="mr-2 underline font-bold">Heure estimée de réssolution:</span>{{ issue.to }}</p>
                <p class="mt-2 text-sm italic">Incident survenue le: {{ issue.intervention_date }}</p>
              </div>
            </div>
          </div>
        </div>
        <div class="mb-6 border-b-2 border-dashed">
          <div class="flex flex-row items-center">
            <h4 class="pr-2 text-lg font-bold uppercase">Travaux en Cours:</h4>
          </div>
          <div class="flex flex-col">
            <div v-for="maintenance in maintenances" :key="maintenance.id" class="flex items-start mb-3 mt-1 p-4 bg-white rounded-xl shadow-lg">
              <div class="bg-indigo-50 flex items-center justify-center w-12 h-12 bg-cyan-50 border border-cyan-100 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 text-cyan-700">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
              </div>

              <div class="ml-4">
                <h2 class="pb-2 font-semibold">Maintenance:</h2>
                <p>{{ maintenance.description }}</p>
                <p class="mt-2 text-gray-500 text-sm">
                  <span class="text-sm underline italic mr-5">Prévu le: {{ maintenance.intervention_date }}</span>
                  <span class="mr-2 underline font-bold">de</span>
                  {{ maintenance.from }}
                  <span class="mx-2 underline font-bold">à</span>
                  {{ maintenance.to }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import { Head } from '@inertiajs/inertia-vue3'
export default {
  components: {
    Head,
  },
  layout: Layout,
  props: {
    area: Object,
  },
  computed: {
    issues() {
      return this.area.maintenances.filter((m) => m.type === 'issue')
    },
    maintenances() {
      return this.area.maintenances.filter((m) => m.type === 'maintenance')
    },
  },
  methods: {
    hasCentre(list, centre) {
      return list.filter((s) => s.centre === centre)
    },
  },
}
</script>

<style></style>
