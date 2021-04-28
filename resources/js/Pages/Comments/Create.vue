<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('comments')">Comments</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="store">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
        
         

          <text-input v-model="form.id" :error="form.errors.id" class="pr-6 pb-8 w-full lg:w-1/2" label="Id" />
          <text-input v-model="form.description" :error="form.errors.description" class="pr-6 pb-8 w-full lg:w-1/2" label="Description" />
          <text-input v-model="form.User_id" :error="form.errors.user_id" class="pr-6 pb-8 w-full lg:w-1/2" label="User_id" />
          <text-input v-model="form.task_id" :error="form.errors.task_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Task_id" />
          <text-input v-model="form.assigned_user_id" :error="form.errors.assigned_user_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Assigned_user_id" />
          <text-input v-model="form.type" :error="form.errors.type" class="pr-6 pb-8 w-full lg:w-1/2" label="Type" />
        
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Comment</loading-button>
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
  metaInfo: { title: 'Create Comment' },
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
        deu_date: null,
        completed_date: null,
        user_id: null,
        comment_id: null,
        project_id: null,
        team_id: null,
      }),
    }
  },
  methods: {
    store() {
      this.form.post(this.route('comments.store'))
    },
  },
}
</script>
