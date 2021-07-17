<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('rulecategory')">RuleCategory</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="rulecategory.deleted_at" class="mb-6" @restore="restore">
      This rulecategory has been deleted.
    </trashed-message>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="update">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          
          <text-input v-model="form.name" :error="form.errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Name" />
          <text-input v-model="form.description" :error="form.errors.description" class="pr-6 pb-8 w-full lg:w-1/2" label="Description" />
          <text-input v-model="form.category" :error="form.errors.category" class="pr-6 pb-8 w-full lg:w-1/2" label="Category" />
          <text-input v-model="form.instructor_id" :error="form.errors.instructor_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Instructor ID" />
          <text-input v-model="form.parent_id" :error="form.errors.parent_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Parent ID" />
          <select-input v-model="form.priority" :error="form.errors.priority" class="pr-6 pb-8 w-full lg:w-1/2" label="Priority">
            <option :value="null" />
            <option value="10">Low</option>
            <option value="20">Normal</option>
            <option value="30">High</option>
            <option value="40">Urgent</option>
          </select-input>
        
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <button v-if="!rulecategory.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete RuleCategory</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update RuleCategory</loading-button>
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
    rulecategory: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: this.rulecategory.name,
        phone: this.rulecategory.phone,
        status: this.rulecategory.status,
        priority: this.rulecategory.priority,

      }),
    }
  },
  methods: {
    update() {
      this.form.put(this.route('rulecategory.update', this.rulecategory.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this rulecategory?')) {
        this.$inertia.delete(this.route('rulecategory.destroy', this.rulecategory.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this rulecategory?')) {
        this.$inertia.put(this.route('rulecategory.restore', this.rulecategory.id))
      }
    },
  },
}
</script>
