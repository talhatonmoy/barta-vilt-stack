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
            class="absolute flex items-center justify-center w-5 h-5 ms-6 -mt-5 bg-blue-600 border border-white rounded-full dark1:border-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-2.5 fill-white">
                <path
                    d="M2.09 15a1 1 0 0 0 1-1V8a1 1 0 1 0-2 0v6a1 1 0 0 0 1 1ZM5.765 13H4.09V8c.663 0 1.218-.466 1.556-1.037a4.02 4.02 0 0 1 1.358-1.377c.478-.292.907-.706.989-1.26V4.32a9.03 9.03 0 0 0 0-2.642c-.028-.194.048-.394.224-.479A2 2 0 0 1 11.09 3c0 .812-.08 1.605-.235 2.371a.521.521 0 0 0 .502.629h1.733c1.104 0 2.01.898 1.901 1.997a19.831 19.831 0 0 1-1.081 4.788c-.27.747-.998 1.215-1.793 1.215H9.414c-.215 0-.428-.035-.632-.103l-2.384-.794A2.002 2.002 0 0 0 5.765 13Z" />
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