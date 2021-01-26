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
            <v-text-field
              v-model="form.name"
              :error-messages="errors.name"
              class="title text-uppercase"
              label="Nombre"
              outlined
            />
          </v-col>
          <!-- <v-col cols="12" lg="6">
            <v-textarea
              v-model="form.description"
              :error-messages="errors.description"
              class="pr-6 pb-8 title text-uppercase"
              label="Descripcion"
              outlined
            />
          </v-col> -->
        </v-row>
        <v-row>
          <v-col cols="12">
            <v-toolbar color="blue lighten-2 text-uppercase" dark dense>
              <v-toolbar-title>CheckList Requisitos</v-toolbar-title>
              <v-spacer />
              <!-- <v-text-field
                rounded
                append-icon="mdi-magnify"
                dense
                single-line
                outlined
                solo-inverted
                hide-details
              /> -->
              <v-btn icon @click.native="showAddRequirementDialog">
                <v-icon large color="success darken-2">
                  mdi-plus-box-multiple-outline
                </v-icon>
              </v-btn>
            </v-toolbar>
            <v-list dense class=" title text-uppercase">
              <template v-for="(item, index) in items">
                <v-list-item :key="item.title" class="green lighten-5">
                  <template v-slot:default>
                    <v-list-item-content>
                      <v-list-item-title v-text="item.name" />
                    </v-list-item-content>

                    <v-list-item-action>
                      <v-btn icon @click="deleteItemConfirm(index)">
                        <v-icon color="red darken-1">
                          mdi-trash-can
                        </v-icon>
                      </v-btn>
                    </v-list-item-action>
                  </template>
                </v-list-item>

                <v-divider v-if="index < items.length - 1" :key="index" />
              </template>
            </v-list>
          </v-col>
        </v-row>
      </v-card-text>
      <v-card-actions>
        <v-btn type="submit" block :loading="sending">Guardar</v-btn>
      </v-card-actions>
    </form>

    <dialog-modal :show="addRequirementDialog" @close="closeModal">
      <template #title>
        Requisitos
      </template>

      <template #content>
        <v-row justify="center" align="center" class="ma-auto">
          <v-autocomplete
            v-model="values"
            :items="requirements"
            item-text="name"
            item-value="id"
            clearable
            filled
            rounded
            solo
            hide-details
            return-object
          />
        </v-row>
      </template>

      <template #footer>
        <v-btn block @click="save(values)">Agregar</v-btn>
      </template>
    </dialog-modal>
  </v-card>
</template>

<script>
import Layout from '@/Shared/Layout'
import DialogModal from '@/Shared/DialogModal'

export default {
  metaInfo: { title: 'Crear Requisito' },
  layout: Layout,
  components: { DialogModal },
  props: {
    errors: Object,
    requirements: Array,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      addRequirementDialog: false,
      form: this.$inertia.form({
        name: null,
        requirements: [],
      }),
      values: [],
      items: [],
      breadcrumbs: [
        {
          text: 'Plantillas',
          disabled: false,
          href: this.route('templates'),
          exact: true,
        },
        { text: 'Crear', disabled: true },
      ],
    }
  },
  methods: {
    submit() {
      const playload = {
        ...this.form,
        requirements: this.items.map(d => d.id),
      }
      this.$inertia.post(
        this.route('templates.store'),
        playload,

        // this.form.transform(data => ({
        //   ...data,
        //   requirements: 'aqui se transformo',
        // })),
        {
          onStart: () => (this.sending = true),
          onFinish: () => (this.sending = false),
        }
      )
    },
    showAddRequirementDialog() {
      this.addRequirementDialog = true
    },
    closeModal() {
      this.addRequirementDialog = false
      this.values = []
    },
    save(item) {
      if (item.id && !this.items.some(e => e.id === item.id)) {
        this.items.push(item)
        return this.closeModal()
      }
      return !item.id
        ? alert('Seleccione algun Requisito')
        : alert('Elemento Duplicado')
    },
    deleteItemConfirm(index) {
      if (confirm('Se Eliminara de la lista')) {
        this.items.splice(index, 1)
      }
    },
  },
}
</script>

<style></style>
