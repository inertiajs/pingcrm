<template>
  <div class="flex items-center">
    <div class="flex w-full bg-white rounded shadow">
      <dropdown v-if="hasFilter" :auto-close="false" class="focus:z-10 px-4 hover:bg-gray-100 border-r focus:border-white rounded-l focus:ring md:px-6" placement="bottom-start">
        <template #default>
          <div class="flex items-baseline">
            <span class="hidden text-gray-700 md:inline">Filtrer</span>
            <svg class="w-2 h-2 fill-gray-700 md:ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 961.243 599.998">
              <path d="M239.998 239.999L0 0h961.243L721.246 240c-131.999 132-240.28 240-240.624 239.999-.345-.001-108.625-108.001-240.624-240z" />
            </svg>
          </div>
        </template>
        <template #dropdown>
          <div class="mt-2 px-4 py-6 w-screen bg-white rounded shadow-xl" :style="{ maxWidth: `${maxWidth}px` }">
            <slot />
          </div>
        </template>
      </dropdown>
      <div v-if="isCombobox" class="relative flex flex-col items-center w-full">
        <div class="w-full">
          <div class="flex my-2 p-1">
            <div class="flex flex-auto flex-wrap" />
            <input placeholder="Entrer un quartier.." class="p-1 px-2 w-full text-gray-800 outline-none appearance-none" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />
            <div class="flex items-center pl-2 pr-1 py-1 w-8 text-gray-300 border-l border-gray-200">
              <button class="w-6 h-6 text-gray-600 outline-none focus:outline-none cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up w-4 h-4">
                  <polyline points="18 15 12 9 6 15"></polyline>
                </svg>
              </button>
            </div>
          </div>
        </div>
        <div class="top-100 lef-0 max-h-select absolute z-40 w-full bg-white rounded shadow overflow-y-auto">
          <slot name="result" />
        </div>
      </div>
      <input v-else class="relative px-6 py-3 w-full rounded-r focus:shadow-outline" autocomplete="off" type="text" name="search" placeholder="Rechercher..." :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />
    </div>
    <button class="ml-3 text-gray-500 hover:text-gray-700 focus:text-indigo-500 text-sm" type="button" @click="$emit('reset')">Réinitialiser</button>
  </div>
</template>

<script>
import Dropdown from '@/Shared/Dropdown'

export default {
  components: {
    Dropdown,
  },
  props: {
    hasFilter: {
      type: Boolean,
      default: true,
    },
    isCombobox: {
      type: Boolean,
      default: false,
    },
    modelValue: String,
    maxWidth: {
      type: Number,
      default: 300,
    },
  },
  emits: ['update:modelValue', 'reset'],
}
</script>

<style>
.top-100 {
  top: 100%;
}
.bottom-100 {
  bottom: 100%;
}
.max-h-select {
  max-height: 300px;
}
</style>
