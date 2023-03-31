<template>
  <v-card flat>
    <v-breadcrumbs :items="breadcrumbs" class="overline">
      <template v-slot:divider>
        <v-icon>mdi-chevron-right</v-icon>
      </template>
    </v-breadcrumbs>
    <trashed-message v-if="item.deleted_at" class="mb-6" @restore="restore">
      Este Registro a sido Eliminado.
    </trashed-message>

    <form @submit.prevent="submit">
      <v-card-text>
        <v-row>
          <v-col cols="12">
            <v-select
              v-model="form.category_id"
              :error-messages="errors.category_id"
              :items="categories"
              label="Categoria"
              class="overline"
              outlined
              dense
            />
          </v-col>
          <v-col cols="12">
            <v-text-field
              v-model="form.no_serie"
              :error-messages="errors.no_serie"
              label="No. Serie"
              class="overline"
              outlined
              dense
            />
          </v-col>
          <v-col cols="12">
            <v-text-field
              v-model="form.model"
              :error-messages="errors.model"
              label="Modelo"
              class="overline"
              outlined
              dense
            />
          </v-col>
          <v-col cols="12">
            <v-textarea
              v-model="form.description"
              :error-messages="errors.description"
              label="Descripcion"
              class="overline"
              outlined
              dense
            />
          </v-col>
          <v-col cols="12">
            <v-text-field
              v-model.number="form.price"
              :error-messages="errors.price"
              label="Valor de la Maquinaria"
              class="overline"
              type="number"
              prefix="$"
              outlined
              dense
            />
          </v-col>
          <v-col cols="12">
            <v-text-field
              v-model="form.acquisition_date"
              :error-messages="errors.acquisition_date"
              label="Fecha de la Adquisicion"
              class="overline"
              type="date"
              outlined
              dense
            />
          </v-col>
          <v-col cols="12">
            <v-file-input
              v-model="form.images"
              :error="errors.images"
              label="Fotos del Equipo"
              prepend-icon="mdi-camera"
              accept="image/*"
              truncate-length="30"
              small-chips
              multiple
              show-size
              counter
              outlined
              dense
            />
          </v-col>
        </v-row>
      </v-card-text>
      <v-card-actions>
        <v-btn v-if="!item.deleted_at" color="error" @click="destroy">
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
  metaInfo: { title: "Registrar Maquinaria" },
  layout: Layout,
  components: {
    TrashedMessage,
  },
  props: {
    errors: Object,
    item: Object,
    categories: Array,
  },
  remember: "form",
  data() {
    return {
      sending: false,
      form: {
        category_id: this.item.category_id,
        no_serie: this.item.no_serie,
        model: this.item.model,
        description: this.item.description,
        price: this.item.price,
        sale_price: this.item.sale_price,
        acquisition_date: this.item.acquisition_date,
        images: [],
      },
      breadcrumbs: [
        {
          text: "Maquinaria",
          disabled: false,
          href: this.route("machineries"),
          exact: true,
        },
        { text: "Editar", disabled: true },
      ],
    };
  },
  methods: {
    submit() {
      this.$inertia.put(
        this.route("machineries.update", this.item.id),
        this.form,
        {
          onStart: () => (this.sending = true),
          onFinish: () => (this.sending = false),
        }
      );
    },
    destroy() {
      if (confirm("Desea Eliminar la Maquinaria?")) {
        this.$inertia.delete(this.route("machineries.destroy", this.item.id));
      }
    },
    restore() {
      if (confirm("Desea Restaurar la Maquinaria?")) {
        this.$inertia.put(this.route("machineries.restore", this.item.id));
      }
    },
  },
};
</script>

<style></style>
