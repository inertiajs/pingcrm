<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('addresses')">Addresses</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="address.deleted_at" class="mb-6" @restore="restore">
      This address has been deleted.
    </trashed-message>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="update">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.name" :error="form.errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />
           <text-input v-model="form.phone" :error="form.errors.phone" class="pr-6 pb-8 w-full lg:w-1/2" label="Phone" />
          <text-input v-model="form.address_line1" :error="form.errors.address_line1" class="pr-6 pb-8 w-full lg:w-1/2" label="Address" />
          <text-input v-model="form.address_line2" :error="form.errors.address_line2" class="pr-6 pb-8 w-full lg:w-1/2" label="Address" />
         <text-input v-model="form.city" :error="form.errors.city" class="pr-6 pb-8 w-full lg:w-1/2" label="City" />
          <text-input v-model="form.region" :error="form.errors.region" class="pr-6 pb-8 w-full lg:w-1/2" label="Province/State" />
          <select-input v-model="form.country" :error="form.errors.country" class="pr-6 pb-8 w-full lg:w-1/2" label="Country">
            <option :value="null" />
            <option value="CA">India</option>
            <option value="US">United States</option>
          </select-input>
          <text-input v-model="form.postal_code" :error="form.errors.postal_code" class="pr-6 pb-8 w-full lg:w-1/2" label="Postal code" />
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <button v-if="!address.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Address</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Address</loading-button>
        </div>
      </form>
    </div>
    
    </div>
  
</template>

<script>
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  metaInfo() {
    return { title: this.form.name }
  },
  components: {
    Icon,
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
  },
  layout: Layout,
  props: {
    address: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: this.address.name,
         phone: this.address.phone,
        address_line1: this.address.address_line1,
        address_line2: this.address.address_line2,
        city: this.address.city,
        region: this.address.region,
        country: this.address.country,
        postal_code: this.address.postal_code,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(this.route('address.update', this.address.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this address?')) {
        this.$inertia.delete(this.route('address.destroy', this.address.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this address?')) {
        this.$inertia.put(this.route('address.restore', this.address.id))
      }
    },
  },
}
</script>
