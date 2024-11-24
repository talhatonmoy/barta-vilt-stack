<script setup>
import { router, usePage } from '@inertiajs/vue3';
import UserLayout from '../../Layouts/UserLayout.vue';
import CreatePostCard from '../../Components/CreatePostCard.vue';
import PostCard from '../../Components/PostCard.vue';
import { ref } from 'vue';

const timelinePosts = ref(usePage().props.timelinePosts)
const nextPageUrl = ref(usePage().props.nextPageUrl)

//Load More Posts
function loadMorePosts() {
    if (!nextPageUrl.value) return; // Prevent loading if no next page URL

    router.get(nextPageUrl.value, {}, {
        preserveState: true,
        preserveScroll: true, // Preserve scroll position
        replace: true, // Replace the current page state
        onSuccess: (page) => {
            timelinePosts.value.push(...page.props.timelinePosts) // Append new posts
            nextPageUrl.value = page.props.nextPageUrl // Update next page URL
        }
    })
}

</script>

<template>
    <UserLayout>
        <!-- <pre>
            {{ timelinePosts }}
        </pre> -->
        <main class="container max-w-2xl mx-auto space-y-8 mt-8 px-2 min-h-screen">
            <!-- Create Post Card -->
            <CreatePostCard rows="2" />

            <!-- User Specific Posts Feed -->
            <PostCard v-for="(post, index) in timelinePosts" :key="index" :post="post" />
        </main>
        <div class="flex justify-center">
            <button @click="loadMorePosts" v-if="nextPageUrl"
                class="text-gray-900 hover:text-white border-2 border-gray-800 hover:bg-gray-900 focus:ring-2 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center hidden md:block">
                Load More
            </button>
        </div>
    </UserLayout>
</template>

<style scoped></style>