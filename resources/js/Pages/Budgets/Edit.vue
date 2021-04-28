<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('budgets')">Budgets</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="budget.deleted_at" class="mb-6" @restore="restore">
      This budget has been deleted.
    </trashed-message>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="update">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
           <text-input v-model="form.title" :error="form.errors.title" class="pr-6 pb-8 w-full lg:w-1/2" label="Title" />
          <text-input v-model="form.description" :error="form.errors.description" class="pr-6 pb-8 w-full lg:w-1/2" label="Description" />
          <text-input v-model="form.User_id" :error="form.errors.user_id" class="pr-6 pb-8 w-full lg:w-1/2" label="User_id" />
          <text-input v-model="form.annually_salary" :error="form.errors.annually_salary" class="pr-6 pb-8 w-full lg:w-1/2" label="Annually_salary" />
          <text-input v-model="form.monthly_salary" :error="form.errors.monthly_salary" class="pr-6 pb-8 w-full lg:w-1/2" label="Monthly_salary" />
          <text-input v-model="form.data_type" :error="form.errors.data_type" class="pr-6 pb-8 w-full lg:w-1/2" label="Data_type" />
          
    
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <button v-if="!budget.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete budget</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Budget</loading-button>
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
    budget: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        id: this.budget.id,
        title: this.budget.title,
        user_id: this.budget.user_id,
        annually_salary: this.budget.annually_salary,
        monthly_salary: this.budget.monthly_salary,
        data_type: this.budget.data_type,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(this.route('budgets.update', this.budget.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this budget?')) {
        this.$inertia.delete(this.route('budgets.destroy', this.budget.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this budget?')) {
        this.$inertia.put(this.route('budgets.restore', this.budget.id))
      }
    },
  },
}
</script>
