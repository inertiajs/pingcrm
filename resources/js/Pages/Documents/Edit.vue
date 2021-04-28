<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('documents')">Documents</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="document.deleted_at" class="mb-6" @restore="restore">
      This document has been deleted.
    </trashed-message>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="update">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
        
          <text-input v-model="form.title" :error="form.errors.title" class="pr-6 pb-8 w-full lg:w-1/2" label="Title" />
          <text-input v-model="form.customer_name" :error="form.errors.customer_name" class="pr-6 pb-8 w-full lg:w-1/2" label="Customer_Name" />
          <text-input v-model="form.document_type" :error="form.errors.document_type" class="pr-6 pb-8 w-full lg:w-1/2" label="Document_type" />
          <text-input v-model="form.digit" :error="form.errors.digit" class="pr-6 pb-8 w-full lg:w-1/2" label="Digit" />
          <text-input v-model="form.document_label" :error="form.errors.document_label" class="pr-6 pb-8 w-full lg:w-1/2" label="Document_label" />
          <text-input v-model="form.length" :error="form.errors.length" class="pr-6 pb-8 w-full lg:w-1/2" label="Length" />
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <button v-if="!document.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete document</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Document</loading-button>
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
    document: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        title: this.document.title,
        customer_name: this.document.customer_name,
        document_type: this.document.document_type,
        length: this.document.length,
        digit: this.document.digit,
        document_label: this.document.document_label,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(this.route('documents.update', this.document.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this document?')) {
        this.$inertia.delete(this.route('documents.destroy', this.document.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this document?')) {
        this.$inertia.put(this.route('documents.restore', this.document.id))
      }
    },
  },
}
</script>