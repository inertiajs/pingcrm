<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('profiles')">Profile Details</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="profile.deleted_at" class="mb-6" @restore="restore">
      This profile has been deleted.
    </trashed-message>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="update">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.name" :error="form.errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />
          <text-input v-model="form.phone" :error="form.errors.phone" class="pr-6 pb-8 w-full lg:w-1/2" label="Phone" />
           <text-input v-model="form.city" :error="form.errors.city" class="pr-6 pb-8 w-full lg:w-1/2" label="City" />
          <text-input v-model="form.job" :error="form.errors.job" class="pr-6 pb-8 w-full lg:w-1/2" label="Job" />
          <select-input v-model="form.nationality" :error="form.errors.nationality" class="pr-6 pb-8 w-full lg:w-1/2" label="Nationality">
            <option :value="null" />
            <option value="Hindu">Hindu</option>
            <option value="Muslim">Muslim</option>
            <option value="Sikh">Sikh</option>
            <option value="Christian">Christian</option>
          </select-input>
            </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <button v-if="!profile.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Profile</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Profile</loading-button>
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
    profile: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: this.profile.name,
        phone: this.profile.phone,
        city: this.profile.city,
        job: this.profile.job,
        nationality: this.profile.nationality,
           }),
    }
  },
  methods: {
    update() {
      this.form.put(this.route('profiles.update', this.profile.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this profile?')) {
        this.$inertia.delete(this.route('profiles.destroy', this.profile.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this profile?')) {
        this.$inertia.put(this.route('profiles.restore', this.profile.id))
      }
    },
  },
}
</script>
