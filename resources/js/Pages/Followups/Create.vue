<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('followups')">Followups</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="store">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
        
         
          <text-input v-model="form.title" :error="form.errors.title" class="pr-6 pb-8 w-full lg:w-1/2" label="Title" />
          <text-input v-model="form.description" :error="form.errors.description" class="pr-6 pb-8 w-full lg:w-1/2" label="Description" />
          <text-input v-model="form.priority" :error="form.errors.priority" class="pr-6 pb-8 w-full lg:w-1/2" label="Priority" />
          <text-input v-model="form.status" :error="form.errors.status" class="pr-6 pb-8 w-full lg:w-1/2" label="Status" />
          <text-input v-model="form.agreement" :error="form.errors.agreement" class="pr-6 pb-8 w-full lg:w-1/2" label="Agreement" />
          <text-input v-model="form.phone" :error="form.errors.phone" class="pr-6 pb-8 w-full lg:w-1/2" label="Phone" />
          <text-input v-model="form.customer_name" :error="form.errors.customer_name" class="pr-6 pb-8 w-full lg:w-1/2" label="Customer_name" />
          <text-input v-model="form.maximum_time" :error="form.errors.maximum_time" class="pr-6 pb-8 w-full lg:w-1/2" label="Maximum_time" />
          <text-input v-model="form.meeting_schedule" :error="form.errors.meeting_schedule" class="pr-6 pb-8 w-full lg:w-1/2" label="Meeting_schedule" />
          <text-input v-model="form.team_id" :error="form.errors.team_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Team_id" />
      
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Followup</loading-button>
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
  metaInfo: { title: 'Create Followup' },
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
       
        title :null,
        description :null,
        priority :null,
        status:null,
        customer_name :null,
        email  :null,
        team_id :null,
        phone :null,
        agreement :null,
        maximum_time :null,
        maximum_schedule :null,
      }),
    }
  },
  methods: {
    store() {
      this.form.post(this.route('followups.store'))
    },
  },
}
</script>
