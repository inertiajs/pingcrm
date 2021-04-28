<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('experiences')">Experience Details</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="experience.deleted_at" class="mb-6" @restore="restore">
      This experience has been deleted.
    </trashed-message>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="update">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.name" :error="form.errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />
          <text-input v-model="form.company" :error="form.errors.company" class="pr-6 pb-8 w-full lg:w-1/2" label="Company" />
          <text-input v-model="form.start_date" :error="form.errors.start_date" class="pr-6 pb-8 w-full lg:w-1/2" label="Start Date" />
          <text-input v-model="form.end_date" :error="form.errors.end_date" class="pr-6 pb-8 w-full lg:w-1/2" label="End Date" />
          <text-input v-model="form.total_experience" :error="form.errors.total_experience" class="pr-6 pb-8 w-full lg:w-1/2" label="Total Experience" />
          </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <button v-if="!experience.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Experience</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Experience</loading-button>
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
    experience: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: this.experience.name,
        company: this.experience.company,
        start_date: this.experience.start_date,
        end_date: this.experience.end_date,
        total_experience: this.experience.total_experience,
         }),
    }
  },
  methods: {
    update() {
      this.form.put(this.route('experiences.update', this.experience.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this experience?')) {
        this.$inertia.delete(this.route('experiences.destroy', this.experience.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this experience?')) {
        this.$inertia.put(this.route('experiences.restore', this.experience.id))
      }
    },
  },
}
</script>
