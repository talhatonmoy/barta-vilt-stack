<script setup>

import { Link } from '@inertiajs/vue3';

const props = defineProps({
    notification: {
        type: Object
    }
})

</script>

<template>

    <Link :href="props.notification.data.post_link"
        class="flex px-4 py-3 -mx-2 transition-colors duration-300 transform border-b border-gray-100 hover:bg-gray-50 dark1:hover:bg-gray-700 dark1:border-gray-700">
    <div class="flex-shrink-0">
        <img class="rounded-full w-11 h-11" :src="props.notification.data.sender.profileImgUrl"
            :alt="props.notification.data.sender.first_name">
        <div
            class="absolute flex items-center justify-center w-5 h-5 ms-6 -mt-5 bg-red-600 border border-white rounded-full dark1:border-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-2.5 fill-white stroke-red-600">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
            </svg>
        </div>
    </div>
    <p class="mx-2 text-sm text-gray-600 dark1:text-white">
        <span class="font-bold text-neutral-900">
            {{ props.notification.data.sender.first_name }} {{ props.notification.data.sender.last_name }}
        </span> {{ props.notification.data.message }} - {{ props.notification.data.excerpt }}
        <br>
        <span class="text-xs text-blue-600">
            {{ props.notification.created_at }}
        </span>
    </p>
    </Link>
</template>

<style scoped></style>