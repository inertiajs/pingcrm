<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('experiences')">Experience Details</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="store">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.name" :error="form.errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />
          <text-input v-model="form.company" :error="form.errors.company" class="pr-6 pb-8 w-full lg:w-1/2" label="Company" />
          <text-input v-model="form.start_date" :error="form.errors.start_date" class="pr-6 pb-8 w-full lg:w-1/2" label="Start Date" />
          <text-input v-model="form.end_date" :error="form.errors.end_date" class="pr-6 pb-8 w-full lg:w-1/2" label="End Date" />
          <text-input v-model="form.total_experience" :error="form.errors.total_experience" class="pr-6 pb-8 w-full lg:w-1/2" label="Total Experience" />
          </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Experience</loading-button>
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
  metaInfo: { title: 'Create Experience' },
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
        company:null,
        start_date:null,
        end_date:null,
        total_experience:null,

      }),
    }
  },
  methods: {
    store() {
      this.form.post(this.route('experiences.store'))
    },
  },
}
</script>
