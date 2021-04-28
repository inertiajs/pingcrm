<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('budgets')">Budgets</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="store">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
        
         
          <text-input v-model="form.title" :error="form.errors.title" class="pr-6 pb-8 w-full lg:w-1/2" label="Title" />
          <text-input v-model="form.description" :error="form.errors.description" class="pr-6 pb-8 w-full lg:w-1/2" label="Description" />
          <text-input v-model="form.User_id" :error="form.errors.user_id" class="pr-6 pb-8 w-full lg:w-1/2" label="User_id" />
          <text-input v-model="form.annually_salary" :error="form.errors.annually_salary" class="pr-6 pb-8 w-full lg:w-1/2" label="Annually_salary" />
          <text-input v-model="form.monthly_salary" :error="form.errors.monthly_salary" class="pr-6 pb-8 w-full lg:w-1/2" label="Monthly_salary" />
          <text-input v-model="form.data_type" :error="form.errors.data_type" class="pr-6 pb-8 w-full lg:w-1/2" label="Data_type" />
      
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Budget</loading-button>
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
  metaInfo: { title: 'Create Budget' },
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
        user_id: null,
        monthly_salary: null,
        annually_salary: null,
        data_type: null,
      }),
    }
  },
  methods: {
    store() {
      this.form.post(this.route('budgets.store'))
    },
  },
}
</script>
