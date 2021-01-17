<template>
  <v-banner class="error overline" single-line dark>
    <v-icon slot="icon" size="36">
      mdi-trash-can
    </v-icon>
    <slot />
    <template v-slot:actions>
      <v-btn color="warning" @click="$emit('restore')">Restaurar</v-btn>
    </template>
  </v-banner>
</template>

<script>
export default {
  components: {},
}
</script>
