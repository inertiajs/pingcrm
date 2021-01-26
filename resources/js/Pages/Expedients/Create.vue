<template>
  <v-card flat>
    <breadcrumbs :breadcrumbs="breadcrumbs" />

    <form @submit.prevent="submit">
      <v-card-text>
        <v-row>
          <v-col cols="12" lg="12">
            <v-text-field
              v-model="form.name"
              :error-messages="errors.name"
              class="title text-uppercase"
              label="Titulo del Expediente:"
              placeholder="Escibir Nombre Cliente o Referencia para el Expediente"
              dense
              hide-details
              outlined
              prepend-inner-icon="mdi-folder-account"
            />
          </v-col>
          <v-col cols="12" lg="12">
            <div class="d-flex d-flex-row align-center">
              <v-autocomplete
                v-model="form.template"
                :items="templates"
                item-text="name"
                item-value="id"
                clearable
                filled
                rounded
                solo
                hide-details
                return-object
                dense
                placeholder="Seleccione una Plantilla"
                label="Plantilla:"
                prepend-inner-icon="mdi-clipboard-list-outline"
              >
                <template v-slot:prepend>
                  <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                      <v-btn
                        icon
                        v-on="on"
                        @click.native="showAddRequirementDialog"
                      >
                        <v-icon>
                          mdi-checkbox-multiple-marked-outline
                        </v-icon>
                      </v-btn>
                    </template>
                    Personalizar
                  </v-tooltip>
                </template>
              </v-autocomplete>
            </div>
          </v-col>
          <v-col cols="12" lg="6">
            <div class="d-flex flex-column">
              <v-autocomplete
                v-model="form.owner_user"
                :items="users"
                item-text="email"
                item-value="id"
                clearable
                filled
                rounded
                solo
                hide-details
                dense
                placeholder="Email de responsable de los requisitos *"
                label="A pertence el expediente:"
                prepend-inner-icon="mdi-account"
              >
                <template v-slot:prepend>
                  <v-tooltip bottom>
                    <template v-slot:activator="{ on }">
                      <v-btn icon v-on="on">
                        <v-icon>
                          mdi-new-box
                        </v-icon>
                      </v-btn>
                    </template>
                    Registrar Nuevo Cliente
                  </v-tooltip>
                </template>
              </v-autocomplete>
              <v-switch v-model="form.active" label="ACTIVO" class="mr-auto" />
              <v-row align="center" class="text-center text-h3">
                <v-col cols="12">
                  <div>{{ form.requirements.length }}</div>
                  <div class="overline">requisitos por revisar.</div>
                </v-col>
              </v-row>
            </div>
          </v-col>
          <v-col cols="12" lg="6">
            <v-expansion-panels>
              <v-expansion-panel class="py-0">
                <v-expansion-panel-header
                  class="indigo white--text overline"
                  disable-icon-rotate
                >
                  <span>Lista Seguidores ({{ form.users_followers.length }})
                  </span>
                  <v-spacer />
                  <template v-slot:actions>
                    <v-btn icon @click.native="showAddFollowerDialog">
                      <v-icon color="white">mdi-account-plus</v-icon>
                    </v-btn>
                  </template>
                </v-expansion-panel-header>
                <v-expansion-panel-content>
                  <v-list
                    v-if="form.users_followers.length >= 0"
                    dense
                    class="overlin"
                    two-line
                  >
                    <v-list-item
                      v-for="(item, index) in form.users_followers"
                      :key="item.id"
                    >
                      <v-list-item-avatar>
                        <v-img :src="item.photo" />
                      </v-list-item-avatar>
                      <v-list-item-content>
                        <v-list-item-title v-text="item.name" />
                        <v-list-item-subtitle v-text="item.email" />
                      </v-list-item-content>
                      <v-list-item-action>
                        <v-btn icon @click="deleteItemConfirm(index)">
                          <v-icon>mdi-trash-can</v-icon>
                        </v-btn>
                      </v-list-item-action>
                    </v-list-item>
                  </v-list>
                </v-expansion-panel-content>
              </v-expansion-panel>
            </v-expansion-panels>
          </v-col>
        </v-row>
      </v-card-text>
      <v-card-actions>
        <v-btn type="submit" block :loading="sending">Guardar</v-btn>
      </v-card-actions>
    </form>
    <dialog-modal :show="addRequirementDialog" persistent @close="closeModal">
      <template #title>
        Personalizar CheckLis de Requisitos
      </template>

      <template #content>
        <v-row>
          <v-col cols="12">
            <v-list shaped>
              <v-list-item-group v-model="form.requirements" multiple>
                <template v-for="(item, i) in form.template.requirements">
                  <v-divider v-if="!item" :key="`divider-${i}`" />

                  <v-list-item
                    v-else
                    :key="`item-${i}`"
                    :value="item"
                    active-class="deep-purple--text text--accent-4"
                  >
                    <template v-slot:default="{ active }">
                      <v-list-item-content>
                        <v-list-item-title v-text="item.name" />
                      </v-list-item-content>

                      <v-list-item-action>
                        <v-checkbox
                          :input-value="active"
                          color="deep-purple accent-4"
                        />
                      </v-list-item-action>
                    </template>
                  </v-list-item>
                </template>
              </v-list-item-group>
            </v-list>
          </v-col>
        </v-row>
      </template>
    </dialog-modal>
    <dialog-modal :show="addFollowerDialog" @close="closeModal">
      <template #title>
        Seguidores
      </template>

      <template #content>
        <v-row justify="center" align="center" class="ma-auto">
          <v-autocomplete
            v-model="value"
            :items="users"
            item-text="email"
            item-value="id"
            clearable
            filled
            rounded
            solo
            hide-details
            dense
            return-object
            placeholder="Email de responsable de los requisitos *"
            label="A pertence el expediente:"
            prepend-inner-icon="mdi-account"
          />
        </v-row>
      </template>

      <template #footer>
        <v-btn block @click="save(value)">Agregar</v-btn>
      </template>
    </dialog-modal>
  </v-card>
