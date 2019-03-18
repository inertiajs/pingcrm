<template>
  <div class="p-6 bg-indigo-darker min-h-screen flex justify-center items-center">
    <div class="w-full max-w-sm">
      <logo class="block mx-auto w-full max-w-xs fill-white" height="50" />
      <form class="mt-8 bg-white rounded-lg shadow-lg overflow-hidden" @submit.prevent="submit">
        <div class="px-10 py-12">
          <h1 class="text-center font-bold text-3xl">Welcome Back!</h1>
          <div class="mx-auto mt-6 w-24 border-b-2" />
          <text-input v-model="form.fields.email" class="mt-10" label="Email" :error="form.errors.first('email')" type="email" autofocus autocapitalize="off" />
          <text-input v-model="form.fields.password" class="mt-6" label="Password" :error="form.errors.first('password')" type="password" />
          <label class="mt-6 select-none flex items-center" for="remember">
            <input id="remember" v-model="form.fields.remember" class="mr-1" type="checkbox">
            <span class="text-sm">Remember Me</span>
          </label>
        </div>
        <div class="px-10 py-4 bg-grey-lightest border-t border-grey-lighter flex justify-between items-center">
          <a class="hover:underline" tabindex="-1" href="#reset-password">Forget password?</a>
          <loading-button :loading="form.sending" class="btn-indigo" type="submit">Login</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Inertia } from 'inertia-vue'
import Form from '@/Utils/Form'
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
    intendedUrl: String,
  },
  inject: ['page'],
  data() {
    return {
      form: new Form({
        email: null,
        password: null,
        remember: null,
      }),
    }
  },
  mounted() {
    document.title = `Login | ${this.page.props.app.name}`
  },
  methods: {
    submit() {
      this.form.post({
        url: this.route('login.attempt').url(),
        then: () => Inertia.visit(this.intendedUrl),
      })
    },
  },
}
</script>
