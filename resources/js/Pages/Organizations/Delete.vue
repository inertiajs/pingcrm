<template>
  <modal :max-width="500">
    <form @submit.prevent="submit" class="bg-white rounded shadow overflow-hidden max-w-3xl">
      <div class="px-8 pt-6 pb-5 border-b font-bold leading-none">
        Delete organization
      </div>
      <form class="p-8">
        Are you sure you want to delete <span class="font-bold">{{ organization.name }}</span>?
      </form>
      <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
        <loading-button :loading="form.sending" class="btn-red" type="submit">Delete</loading-button>
      </div>
    </form>
  </modal>
</template>

<script>
import { Inertia } from '@inertiajs/inertia'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from '@/Shared/SelectInput'
import TextInput from '@/Shared/TextInput'
import Modal from '@/Shared/Modal'

export default {
  components: {
    Modal,
    LoadingButton,
    SelectInput,
    TextInput,
  },
  props: {
    organization: Object,
  },
  data() {
    return {
      form: this.$inertia.form()
    }
  },
  created() {
    document.title = 'Delete organization - Ping CRM'
  },
  methods: {
    submit() {
      this.form.delete(`/organizations/${this.organization.id}`)
    }
  }
}
</script>
