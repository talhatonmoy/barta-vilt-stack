<script setup>
import { Link, router } from '@inertiajs/vue3';
import { provide, reactive, ref } from 'vue';
import EditCommentForm from './EditCommentForm.vue';

const props = defineProps({
    commentData: {
        type: Object,
        Required: true
    }
})

const commentData = props.commentData;

const menu = reactive({
    open: false,
    handleChange() {
        menu.open = !menu.open
    },
    reset() {
        menu.open = false
    }
})


// CommentState
const CommentMoodStore = reactive({
    editing: false,
    handleEditButton() {
        CommentMoodStore.editing = true
    },
    reset() {
        CommentMoodStore.editing = false
    }
})
provide('CommentMoodStore', CommentMoodStore)


// Sending Delete Request
function handlePostDelete() {
    router.visit(route('comments.destroy', commentData.uuid), {
        method: 'delete',
        preserveScroll: true,
        onBefore: visit => {
            return confirm("Are You Really Want To Delete This Comment?")
        }
    })
}




</script>

<template>
    <div class="py-4">
        <!-- Barta User Comments Top -->
        <header>
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <!-- User Avatar -->
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full object-cover" :src="commentData.user.profileImgUrl"
                            :alt="commentData.user.first_name" />
                    </div>
                    <!-- /User Avatar -->
                    <!-- User Info -->
                    <div class="text-gray-900 flex flex-col min-w-0 flex-1">
                        <Link :href="route('user.profile.show', commentData.user.user_name)"
                            class="hover:underline font-semibold line-clamp-1">
                        {{ commentData.user.first_name }} {{ commentData.user.last_name }}
                        </Link>

                        <p class=" text-sm text-gray-500 line-clamp-1">
                            {{ commentData.user.bio }}
                        </p>
                    </div>
                    <!-- /User Info -->
                </div>

                <!-- Card Action Dropdown -->
                <div v-if="commentData.can.update && commentData.can.delete"  class="flex flex-shrink-0 self-center" >
                    <div class="relative inline-block text-left">
                        <div>
                            <button @click="menu.handleChange" type="button" v-click-away="menu.reset"
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
                            <button @click.prevent="CommentMoodStore.handleEditButton"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left"
                                role="menuitem" tabindex="-1" id="user-menu-item-0">Edit</button>
                            <button @click.prevent="handlePostDelete()"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left"
                                role="menuitem" tabindex="-1" id="user-menu-item-1">Delete</button>
                        </div>
                    </div>
                </div>
                <!-- /Card Action Dropdown -->
            </div>
        </header>

        <!-- Content -->
        <EditCommentForm v-if="CommentMoodStore.editing" :commentData="commentData" />
        <div v-show="!CommentMoodStore.editing" class="py-4 text-gray-700 font-normal">
            {{ commentData.comment_body }}
        </div>

        <!-- Date Created -->
        <div class="flex items-center gap-2 text-gray-500 text-xs">
            <span class="">{{ commentData.last_modified_time }}</span>
        </div>
    </div>


</template>

<style scoped>

</style>