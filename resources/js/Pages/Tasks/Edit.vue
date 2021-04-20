<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('tasks')">Tasks</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="task.deleted_at" class="mb-6" @restore="restore">
      This task has been deleted.
    </trashed-message>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="update">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.id" :error="form.errors.id" class="pr-6 pb-8 w-full lg:w-1/2" label="Id" />
          <text-input v-model="form.title" :error="form.errors.title" class="pr-6 pb-8 w-full lg:w-1/2" label="Title" />
          <text-input v-model="form.description" :error="form.errors.description" class="pr-6 pb-8 w-full lg:w-1/2" label="Description" />
          <text-input v-model="form.priority" :error="form.errors.priority" class="pr-6 pb-8 w-full lg:w-1/2" label="Priority" />
          <text-input v-model="form.status" :error="form.errors.status" class="pr-6 pb-8 w-full lg:w-1/2" label="Status" />
          <text-input v-model="form.deu_date" :error="form.errors.deu_date" class="pr-6 pb-8 w-full lg:w-1/2" label="Deu_date" />
          <text-input v-model="form.completed_date" :error="form.errors.completed_date" class="pr-6 pb-8 w-full lg:w-1/2" label="Completed_date" />
          <text-input v-model="form.user_id" :error="form.errors.User_id" class="pr-6 pb-8 w-full lg:w-1/2" label="User_id" />
          <text-input v-model="form.task_id" :error="form.errors.task_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Task_id" />
          <text-input v-model="form.project_id" :error="form.errors.project_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Project_id" />
          <text-input v-model="form.team_id" :error="form.errors.team_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Team_id" />
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <button v-if="!task.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete task</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update task</loading-button>
        </div>
      </form>
    </div>
    <h2 class="mt-12 font-bold text-2xl">Contacts</h2>
    <div class="mt-6 bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Id</th>
          <th class="px-6 pt-6 pb-4">Title</th>
          <th class="px-6 pt-6 pb-4">Description</th>
          <th class="px-6 pt-6 pb-4">Priority</th>
          <th class="px-6 pt-6 pb-4">Status</th>
          <th class="px-6 pt-6 pb-4">Deu_date</th>
          <th class="px-6 pt-6 pb-4">Completed_date</th>
          <th class="px-6 pt-6 pb-4">User_id</th>
          <th class="px-6 pt-6 pb-4">Task_id</th>
          <th class="px-6 pt-6 pb-4">Project_id</th>
          <th class="px-6 pt-6 pb-4">Team_id</th>
          
        </tr>
        <tr v-for="contact in task.contacts" :key="contact.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('contacts.edit', contact.id)">
              {{ contact.id }}
              <icon v-if="contact.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
            </inertia-link>
          </td>

          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
              {{ contact.title }}
            </inertia-link>
          </td>
    
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
              {{ contact.description }}
            </inertia-link>
          </td>

           <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
              {{ contact.priority }}
            </inertia-link>
          </td>

           <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
              {{ contact.status }}
            </inertia-link>
          </td>

           <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
              {{ contact.deu_date }}
            </inertia-link>
          </td>

           <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
              {{ contact.completed_date }}
            </inertia-link>
          </td>

           <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
              {{ contact.user_id }}
            </inertia-link>
          </td>

           <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
              {{ contact.task_id }}
            </inertia-link>
          </td>

           <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
              {{ contact.project_id }}
            </inertia-link>
          </td>
          
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
              {{ contact.team_id }}
            </inertia-link>
          </td>

          <td class="border-t w-px">
            <inertia-link class="px-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </inertia-link>
          </td>
        </tr>
        <tr v-if="task.contacts.length === 0">
          <td class="border-t px-6 py-4" colspan="4">No contacts found.</td>
        </tr>
      </table>
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
    task: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        id: this.task.id,
        title: this.task.title,
        description: this.task.description,
        priority: this.task.priority,
        status: this.task.status,
        deu_date: this.task.deu_date,
        completed_date: this.task.completed_date,
        user_id: this.task.user_id,
        task_id: this.task.task,
        project_id: this.task.project_id,
        team_id: this.task.team_id,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(this.route('tasks.update', this.task.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this task?')) {
        this.$inertia.delete(this.route('tasks.destroy', this.task.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this organization?')) {
        this.$inertia.put(this.route('tasks.restore', this.task.id))
      }
    },
  },
}
</script>
