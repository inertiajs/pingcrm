<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('tasks')">Tasks</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="store">
        
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
        
         
          <text-input v-model="form.title" :error="form.errors.title" class="pr-6 pb-8 w-full lg:w-1/2" label="Title" />
          <text-input v-model="form.description" :error="form.errors.description" class="pr-6 pb-8 w-full lg:w-1/2" label="Description" />
         
          <select-input v-model="form.priority" :error="form.errors.priority" class="pr-6 pb-8 w-full lg:w-1/2" label="Priority">
            <option :value="null" />
            <option value="10">Low</option>
            <option value="20">Normal</option>
            <option value="30">High</option>
            <option value="40">Urgent</option>
          </select-input>

          <select-input v-model="form.status" :error="form.errors.status" class="pr-6 pb-8 w-full lg:w-1/2" label="Status">
            <option :value="null" />
            <option value="100">Pending</option>
            <option value="200">Complete</option>
          </select-input>
          
          <text-input v-model="form.due_date" :error="form.errors.due_date" class="pr-6 pb-8 w-full lg:w-1/2" label="Due_date" />
          <text-input v-model="form.completed_date" :error="form.errors.completed_date" class="pr-6 pb-8 w-full lg:w-1/2" label="Completed_date" />
          <text-input v-model="form.User_id" :error="form.errors.user_id" class="pr-6 pb-8 w-full lg:w-1/2" label="User_id" />
          <text-input v-model="form.task_id" :error="form.errors.task_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Task_id" />
          <text-input v-model="form.project_id" :error="form.errors.project_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Project_id" />
          <text-input v-model="form.team_id" :error="form.errors.team_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Team_id" />
      
        </div>

        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Task</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'

export default {
  metaInfo: { title: 'Create Task' },
  components: {
    LoadingButton,
    SelectInput,
    TextInput,
  },
  layout: Layout,
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
       
        title: null,
        description: null,
        priority: null,
        status: null,
        due_date: null,
        completed_date: null,
        user_id: null,
        task_id: null,
        project_id: null,
        team_id: null,
      }),
    }
  },
  methods: {
    store() {
      this.form.post(this.route('tasks.store'))
    },
  },
}
</script>
