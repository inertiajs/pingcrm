<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('educations')">Educations</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="store">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
        
         
          <text-input v-model="form.title" :error="form.errors.title" class="pr-6 pb-8 w-full lg:w-1/2" label="Title" />
          <text-input v-model="form.name" :error="form.errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />
          <text-input v-model="form.email" :error="form.errors.email" class="pr-6 pb-8 w-full lg:w-1/2" label="Email" />
          <text-input v-model="form.phone" :error="form.errors.phone" class="pr-6 pb-8 w-full lg:w-1/2" label="Phone" />
          <text-input v-model="form.school" :error="form.errors.school" class="pr-6 pb-8 w-full lg:w-1/2" label="School" />
          <text-input v-model="form.college" :error="form.errors.college" class="pr-6 pb-8 w-full lg:w-1/2" label="College" />
          <select-input v-model="form.higher_education" :error="form.errors.priority" class="pr-6 pb-8 w-full lg:w-1/2" label="Higher_education">
            <option :value="null" />
            <option value="100">Diploma</option>
            <option value="200">Graduation</option>
            <option value="300">Matrix</option>
            <option value="400">Post_Graduation</option>
          </select-input>
          
          <text-input v-model="form.percentage" :error="form.errors.percentage" class="pr-6 pb-8 w-full lg:w-1/2" label="Percentage" />
      
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Education</loading-button>
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
  metaInfo: { title: 'Create education' },
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
        name: null,
        email: null,
        phone: null,
        school: null,
        college: null,
        higher_education: null,
        percentage: null,
        
      }),
    }
  },
  methods: {
    store() {
      this.form.post(this.route('educations.store'))
    },
  },
}
</script>
