<template>
  <v-row align="center" justify="center" class="ma-0">
    <v-col cols="12" sm="8" md="4" lg="4" xl="3">
      <v-card outlined>
        <v-card-title> Login </v-card-title>

        <v-container>
          <form @submit.prevent="submit">
            <v-card-text>
              <v-text-field
                v-model="form.email"
                :error="errors.email"
                class="mt-10"
                label="Email"
                type="email"
                autofocus
                autocapitalize="off"
              />
              <v-text-field
                v-model="form.password"
                class="mt-6"
                label="Password"
                type="password"
              />
            </v-card-text>
            <v-card-actions>
              <v-checkbox
                id="remember"
                v-model="form.remember"
                label="Recuerdame"
                class="mr-1"
                type="checkbox"
              />
              <v-spacer />
              <v-btn
                dark
                depressed
                :loading="loading"
                color="primary"
                type="submit"
              >
                Login
              </v-btn>
            </v-card-actions>
          </form>
        </v-container>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import Layout from '@/Shared/Basic'

export default {
  metaInfo: { title: 'Login' },
  components: {},
  props: { errors: Object },
  layout: (h, page) => h(Layout, [page]),
  data() {
    return {
      sending: false,
      tab: null,
      form: {
        email: 'johndoe@example.com',
        password: 'secret',
        remember: null,
      },
    }
  },
  methods: {
    submit() {
      const data = {
        email: this.form.email,
        password: this.form.password,
        remember: this.form.remember,
      }
      this.$inertia.post(this.route('login.attempt'), data, {
        onStart: () => (this.sending = true),
        onFinish: () => (this.sending = false),
      })
    },
  },
}
</script>
