<template>
  <v-breadcrumbs :items="breadcrumbs" class="overline">
    <template v-slot:divider>
      <v-icon>mdi-chevron-right</v-icon>
    </template>
  </v-breadcrumbs>
</template>

<script>
export default {
  props: {
    breadcrumbs: {
      type: Array,
      required: true,
    },
  },
}
</script>

<style></style>
