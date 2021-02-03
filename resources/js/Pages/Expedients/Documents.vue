<template>
  <v-card flat>
    <breadcrumbs :items="breadcrumbs" />

    <v-row class="mx-3">
      <v-col cols="12" md="4">
        <v-card>
          <v-list subheader dense>
            <v-subheader inset class="overline">Requisitos</v-subheader>
            <v-list-group
              v-for="folder in FoldersRequirement"
              :key="folder.title"
              prepend-icon="mdi-folder-open"
            >
              <template v-slot:activator>
                <v-list-item-content>
                  <v-list-item-title
                    class="overline"
                    v-text="`${folder.title} (${folder.total})`"
                  />
                </v-list-item-content>
              </template>

              <v-list-item
                v-for="child in folder.documents"
                :key="child.title"
                class="grey lighten-4"
                @click="Document = { ...child }"
              >
                <v-list-item-icon>
                  <v-icon>
                    mdi-file-check-outline
                  </v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                  <v-list-item-title
                    class="caption font-weight-bold font-italic"
                    v-text="child.title"
                  />
                </v-list-item-content>
              </v-list-item>
            </v-list-group>
            <v-subheader class="overline">
              <v-btn
                block
                color="indigo darken-5"
                text
                @click="openDialogAddRequirement"
              >
                Agregar requisito
                <v-icon right>
                  mdi-plus
                </v-icon>
              </v-btn>
            </v-subheader>
          </v-list>
        </v-card>
      </v-col>
      <v-col cols="12" md="8">
        <v-card>
          <v-toolbar color="light-blue" dark dense>
            <v-toolbar-title>
              {{ Document.title }}
            </v-toolbar-title>
            <v-spacer />
            <v-chip label outlined>
              <span class="overline"> {{ statusText }} </span>
            </v-chip>
          </v-toolbar>
          <v-sheet min-height="300" color="grey lighten-3">
            <v-container>
              <v-row class="justify-items-center text-center">
                <v-col cols="12" md="4">
                  <v-select
                    v-model="Document.status_key"
                    outlined
                    label="ESTATUS"
                    dense
                    :items="statuses"
                    item-text="text"
                    item-value="key"
                    :hint="
                      `valido hasta: ${Document.until_valid || 'Indefinido'}`
                    "
                    persistent-hint
                    :error-messages="errors.status_key"
                  />
                  <v-menu
                    v-if="Document.status_key === 'valid'"
                    v-model="menu_picker_date"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                        v-model="Document.until_valid"
                        label="Valido hasta:"
                        prepend-inner-icon="mdi-calendar"
                        readonly
                        dense
                        clearable
                        v-bind="attrs"
                        v-on="on"
                      />
                    </template>
                    <v-date-picker
                      v-model="Document.until_valid"
                      :min="new Date().toISOString().substr(0, 10)"
                      @input="menu_picker_date = false"
                    />
                  </v-menu>
                </v-col>
                <v-col cols="12" md="3" class="text-left">
                  <v-btn
                    v-if="Document.id"
                    color="success"
                    @click="submit(Document.status_key)"
                  >
                    Guardar
                  </v-btn>
                </v-col>
                <v-col class="text-left">
                  <span class="overline">
                    {{
                      Intl.DateTimeFormat('es-MX', {
                        dateStyle: 'long',
                      }).format(Date.now())
                    }}</span>
                </v-col>
                <v-col cols="12" class="py-0">
                  <v-textarea
                    v-if="Document.status_key === 'invalid'"
                    v-model="Document.commentary"
                    placeholder="Escriba una Comentario para el Cliente del motivo de la invalidacion."
                    label="Comentario."
                    outlined
                    clearable
                    class="title"
                    :error-messages="errors.commentary"
                  />
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="12" md="6">
                  <v-card max-width="500" class="mx-auto">
                    <v-toolbar color="indigo" dark dense>
                      <v-toolbar-title>Archivos</v-toolbar-title>
                      <v-spacer />

                      <v-btn
                        icon
                        @click="
                          Document.id ? (dialogs.uploadFiles = true) : false
                        "
                      >
                        <v-icon>mdi-file-upload</v-icon>
                      </v-btn>
                      <template v-if="Document.files">
                        <v-btn
                          v-if="Document.files.length > 0"
                          icon
                          target="_blank"
                          :href="`/documents/${Document.id}/downloadFilesZip`"
                        >
                          <v-icon>mdi-cloud-download-outline</v-icon>
                        </v-btn>
                      </template>
                    </v-toolbar>
                    <v-list dense>
                      <v-list-item
                        v-for="(file, index) in Document.files"
                        :key="index"
                      >
                        <v-list-item-avatar>
                          <v-btn icon :href="file.path" target="_blank">
                            <v-icon color="blue">
                              mdi-paperclip
                            </v-icon>
                          </v-btn>
                        </v-list-item-avatar>

                        <v-list-item-content>
                          <v-list-item-title v-text="file.file_name" />
                          <v-list-item-subtitle v-text="file.created_at" />
                        </v-list-item-content>
                        <v-list-item-action>
                          <v-btn icon @click="deleteFile(file.id)">
                            <v-icon color="error lighten-1">
                              mdi-trash-can
                            </v-icon>
                          </v-btn>
                        </v-list-item-action>
                      </v-list-item>
                    </v-list>
                  </v-card>
                </v-col>
                <v-col cols="12" md="6">
                  <v-card max-width="500" class="mx-auto" flat>
                    <v-toolbar color="blue lighten-5" dense flat>
                      <v-toolbar-title>Descripcion</v-toolbar-title>
                    </v-toolbar>
                    <v-card-text v-text="Document.description" />
                  </v-card>
                </v-col>
              </v-row>
            </v-container>
          </v-sheet>
        </v-card>
      </v-col>
    </v-row>

    <dialog-modal :show="dialogs.uploadFiles" persistent @close="closeModal">
      <template #title>
        Subir Archivo(s) a:
        <span v-if="Document" class="font-italic">
          {{ Document.title }}
        </span>
      </template>

      <template #content>
        <div class="d-flex flex-column align-content-space-between">
          <v-file-input
            v-model="filesToUpload"
            accept="image/*, application/pdf"
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
      </template>

      <template #footer>
        <v-btn
          v-show="filesToUpload.length > 0"
          block
          :loading="sending"
          :disabled="sending"
          class="white--text"
          color="indigo darken-5"
          @click.prevent="uploadFileDocument"
        >
          Cargar Archivo(s)
        </v-btn>
      </template>
    </dialog-modal>

    <dialog-modal :show="dialogs.addRequirement" @close="closeModal">
      <template #title>
        Requisitos
      </template>

      <template #content>
        <v-row justify="center" align="center" class="ma-auto">
          <v-autocomplete
            v-model="requirement"
            :items="requirements"
            item-text="name"
            item-value="id"
            clearable
            filled
            rounded
            outlined
            :error-messages="errors.requirement"
            return-object
          />
        </v-row>
      </template>

      <template #footer>
        <v-btn
          v-show="requirement"
          block
          :loading="sending"
          :disabled="sending"
          class="white--text"
          color="indigo darken-5"
          @click="saveRequirement(requirement)"
        >
          Agregar
        </v-btn>
      </template>
    </dialog-modal>
  </v-card>
