<template>
  <v-container fluid fill-height class="loginOverlay">
    <v-layout flex align-center justify-center>
      <v-flex xs12 sm4 elevation-6>
        <v-toolbar class="red darken-2 overline text-center">
          <v-toolbar-title class="white--text text-center">
            <h4>RENTA ETBSA</h4>
          </v-toolbar-title>
        </v-toolbar>
        <v-card>
          <v-card-text class="pt-4">
            <div>
              <v-form ref="form" @submit.prevent="submit">
                <v-text-field
                  v-model="form.email"
                  label="Correo Electronico"
                  :error-messages="errors.email"
                  required
                  outlined
                />
                <v-text-field
                  v-model="form.password"
                  :error-messages="errors.password"
                  label="Contraseña"
                  min="8"
                  :append-icon="e1 ? 'mdi-eye' : 'mdi-eye-off'"
                  :type="e1 ? 'password' : 'text'"
                  :rules="passwordRules"
                  counter
                  required
                  outlined
                  @click:append="() => (e1 = !e1)"
                />
                <v-checkbox
                  id="remember"
                  v-model="form.remember"
                  label="Recuerdame"
                  type="checkbox"
                />
                <v-layout justify-space-between>
                  <v-btn
                    dark
                    depressed
                    block
                    :loading="sending"
                    color="primary"
                    type="submit"
                  >
                    Login
                  </v-btn>
                </v-layout>
              </v-form>
            </div>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import Layout from "@/Shared/Basic";

export default {
  metaInfo: { title: "Login" },
  components: {},
  props: { errors: Object },
  layout: (h, page) => h(Layout, [page]),
  data() {
    return {
      e1: true,
      sending: false,
      tab: null,
      form: {
        email: null,
        password: null,
        remember: null,
      },
    };
  },
  methods: {
    submit() {
      const data = {
        email: this.form.email,
        password: this.form.password,
        remember: this.form.remember,
      };
      this.$inertia.post(this.route("login.attempt"), data, {
        onStart: () => (this.sending = true),
        onFinish: () => (this.sending = false),
      });
    },
  },
};
</script>
<style>
#login {
  background-image: url("https://images.unsplash.com/photo-1497733942558-e74c87ef89db?dpr=1&auto=compress,format&fit=crop&w=1650&h=&q=80&cs=tinysrgb&crop=");
  background-size: cover;
  overflow: hidden;
}

.loginOverlay {
  background: rgba(33, 150, 243, 0.3);
}

.photoCredit {
  position: absolute;
  bottom: 15px;
  right: 15px;
}
</style>
