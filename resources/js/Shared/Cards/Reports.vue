<template>
    <div class="h-44 w-32 bg-white rounded-xl flex flex-col justify-center shadow duration-300 hover:bg-white hover:shadow-xl">
        <div class=" w-full flex justify-center items-center">
            <svg fill="#758ca3" height="55px" width="55px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <g> <path d="M490.667,469.333h-448v-448C42.667,9.551,33.115,0,21.333,0C9.551,0,0,9.551,0,21.333v469.333 C0,502.449,9.551,512,21.333,512h469.333c11.782,0,21.333-9.551,21.333-21.333S502.449,469.333,490.667,469.333z"></path> <path d="M490.667,298.667H384V256h21.333c11.782,0,21.333-9.551,21.333-21.333v-85.333c0-11.782-9.551-21.333-21.333-21.333 H298.667V64c0-11.782-9.551-21.333-21.333-21.333H106.667c-11.782,0-21.333,9.551-21.333,21.333v85.333v85.333V320v85.333 c0,11.782,9.551,21.333,21.333,21.333h384c11.782,0,21.333-9.551,21.333-21.333V320C512,308.218,502.449,298.667,490.667,298.667 z M341.333,298.667H128V256h213.333V298.667z M384,213.333h-21.333H128v-42.667h149.333H384V213.333z M128,85.333h128V128H128 V85.333z M469.333,384H128v-42.667h234.667h106.667V384z"></path> </g> </g> </g> </g></svg>
        </div>
      
        <span class="mt-6 text-xl ?leading-5 font-bold text-center">{{ props.reports ?? '0' }}</span>
        <span class="mt-2 text-lg ?leading-5 font-normal text-center">Reports</span>
    </div>
    </template>
    
    <script setup>
const props = defineProps(['reports'])

    </script>