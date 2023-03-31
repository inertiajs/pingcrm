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
        <v-btn type="submit" block :loading="sending" color="primary">
          Guardar
        </v-btn>
      </v-card-actions>
    </form>
  </v-card>
</template>

<script>
import Layout from "@/Shared/Layout";

export default {
  metaInfo: { title: "Registrar Maquinaria" },
  layout: Layout,
  components: {},
  props: {
    categories: Array,
    errors: Object,
  },
  remember: "form",
  data() {
    return {
      sending: false,
      form: {
        category_id: null,
        no_serie: null,
        model: null,
        description: null,
        price: null,
        sale_price: null,
        acquisition_date: null,
        images: [],
      },
      breadcrumbs: [
        {
          text: "Maquinaria",
          disabled: false,
          href: this.route("machineries"),
        },
        { text: "Crear", disabled: true },
      ],
    };
  },
  methods: {
    submit() {
      this.$inertia.post(this.route("machineries.store"), this.form, {
        onStart: () => (this.sending = true),
        onFinish: () => (this.sending = false),
      });
    },
  },
};
</script>

<style></style>
