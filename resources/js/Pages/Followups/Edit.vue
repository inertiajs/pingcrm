<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('followups')">Followups</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="followup.deleted_at" class="mb-6" @restore="restore">
      This followup has been deleted.
    </trashed-message>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="update">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.title" :error="form.errors.title" class="pr-6 pb-8 w-full lg:w-1/2" label="Title" />
          <text-input v-model="form.description" :error="form.errors.description" class="pr-6 pb-8 w-full lg:w-1/2" label="Description" />
      <select-input v-model="form.priority" :error="form.errors.priority" class="pr-6 pb-8 w-full lg:w-1/2" label="Priority">
            <option :value="null" />
            <option value="10">Low</option>
            <option value="20">Normal</option>
            <option value="30">High</option>
            <option value="40">Urgent</option>
          </select-input>

          <select-input v-model="form.status" :error="form.errors.status" class="pr-6 pb-8 w-full lg:w-1/2" label="Status">
            <option :value="null" />
            <option value="100">Pending</option>
            <option value="200">Complete</option>
          </select-input>
          
          <text-input v-model="form.agreement" :error="form.errors.agreement" class="pr-6 pb-8 w-full lg:w-1/2" label="Agreement" />
          <text-input v-model="form.phone" :error="form.errors.phone" class="pr-6 pb-8 w-full lg:w-1/2" label="Phone" />
          <text-input v-model="form.customer_name" :error="form.errors.customer_name" class="pr-6 pb-8 w-full lg:w-1/2" label="Customer_name" />
          <text-input v-model="form.maximum_time" :error="form.errors.maximum_time" class="pr-6 pb-8 w-full lg:w-1/2" label="Maximum_time" />
          <text-input v-model="form.meeting_schedule" :error="form.errors.meeting_schedule" class="pr-6 pb-8 w-full lg:w-1/2" label="Meeting_schedule" />
          <text-input v-model="form.team_id" :error="form.errors.team_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Team_id" />
      
          
    
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <button v-if="!followup.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete followup</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Followup</loading-button>
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
    followup: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        id: this.followup.id,
        title: this.followup.title,
        description: this.followup.description,
        priority: this.followup.priority,
        status: this.followup.status,
        agreement: this.followup.agreement,
        maximum_time: this.followup.maximum_time,
        meeting_schedule: this.followup.meeting_schedule,
        customer_name: this.followup.customer_name,
        email: this.followup.email,
        phone: this.followup.phone,
        team_id: this.followup.team_id,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(this.route('followups.update', this.followup.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this followup?')) {
        this.$inertia.delete(this.route('followups.destroy', this.followup.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this followup?')) {
        this.$inertia.put(this.route('followups.restore', this.followup.id))
      }
    },
  },
}
</script>