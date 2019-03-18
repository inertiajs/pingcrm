<template>
  <layout :title="form.fields.name">
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-light hover:text-indigo-dark" :href="route('organizations')">Organizations</inertia-link>
      <span class="text-indigo-light font-medium">/</span>
      {{ form.fields.name }}
    </h1>
    <trashed-message v-if="organization.deleted_at" class="mb-6" @restore="restore">
      This organization has been deleted.
    </trashed-message>
    <div class="bg-white rounded shadow overflow-hidden max-w-lg">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.fields.name" class="pr-6 pb-8 w-full lg:w-1/2" :error="form.errors.first('name')" label="Name" />
          <text-input v-model="form.fields.email" class="pr-6 pb-8 w-full lg:w-1/2" :error="form.errors.first('email')" label="Email" />
          <text-input v-model="form.fields.phone" class="pr-6 pb-8 w-full lg:w-1/2" :error="form.errors.first('phone')" label="Phone" />
          <text-input v-model="form.fields.address" class="pr-6 pb-8 w-full lg:w-1/2" :error="form.errors.first('address')" label="Address" />
          <text-input v-model="form.fields.city" class="pr-6 pb-8 w-full lg:w-1/2" :error="form.errors.first('city')" label="City" />
          <text-input v-model="form.fields.region" class="pr-6 pb-8 w-full lg:w-1/2" :error="form.errors.first('region')" label="Province/State" />
          <select-input v-model="form.fields.country" class="pr-6 pb-8 w-full lg:w-1/2" :error="form.errors.first('country')" label="Country">
            <option :value="null" />
            <option value="CA">Canada</option>
            <option value="US">United States</option>
          </select-input>
          <text-input v-model="form.fields.postal_code" class="pr-6 pb-8 w-full lg:w-1/2" :error="form.errors.first('postal_code')" label="Postal code" />
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
import Form from '@/Utils/Form'
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
  },
  data() {
    return {
      form: new Form({
        name: this.organization.name,
        email: this.organization.email,
        phone: this.organization.phone,
        address: this.organization.address,
        city: this.organization.city,
        region: this.organization.region,
        country: this.organization.country,
        postal_code: this.organization.postal_code,
      }),
    }
  },
  methods: {
    submit() {
      this.form.put({
        url: this.route('organizations.update', this.organization.id).url(),
        then: () => Inertia.visit(this.route('organizations')),
      })
    },
    destroy() {
      if (confirm('Are you sure you want to delete this organization?')) {
        this.form.delete({
          url: this.route('organizations.destroy', this.organization.id).url(),
          then: () => Inertia.replace(this.route('organizations.edit', this.organization.id).url()),
        })
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this organization?')) {
        this.form.put({
          url: this.route('organizations.restore', this.organization.id).url(),
          then: () => Inertia.replace(this.route('organizations.edit', this.organization.id).url()),
        })
      }
    },
  },
}
</script>
