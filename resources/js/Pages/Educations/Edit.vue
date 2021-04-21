<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('educations')">Educations</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="education.deleted_at" class="mb-6" @restore="restore">
      This education has been deleted.
    </trashed-message>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="update">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.title" :error="form.errors.title" class="pr-6 pb-8 w-full lg:w-1/2" label="Title" />
          <text-input v-model="form.name" :error="form.errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />
          <text-input v-model="form.email" :error="form.errors.email" class="pr-6 pb-8 w-full lg:w-1/2" label="Email" />
          <text-input v-model="form.mobile" :error="form.errors.mobile" class="pr-6 pb-8 w-full lg:w-1/2" label="Mobile" />
          <text-input v-model="form.school" :error="form.errors.school" class="pr-6 pb-8 w-full lg:w-1/2" label="School" />
          <text-input v-model="form.college" :error="form.errors.college" class="pr-6 pb-8 w-full lg:w-1/2" label="College" />
          <text-input v-model="form.percentage" :error="form.errors.percentage" class="pr-6 pb-8 w-full lg:w-1/2" label="Percentage" />
      
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <button v-if="!education.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete education</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Education</loading-button>
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
    education: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        id: this.education.id,
        title: this.education.title,
        description: this.education.description,
        priority: this.education.priority,
        status: this.education.status,
        deu_date: this.education.deu_date,
        completed_date: this.education.completed_date,
        user_id: this.education.user_id,
        education_id: this.education.education_id,
        project_id: this.education.project_id,
        team_id: this.education.team_id,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(this.route('educations.update', this.education.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this education?')) {
        this.$inertia.delete(this.route('educations.destroy', this.education.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this education?')) {
        this.$inertia.put(this.route('educations.restore', this.education.id))
      }
    },
  },
}
</script>