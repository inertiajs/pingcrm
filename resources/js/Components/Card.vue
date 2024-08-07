<template>
  <div class="max-w-sm rounded-lg overflow-hidden shadow-lg transform transition duration-500 hover:scale-110 hover:shadow-2xl hover:bg-white bg-gradient-to-r from-indigo-900 to-indigo-800 p-2">
    <img class="w-full h-48 object-cover  rounded" src="https://via.placeholder.com/150" alt="Placeholder Image">
    <div class="font-bold text-xl mb-1 text-white bg-gradient-to-r from-indigo-900 to-indigo-800 text-center mt-1">{{ name }}</div>
    <div class="px-6 py-4 bg-white rounded shadow-sm">

      <p class="text-gray-700 text-base mb-2">
        City: {{ city }}
      </p>
      <p class="text-gray-700 text-base mb-2">
        Phone: {{ phone }}
      </p>
      <p class="text-gray-700 text-base">
        Owner: {{ owner || 'N/A' }}
      </p>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    name: {
      type: String,
      required: true
    },
    city: {
      type: String,
      required: true
    },
    phone: {
      type: String,
      required: true
    },
    owner: {
      type: String,
      default: 'N/A'
    }
  }
}
</script>
