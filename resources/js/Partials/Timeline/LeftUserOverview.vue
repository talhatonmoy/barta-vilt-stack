<script setup>
import { usePage } from '@inertiajs/vue3';
const props = defineProps({
    userData: {
        type: Object
    }
})
</script>

<template>
    <div
        class="bg-white border-[1px] border-neutral-300  w-full max-w-sm divide-y divide-gray-100 rounded-lg  dark1:bg-gray-800 dark1:divide-gray-700">
        <div class="w-full max-w-sm bg-white p-4  mt-3  dark1:bg-gray-800 ">
            <div class="flex flex-col items-center">
                <img class="w-24 h-24 mb-3 rounded-full shadow-lg" :src="userData.profileImgUrl"
                    :alt="userData.first_name" />
                <a href="#">
                    <h5 class="mb-1 text-xl font-medium text-gray-900 dark1:text-white">
                        {{ userData.first_name }} {{ userData.last_name }}
                    </h5>
                </a>
                <span class="text-sm text-center font-light text-gray-500 dark1:text-gray-400">
                    {{ userData.bio }}
                </span>
            </div>
        </div>

        <div class="w-full max-w-sm bg-white p-4  mt-3  dark1:bg-gray-800 ">
            <p class="text-xs text-gray-500 font-medium text-center">(Favorite Quote)</p>
            <p class="text-sm text-center font-light text-gray-500 dark1:text-gray-400">
                {{ userData.user_details.favorite_quote }}
            </p>
        </div>

        <div class="w-full max-w-sm bg-white p-4  mt-3  dark1:bg-gray-800 ">
            <div class="space-y-2">
                <!-- <p class="text-xs text-gray-500 font-medium text-left border-b-2 border-b-gray-100 ">Contact info</p> -->

                <!-- Primary Lag -->
                <div class="flex justify-between">
                    <p class="text-xs text-gray-700 ">
                        Primary Language
                    </p>
                    <p class="text-xs text-left font-light text-gray-500 dark1:text-gray-400">
                        {{ userData.user_details.primary_lang }}
                    </p>
                </div>

                <!-- Secondary Lag -->
                <div class="flex justify-between">
                    <p class="text-xs text-gray-700 ">
                        Secondary Language
                    </p>
                    <p class="text-xs text-left font-light text-gray-500 dark1:text-gray-400">
                        {{ userData.user_details.secondary_lang }}
                    </p>
                </div>

                <!-- Date of Birth -->
                <div class="flex justify-between">
                    <p class="text-xs text-gray-700 ">
                        Date of birth
                    </p>
                    <p class="text-xs text-left font-light text-gray-500 dark1:text-gray-400">
                        {{ userData.user_details.date_of_birth }}
                    </p>
                </div>

                <!-- Website -->
                <div class="flex justify-between">
                    <p class="text-xs text-gray-700 ">Website</p>
                    <a :href="userData.user_details.website" target="_blank"
                        class="text-xs hover:underline cursor-pointer text-left font-light text-gray-500 dark1:text-gray-400">
                        {{ userData.user_details.website }}
                    </a>
                </div>

                <!-- Lives in -->
                <div class="flex justify-between">
                    <p class="text-xs text-gray-700 ">Lives in</p>
                    <p class="text-xs text-left font-light text-gray-500 dark1:text-gray-400">
                        {{ userData.user_details.current_city }}
                    </p>
                </div>
            </div>
        </div>

        <!-- View Saved Items -->
        <a href="#"
            class="block py-2 px-3 text-sm font-medium  text-gray-900 rounded-b-lg bg-gray-50 hover:bg-gray-100 dark1:bg-gray-800 dark1:hover:bg-gray-700 dark1:text-white">
            <div class="inline-flex gap-2 items-center ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>
                Saved Items
            </div>
        </a>
    </div>
</template>

<style scoped>

</style>