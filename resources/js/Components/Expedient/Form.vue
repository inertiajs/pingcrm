<template>
  <v-form ref="form">
    <v-text-field
      v-model="form.name"
      :error-messages="errors.name"
      class="title"
      label="Titulo del Expediente:"
      placeholder="Escibir una Referencia para el Expediente"
      prepend-inner-icon="mdi-folder-account"
      outlined
    />
    <v-row>
      <v-col cols="12" md="6">
        <v-autocomplete
          v-model="form.owner_user"
          :items="users"
          label="Cliente a quien Pertenece el Expediente:"
          placeholder="Email Cliente..."
          :error-messages="errors.owner_user"
          item-text="email"
          item-value="id"
          clearable
          rounded
          filled
          outlined
          dense
          :disabled="isEdit"
        >
          <!-- <template v-slot:prepend>
        <v-tooltip top>
          <template v-slot:activator="{ on }">
            <v-btn icon :href="route('users.create')" v-on="on">
              <v-icon>
                mdi-account-plus
              </v-icon>
            </v-btn>
          </template>
          Registrar Nuevo Cliente
        </v-tooltip>
      </template> -->
        </v-autocomplete>

        <v-autocomplete
          v-model="form.template"
          :items="templates"
          label="Plantilla:"
          placeholder="Seleccione una Plantilla"
          prepend-inner-icon="mdi-clipboard-list-outline"
          :error-messages="errors.template"
          item-text="name"
          item-value="id"
          return-object
          clearable
          outlined
          rounded
          filled
          dense
          :disabled="isEdit"
        >
          <template v-slot:append-outer>
            <v-tooltip top>
              <template v-slot:activator="{ on }">
                <v-btn icon v-on="on" @click.native="showAddRequirementDialog">
                  <v-icon>
                    mdi-checkbox-multiple-marked-outline
                  </v-icon>
                </v-btn>
              </template>
              Personalizar
            </v-tooltip>
          </template>
        </v-autocomplete>

        <v-switch v-model="form.active" label="ACTIVO" class="mr-auto" />
        <div class="text-center text-h3 text-center">
          <div>{{ form.requirements.length }}</div>
          <div class="overline">requisitos por revisar.</div>
        </div>
      </v-col>
      <v-col cols="12" md="6">
        <v-expansion-panels>
          <v-expansion-panel class="py-0">
            <v-expansion-panel-header
              class="indigo white--text overline py-0"
              disable-icon-rotate
            >
              <span>Lista Seguidores ({{ form.users_followers.length || 0 }})
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
        <span class="text-uppercase">Agregar Segudiores</span>
      </template>

      <template #content>
        <v-row justify="center" align="center" class="ma-auto">
          <v-autocomplete
            v-model="value"
            :items="users"
            placeholder="Buscar por Email de usuario *"
            prepend-inner-icon="mdi-account"
            item-text="email"
            item-value="id"
            return-object
            clearable
            rounded
            filled
            dense
            solo
          />
        </v-row>
      </template>

      <template #footer>
        <v-btn block @click="save(value)">Agregar</v-btn>
      </template>
    </dialog-modal>
  </v-form>
</template>

<script>
import DialogModal from '@/Shared/DialogModal'
import { throttle } from 'lodash'

export default {
  name: 'ExpedientForm',
  components: { DialogModal },
  props: {
    form: { type: Object, required: true },
    errors: Object,
    users: { type: Array, required: true },
    templates: { type: Array, required: true },
    isEdit: {
      type: Boolean,
      required: false,
      default: false,
    },
  },
  data: () => ({
    addRequirementDialog: false,
    addFollowerDialog: false,
    value: [],
  }),
  watch: {
    'form.template': {
      handler: throttle(function(template) {
        this.form.requirements = template ? template.requirements : []
      }, 150),
    },
  },
  methods: {
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
