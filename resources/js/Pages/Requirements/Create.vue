<template>
  <v-card flat>
    <v-breadcrumbs :items="breadcrumbs" class="overline">
      <template v-slot:divider>
        <v-icon>mdi-chevron-right</v-icon>
      </template>
    </v-breadcrumbs>

    <form @submit.prevent="submit">
      <v-card-text>
        <v-row>
          <v-col cols="12" lg="6">
            <v-text-field
              v-model="form.name"
              :error-messages="errors.name"
              class="pr-6 pb-8 title text-uppercase"
              label="Nombre"
              outlined
            />
          </v-col>
          <v-col cols="12" lg="6">
            <v-textarea
              v-model="form.description"
              :error-messages="errors.description"
              class="pr-6 pb-8 title text-uppercase"
              label="Descripcion"
              outlined
            />
          </v-col>
        </v-row>
      </v-card-text>
      <v-card-actions>
        <v-btn type="submit" block :loading="sending">Guardar</v-btn>
      </v-card-actions>
    </form>
  </v-card>
</template>

<script>
import Layout from '@/Shared/Layout'

export default {
  metaInfo: { title: 'Crear Requisito' },
  layout: Layout,
  components: {},
  props: {
    errors: Object,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        name: null,
        description: null,
      },
      breadcrumbs: [
        {
          text: 'Requisitos',
          disabled: false,
          href: this.route('requirements'),
        },
        { text: 'Crear', disabled: true },
      ],
    }
  },
  methods: {
    submit() {
      this.$inertia.post(this.route('requirements.store'), this.form, {
        onStart: () => (this.sending = true),
        onFinish: () => (this.sending = false),
      })
    },
  },
}
</script>

<style></style>
