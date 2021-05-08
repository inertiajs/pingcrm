<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('documents')">Documents</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="store">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
        
         
          <text-input v-model="form.title" :error="form.errors.title" class="pr-6 pb-8 w-full lg:w-1/2" label="Title" />
          <text-input v-model="form.customer_name" :error="form.errors.customer_name" class="pr-6 pb-8 w-full lg:w-1/2" label="Customer_Name" />
          <text-input v-model="form.document_type" :error="form.errors.document_type" class="pr-6 pb-8 w-full lg:w-1/2" label="Document_type" />
          <text-input v-model="form.digit" :error="form.errors.digit" class="pr-6 pb-8 w-full lg:w-1/2" label="Digit" />
          <text-input v-model="form.document_label" :error="form.errors.document_label" class="pr-6 pb-8 w-full lg:w-1/2" label="Document_label" />
          <text-input v-model="form.length" :error="form.errors.length" class="pr-6 pb-8 w-full lg:w-1/2" label="Length" />
         
      
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Document</loading-button>
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
  metaInfo: { title: 'Create document' },
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
        customer_name: null,
        document_type: null,
        length: null,
        digit: null,
        document_label: null,
       
        
      }),
    }
  },
  methods: {
    store() {
      this.form.post(this.route('documents.store'))
    },
  },
}
</script>
