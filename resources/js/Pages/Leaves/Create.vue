<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('leaves')">Leaves</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="store">
        
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          
          <text-input v-model="form.name" :error="form.errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />
          <text-input v-model="form.contact_no" :error="form.errors.contact_no" class="pr-6 pb-8 w-full lg:w-1/2" label="Contact No"></text-input>
          <select-input v-model="form.day" :error="form.errors.day" class="pr-6 pb-8 w-full lg:w-1/2" label="Day">
            
            <option :value="null" />
            <option value="Yesterday">Yesterday</option>
            <option value="Today">Today</option>
            <option value="Tommorow">Tommorow</option>

          </select-input>
          
          <text-input v-model="form.date" :error="form.errors.date" class="pr-6 pb-8 w-full lg:w-1/2" label="Date"></text-input>
          <text-input v-model="form.reason_of_leave" :error="form.errors.reason_of_leave" class="pr-6 pb-8 w-full lg:w-1/2" label="Reason of Leave"></text-input>
        
        </div>
        
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Leave</loading-button>
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
  metaInfo: { title: 'Create Leave' },
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
        contact_no: null,
        day: null,
        date: null,
        reason_of_leave: null,
      }),
    }
  },
  methods: {
    store() {
      this.form.post(this.route('leaves.store'))
    },
  },
}
</script>
