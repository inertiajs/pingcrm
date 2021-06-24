<template>
  <slideout>
    <button type="button" class="absolute top-0 right-0 p-4 text-gray-500 hover:text-gray-700" @click="cancel">
      <svg class="fill-current w-2 h-2" viewBox="278.046 126.846 235.908 235.908">
        <path d="M506.784 134.017c-9.56-9.56-25.06-9.56-34.62 0L396 210.18l-76.164-76.164c-9.56-9.56-25.06-9.56-34.62 0-9.56 9.56-9.56 25.06 0 34.62L361.38 244.8l-76.164 76.165c-9.56 9.56-9.56 25.06 0 34.62 9.56 9.56 25.06 9.56 34.62 0L396 279.42l76.164 76.165c9.56 9.56 25.06 9.56 34.62 0 9.56-9.56 9.56-25.06 0-34.62L430.62 244.8l76.164-76.163c9.56-9.56 9.56-25.06 0-34.62z"></path>
      </svg>
    </button>
    <trashed-message v-if="organization.deleted_at" class="mb-6" @restore="restore">
      This organization has been deleted.
    </trashed-message>
    <h2 class="pt-12 font-bold text-2xl">Edit Organization</h2>
    <div class="mt-6">
      <form @submit.prevent="submit" :class="$dialog.open ? '' : 'bg-white rounded shadow max-w-xl overflow-hidden'">
        <div :class="$dialog.open ? '' : 'p-8'">
          <text-input ref="name" v-model="form.name" :error="errors.name" class="pb-8" label="Name" />
          <text-input v-model="form.email" :error="errors.email" class="pb-8" label="Email" />
          <text-input v-model="form.phone" :error="errors.phone" class="pb-8" label="Phone" />
          <text-input v-model="form.address" :error="errors.address" class="pb-8" label="Address" />
          <div class="-mr-4">
            <div class="flex flex-wrap">
              <text-input v-model="form.city" :error="errors.city" class="w-1/2 pr-4 pb-8" label="City" />
              <text-input v-model="form.region" :error="errors.region" class="w-1/2 pr-4 pb-8" label="Province/State" />
              <select-input v-model="form.country" :error="errors.country" class="w-1/2 pr-4 pb-8" label="Country">
                <option :value="null" />
                <option value="CA">Canada</option>
                <option value="US">United States</option>
              </select-input>
              <text-input v-model="form.postal_code" :error="errors.postal_code" class="w-1/2 pr-4 pb-8" label="Postal code" />
            </div>
          </div>
        </div>
        <div class="py-4 flex items-center" :class="$dialog.open ? '' : 'bg-gray-100 border-t border-gray-200 px-8'">
          <inertia-link v-if="!organization.deleted_at" class="text-red-600 hover:underline" :href="`/organizations/${organization.id}/delete`">
            Delete
          </inertia-link>
          <loading-button :loading="sending" class="ml-auto btn-indigo" type="submit">Update Organization</loading-button>
        </div>
      </form>
    </div>
  </slideout>
</template>

<script>
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from '@/Shared/SelectInput'
import TextInput from '@/Shared/TextInput'
import TrashedMessage from '@/Shared/TrashedMessage'
import Slideout from '@/Shared/Slideout'

export default {
  metaInfo() {
    return { title: this.form.name }
  },
  layout: Layout,
  components: {
    Icon,
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
    Slideout,
  },
  props: {
    errors: Object,
    organization: Object,
  },
  remember: {
    data: ['form'],
    key() {
      return `Organizations/Edit:${this.organization.id}`
    }
  },
  created() {
    document.title = 'Edit organization - Ping CRM'
  },
  mounted() {
    setTimeout(() => this.$refs.name.focus(), 200)
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
  methods: {
    submit() {
      this.$inertia.put(this.route('organizations.update', this.organization.id), this.form, {
        onStart: () => this.sending = true,
        onFinish: () => this.sending = false,
      })
    },
    cancel() {
      this.$inertia.closeDialog()
    },
    destroy() {
      if (confirm('Are you sure you want to delete this organization?')) {
        this.$inertia.delete(this.route('organizations.destroy', this.organization.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this organization?')) {
        this.$inertia.put(this.route('organizations.restore', this.organization.id))
      }
    },
  },
}
</script>
