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
        <v-row>
          <v-col cols="12">
            <v-toolbar color="blue lighten-2 text-uppercase" dark dense>
              <v-toolbar-title>CheckList Requisitos</v-toolbar-title>
              <v-spacer />
              <v-text-field
                rounded
                append-icon="mdi-magnify"
                dense
                single-line
                outlined
                solo-inverted
                hide-details
              />
              <v-btn icon @click.native="showAddRequirementDialog">
                <v-icon large color="success darken-2">
                  mdi-plus-box-multiple-outline
                </v-icon>
              </v-btn>
            </v-toolbar>
            <v-list two-line dense>
              <v-list-item-group
                v-model="selected"
                active-class="pink--text"
                multiple
              >
                <template v-for="(item, index) in items">
                  <v-list-item :key="item.title">
                    <template v-slot:default="{ active }">
                      <v-list-item-content>
                        <v-list-item-title v-text="item.title" />

                        <v-list-item-subtitle
                          class="text--primary"
                          v-text="item.headline"
                        />

                        <v-list-item-subtitle v-text="item.subtitle" />
                      </v-list-item-content>

                      <v-list-item-action>
                        <v-list-item-action-text v-text="item.action" />

                        <v-icon v-if="!active" color="grey lighten-1">
                          mdi-trash-can-outline
                        </v-icon>

                        <v-icon v-else color="yellow darken-3">
                          mdi-trash-can
                        </v-icon>
                      </v-list-item-action>
                    </template>
                  </v-list-item>

                  <v-divider v-if="index < items.length - 1" :key="index" />
                </template>
              </v-list-item-group>
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
        Mi Portal Dialog
      </template>

      <template #content>
        <v-row justify="center" align="center" class="ma-auto">
          <v-autocomplete
            v-model="values"
            :items="items"
            item-text="headline"
            item-value="action"
            chips
            clearable
            deletable-chips
            filled
            multiple
            rounded
            solo
            hide-details
          />
        </v-row>
      </template>

      <template #footer>
        <v-btn block @click="selected.push(4), closeModal()">Accion</v-btn>
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
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      addRequirementDialog: false,
      selected: [2],
      form: {
        name: null,
        description: null,
      },
      values: [],
      items: [
        {
          action: '15 min',
          headline: 'Brunch this weekend?',
          subtitle:
            'I\'llbe in your neighborhood doing errands this weekend. Do you want to hang out?',
          title: 'Ali Connors',
        },
        {
          action: '2 hr',
          headline: 'Summer BBQ',
          subtitle: 'Wish I could come, but I\'m out of town this weekend.',
          title: 'me, Scrott,Jennifer',
        },
        {
          action: '6 hr',
          headline: 'Oui oui',
          subtitle: 'Do you haveParis recommendations? Have you ever been?',
          title: 'Sandra Adams',
        },
        {
          action: '12 hr',
          headline: 'Birthday gift',
          subtitle:
            'Have any ideas about what weshould get Heidi for her birthday?',
          title: 'Trevor Hansen',
        },
        {
          action: '18hr',
          headline: 'Recipe to try',
          subtitle:
            'We should eat this: Grate, Squash,Corn, and tomatillo Tacos.',
          title: 'Britta Holt',
        },
      ],
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
      this.$inertia.post(this.route('templates.store'), this.form, {
        onStart: () => (this.sending = true),
        onFinish: () => (this.sending = false),
      })
    },
    showAddRequirementDialog() {
      this.addRequirementDialog = true
    },
    closeModal() {
      this.addRequirementDialog = false
      // this.form.reset()
    },
  },
}
</script>

<style></style>
