<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('leaves')">Leave</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="leave.deleted_at" class="mb-6" @restore="restore">
      This leave has been deleted.
    </trashed-message>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="update">
        
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
        
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <button v-if="!leave.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Leave</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Leave</loading-button>
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
    leave: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name:this.leave.name,
        contact_no: this.leave.contact_no,
        day: this.leave.day,
        date: this.leave.date,
        reason_of_leave: this.leave.reason_of_leave,
      }),
    }
  },
  methods: {
     update() {
      this.form.put(this.route('leaves.update', this.leave.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this leave?')) {
        this.$inertia.delete(this.route('leaves.destroy', this.leave.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this leave?')) {
        this.$inertia.put(this.route('leaves.restore', this.leave.id))
      }
    },
  },
}
</script>
