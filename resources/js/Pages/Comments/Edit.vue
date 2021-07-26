<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('comments')">Comments</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="comment.deleted_at" class="mb-6" @restore="restore">
      This comment has been deleted.
    </trashed-message>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="update">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.id" :error="form.errors.id" class="pr-6 pb-8 w-full lg:w-1/2" label="Id" />
          <text-input v-model="form.description" :error="form.errors.description" class="pr-6 pb-8 w-full lg:w-1/2" label="Description" />
          <text-input v-model="form.User_id" :error="form.errors.user_id" class="pr-6 pb-8 w-full lg:w-1/2" label="User_id" />
          <text-input v-model="form.task_id" :error="form.errors.task_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Task_id" />
          <text-input v-model="form.assigned_user_id" :error="form.errors.assigned_user_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Assigned_user_id" />
          <text-input v-model="form.type" :error="form.errors.type" class="pr-6 pb-8 w-full lg:w-1/2" label="Type" />
          
    
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <button v-if="!comment.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete comment</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Comment</loading-button>
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
    comment: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        id: this.comment.id,
        description: this.comment.description,
        user_id: this.comment.user_id,
        assigned_user_id: this.comment.assigned_user_id,
        task_id: this.comment.task_id,
        type: this.comment.type,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(this.route('comments.update', this.comment.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this comment?')) {
        this.$inertia.delete(this.route('comments.destroy', this.comment.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this comment?')) {
        this.$inertia.put(this.route('comments.restore', this.comment.id))
      }
    },
  },
}
</script>