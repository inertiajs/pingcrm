<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('budgets')">Budgets</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="store">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
        
         
          <text-input v-model="form.project_name" :error="form.errors.project_name" class="pr-6 pb-8 w-full lg:w-1/2" label="Project name" />
          <text-input v-model="form.resources" :error="form.errors.resources" class="pr-6 pb-8 w-full lg:w-1/2" label="Resources" />
          <text-input v-model="form.cost" :error="form.errors.cost" class="pr-6 pb-8 w-full lg:w-1/2" label="Cost" />
          <text-input v-model="form.profit" :error="form.errors.profit" class="pr-6 pb-8 w-full lg:w-1/2" label="Profit" />
          <text-input v-model="form.loss" :error="form.errors.loss" class="pr-6 pb-8 w-full lg:w-1/2" label="Loss" />
          
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
       
        project_name: null,
        resources: null,
        cost: null,
        profit: null,
        loss: null,
        
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
