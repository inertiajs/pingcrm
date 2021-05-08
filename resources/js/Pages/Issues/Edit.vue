<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('issues')">Issues</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.issue }}
    </h1>
    <trashed-message v-if="issue.deleted_at" class="mb-6" @restore="restore">
      This issue has been deleted.
    </trashed-message>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="update">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.issue" :error="form.errors.issue" class="pr-6 pb-8 w-full lg:w-1/2" label="Issue" />
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
          <text-input v-model="form.fix" :error="form.errors.fix" class="pr-6 pb-8 w-full lg:w-1/2" label="Fix" />
          <text-input v-model="form.assign" :error="form.errors.assign" class="pr-6 pb-8 w-full lg:w-1/2" label="Assign" />
          <text-input v-model="form.due_date" :error="form.errors.due_date" class="pr-6 pb-8 w-full lg:w-1/2" label="Due Date" />
          <text-input v-model="form.completed_date" :error="form.errors.completed_date" class="pr-6 pb-8 w-full lg:w-1/2" label="Completed Date" />
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <button v-if="!issue.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Issue</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Issue</loading-button>
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
    return { issue: this.form.name }
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
    issue: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        issue: this.issue.issue,
        description: this.issue.description,
        status: this.issue.status,
        priority: this.issue.priority,
        fix: this.issue.fix,
        assign: this.issue.assign,
        due_date: this.issue.due_date,
        completed_date: this.issue.completed_date,

      }),
    }
  },
  methods: {
    update() {
      this.form.put(this.route('issues.update', this.issue.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this issue?')) {
        this.$inertia.delete(this.route('issues.destroy', this.issue.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this issue?')) {
        this.$inertia.put(this.route('issues.restore', this.issue.id))
      }
    },
  },
}
</script>
