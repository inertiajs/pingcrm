<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('holidays')">Holidays</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="store">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
         
          <text-input v-model="form.month" :error="form.errors.phone" class="pr-6 pb-8 w-full lg:w-1/2" label="Month" />
          <select-input v-model="form.week" :error="form.errors.priority" class="pr-6 pb-8 w-full lg:w-1/2" label="Week">
            <option :value="null" />
            <option value="first_week">First Week</option>
            <option value="second_week">Second Week</option>
            <option value="third_week">Third Week</option>
            <option value="fourth_week">Fourth Week</option>
          </select-input>
            <text-input v-model="form.day" :error="form.errors.status" class="pr-6 pb-8 w-full lg:w-1/2" label="Day"></text-input>
            <text-input v-model="form.date" :error="form.errors.status" class="pr-6 pb-8 w-full lg:w-1/2" label="Date"></text-input>
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Holiday</loading-button>
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
  metaInfo: { title: 'Create Holiday' },
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
        phone: null,
        status: null,
        priority: null,
      }),
    }
  },
  methods: {
    store() {
      this.form.post(this.route('holidays.store'))
    },
  },
}
</script>
