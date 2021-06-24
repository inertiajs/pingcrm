<template>
  <modal :max-width="600">
    <form @submit.prevent="submit" class="bg-white rounded shadow overflow-hidden max-w-3xl">
      <div class="px-8 pt-6 pb-5 border-b font-bold leading-none">
        Create user
      </div>
      <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
        <text-input v-model="form.first_name" :error="form.errors.first_name" class="pr-6 pb-8 w-full lg:w-1/2" label="First name" />
        <text-input v-model="form.last_name" :error="form.errors.last_name" class="pr-6 pb-8 w-full lg:w-1/2" label="Last name" />
        <text-input v-model="form.email" :error="form.errors.email" class="pr-6 pb-8 w-full lg:w-1/2" label="Email" />
        <text-input v-model="form.password" :error="form.errors.password" class="pr-6 pb-8 w-full lg:w-1/2" type="password" autocomplete="new-password" label="Password" />
        <select-input v-model="form.owner" :error="form.errors.owner" class="pr-6 pb-8 w-full lg:w-1/2" label="Owner">
          <option :value="true">Yes</option>
          <option :value="false">No</option>
        </select-input>
        <file-input v-model="form.photo" :error="form.errors.photo" class="pr-6 pb-8 w-full lg:w-1/2" type="file" accept="image/*" label="Photo" />
      </div>
      <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
        <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create User</loading-button>
      </div>
    </form>
  </modal>
</template>

<script>
import Modal from '@/Shared/Modal'
import Layout from '@/Shared/Layout'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from '@/Shared/SelectInput'
import TextInput from '@/Shared/TextInput'
import FileInput from '@/Shared/FileInput'

export default {
  metaInfo: { title: 'Create User' },
  layout: Layout,
  components: {
    Modal,
    LoadingButton,
    SelectInput,
    TextInput,
    FileInput,
  },
  data() {
    return {
      form: this.$inertia.form({
        first_name: null,
        last_name: null,
        email: null,
        password: null,
        owner: false,
        photo: null,
      }),
    }
  },
  methods: {
    submit() {
      this.form.post(this.route('users.store'))
    },
  },
}
</script>
