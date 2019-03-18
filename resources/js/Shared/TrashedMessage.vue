<template>
  <div class="p-4 bg-yellow-light rounded border border-yellow-dark flex items-center justify-between">
    <div class="flex items-center">
      <icon name="trash" class="flex-no-shrink w-4 h-4 fill-yellow-darker mr-2" />
      <div class="text-yellow-darker">
        <slot />
      </div>
    </div>
    <button class="text-yellow-darker hover:underline" tabindex="-1" type="button" @click="$emit('restore')">Restore</button>
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'

export default {
  components: {
    Icon,
  },
}
</script>