</template>

<script>
import Layout from '@/Shared/Layout'
import Breadcrumbs from '@/Shared/Breadcrumbs'
import DialogModal from '@/Shared/DialogModal'
import { each } from 'lodash'

export default {
  metaInfo: { title: 'Administar Expediente' },
  layout: Layout,
  components: { Breadcrumbs, DialogModal },
  props: {
    errors: Object,
    expedient: {
      type: Object,
      required: true,
    },
    folders: Array,
    statuses: Array,
    requirements: Array,
  },
  remember: 'Document',
  data() {
    return {
      dialogs: {
        uploadFiles: false,
        addRequirement: false,
      },
      menu_picker_date: false,
      Document: {},
      requirement: {},
      sending: false,
      filesToUpload: [],
      breadcrumbs: [
        {
          text: 'Expedientes',
          disabled: false,
          href: this.route('expedients'),
          exact: true,
        },
        { text: 'Administrar', disabled: true },
        { text: this.expedient.name, disabled: true },
      ],
    }
  },
  computed: {
    FoldersRequirement() {
      return this.folders.map(folder => {
        return {
          title: folder.status_text,
          documents: folder.documents,
          total: folder.documents_count,
        }
      })
    },
    statusText() {
      return Object.keys(this.Document).length === 0
        ? ''
        : this.statuses.find(status => status.key === this.Document.status_key)
          .text
    },
  },
  methods: {
    openDialogUploadFiles() {
      this.dialogs.uploadFiles = true
    },
    openDialogAddRequirement() {
      this.dialogs.addRequirement = true
    },
    closeModal() {
      this.dialogs.uploadFiles = false
      this.dialogs.addRequirement = false
      this.filesToUpload = []
      this.requirement = {}
    },
    uploadFileDocument() {
      const data = new FormData()
      each(this.filesToUpload, (file, i) => {
        data.append(`archivos[${i}]`, file)
      })
      data.append('document_id', this.Document.id)
      data.append('_method', 'put')
      this.$inertia.post(
        this.route('documents.uploadFiles', this.Document.id),
        data,
        {
          onStart: () => (this.sending = true),
          onFinish: () => (this.sending = false),
          onSuccess: () => {
            this.closeModal()
            this.Document = {}
          },
        }
      )
    },
    saveRequirement(_requirement) {
      let payload = {
        requirement: _requirement.id,
      }
      this.$inertia.put(
        this.route('expedients.addRequirement', this.expedient.id),
        payload,
        {
          onStart: () => (this.sending = true),
          onFinish: () => (this.sending = false),
          onSuccess: () => {
            this.closeModal()
          },
        }
      )
    },
    deleteFile(_file_id) {
      this.$inertia.delete(this.route('documents.deleteFile', _file_id), {
        onStart: () => (this.sending = true),
        onFinish: () => (this.sending = false),
        onSuccess: () => {
          this.closeModal()
          this.Document = {}
        },
      })
    },
    submit(status) {
      let payload = {
        ...this.Document,
        until_valid: status !== 'valid' ? null : this.Document.until_valid,
        commentary: status !== 'invalid' ? null : this.Document.commentary,
      }
      this.$inertia.put(
        this.route('documents.update', this.Document.id),
        payload,
        {
          onStart: () => (this.sending = true),
          onFinish: () => (this.sending = false),
          onSuccess: () => {
            this.closeModal()
            this.Document = {}
          },
        }
      )
    },
  },
}
</script>

<style></style>
