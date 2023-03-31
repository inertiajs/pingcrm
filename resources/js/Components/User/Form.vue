<template>
  <v-form ref="form">
    <v-row align="start">
      <v-col cols="12" lg="6">
        <v-text-field
          v-model="form.first_name"
          :error-messages="errors.first_name"
          label="Nombre"
          outlined
          dense
        />
      </v-col>
      <v-col cols="12" lg="6">
        <v-text-field
          v-model="form.last_name"
          :error-messages="errors.last_name"
          label="Apellido"
          outlined
          dense
        />
      </v-col>
      <v-col cols="12" lg="6">
        <v-text-field
          v-model="form.email"
          :error-messages="errors.email"
          label="Email"
          outlined
          dense
        />
      </v-col>
      <v-col cols="12" lg="6">
        <v-text-field
          v-model="form.phone"
          :error-messages="errors.phone"
          label="Telefono"
          outlined
          dense
        />
      </v-col>
      <v-col cols="12" lg="6">
        <v-text-field
          v-model="form.password"
          :error-messages="errors.password"
          type="password"
          label="Contraseña"
          outlined
          dense
        />
      </v-col>
      <v-col cols="12" lg="6">
        <v-select
          v-model="form.owner"
          :items="owner"
          :error="errors.owner"
          label="Administrador"
          outlined
          dense
        />
      </v-col>
      <v-col cols="12" lg="6" class="d-flex flex-row align-self-auto">
        <v-file-input
          v-model="form.photo"
          :error="errors.photo"
          prepend-icon="mdi-camera"
          accept="image/*"
          label="Photo"
          outlined
          dense
        />
      </v-col>
    </v-row>
  </v-form>
</template>

<script>
export default {
  name: "UserForm",

  props: { form: { type: Object, required: true }, errors: Object },

  data: () => ({
    owner: [
      { value: true, text: "Si" },
      { value: false, text: "No" },
    ],
  }),
};
</script>
