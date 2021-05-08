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
           <text-input v-model="form.project_name" :error="form.errors.project_name" class="pr-6 pb-8 w-full lg:w-1/2" label="Project name" />
          <text-input v-model="form.resources" :error="form.errors.resources" class="pr-6 pb-8 w-full lg:w-1/2" label="Resources" />
          <text-input v-model="form.cost" :error="form.errors.cost" class="pr-6 pb-8 w-full lg:w-1/2" label="Cost" />
          <text-input v-model="form.profit" :error="form.errors.profit" class="pr-6 pb-8 w-full lg:w-1/2" label="Profit" />
          <text-input v-model="form.loss" :error="form.errors.loss" class="pr-6 pb-8 w-full lg:w-1/2" label="Loss" />
          
    
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
        project_name: this.budget.project_name,
        resources: this.budget.resources,
        cost: this.budget.cost,
        profit: this.budget.profit,
        loss: this.budget.loss,
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
