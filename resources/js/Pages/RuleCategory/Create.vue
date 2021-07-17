<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('rulecategory')">RuleCategory</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="store">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          
          <text-input v-model="form.name" :error="form.errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />
          <text-input v-model="form.description" :error="form.errors.description" class="pr-6 pb-8 w-full lg:w-1/2" label="Description" />
          <select-input v-model="form.priority" :error="form.errors.priority" class="pr-6 pb-8 w-full lg:w-1/2" label="Priority">
            <option :value="null" />
            <option value="10">Low</option>
            <option value="20">Normal</option>
            <option value="30">High</option>
            <option value="40">Urgent</option>
          </select-input>
          <text-input v-model="form.category" :error="form.errors.category" class="pr-6 pb-8 w-full lg:w-1/2" label="Category" />
          <text-input v-model="form.instructor_id" :error="form.errors.instructor_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Instructor ID" />
          <text-input v-model="form.parent_id" :error="form.errors.parent_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Parent ID" />
        </div>
        
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create RuleCategory</loading-button>
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
  metaInfo: { title: 'Create RuleCategory' },
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
        name: null,
        phone: null,
        status: null,
        priority: null,
      }),
    }
  },
  methods: {
    store() {
      this.form.post(this.route('rulecategory.store'))
    },
  },
}
</script>
