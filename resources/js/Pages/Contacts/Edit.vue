<template>
  <layout :title="`${form.fields.first_name} ${form.fields.last_name}`">
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-light hover:text-indigo-dark" :href="route('contacts')">Contacts</inertia-link>
      <span class="text-indigo-light font-medium">/</span>
      {{ form.fields.first_name }} {{ form.fields.last_name }}
    </h1>
    <trashed-message v-if="contact.deleted_at" class="mb-6" @restore="restore">
      This contact has been deleted.
    </trashed-message>
    <div class="bg-white rounded shadow overflow-hidden max-w-lg">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.fields.first_name" class="pr-6 pb-8 w-full lg:w-1/2" :error="form.errors.first('first_name')" label="First name" />
          <text-input v-model="form.fields.last_name" class="pr-6 pb-8 w-full lg:w-1/2" :error="form.errors.first('last_name')" label="Last name" />
          <select-input v-model="form.fields.organization_id" class="pr-6 pb-8 w-full lg:w-1/2" :error="form.errors.first('organization_id')" label="Organization">
            <option :value="null" />
            <option v-for="organization in organizations" :key="organization.id" :value="organization.id">{{ organization.name }}</option>
          </select-input>
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
          <button v-if="!contact.deleted_at" class="text-red hover:underline" tabindex="-1" type="button" @click="destroy">Delete Contact</button>
          <loading-button :loading="form.sending" class="btn-indigo ml-auto" type="submit">Update Contact</loading-button>
        </div>
      </form>
    </div>
  </layout>
</template>

<script>
import { Inertia, InertiaLink } from 'inertia-vue'
import Form from '@/Utils/Form'
import Layout from '@/Shared/Layout'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from '@/Shared/SelectInput'
import TextInput from '@/Shared/TextInput'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  components: {
    InertiaLink,
    Layout,
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
  },
  props: {
    contact: Object,
    organizations: Array,
  },
  data() {
    return {
      form: new Form({
        first_name: this.contact.first_name,
        last_name: this.contact.last_name,
        organization_id: this.contact.organization_id,
        email: this.contact.email,
        phone: this.contact.phone,
        address: this.contact.address,
        city: this.contact.city,
        region: this.contact.region,
        country: this.contact.country,
        postal_code: this.contact.postal_code,
      }),
    }
  },
  methods: {
    submit() {
      this.form.put({
        url: this.route('contacts.update', this.contact.id).url(),
        then: () => Inertia.visit(this.route('contacts')),
      })
    },
    destroy() {
      if (confirm('Are you sure you want to delete this contact?')) {
        this.form.delete({
          url: this.route('contacts.destroy', this.contact.id).url(),
          then: () => Inertia.replace(this.route('contacts.edit', this.contact.id).url()),
        })
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this contact?')) {
        this.form.put({
          url: this.route('contacts.restore', this.contact.id).url(),
          then: () => Inertia.replace(this.route('contacts.edit', this.contact.id).url()),
        })
      }
    },
  },
}
</script>
