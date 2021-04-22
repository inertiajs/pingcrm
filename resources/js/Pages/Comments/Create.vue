<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('comments')">Comments</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="store">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
        
         

          <text-input v-model="form.description" :error="form.errors.description" class="pr-6 pb-8 w-full lg:w-1/2" label="Description" />
          <text-input v-model="form.User_id" :error="form.errors.user_id" class="pr-6 pb-8 w-full lg:w-1/2" label="User_id" />
          <text-input v-model="form.comment_id" :error="form.errors.comment_id" class="pr-6 pb-8 w-full lg:w-1/2" label="comment_id" />
          <text-input v-model="form.project_id" :error="form.errors.project_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Project_id" />
          <text-input v-model="form.team_id" :error="form.errors.team_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Team_id" />
      
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
