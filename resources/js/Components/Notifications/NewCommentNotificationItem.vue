<script setup>

import { Link } from '@inertiajs/vue3';

const props = defineProps({
    notification: {
        type: Object
    }
})

</script>

<template>
    <Link :href="props.notification.data.post_link" class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700">
        <!-- <pre class="text-xs">
            {{ props.notification }}
        </pre> -->
        <div class="flex-shrink-0">
            <img class="rounded-full w-11 h-11" :src="props.notification.data.sender.profileImgUrl" alt="Leslie image">
            <div
                class="absolute flex items-center justify-center w-5 h-5 ms-6 -mt-5 bg-green-400 border border-white rounded-full dark:border-gray-800">
                <svg class="w-2 h-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 18">
                    <path
                        d="M18 0H2a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h2v4a1 1 0 0 0 1.707.707L10.414 13H18a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5 4h2a1 1 0 1 1 0 2h-2a1 1 0 1 1 0-2ZM5 4h5a1 1 0 1 1 0 2H5a1 1 0 0 1 0-2Zm2 5H5a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Zm9 0h-6a1 1 0 0 1 0-2h6a1 1 0 1 1 0 2Z" />
                </svg>
            </div>
        </div>
        <div class="w-full ps-3">
            <div class="text-gray-500 text-sm mb-1.5 dark:text-gray-400"><span
                    class="font-semibold text-gray-900 dark:text-white">{{ props.notification.data.sender.first_name }} {{ props.notification.data.sender.last_name }}</span>
                {{ props.notification.data.message }} 
            </div>
            <div class="text-xs text-blue-600 dark:text-blue-500">{{ props.notification.created_at }}</div>
        </div>
    </Link>
</template>

<style scoped>

</style>