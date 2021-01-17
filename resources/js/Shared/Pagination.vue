<template>
  <div class="text-center py-3">
    <v-pagination
      :value="page"
      :length="links.length"
      :total-visible="7"
      @input="$emit('input', $event)"
    />
  </div>
</template>

<script>
export default {
  props: {
    links: {
      type: Array,
      required: true,
    },
    page: {
      type: Number,
      required: true,
    },
  },
}
</script>
<style scoped>
.active {
  text-decoration: none !important;
}
</style>
