<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('banks')">Bank Details</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="bank.deleted_at" class="mb-6" @restore="restore">
      This bank has been deleted.
    </trashed-message>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="update">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.name" :error="form.errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />
          <text-input v-model="form.phone" :error="form.errors.phone" class="pr-6 pb-8 w-full lg:w-1/2" label="Phone" />
          <text-input v-model="form.account_number" :error="form.errors.account_number" class="pr-6 pb-8 w-full lg:w-1/2" label="Account_number" />
          <text-input v-model="form.ifsc_code" :error="form.errors.ifsc_code" class="pr-6 pb-8 w-full lg:w-1/2" label="IFSC Code" />
           <text-input v-model="form.bank_name" :error="form.errors.bank_name" class="pr-6 pb-8 w-full lg:w-1/2" label="Bank Name" />
          <text-input v-model="form.email" :error="form.errors.email" class="pr-6 pb-8 w-full lg:w-1/2" label="Email" />
           </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <button v-if="!bank.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Bank</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Bank</loading-button>
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
    bank: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: this.bank.name,
        phone: this.bank.phone,
        account_number: this.bank.account_number,
        ifsc_code: this.bank.ifsc_code,
        bank_name: this.bank.bank_name,
        email: this.bank.email,
            }),
    }
  },
  methods: {
    update() {
      this.form.put(this.route('banks.update', this.bank.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this bank?')) {
        this.$inertia.delete(this.route('banks.destroy', this.bank.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this bank?')) {
        this.$inertia.put(this.route('banks.restore', this.bank.id))
      }
    },
  },
}
</script>
