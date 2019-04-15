<template>
  <layout title="Create User">
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-light hover:text-indigo-dark" :href="route('users')">Users</inertia-link>
      <span class="text-indigo-light font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded shadow overflow-hidden max-w-lg">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.fields.first_name" class="pr-6 pb-8 w-full lg:w-1/2" :error="form.errors.first('first_name')" label="First name" />
          <text-input v-model="form.fields.last_name" class="pr-6 pb-8 w-full lg:w-1/2" :error="form.errors.first('last_name')" label="Last name" />
          <text-input v-model="form.fields.email" class="pr-6 pb-8 w-full lg:w-1/2" :error="form.errors.first('email')" label="Email" />
          <text-input v-model="form.fields.password" class="pr-6 pb-8 w-full lg:w-1/2" :error="form.errors.first('password')" type="password" autocomplete="new-password" label="Password" />
          <select-input v-model="form.fields.owner" class="pr-6 pb-8 w-full lg:w-1/2" :error="form.errors.first('owner')" label="Owner">
            <option :value="true">Yes</option>
            <option :value="false">No</option>
          </select-input>
        </div>
        <div class="px-8 py-4 bg-grey-lightest border-t border-grey-lighter flex justify-end items-center">
          <loading-button :loading="form.sending" class="btn-indigo" type="submit">Create User</loading-button>
        </div>
      </form>
    </div>
  </layout>
</template>

<script>
import { Inertia, InertiaLink } from 'inertia-vue'
import Form from '@/Utils/Form'
import Layout from '@/Shared/Layout'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from '@/Shared/SelectInput'
import TextInput from '@/Shared/TextInput'

export default {
  components: {
    InertiaLink,
    Layout,
    LoadingButton,
    SelectInput,
    TextInput,
  },
  props: {
    organizations: Array,
  },
  data() {
    return {
      form: new Form({
        first_name: null,
        last_name: null,
        email: null,
        password: null,
        owner: null,
      }),
    }
  },
  methods: {
    submit() {
      this.form.post({
        url: this.route('users.store'),
        then: data => Inertia.visit(this.route('users.edit', data.id)),
      })
    },
  },
}
</script>
