<template>
  <div class="p-6 bg-indigo-darker min-h-screen flex justify-center items-center">
    <div class="w-full max-w-sm">
      <logo class="block mx-auto w-full max-w-xs fill-white" height="50" />
      <form class="mt-8 bg-white rounded-lg shadow-lg overflow-hidden" @submit.prevent="submit">
        <div class="px-10 py-12">
          <h1 class="text-center font-bold text-3xl">Welcome Back!</h1>
          <div class="mx-auto mt-6 w-24 border-b-2" />
          <text-input v-model="form.email" class="mt-10" label="Email" :error="errors.email ? errors.email[0] : null" type="email" autofocus autocapitalize="off" />
          <text-input v-model="form.password" class="mt-6" label="Password" type="password" />
          <label class="mt-6 select-none flex items-center" for="remember">
            <input id="remember" v-model="form.remember" class="mr-1" type="checkbox">
            <span class="text-sm">Remember Me</span>
          </label>
        </div>
        <div class="px-10 py-4 bg-grey-lightest border-t border-grey-lighter flex justify-between items-center">
          <a class="hover:underline" tabindex="-1" href="#reset-password">Forget password?</a>
          <loading-button :loading="sending" class="btn-indigo" type="submit">Login</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Inertia } from 'inertia-vue'
import LoadingButton from '@/Shared/LoadingButton'
import Logo from '@/Shared/Logo'
import TextInput from '@/Shared/TextInput'

export default {
  components: {
    LoadingButton,
    Logo,
    TextInput,
  },
  props: {
    errors: Object,
  },
  inject: ['page'],
  data() {
    return {
      sending: false,
      form: {
        email: null,
        password: null,
        remember: null,
      },
    }
  },
  mounted() {
    document.title = `Login | ${this.page.props.app.name}`
  },
  methods: {
    submit() {
      this.sending = true
      Inertia.post(this.route('login.attempt'), {
        email: this.form.email,
        password: this.form.password,
        remember: this.form.remember,
      }).then(() => this.sending = false)
    },
  },
}
</script>
