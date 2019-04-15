<template>
  <layout :title="form.name">
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-light hover:text-indigo-dark" :href="route('organizations')">Organizations</inertia-link>
      <span class="text-indigo-light font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="organization.deleted_at" class="mb-6" @restore="restore">
      This organization has been deleted.
    </trashed-message>
    <div class="bg-white rounded shadow overflow-hidden max-w-lg">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.name" class="pr-6 pb-8 w-full lg:w-1/2" :error="errors.name ? errors.name[0] : null" label="Name" />
          <text-input v-model="form.email" class="pr-6 pb-8 w-full lg:w-1/2" :error="errors.email ? errors.email[0] : null" label="Email" />
          <text-input v-model="form.phone" class="pr-6 pb-8 w-full lg:w-1/2" :error="errors.phone ? errors.phone[0] : null" label="Phone" />
          <text-input v-model="form.address" class="pr-6 pb-8 w-full lg:w-1/2" :error="errors.address ? errors.address[0] : null" label="Address" />
          <text-input v-model="form.city" class="pr-6 pb-8 w-full lg:w-1/2" :error="errors.city ? errors.city[0] : null" label="City" />
          <text-input v-model="form.region" class="pr-6 pb-8 w-full lg:w-1/2" :error="errors.region ? errors.region[0] : null" label="Province/State" />
          <select-input v-model="form.country" class="pr-6 pb-8 w-full lg:w-1/2" :error="errors.country ? errors.country[0] : null" label="Country">
            <option :value="null" />
            <option value="CA">Canada</option>
            <option value="US">United States</option>
          </select-input>
          <text-input v-model="form.postal_code" class="pr-6 pb-8 w-full lg:w-1/2" :error="errors.postal_code ? errors.postal_code[0] : null" label="Postal code" />
        </div>
        <div class="px-8 py-4 bg-grey-lightest border-t border-grey-lighter flex items-center">
          <button v-if="!organization.deleted_at" class="text-red hover:underline" tabindex="-1" type="button" @click="destroy">Delete Organization</button>
          <loading-button :loading="form.sending" class="btn-indigo ml-auto" type="submit">Update Organization</loading-button>
        </div>
      </form>
    </div>
    <h2 class="mt-12 font-bold text-2xl">Contacts</h2>
    <div class="mt-6 bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-no-wrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Name</th>
          <th class="px-6 pt-6 pb-4">City</th>
          <th class="px-6 pt-6 pb-4" colspan="2">Phone</th>
        </tr>
        <tr v-for="contact in organization.contacts" :key="contact.id" class="hover:bg-grey-lightest focus-within:bg-grey-lightest">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo" :href="route('contacts.edit', contact.id)">
              {{ contact.name }}
              <icon v-if="contact.deleted_at" name="trash" class="flex-no-shrink w-3 h-3 fill-grey ml-2" />
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
              <icon name="cheveron-right" class="block w-6 h-6 fill-grey" />
            </inertia-link>
          </td>
        </tr>
        <tr v-if="organization.contacts.length === 0">
          <td class="border-t px-6 py-4" colspan="4">No contacts found.</td>
        </tr>
      </table>
    </div>
  </layout>
</template>

<script>
import { Inertia, InertiaLink } from 'inertia-vue'
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from '@/Shared/SelectInput'
import TextInput from '@/Shared/TextInput'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  components: {
    InertiaLink,
    Icon,
    Layout,
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
  },
  props: {
    organization: Object,
    errors: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      form: {
        name: this.organization.name,
        email: this.organization.email,
        phone: this.organization.phone,
        address: this.organization.address,
        city: this.organization.city,
        region: this.organization.region,
        country: this.organization.country,
        postal_code: this.organization.postal_code,
      },
    }
  },
  methods: {
    submit() {
      Inertia.put(this.route('organizations.update', this.organization.id).url(), this.form)
    },
    destroy() {
      if (confirm('Are you sure you want to delete this organization?')) {
        Inertia.delete(this.route('organizations.destroy', this.organization.id).url())
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this organization?')) {
        Inertia.put(this.route('organizations.restore', this.organization.id).url())
      }
    },
  },
}
</script>
