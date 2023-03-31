<template>
  <v-card flat>
    <v-breadcrumbs :items="breadcrumbs" class="overline">
      <template v-slot:divider>
        <v-icon>mdi-chevron-right</v-icon>
      </template>
    </v-breadcrumbs>
    <v-card-text>
      <v-container class="grey lighten-5 elevation-2" fluid>
        <user-form :form.sync="form" :errors="errors" />
      </v-container>
    </v-card-text>
    <v-card-actions>
      <v-btn
        :loading="sending"
        :errors="errors"
        color="indigo darken-5"
        dark
        block
        @click="submit"
      >
        Guardar
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import Layout from "@/Shared/Layout";
import UserForm from "@/Components/User/Form";

export default {
  name: "UserCreate",
  metaInfo: {
    title: "Create User",
  },
  layout: Layout,
  components: {
    UserForm,
  },
  props: {
    errors: Object,
  },
  remember: "form",
  data() {
    return {
      sending: false,
      form: {
        first_name: null,
        last_name: null,
        email: null,
        password: null,
        phone: null,
        owner: false,
        photo: null,
      },
      breadcrumbs: [
        {
          text: "Usuarios",
          disabled: false,
          href: this.route("users"),
        },
        { text: "Crear", disabled: true },
      ],
    };
  },
  methods: {
    submit() {
      const data = new FormData();
      data.append("first_name", this.form.first_name || "");
      data.append("last_name", this.form.last_name || "");
      data.append("email", this.form.email || "");
      data.append("password", this.form.password || "");
      data.append("phone", this.form.phone || "");
      data.append("owner", this.form.owner ? "1" : "0");
      data.append("photo", this.form.photo || "");

      this.$inertia.post(this.route("users.store"), data, {
        onStart: () => (this.sending = true),
        onFinish: () => (this.sending = false),
      });
    },
    restore() {
      return null;
    },
  },
};
</script>
