<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('restaurants')">Restaurants</inertia-link>
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
          <text-input v-model="form.custmer_name" :error="form.errors.custmer_name" class="pr-6 pb-8 w-full lg:w-1/2" label="Custmer_name" />
          <text-input v-model="form.phone" :error="form.errors.phone" class="pr-6 pb-8 w-full lg:w-1/2" label="Phone" />
          <text-input v-model="form.custmer_order" :error="form.errors.custmer_order" class="pr-6 pb-8 w-full lg:w-1/2" label="Custmer_order" />
          <text-input v-model="form.Custmer_address" :error="form.errors.Custmer_address" class="pr-6 pb-8 w-full lg:w-1/2" label="Custmer_address" />
          <text-input v-model="form.restaurant_name" :error="form.errors.restaurant_name" class="pr-6 pb-8 w-full lg:w-1/2" label="restaurant_name" />
          <text-input v-model="form.bill_no" :error="form.errors.bill_no" class="pr-6 pb-8 w-full lg:w-1/2" label="Bill_no" />
          <text-input v-model="form.feedback" :error="form.errors.feedback" class="pr-6 pb-8 w-full lg:w-1/2" label="Feedback" />
          
          <select-input v-model="form.payment_method" :error="form.errors.payment_method" class="pr-6 pb-8 w-full lg:w-1/2" label="Payment_method">
            <option :value="null" />
            <option value="10">Gpay</option>
            <option value="20">Paytm</option>
            <option value="30">Cash</option>
            <option value="40">Bank_Transfer</option>
          </select-input>
          
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <button v-if="!education.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete restaurant</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Restaurant</loading-button>
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
    restaurant: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        id: this.restaurant.id,
        title: this.restaurant.title,
        description: this.restaurant.description,
        custmer_name: this.restaurant.custmer_name,
        phone: this.restaurant.phone,
        custmer_order: this.restaurant.custmer_order,
        custmer_address: this.restaurant.custmer_address,
        restaurant_name: this.restaurant.restaurant_name,
        bill_no: this.restaurant.bill_no,
        feedback: this.restaurant.feedback,
        payment_method: this.restaurant.payment_method,
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
