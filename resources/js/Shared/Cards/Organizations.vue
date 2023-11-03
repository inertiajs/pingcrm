<template>
    <div class="h-44 w-32 bg-white rounded-lg flex flex-col justify-center shadow duration-300 hover:bg-white hover:shadow-xl">
        <div class=" w-full flex justify-center items-center">
            <svg width="55px" height="55px" viewBox="0 0 24 24" id="company-small-24px" xmlns="http://www.w3.org/2000/svg" fill="#758ca3"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path id="company-small-24px-2" data-name="company-small-24px" d="M16,4H2A2.006,2.006,0,0,0,0,6V24H18V6A2.006,2.006,0,0,0,16,4ZM8,22V18h2v4Zm8,0H12V17a.945.945,0,0,0-1-1H7a.945.945,0,0,0-1,1v5H2V6H16ZM8,10H6V8H8Zm4,0H10V8h2ZM8,14H6V12H8Zm4,0H10V12h2Z" transform="translate(3 -2)"></path> <rect id="Retângulo_222" data-name="Retângulo 222" width="24" height="24" fill="none" opacity="0"></rect> </g></svg>
        </div>
      
        <span class="mt-6 text-xl ?leading-5 font-bold text-center">{{ props.orgs ?? '0' }}</span>
        <span class="mt-2 text-lg ?leading-5 font-normal text-center">Organs</span>
    </div>
    </template>
    
    <script setup>
const props = defineProps(['orgs'])

    </script>
    