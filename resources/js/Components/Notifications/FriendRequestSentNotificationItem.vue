<script setup>

import { Link } from '@inertiajs/vue3';

const props = defineProps({
    notification: {
        type: Object
    }
})

</script>

<template>

    <Link :href="props.notification.data.profile_link"
        class="flex px-4 py-3 -mx-2 transition-colors duration-300 transform border-b border-gray-100 hover:bg-gray-50 dark1:hover:bg-gray-700 dark1:border-gray-700">
    <div class="flex-shrink-0">
        <img class="rounded-full w-11 h-11" :src="props.notification.data.sender.profileImgUrl"
            :alt="props.notification.data.sender.first_name">
        <div
            class="absolute flex items-center justify-center w-5 h-5 ms-6 -mt-5 bg-blue-600 border border-white rounded-full dark1:border-gray-800">
            <!-- Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-2.5 fill-white">
                <path
                    d="M8 1a.75.75 0 0 1 .75.75V5h-1.5V1.75A.75.75 0 0 1 8 1ZM7.25 5v4.44L6.03 8.22a.75.75 0 0 0-1.06 1.06l2.5 2.5a.75.75 0 0 0 1.06 0l2.5-2.5a.75.75 0 1 0-1.06-1.06L8.75 9.44V5H11a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h2.25Z" />
            </svg>


        </div>
    </div>
    <p class="mx-2 text-sm text-gray-600 dark1:text-white">
        <span class="font-bold text-neutral-900">
            {{ props.notification.data.sender.first_name }} {{ props.notification.data.sender.last_name }}
        </span> Send you a friend request
        <br>
        <span class="text-xs text-blue-600">
            {{ props.notification.created_at }}
        </span>
    </p>
    </Link>
</template>

<style scoped></style>