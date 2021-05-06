<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('restaurants')">Restaurants</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="store">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
        
          <text-input v-model="form.id" :error="form.errors.id" class="pr-6 pb-8 w-full lg:w-1/2" label="Id" />
          <text-input v-model="form.title" :error="form.errors.title" class="pr-6 pb-8 w-full lg:w-1/2" label="Title" />
          <text-input v-model="form.description" :error="form.errors.description" class="pr-6 pb-8 w-full lg:w-1/2" label="Description" />
          <text-input v-model="form.custmer_name" :error="form.errors.custmer_name" class="pr-6 pb-8 w-full lg:w-1/2" label="Custmer Name" />
          <text-input v-model="form.phone" :error="form.errors.phone" class="pr-6 pb-8 w-full lg:w-1/2" label="Phone" />
          <text-input v-model="form.custmer_order" :error="form.errors.custmer_order" class="pr-6 pb-8 w-full lg:w-1/2" label="Custmer order" />
          <text-input v-model="form.custmer_address" :error="form.errors.custmer_address" class="pr-6 pb-8 w-full lg:w-1/2" label="Custmer Address" />
          <text-input v-model="form.restaurant_name" :error="form.errors.restaurant_name" class="pr-6 pb-8 w-full lg:w-1/2" label="Restuarant Name" />
          <text-input v-model="form.bill_no" :error="form.errors.bill_no" class="pr-6 pb-8 w-full lg:w-1/2" label="Bill No." />
          <text-input v-model="form.feedback" :error="form.errors.feedback" class="pr-6 pb-8 w-full lg:w-1/2" label="Feedback" />
          
          <select-input v-model="form.payment_method" :error="form.errors.payment_method" class="pr-6 pb-8 w-full lg:w-1/2" label="Payment Method">
            <option :value="null" />
            <option value="10">Gpay</option>
            <option value="20">Paytm</option>
            <option value="30">Cash</option>
            <option value="40">Bank_Transfer</option>
          </select-input>

        
        
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex justify-end items-center">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Restaurant</loading-button>
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
  metaInfo: { title: 'Create Restaurant' },
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
    
        title: null,
        description: null,
        custmer_name: null,
        phone: null,
        custmer_order: null,
        custmer_address:  null,   
        restaurant_name: null,
        
        bill_no: null,
        feedback: null,
        payment_method: null,
      
      }),
    }
  },
  methods: {
    store() {
      this.form.post(this.route('restaurants.store'))
    },
  },
}
</script>
