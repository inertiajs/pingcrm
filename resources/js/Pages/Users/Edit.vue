<script setup>
import { Head, Link, useForm, router } from '@inertiajs/vue3'
import Layout from '@/Shared/Layout.vue'
import TextInput from '@/Shared/TextInput.vue'
import FileInput from '@/Shared/FileInput.vue'
import SelectInput from '@/Shared/SelectInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'
import TrashedMessage from '@/Shared/TrashedMessage.vue'

const props = defineProps({
  user: Object,
})

const form = useForm({
  _method: 'put',
  first_name: props.user.first_name,
  last_name: props.user.last_name,
  email: props.user.email,
  password: '',
  owner: props.user.owner,
  photo: null,
})

const update = () => {
  form.post(`/users/${props.user.id}`, {
    onSuccess: () => form.reset('password', 'photo'),
  })
}

const destroy = () => {
  if (confirm('Are you sure you want to delete this user?')) {
    router.delete(`/users/${props.user.id}`)
  }
}

const restore = () => {
  if (confirm('Are you sure you want to restore this user?')) {
    router.put(`/users/${props.user.id}/restore`)
  }
}
</script>
<template>
  <Layout>
    <Head :title="`${form.first_name} ${form.last_name}`" />
    <div class="flex justify-start mb-8 max-w-3xl">
      <h1 class="text-3xl font-bold">
        <Link class="text-indigo-400 hover:text-indigo-600" href="/users">Users</Link>
        <span class="text-indigo-400 font-medium">/</span>
        {{ form.first_name }} {{ form.last_name }}
      </h1>
      <img v-if="user.photo" class="block ml-4 w-8 h-8 rounded-full" :src="user.photo" />
    </div>
    <TrashedMessage v-if="user.deleted_at" class="mb-6" @restore="restore"> This user has been deleted. </TrashedMessage>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <TextInput v-model="form.first_name" :error="form.errors.first_name" class="pb-8 pr-6 w-full lg:w-1/2" label="First name" />
          <TextInput v-model="form.last_name" :error="form.errors.last_name" class="pb-8 pr-6 w-full lg:w-1/2" label="Last name" />
          <TextInput v-model="form.email" :error="form.errors.email" class="pb-8 pr-6 w-full lg:w-1/2" label="Email" />
          <TextInput v-model="form.password" :error="form.errors.password" class="pb-8 pr-6 w-full lg:w-1/2" type="password" autocomplete="new-password" label="Password" />
          <SelectInput v-model="form.owner" :error="form.errors.owner" class="pb-8 pr-6 w-full lg:w-1/2" label="Owner">
            <option :value="true">Yes</option>
            <option :value="false">No</option>
          </SelectInput>
          <FileInput v-model="form.photo" :error="form.errors.photo" class="pb-8 pr-6 w-full lg:w-1/2" type="file" accept="image/*" label="Photo" />
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!user.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete User</button>
          <LoadingButton :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update User</LoadingButton>
        </div>
      </form>
    </div>
  </Layout>
</template>
