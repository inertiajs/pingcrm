<template>
  <div>
    <Head title="Ajouter Panne" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/pannes">Maintenances</Link>
      <span class="text-indigo-400 font-medium">/</span> Ajouter
    </h1>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <!-- Intervention Date -->
          <text-input v-model="form.intervention_date" :error="form.errors.intervention_date" class="pb-8 pr-6 w-full lg:w-1/2" label="Date d'Intervention" type="date" />
          <div class="lg:w-1/2 hidden lg:block" />
          <!-- From -->
          <text-input v-model="form.from" :error="form.errors.from" class="pb-8 pr-6 w-full lg:w-1/2" label="Heure de début" type="time" />
          <!-- To -->
          <text-input v-model="form.to" :error="form.errors.to" class="pb-8 pr-6 w-full lg:w-1/2" label="Heure de fin" type="time" />

          <div class="w-full border-b mb-3" />
          <div class="w-full mt-8 mb-6">
            <span class="font-bold">Zones concernées par les travaux:</span>
          </div>

          <!-- Department -->
          <select-input v-model="form.department_id" :error="form.errors.department_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Département" @select-changed="getCommunes">
            <option :value="null" />
            <option v-for="dep in departments" :key="dep.id" :value="dep.id">{{ dep.lib_dep }}</option>
          </select-input>
          <!-- Commune -->
          <select-input v-model="form.commune_id" :error="form.errors.commune_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Commune" @select-changed="getArrondissements">
            <option :value="null" />
            <option v-for="com in communes" :key="com.id" :value="com.id">{{ com.lib_com }}</option>
          </select-input>
          <!-- Arrondissement -->
          <select-input v-model="form.arrondissement_id" :error="form.errors.arrondissement_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Arrondissement" @select-changed="getAreas">
            <option :value="null" />
            <option v-for="arr in arrondissements" :key="arr.id" :value="arr.id">{{ arr.lib_arr }}</option>
          </select-input>
          <!-- Area -->
          <select-input v-model="form.area_id" :error="form.errors.area_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Quartier">
            <option :value="null" />
            <option v-for="area in areas" :key="area.id" :value="area.id">{{ area.lib_area }}</option>
          </select-input>

          <div class="w-full border-b mb-3" />
          <div class="w-full mt-8 mb-6">
            <span class="font-bold">Description:</span>
          </div>

          <!-- Description -->
          <textarea-input v-model="form.description" :error="form.errors.description" class="pb-8 pr-6 w-full" label="Détails sur les travaux" />
        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Ajouter Travaux</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import TextareaInput from '@/Shared/TextareaInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import axios from 'axios'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    TextareaInput,
  },
  layout: Layout,
  props: {
    departments: Array,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        intervention_date: null,
        from: null,
        to: null,
        type: 'maintenance',
        description: null,
        department_id: null,
        commune_id: null,
        arrondissement_id: null,
        area_id: null,
      }),
      communes: [],
      arrondissements: [],
      areas: [],
    }
  },
  methods: {
    store() {
      this.form.post('/pannes')
    },
    getCommunes(dep) {
      this.arrondissements = []
      this.areas = []
      axios.get(`/departments/${dep}/communes`).then((res) => (this.communes = res.data))
    },
    getArrondissements(com) {
      this.areas = []
      axios.get(`/communes/${com}/arrondissements`).then((res) => (this.arrondissements = res.data))
    },
    getAreas(arr) {
      axios.get(`/arrondissements/${arr}/areas`).then((res) => (this.areas = res.data))
    },
  },
}
</script>
