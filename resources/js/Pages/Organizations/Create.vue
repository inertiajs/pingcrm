<template>
  <layout title="Create Organization">
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-light hover:text-indigo-dark" :href="route('organizations')">Organizations</inertia-link>
      <span class="text-indigo-light font-medium">/</span> Create
    </h1>
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
        <div class="px-8 py-4 bg-grey-lightest border-t border-grey-lighter flex justify-end items-center">
          <loading-button :loading="sending" class="btn-indigo" type="submit">Create Organization</loading-button>
        </div>
      </form>
    </div>
  </layout>
</template>

<script>
import { Inertia, InertiaLink } from 'inertia-vue'
import Layout from '@/Shared/Layout'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from '@/Shared/SelectInput'
import TextInput from '@/Shared/TextInput'

export default {
  components: {
    InertiaLink,
    Layout,
    LoadingButton,
    SelectInput,
    TextInput,
  },
  props: {
    organization: {
      type: Object,
      default: () => ({}),
    },
    errors: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      sending: false,
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
  watch: {
    form: {
      handler: form => Inertia.cache('organization', form),
      deep: true,
    },
  },
  methods: {
    submit() {
      this.sending = true
      Inertia.post(this.route('organizations.store').url(), this.form).then(() => this.sending = false)
    },
  },
}
</script>