</template>

<script>
import Layout from '@/Shared/Layout'
import Breadcrumbs from '@/Shared/Breadcrumbs'
import throttle from 'lodash/throttle'
import DialogModal from '@/Shared/DialogModal'

export default {
  metaInfo: { title: 'Crear Expediente' },
  layout: Layout,
  components: { Breadcrumbs, DialogModal },
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
      model: [],
      value: [],
      sending: false,
      addRequirementDialog: false,
      addFollowerDialog: false,
      selected: {
        template: {},
        user: {},
      },
      form: {
        active: true,
        name: 'primer',
        template: null,
        requirements: [],
        owner_user: 2,
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
  watch: {
    ['form.template']: {
      handler: throttle(function(template) {
        this.form.requirements = template ? template.requirements : []
      }, 150),
    },
  },

  methods: {
    submit() {
      const payload = {
        ...this.form,
        requirements: this.form.requirements.flatMap(n => [n.id]),
        users_followers: this.form.users_followers.flatMap(n => [n.id]),
        template: this.form.template.id,
      }
      this.$inertia.post(this.route('expedients.store'), payload, {
        onStart: () => (this.sending = true),
        onFinish: () => (this.sending = false),
      })
    },
    showAddRequirementDialog() {
      if (this.form.requirements && this.form.requirements.length >= 1) {
        this.addRequirementDialog = true
      }
    },
    showAddFollowerDialog() {
      this.addFollowerDialog = true
    },
    closeModal() {
      this.addRequirementDialog = false
      this.addFollowerDialog = false
      this.value = []
    },
    save(item) {
      if (item.id && !this.form.users_followers.some(e => e.id === item.id)) {
        this.form.users_followers.push(item)
        return this.closeModal()
      }
      return !item.id
        ? alert('Seleccione algun Requisito')
        : alert('Elemento Duplicado')
    },
    deleteItemConfirm(index) {
      if (confirm('Se Eliminara de la lista')) {
        this.form.users_followers.splice(index, 1)
      }
    },
  },
}
</script>

<style></style>
