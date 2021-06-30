<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('officerule')">OfficeRule</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="officerule.deleted_at" class="mb-6" @restore="restore">
      This officerule has been deleted.
    </trashed-message>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="update">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          
          <text-input v-model="form.title" :error="form.errors.title" class="pr-6 pb-8 w-full lg:w-1/2" label="Title" />
          <text-input v-model="form.description" :error="form.errors.description" class="pr-6 pb-8 w-full lg:w-1/2" label="Description" />
          <text-input v-model="form.User_id" :error="form.errors.user_id" class="pr-6 pb-8 w-full lg:w-1/2" label="User ID" />
          <text-input v-model="form.rule_category_id" :error="form.errors.rule_category_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Rule Category ID" />
        
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <button v-if="!officerule.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete OfficeRule</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update OfficeRule</loading-button>
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
    officerule: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: this.officerule.name,
        phone: this.officerule.phone,
        status: this.officerule.status,
        priority: this.officerule.priority,

      }),
    }
  },
  methods: {
    update() {
      this.form.put(this.route('officerule.update', this.officerule.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this officerule?')) {
        this.$inertia.delete(this.route('officerule.destroy', this.officerule.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this officerule?')) {
        this.$inertia.put(this.route('officerule.restore', this.officerule.id))
      }
    },
  },
}
</script>
