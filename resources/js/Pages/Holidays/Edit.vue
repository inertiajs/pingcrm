<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('holidays')">Holidays</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="holiday.deleted_at" class="mb-6" @restore="restore">
      This holiday has been deleted.
    </trashed-message>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="update">
        
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
           
          <text-input v-model="form.month" :error="form.errors.phone" class="pr-6 pb-8 w-full lg:w-1/2" label="Month" />
          <select-input v-model="form.week" :error="form.errors.priority" class="pr-6 pb-8 w-full lg:w-1/2" label="Weak">
            <option :value="null" />
            <option value="first_weak">First Weak</option>
            <option value="second_weak">Second Weak</option>
            <option value="third_weak">Third Weak</option>
            <option value="fourth_weak">Fourth Weak</option>
          </select-input>
            <text-input v-model="form.day" :error="form.errors.status" class="pr-6 pb-8 w-full lg:w-1/2" label="Day"></text-input>
            <text-input v-model="form.date" :error="form.errors.status" class="pr-6 pb-8 w-full lg:w-1/2" label="Date"></text-input>
        
        </div>
        
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <button v-if="!holiday.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Holiday</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Holiday</loading-button>
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
    holiday: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        month:this.holiday.month,
        weak: this.holiday.weak,
        day: this.holiday.day,
        date: this.holiday.date,
      }),
    }
  },
  methods: {
     update() {
      this.form.put(this.route('holidays.update', this.holiday.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this holiday?')) {
        this.$inertia.delete(this.route('holidays.destroy', this.holiday.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this holiday?')) {
        this.$inertia.put(this.route('holidays.restore', this.holiday.id))
      }
    },
  },
}
</script>
