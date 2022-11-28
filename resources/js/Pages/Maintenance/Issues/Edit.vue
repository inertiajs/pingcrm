<template>
  <div>
    <Head :title="form.name" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/agences">Agences</Link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="organization.deleted_at" class="mb-6" @restore="restore"> Cette agence a été supprimée avec succès. </trashed-message>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <!-- Name -->
          <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Nom" />
          <!-- Contact -->
          <text-input v-model="form.phone" :error="form.errors.phone" class="pb-8 pr-6 w-full lg:w-1/2" label="Contact" />
          <!-- Address -->
          <text-input v-model="form.address" :error="form.errors.address" class="pb-8 pr-6 w-full lg:w-1/2" label="Indication Précise" />
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
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!organization.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Supprimer Agence</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Modifier Agence</loading-button>
        </div>
      </form>
    </div>
    <h2 class="mt-12 text-2xl font-bold">Responsables</h2>
    <div class="mt-6 bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="pb-4 pt-6 px-6">Nom</th>
          <th class="pb-4 pt-6 px-6">Service</th>
          <th class="pb-4 pt-6 px-6" colspan="2">Contact Personnel</th>
        </tr>
        <tr v-for="contact in organization.contacts" :key="contact.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/contacts/${contact.id}/edit`">
              {{ contact.name }}
              <icon v-if="contact.deleted_at" name="trash" class="flex-shrink-0 ml-2 w-3 h-3 fill-gray-400" />
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/contacts/${contact.id}/edit`" tabindex="-1">
              {{ contact.support }}
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/contacts/${contact.id}/edit`" tabindex="-1">
              {{ contact.phone }}
            </Link>
          </td>
          <td class="w-px border-t">
            <Link class="flex items-center px-4" :href="`/contacts/${contact.id}/edit`" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </Link>
          </td>
        </tr>
        <tr v-if="organization.contacts.length === 0">
          <td class="px-6 py-4 border-t" colspan="4">Aucun responsable associé.</td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from '@/Shared/TrashedMessage'
import axios from 'axios'

export default {
  components: {
    Head,
    Icon,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
  },
  layout: Layout,
  props: {
    organization: Object,
    departments: Array,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: this.organization.name,
        phone: this.organization.phone,
        address: this.organization.address,
        department_id: this.organization.department_id,
        commune_id: this.organization.commune_id,
        arrondissement_id: this.organization.arrondissement_id,
        area_id: this.organization.area_id,
      }),
      communes: [],
      arrondissements: [],
      areas: [],
    }
  },
  created() {
    this.getCommunes(this.organization.department_id)
    this.getArrondissements(this.organization.commune_id)
    this.getAreas(this.organization.arrondissement_id)
  },
  methods: {
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
    update() {
      this.form.put(`/agences/${this.organization.id}`)
    },
    destroy() {
      if (confirm('Êtes-vous sûr de vouloir supprimer cette agence?')) {
        this.$inertia.delete(`/agences/${this.organization.id}`)
      }
    },
    restore() {
      if (confirm('Êtes-vous sûr de vouloir restaurer cette agence?')) {
        this.$inertia.put(`/agences/${this.organization.id}/restore`)
      }
    },
  },
}
</script>
