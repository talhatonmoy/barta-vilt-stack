<script setup>
import { router, Link } from '@inertiajs/vue3';
import { reactive } from 'vue';

const props = defineProps({
    modelData: {
        type: Object
    }
})

// Accepting Post Data
const postObj = props.modelData

// Preparing Like data
const likeData = reactive({
    likes_count: postObj.likes_count,
    is_liked_by_current_user: postObj.is_liked_by_current_user,
    allLikes: postObj.likes
})

// Like Mechanism initiation
function likePost() {
    router.visit(route('posts.like', postObj.uuid), {
        method: 'post',
        preserveScroll: true,
    })
}

// Likers Modal
const modal = reactive({
    open: false,
    handleChange() {
        this.open = !this.open
    },
    reset() {
        modal.open = false
    }
})

</script>

<template>
    <div class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800">
        <span class="sr-only">Likes</span>
        <svg @click.prevent="likePost" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor"
            :class="{ 'fill-red-700 stroke-red-700': likeData.is_liked_by_current_user == true }"
            class="size-5 cursor-pointer">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
        </svg>
        <div v-if="likeData.likes_count > 0">
            <div class="flex flex-shrink-0 self-center">
                <div class="relative inline-block text-left">
                    <div>
                        <!-- Like Count -->
                        <button @click="modal.handleChange" v-click-away="modal.reset"
                            class=" cursor-pointer hover:underline">
                            <p>{{ likeData.likes_count }}</p>
                        </button>
                    </div>
                    <!-- Dropdown Modal -->
                    <div v-show="modal.open"
                        class="absolute px-2 z-10 mt-5 w-64 md:w-80 lg:w-96 origin-top-right  rounded-md bg-gray-50 py-1 shadow-xl transition-all ring-1 ring-black ring-opacity-5 focus:outline-none">
                        <ul class="space-y-2 divide-y divide-gray-200">
                            <li class="py-2 sm:py-1.5" v-for="like in likeData.allLikes" :key="like.id">
                                <div class="flex items-center gap-2">
                                    <div class="flex-shrink-0">
                                        <img class="w-9 h-9 rounded-full" :src="like.user.profileImgUrl"
                                            :alt="like.user.last_name">
                                    </div>
                                    <div class="flex-1 min-w-0 ">
                                        <Link :href="route('user.profile.show', like.user.user_name)">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                            {{ like.user.first_name }} {{ like.user.last_name }}
                                        </p>
                                        </Link>
                                        <p class="text-[12px] text-gray-500 truncate dark:text-gray-400">
                                            {{ like.user.bio }}
                                        </p>
                                    </div>
                                </div>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>


</template>

<style scoped></style>