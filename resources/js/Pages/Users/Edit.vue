<template>
  <v-card flat>
    <v-breadcrumbs :items="breadcrumbs" class="overline">
      <template v-slot:divider>
        <v-icon>mdi-chevron-right</v-icon>
      </template>
    </v-breadcrumbs>
    <trashed-message v-if="user.deleted_at" class="mb-6" @restore="restore">
      Este Usuario a sido Eliminada.
    </trashed-message>

    <v-card-text>
      <v-row>
        <v-col cols="12">
          <user-form :form.sync="form" :errors="errors" class="overline">
            <template #preview>
              <v-avatar
                v-if="user.photo"
                color="grey darken-1 shrink"
                rounded
                size="64"
              >
                <img :src="user.photo" :alt="user.name">
              </v-avatar>
            </template>
          </user-form>
        </v-col>
      </v-row>
    </v-card-text>
    <v-card-actions>
      <v-btn v-if="!user.deleted_at" color="error" @click="destroy">
        Eliminar
      </v-btn>
      <v-spacer />

      <v-btn
        :loading="sending"
        :errors="errors"
        color="primary"
        @click="submit"
      >
        Actualizar
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import Layout from '@/Shared/Layout'
import UserForm from '@/Components/User/Form'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  metaInfo() {
    return {
      title: `${this.form.first_name} ${this.form.last_name}`,
    }
  },
  layout: Layout,
  components: {
    UserForm,
    TrashedMessage,
  },
  props: {
    errors: Object,
    user: Object,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        ...this.user,
        photo: null,
        // first_name: this.user.first_name,
        // last_name: this.user.last_name,
        // email: this.user.email,
        // phone: this.user.phone,
        // password: this.user.password,
        // owner: this.user.owner,
      },
      breadcrumbs: [
        {
          text: 'Usuarios',
          disabled: false,
          href: this.route('users'),
          exact: true,
        },
        { text: 'Editar', disabled: true },
      ],
    }
  },
  methods: {
    submit() {
      var data = new FormData()
      data.append('first_name', this.form.first_name || '')
      data.append('last_name', this.form.last_name || '')
      data.append('email', this.form.email || '')
      data.append('phone', this.form.phone || '')
      data.append('password', this.form.password || '')
      data.append('owner', this.form.owner ? '1' : '0')
      data.append('photo', this.form.photo || '')
      data.append('_method', 'put')

      this.$inertia.post(this.route('users.update', this.user.id), data, {
        onStart: () => (this.sending = true),
        onFinish: () => (this.sending = false),
        onSuccess: () => {
          if (Object.keys(this.$page.errors).length === 0) {
            this.form.photo = null
            this.form.password = null
          }
        },
      })
    },
    destroy() {
      if (confirm('Are you sure you want to delete this user?')) {
        this.$inertia.delete(this.route('users.destroy', this.user.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this user?')) {
        this.$inertia.put(this.route('users.restore', this.user.id))
      }
    },
  },
}
</script>
