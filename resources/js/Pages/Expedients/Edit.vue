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
          is-edit
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
        Actualizar
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
    expedient: Object,
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
        name: this.expedient.name,
        active: this.expedient.active,
        template: this.expedient.template,
        owner_user: this.expedient.owner_user,
        requirements: this.expedient.requirements,
        users_followers: this.expedient.users_followers
          ? this.expedient.users_followers
          : [],
      },
      breadcrumbs: [
        {
          text: 'Expedientes',
          disabled: false,
          href: this.route('expedients'),
          exact: true,
        },

        { text: 'Editar', disabled: true },
        { text: this.expedient.name, disabled: true },
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
      this.$inertia.put(
        this.route('expedients.update', this.expedient.id),
        payload,
        {
          onStart: () => (this.sending = true),
          onFinish: () => (this.sending = false),
        }
      )
    },
  },
}
</script>

<style></style>
