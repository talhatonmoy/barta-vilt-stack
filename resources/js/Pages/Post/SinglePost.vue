<script setup>
import { onBeforeMount, reactive, ref } from 'vue';
import UserLayout from '../../Layouts/UserLayout.vue';
import { usePage, Link, router } from '@inertiajs/vue3';
import CommentForm from '../../Components/CommentForm.vue';
import CommentsListCard from '../../Components/CommentsListCard.vue';
import SingularPluralHelper from '../../Helpers/SingularPluralHelper';


const { postDetail, can, allComments } = usePage().props

// Menu State
const menu = reactive({
    open: false,
    handleChange() {
        menu.open = !menu.open
    },
    reset() {
        menu.open = false
    }
})



// Sending Post Delete Request
function handlePostDelete() {
    router.visit(route('posts.destroy', postDetail.uuid), {
        method: 'delete',
        onBefore: visit => {
            return confirm("Are You Really Want To Delete This Post?")
        }
    })
}



</script>

<template>
    <UserLayout>
        <main class="container max-w-2xl mx-auto space-y-8 mt-8 px-2 md:px-0 min-h-screen">
            <section id="newsfeed" class="space-y-6">
                <!-- Barta Card -->
                <article class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-5 sm:px-6">
                    <!-- Barta Card Top -->
                    <header>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <!-- User Avatar -->
                                <Link :href="route('user.profile.show', postDetail.user.user_name)">
                                <div class="flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full object-cover"
                                        :src="postDetail.user.profileImgUrl" :alt="postDetail.user.first_name" />
                                </div>
                                </Link>

                                <!-- /User Avatar -->

                                <!-- User Info -->
                                <div class="text-gray-900 flex flex-col min-w-0 flex-1">
                                    <Link :href="route('user.profile.show', postDetail.user.user_name)"
                                        class="hover:underline font-semibold line-clamp-1">
                                    {{ postDetail.user.first_name }} {{ postDetail.user.last_name }}
                                    </Link>

                                    <p class=" text-sm text-gray-500 line-clamp-1">
                                        {{ postDetail.user.bio }}
                                    </p>
                                </div>
                                <!-- /User Info -->
                            </div>

                            <!-- Card Action Dropdown -->
                            <div v-if="can.update_post && can.delete_post" class="flex flex-shrink-0 self-center">
                                <div class="relative inline-block text-left">
                                    <div>
                                        <button @click="menu.handleChange" v-click-away="menu.reset" type="button"
                                            class="-m-2 flex items-center rounded-full p-2 text-gray-400 hover:text-gray-600"
                                            id="menu-0-button">
                                            <span class="sr-only">Open options</span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"
                                                aria-hidden="true">
                                                <path
                                                    d="M10 3a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM10 8.5a1.5 1.5 0 110 3 1.5 1.5 0 010-3zM11.5 15.5a1.5 1.5 0 10-3 0 1.5 1.5 0 003 0z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                    <!-- Dropdown menu -->
                                    <div v-show="menu.open"
                                        class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                        role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                        tabindex="-1">
                                        <Link :href="route('posts.edit', postDetail.uuid)"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            role="menuitem" tabindex="-1" id="user-menu-item-0">Edit
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

                    <!--Post Content -->
                    <div class="py-4 text-gray-700 font-normal whitespace-pre-wrap">
                        {{ postDetail.post_body }}
                    </div>

                    <!-- Post Image -->
                    <div v-if="postDetail.postImages.length" class="mt-2 mb-6 space-y-4">
                        <img v-for="(img, index) in postDetail.postImages" :key="index" :src="img.url"
                            :alt="img.file_name" class="rounded-md">
                    </div>


                    <!-- Date Created & View Stat -->
                    <div class="flex items-center gap-2 text-gray-500 text-xs my-2">
                        <span class="">
                            {{ postDetail.last_modified_time }}
                        </span>

                        <span class="">•</span>
                        <span>{{ SingularPluralHelper(postDetail.comments_count, 'Comment', 'Comments') }}</span>
                        <span class="">•</span>
                        <span>450 views</span>
                    </div>

                    <hr class="my-6" />

                    <!-- Barta Create Comment Form -->
                    <CommentForm :postUuid="postDetail.uuid" />
                    <!-- /Barta Create Comment Form -->

                    <!-- /Barta Card Bottom -->
                </article>
                <!-- /Barta Card -->

                <hr />

                <div class="flex flex-col space-y-6">
                    <h1 class="text-lg font-semibold">
                        {{ SingularPluralHelper(allComments.length, 'Comment', 'Comments', false) }}
                    </h1>

                    <!-- Barta User Comments Container -->
                    <article v-if="allComments.length>0"
                        class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-2 sm:px-6 min-w-full divide-y">
                        <!-- Comment  -->
                        <div v-for="(comment, index) in allComments" :key="index">
                            <CommentsListCard :commentData="comment" />
                        </div>
                        <!-- /Comment  -->
                    </article>

                    <article v-else
                        class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-2 sm:px-6 min-w-full divide-y">
                        <!-- Comment  -->
                        <p>Be the first to comment on this post</p>
                        <!-- /Comment  -->
                    </article>
                    <!-- /Barta User Comments -->
                </div>
            </section>
            <!-- /Newsfeed -->
        </main>
    </UserLayout>
</template>

<style scoped></style>