<script setup>
import { Link, router, usePage } from '@inertiajs/vue3';
import { reactive } from 'vue';
import Like from './Like/Like.vue';
import Dislike from './Like/Dislike.vue';
const props = defineProps({
    post: {
        type: Object
    }
})

const user = usePage().props.auth.user

const menu = reactive({
    open: false,
    handleChange() {
        this.open = !this.open
    },
    reset() {
        menu.open = false
    }
})

// Sending Delete Request
function handlePostDelete() {
    router.visit(route('posts.destroy', props.post.uuid), {
        method: 'delete',
        preserveScroll: true,
        onBefore: visit => {
            return confirm("Are You Really Want To Delete This Post?")
        }
    })
}

</script>

<template>
    <!-- <pre>
        {{ props.post }}
    </pre> -->
    <article class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-5 sm:px-6">
        <!-- Barta Card Top -->
        <header>
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <!-- User Avatar -->
                    <Link :href="route('user.profile.show', props.post.user.user_name)">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full object-cover" :src="props.post.user.profileImgUrl"
                            :alt="props.post.user.first_name" />
                    </div>
                    </Link>

                    <!-- /User Avatar -->

                    <!-- User Info -->
                    <div class="text-gray-900 flex flex-col min-w-0 flex-1">
                        <Link :href="route('user.profile.show', props.post.user.user_name)"
                            class="hover:underline font-semibold line-clamp-1">
                        {{ props.post.user.first_name }} {{ props.post.user.last_name }}
                        </Link>

                        <p class=" text-sm text-gray-500 line-clamp-1">
                            {{ props.post.user.bio }}
                        </p>
                    </div>
                    <!-- /User Info -->
                </div>

                <!-- Card Action Dropdown -->
                <div v-if="props.post.user.user_name == user.user_name" class="flex flex-shrink-0 self-center">
                    <div class="relative inline-block text-left">
                        <div>
                            <button @click="menu.handleChange" v-click-away="menu.reset" type="button"
                                class="-m-2 flex items-center rounded-full p-2 text-gray-400 hover:text-gray-600"
                                id="menu-0-button">
                                <span class="sr-only">Open options</span>
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path
                                        d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                        <!-- Dropdown menu -->
                        <div v-show="menu.open"
                            class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                            role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            <Link :href="route('posts.edit', props.post.uuid)"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem"
                                tabindex="-1" id="user-menu-item-0">
                            Edit
                            </Link>
                            <button @click.prevent="handlePostDelete()"
                                class="block px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100 w-full"
                                role="menuitem" tabindex="-1" id="user-menu-item-1">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /Card Action Dropdown -->
            </div>
        </header>

        <Link :href="route('posts.show', props.post.uuid)">
        <!-- Post Excerpt -->
        <div class="py-4 text-gray-700 font-normal whitespace-pre-wrap">
            {{ props.post.excerpt }}
        </div>

        <!-- Displaying Post Images -->
        <div v-if="props.post.media" class="mt-1 mb-6 grid gap-1"
            :class="(props.post.media.length > 1) ? 'grid-cols-2' : 'grid-cols-1'">
            <div v-for="(postImage, index) in props.post.media" :key="index" class="relative">
                <img :src="postImage.original_url" :alt="postImage.file_name" class="rounded-md">
                <!-- Show More -->
                <div v-if="index == 3 && props.post.remainingPostImages > 0"
                    class="absolute inset-0 bg-black bg-opacity-50 flex justify-center items-center text-white rounded-md cursor-pointer">
                    {{ (props.post.remainingPostImages == 1) ? '1 More' : `${props.post.remainingPostImages}+ More` }}
                </div>
            </div>

        </div>
        </Link>

        <!-- Date Created & View Stat -->
        <div class="flex items-center gap-2 text-gray-500 text-xs my-2">
            <span class="">{{ props.post.last_modified_time }}</span>
            <span class="">•</span>
            <span>4,450 views</span>
        </div>

        <!-- Barta Card Bottom -->
        <footer class="border-t border-gray-200 pt-2">
            <!-- Action Buttons -->
            <div class="flex items-center justify-between">
                <div class="flex gap-4 items-center text-gray-600">
                    <!-- Likes -->
                    <Like :modelData="props.post" likeActionRouteName="posts.like" />
                    <!-- Dislikes -->
                    <!-- <Dislike /> -->
                    <!-- Comment Button -->
                    <Link :href="route('posts.show', props.post.uuid)"
                        class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800">
                    <span class="sr-only">Comment</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 01-.923 1.785A5.969 5.969 0 006 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337z" />
                    </svg>

                    <p>{{ props.post.comments_count }}</p>
                    </Link>
                    <!-- /Comment Button -->
                </div>

                <!-- Share -->
                <div>
                    <div
                        class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800">
                        <span class="sr-only">Share</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                            <path fill-rule="evenodd"
                                d="M15.75 4.5a3 3 0 1 1 .825 2.066l-8.421 4.679a3.002 3.002 0 0 1 0 1.51l8.421 4.679a3 3 0 1 1-.729 1.31l-8.421-4.678a3 3 0 1 1 0-4.132l8.421-4.679a3 3 0 0 1-.096-.755Z"
                                clip-rule="evenodd" />
                        </svg>

                        <p>21</p>

                    </div>
                </div>
            </div>
            <!-- /Card Bottom Action Buttons -->
        </footer>
        <!-- /Barta Card Bottom -->
    </article>


</template>

<style scoped></style>