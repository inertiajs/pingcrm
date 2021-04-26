<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('clients')">Clients</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="client.deleted_at" class="mb-6" @restore="restore">
      This client has been deleted.
    </trashed-message>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="update">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.name" :error="form.errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />
          <text-input v-model="form.phone" :error="form.errors.phone" class="pr-6 pb-8 w-full lg:w-1/2" label="Phone" />
          <select-input v-model="form.status" :error="form.errors.status" class="pr-6 pb-8 w-full lg:w-1/2" label="Status">
            <option :value="null" />
            <option value="100">Pending</option>
            <option value="200">Complete</option>
          </select-input>
          <select-input v-model="form.priority" :error="form.errors.priority" class="pr-6 pb-8 w-full lg:w-1/2" label="Priority">
            <option :value="null" />
            <option value="100">Low</option>
            <option value="200">Normal</option>
            <option value="300">High</option>
            <option value="400">Urgent</option>
          </select-input>
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <button v-if="!client.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Client</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Client</loading-button>
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
    client: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: this.client.name,
        phone: this.client.phone,
        status: this.client.status,
        priority: this.client.priority,

      }),
    }
  },
  methods: {
    update() {
      this.form.put(this.route('clients.update', this.client.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this client?')) {
        this.$inertia.delete(this.route('clients.destroy', this.client.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this client?')) {
        this.$inertia.put(this.route('clients.restore', this.client.id))
      }
    },
  },
}
</script>
