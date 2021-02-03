<template>
  <v-card flat>
    <breadcrumbs :items="breadcrumbs" />
    <v-card-text>
      <v-container>
        <expedient-form
          :form.sync="form"
          :errors="errors"
          :users="users"
          :templates="templates"
        />
      </v-container>
    </v-card-text>
    <v-card-actions>
      <v-btn
        dark
        color="indigo darken-5"
        block
        :loading="sending"
        @click="submit"
      >
        Guardar
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import Layout from '@/Shared/Layout'
import Breadcrumbs from '@/Shared/Breadcrumbs'

import ExpedientForm from '@/Components/Expedient/Form'

export default {
  metaInfo: { title: 'Crear Expediente' },
  layout: Layout,
  components: { Breadcrumbs, ExpedientForm },
  props: {
    errors: Object,
    templates: {
      type: Array,
      required: true,
    },
    users: {
      type: Array,
      required: true,
    },
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        active: true,
        name: null,
        template: null,
        requirements: [],
        owner_user: null,
        users_followers: [],
      },
      breadcrumbs: [
        {
          text: 'Expedientes',
          disabled: false,
          href: this.route('expedients'),
          exact: true,
        },

        { text: 'Crear', disabled: true },
      ],
    }
  },

  methods: {
    submit() {
      const payload = {
        ...this.form,
        requirements: this.form.requirements.flatMap(item => [item.id]),
        users_followers: this.form.users_followers.flatMap(item => [item.id]),
        template: this.form.template ? this.form.template.id : null,
      }
      this.$inertia.post(this.route('expedients.store'), payload, {
        onStart: () => (this.sending = true),
        onFinish: () => (this.sending = false),
      })
    },
  },
}
</script>

<style></style>
