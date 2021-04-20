<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('restaurants')">restaurants</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="restaurant.deleted_at" class="mb-6" @restore="restore">
      This restaurant has been deleted.
    </trashed-message>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="update">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
         <text-input v-model="form.id" :error="form.errors.id" class="pr-6 pb-8 w-full lg:w-1/2" label="Id" />
          <text-input v-model="form.title" :error="form.errors.title" class="pr-6 pb-8 w-full lg:w-1/2" label="Title" />
          <text-input v-model="form.description" :error="form.errors.description" class="pr-6 pb-8 w-full lg:w-1/2" label="Description" />
          <text-input v-model="form.User_id" :error="form.errors.user_id" class="pr-6 pb-8 w-full lg:w-1/2" label="User_id" />
         
        
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <button v-if="!restaurant.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete restaurant</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update restaurant</loading-button>
        </div>
      </form>
    </div>
    <h2 class="mt-12 font-bold text-2xl">Contacts</h2>
    <div class="mt-6 bg-white rounded shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Id</th>
          <th class="px-6 pt-6 pb-4">Title</th>
          <th class="px-6 pt-6 pb-4">Description</th>
          <th class="px-6 pt-6 pb-4">User_id</th>
        
        </tr>
        <tr v-for="contact in restaurant.contacts" :key="contact.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('contacts.edit', contact.id)">
              {{ contact.id }}
              <icon v-if="contact.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
            </inertia-link>
          </td>

          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
              {{ contact.title }}
            </inertia-link>
          </td>
    
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
              {{ contact.description }}
            </inertia-link>
          </td>

           <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
              {{ contact.user_id }}
            </inertia-link>
          </td>





          <td class="border-t w-px">
            <inertia-link class="px-4 flex items-center" :href="route('contacts.edit', contact.id)" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </inertia-link>
          </td>
        </tr>
        <tr v-if="restaurant.contacts.length === 0">
          <td class="border-t px-6 py-4" colspan="4">No contacts found.</td>
        </tr>
      </table>
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
    restaurant: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        id: this.restaurant.id,
        title: this.restaurant.title,
        description: this.restaurant.description,
        user_id: this.restaurant.user_id,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(this.route('restaurants.update', this.restaurant.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this restaurant?')) {
        this.$inertia.delete(this.route('restaurants.destroy', this.restaurant.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this restaurant?')) {
        this.$inertia.put(this.route('restaurants.restore', this.restaurant.id))
      }
    },
  },
}
</script>
