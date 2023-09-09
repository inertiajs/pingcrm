<template>
    <div class="h-44 w-32 bg-white rounded-xl flex flex-col justify-center shadow duration-300 hover:bg-white hover:shadow-xl">
        <div class=" w-full flex justify-center items-center">
            <svg width="55px" height="55px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#c01c28"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="9" cy="6" r="4" stroke="#758ca3" stroke-width="1.5"></circle> <path d="M15 9C16.6569 9 18 7.65685 18 6C18 4.34315 16.6569 3 15 3" stroke="#758ca3" stroke-width="1.5" stroke-linecap="round"></path> <path d="M5.88915 20.5843C6.82627 20.8504 7.88256 21 9 21C12.866 21 16 19.2091 16 17C16 14.7909 12.866 13 9 13C5.13401 13 2 14.7909 2 17C2 17.3453 2.07657 17.6804 2.22053 18" stroke="#758ca3" stroke-width="1.5" stroke-linecap="round"></path> <path d="M18 14C19.7542 14.3847 21 15.3589 21 16.5C21 17.5293 19.9863 18.4229 18.5 18.8704" stroke="#758ca3" stroke-width="1.5" stroke-linecap="round"></path> </g></svg>
        </div>
      
        <span class="mt-6 text-xl ?leading-5 font-bold text-center">{{  props.users ?? '0' }}</span>
        <span class="mt-2 text-lg ?leading-5 font-normal text-center">Users</span>
    </div>
    </template>
    
    <script setup>
const props = defineProps(['users'])

    </script>
    