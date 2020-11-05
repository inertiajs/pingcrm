<template>
  <div>
    <modal close-url="/organizations">
      <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
        <div class="px-8 pt-6 pb-5 border-b font-bold leading-none">
          Create organization: {{ message }}
        </div>
        <form @submit.prevent="submit">
          <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
            <text-input v-model="form.name" :error="errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />
            <text-input v-model="form.email" :error="errors.email" class="pr-6 pb-8 w-full lg:w-1/2" label="Email" />
            <text-input v-model="form.phone" :error="errors.phone" class="pr-6 pb-8 w-full lg:w-1/2" label="Phone" />
            <text-input v-model="form.address" :error="errors.address" class="pr-6 pb-8 w-full lg:w-1/2" label="Address" />
            <text-input v-model="form.city" :error="errors.city" class="pr-6 pb-8 w-full lg:w-1/2" label="City" />
            <text-input v-model="form.region" :error="errors.region" class="pr-6 pb-8 w-full lg:w-1/2" label="Province/State" />
            <select-input v-model="form.country" :error="errors.country" class="pr-6 pb-8 w-full lg:w-1/2" label="Country">
              <option :value="null" />
              <option value="CA">Canada</option>
              <option value="US">United States</option>
            </select-input>
            <text-input v-model="form.postal_code" :error="errors.postal_code" class="pr-6 pb-8 w-full lg:w-1/2" label="Postal code" />
          </div>
          <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
            <loading-button :loading="sending" class="btn-indigo" type="submit">Create Organization</loading-button>
          </div>
        </form>
      </div>
    </modal>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from '@/Shared/SelectInput'
import TextInput from '@/Shared/TextInput'
import Modal from '@/Shared/Modal'

export default {
  metaInfo: { title: 'Create Organization' },
  layout: Layout,
  components: {
    Modal,
    LoadingButton,
    SelectInput,
    TextInput,
  },
  props: {
    message: String,
    partial: Boolean,
    errors: Object,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        name: null,
        email: null,
        phone: null,
        address: null,
        city: null,
        region: null,
        country: null,
        postal_code: null,
      },
    }
  },
  methods: {
    submit() {
      this.$inertia.post(this.route('organizations.store'), this.form, {
        inline: 'same',
        onStart: () => this.sending = true,
        onFinish: () => this.sending = false,
      })
    },
  },
}
</script>
