<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('projects')">Projects</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.title }}
    </h1>
    <trashed-message v-if="project.deleted_at" class="mb-6" @restore="restore">
      This project has been deleted.
    </trashed-message>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="update">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.title" :error="form.errors.title" class="pr-6 pb-8 w-full lg:w-1/2" label="Title" />
          <text-input v-model="form.description" :error="form.errors.description" class="pr-6 pb-8 w-full lg:w-1/2" label="Description" />
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
          <text-input v-model="form.creator" :error="form.errors.creator" class="pr-6 pb-8 w-full lg:w-1/2" label="Creator" />
          <text-input v-model="form.due_date" :error="form.errors.due_date" class="pr-6 pb-8 w-full lg:w-1/2" label="Due Date" />
          <text-input v-model="form.completed_date" :error="form.errors.completed_date" class="pr-6 pb-8 w-full lg:w-1/2" label="Completed Date" />
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <button v-if="!project.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Project</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Project</loading-button>
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
    project: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        title: this.project.title,
        description: this.project.description,
        status: this.project.status,
        priority: this.project.priority,
        creator: this.project.creator,
        due_date: this.project.due_date,
        completed_date: this.project.completed_date,

      }),
    }
  },
  methods: {
    update() {
      this.form.put(this.route('projects.update', this.project.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this project?')) {
        this.$inertia.delete(this.route('projects.destroy', this.project.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this project?')) {
        this.$inertia.put(this.route('projects.restore', this.project.id))
      }
    },
  },
}
</script>
