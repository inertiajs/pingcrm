<template>
  <v-card flat>
    <v-breadcrumbs :items="breadcrumbs" class="overline">
      <template v-slot:divider>
        <v-icon>mdi-chevron-right</v-icon>
      </template>
    </v-breadcrumbs>
    <trashed-message
      v-if="requirement.deleted_at"
      class="mb-6"
      @restore="restore"
    >
      Este Requisito a sido Eliminado.
    </trashed-message>

    <form @submit.prevent="submit">
      <v-card-text>
        <v-row no-gutters>
          <v-col cols="12" md="6" class="pa-1">
            <v-text-field
              v-model="form.name"
              :error-messages="errors.name"
              class="title text-uppercase"
              label="Nombre"
              outlined
            />
          </v-col>
          <v-col cols="12" md="6" class="pa-1">
            <v-textarea
              v-model="form.description"
              :error-messages="errors.description"
              class="title text-uppercase"
              label="Descripcion"
              outlined
            />
          </v-col>
        </v-row>
      </v-card-text>
      <v-card-actions>
        <v-btn v-if="!requirement.deleted_at" color="error" @click="destroy">
          Eliminar
        </v-btn>
        <v-spacer />
        <v-btn type="submit" :loading="sending" color="primary">Guardar</v-btn>
      </v-card-actions>
    </form>
  </v-card>
</template>

<script>
import Layout from "@/Shared/Layout";
import TrashedMessage from "@/Shared/TrashedMessage";

export default {
  metaInfo() {
    return { title: this.form.name };
  },
  layout: Layout,
  components: {
    TrashedMessage,
  },
  props: {
    errors: Object,
    requirement: Object,
  },
  remember: "form",
  data() {
    return {
      sending: false,
      form: {
        name: this.requirement.name,
        description: this.requirement.description,
      },
      breadcrumbs: [
        {
          text: "Requisitos",
          disabled: false,
          href: this.route("requirements"),
          exact: true,
        },
        { text: "Editar", disabled: true },
      ],
    };
  },
  methods: {
    submit() {
      this.$inertia.put(
        this.route("requirements.update", this.requirement.id),
        this.form,
        {
          onStart: () => (this.sending = true),
          onFinish: () => (this.sending = false),
        }
      );
    },
    destroy() {
      if (confirm("Are you sure you want to delete this requirement?")) {
        this.$inertia.delete(
          this.route("requirements.destroy", this.requirement.id)
        );
      }
    },
    restore() {
      if (confirm("Are you sure you want to restore this requirement?")) {
        this.$inertia.put(
          this.route("requirements.restore", this.requirement.id)
        );
      }
    },
  },
};
</script>

<style></style>
