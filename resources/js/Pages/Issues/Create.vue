<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('issues')">Issues</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="store">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.title" :error="form.errors.title" class="pr-6 pb-8 w-full lg:w-full" label="Title" />
          <textarea-input v-model="form.description" :error="form.errors.description" class="pr-6 pb-8 w-full lg:w-full" label="Description" />
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
          <select-input v-model="form.assign" :error="form.errors.assign" class="pr-6 pb-8 w-full lg:w-full" label="Assign">
            <option :value="null" />
            <option value="Bhavuk">Bhavuk</option>
            <option value="Jasmeen">Jasmeen</option>
            <option value="Lalit">Lalit</option>
            <option value="Manju">Manju</option>
          </select-input>
          <textarea-input v-model="form.solution" :error="form.errors.solution" class="pr-6 pb-8 w-full lg:w-full" label="Solution" />
          <text-input type="date" v-model="form.due_date" :error="form.errors.due_date" class="pr-6 pb-8 w-full lg:w-1/2" label="Due Date" />
          <text-input type="date" v-model="form.completed_date" :error="form.errors.completed_date" class="date pr-6 pb-8 w-full lg:w-1/2" label="Completed Date" />
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Issue</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import TextareaInput from '@/Shared/TextareaInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'

export default {
  metaInfo: { title: 'Create Issue' },
  components: {
    LoadingButton,
    SelectInput,
    TextInput,
    TextareaInput
  },
  layout: Layout,
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        title: null,
        description: null,
        status: null,
        priority: null,
        solution: null,
        assign: null,
        due_date: null,
        completed_date: null,
      }),
    }
  },
  methods: {
    store() {
      this.form.post(this.route('issues.store'))
    },
  },
}
</script>
