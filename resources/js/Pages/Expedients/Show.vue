<template>
  <v-container>
    <v-app-bar app>
      <v-btn icon href="/">
        <v-icon>mdi-home</v-icon>
      </v-btn>

      <v-toolbar-title class="text-uppercase">
        {{ expedient.name }}
      </v-toolbar-title>
    </v-app-bar>
    <v-row align="center">
      <v-col
        v-for="document in expedient.documents"
        :key="document.id"
        cols="12"
        md="4"
        class="py-auto"
      >
        <v-hover v-slot="{ hover }">
          <v-card
            :elevation="hover ? 12 : 2"
            :class="{
              'on-hover': hover,
              'darken-1': true,
              orange: hover,
              grey: document.status === 'pending',
              error: document.status === 'invalid',
              success: document.status === 'valid',
              accent: document.status === 'review',
            }"
            @click="showDocumentDialog(document)"
          >
            <v-card-title class="overline white--text">
              <v-row class="fill-height flex-column" justify="space-between">
                <div class="align-self-center mt-2">
                  <v-btn
                    v-for="(icon, index) in icons"
                    :key="index"
                    :class="{ 'show-btns': hover }"
                    :color="transparent"
                    icon
                  >
                    <v-icon class="show-btns" :color="transparent">
                      {{ icon }}
                    </v-icon>
                  </v-btn>
                </div>

                <div>
                  <p
                    class="mt-2 subheading text-center"
                    v-text="document.title"
                  />
                </div>
                <div>
                  <p class="caption font-weight-bold text-center">
                    Archivos Cargados: {{ document.files_count }}
                  </p>
                  <p
                    v-if="document.until_valid"
                    class="caption font-weight-medium font-italic text-center"
                  >
                    Valido hasta: {{ document.until_valid }}
                  </p>
                </div>
              </v-row>
            </v-card-title>
          </v-card>
        </v-hover>
      </v-col>
    </v-row>

    <dialog-modal :show="addDocumentsDialog" persistent @close="closeModal">
      <template #title>
        {{ form.document.title }}
      </template>

      <template #content>
        <div class="d-flex flex-column align-content-space-between">
          <v-alert
            v-if="form.document.commentary"
            outlined
            type="warning"
            prominent
            border="left"
          >
            {{ form.document.commentary }}
          </v-alert>

          <q class="text-h6 mb-6" v-text="form.document.description" />
          <div>
            <v-file-input
              v-model="form.files"
              placeholder="seleccionar archivos."
              chips
              counter
              multiple
              show-size
              truncate-length="15"
              outlined
              clearable
              :error-messages="errors.archivos"
            />
          </div>
        </div>
      </template>

      <template #footer>
        <v-btn
          v-show="form.files.length > 0"
          block
          :loading="sending"
          :disabled="sending"
          @click.prevent="submit"
        >
          Enviar Documento(s) Revision
        </v-btn>
      </template>
    </dialog-modal>
  </v-container>
</template>

<script>
import Layout from '@/Shared/Basic'
import { each } from 'lodash'
import DialogModal from '@/Shared/DialogModal'

export default {
  metaInfo: { title: 'Requisitos Expediente' },

  layout: (h, page) => h(Layout, [page]),

  components: { DialogModal },
  props: {
    errors: Object,
    expedient: Object,
    status: Array,
  },
  data: () => ({
    sending: false,
    form: {
      files: [],
      document: {},
    },
    addDocumentsDialog: false,
    icons: ['mdi-clock'],
    transparent: 'rgba(255, 255, 255, 0)',
  }),
  methods: {
    getClasses(status) {
      let classes = ''
      classes = status === 'pending' ? { black: true } : ''
      classes = status === 'review' ? { blue: true } : ''
      classes = status == 'valid' ? { orange: true } : ''
      classes = status === 'invalid' ? { error: true } : ''
      return classes
    },
    showDocumentDialog(_document) {
      this.form.document = _document
      this.addDocumentsDialog = true
    },
    closeModal() {
      this.form.document = {}
      this.form.files = []
      this.addDocumentsDialog = false
    },
    submit() {
      const data = new FormData()
      each(this.form.files, (file, i) => {
        data.append(`archivos[${i}]`, file)
      })
      data.append('_method', 'put')
      this.$inertia.post(
        this.route('documents.uploadFiles', this.form.document.id),
        data,
        {
          onStart: () => (this.sending = true),
          onFinish: () => (this.sending = false),
          onSuccess: () => {
            this.closeModal()
          },
        }
      )
    },
  },
}
</script>

<style scoped>
.v-card {
  transition: opacity 0.4s ease-in-out;
}

.v-card:not(.on-hover) {
  opacity: 0.7;
}

.show-btns {
  color: rgba(255, 255, 255, 1) !important;
}
</style>
