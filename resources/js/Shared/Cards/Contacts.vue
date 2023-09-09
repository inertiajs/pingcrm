<template>
<div class="h-44 w-32 bg-white rounded-xl flex flex-col justify-center shadow duration-300 hover:bg-white hover:shadow-xl">
    <div class=" w-full flex justify-center items-center">
        <svg width="55px" height="55px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000" stroke="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M670.5 471.7c-7.1-3.1-14.2-5.9-21.4-8.5 49.8-40.3 81.6-101.8 81.6-170.6 0-121-98.4-219.4-219.4-219.4s-219.4 98.4-219.4 219.4c0 68.9 31.9 130.5 81.7 170.7C219.4 519.6 109 667.8 109 841.3h73.1c0-181.5 147.7-329.1 329.1-329.1 45.3 0 89.1 9 130.2 26.7l29.1-67.2zM511.3 146.3c80.7 0 146.3 65.6 146.3 146.3S592 438.9 511.3 438.9 365 373.2 365 292.6s65.6-146.3 146.3-146.3zM612.5 636.5c0 10.2 5.6 19.5 14.6 24.2l128 67.6c4 2.1 8.4 3.2 12.8 3.2s8.8-1.1 12.8-3.2l128-67.6c9-4.8 14.6-14.1 14.6-24.2s-5.6-19.5-14.6-24.2l-128-67.7c-8-4.2-17.6-4.2-25.6 0l-128 67.7c-9 4.7-14.6 14-14.6 24.2z m155.4-36.6l69.3 36.6-69.3 36.6-69.3-36.6 69.3-36.6z" fill="#758ca3"></path><path d="M767.9 763.4l-147-77.7-25.6 48.5 172.6 91.2 171.9-90.8-25.6-48.5z" fill="#758ca3"></path><path d="M767.9 851.4l-147-77.6-25.6 48.4 172.6 91.3 171.3-90.6-25.6-48.5z" fill="#758ca3"></path></g></svg>
    </div>
  
    <span class="mt-6 text-xl ?leading-5 font-bold text-center">{{ props.contacts ?? '0' }}</span>
    <span class="mt-2 text-lg ?leading-5 font-normal text-center">Contacts</span>
</div>
</template>
<script setup>
const props = defineProps(['contacts'])

    </script>