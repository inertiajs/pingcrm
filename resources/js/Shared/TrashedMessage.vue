<template>
  <div class="p-4 bg-yellow-400 rounded flex items-center justify-between max-w-3xl">
    <div class="flex items-center">
      <icon name="trash" class="flex-shrink-0 w-4 h-4 fill-yellow-800 mr-2" />
      <div class="text-sm font-medium text-yellow-800">
        <slot />
      </div>
    </div>
    <button class="text-sm text-yellow-800 hover:underline" tabindex="-1" type="button" @click="$emit('restore')">Restore</button>
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
