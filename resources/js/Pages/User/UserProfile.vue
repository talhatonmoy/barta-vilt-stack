<script setup>
import { Link, router, usePage } from '@inertiajs/vue3';
import UserLayout from '../../Layouts/UserLayout.vue';
import CreatePostCard from '../../Components/CreatePostCard.vue';
import PostCard from '../../Components/PostCard.vue';
import { SingularPluralHelperTextOnly } from '../../Helpers/SingularPluralHelper';
import { ref } from 'vue';

const props = usePage().props;

const user = props.auth.user
const userData = props.userData;
const userPosts = props.userPosts;

const userPostsCollection = ref(userPosts.data)
const nextPageUrl = ref(userPosts.links.next);

function loadMorePost() {
    if (!nextPageUrl.value) return; // Prevent loading if no next page URL

    router.get(nextPageUrl.value, {}, {
        preserveState: true,
        preserveScroll: true, // Preserve scroll position
        replace: true, // Replace the current page state
        onSuccess: (page) => {
            userPostsCollection.value.push(...page.props.userPosts.data) // Append new posts
            nextPageUrl.value = page.props.userPosts.links.next // Update next page URL
        }
    })
}

</script>

<template>
    <UserLayout>
        <main class="container max-w-2xl mx-auto space-y-8 mt-8 px-2 min-h-screen">
            <!-- Cover Container -->
            <section
                class="bg-white border-2 p-8 border-gray-800 rounded-xl min-h-[350px] space-y-8 flex items-center flex-col justify-center">
                <!-- Profile Info -->
                <div class="flex gap-4 justify-center flex-col text-center items-center">
                    <!-- Avatar -->
                    <div class="relative">
                        <img class="w-32 h-32 rounded-full border-2 border-gray-800" :src="userData.profileImgUrl"
                            :alt="userData.first_name" />
                        <!--            <span class="bottom-2 right-4 absolute w-3.5 h-3.5 bg-green-400 border-2 border-white dark:border-gray-800 rounded-full"></span>-->
                    </div>
                    <!-- /Avatar -->

                    <!-- User Meta -->
                    <div>
                        <h1 class="font-bold md:text-2xl">{{ userData.first_name }} {{ userData.last_name }}</h1>
                        <p class="text-gray-700">{{ userData.bio }}</p>
                    </div>
                    <!-- / User Meta -->
                </div>
                <!-- /Profile Info -->

                <!-- Profile Stats -->
                <div class="flex flex-row gap-16 justify-center text-center items-center">
                    <!-- Total Posts Count -->
                    <div class="flex flex-col justify-center items-center">
                        <h4 class="sm:text-xl font-bold">{{ userData.posts_count }}</h4>
                        <p class="text-gray-600">{{ SingularPluralHelperTextOnly(userData.posts_count, 'Post', 'Posts') }}
                        </p>
                    </div>

                    <!-- Total Comments Count -->
                    <div class="flex flex-col justify-center items-center">
                        <h4 class="sm:text-xl font-bold">{{ userData.comments_count }}</h4>
                        <p class="text-gray-600">{{ SingularPluralHelperTextOnly(userData.comments_count, 'Comment',
                            'Comments') }}</p>
                    </div>
                </div>
                <!-- /Profile Stats -->

                <!-- Edit Profile Button (Only visible to the profile owner) -->
                <Link v-if="userData.user_name == user.user_name" :href="route('user.profile.edit')"
                    class="-m-2 flex gap-2 items-center rounded-full px-4 py-2 font-semibold bg-gray-100 hover:bg-gray-200 text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                </svg>

                Edit Profile
                </Link>
                <!-- /Edit Profile Button -->
            </section>

            <!-- Create Post Card -->
            <CreatePostCard rows="2" />

            <!-- User Specific Posts Feed -->
            <PostCard v-for="(post, index) in userPostsCollection" :key="index" :post="post" />

            <div class="flex justify-center">
                <button @click="loadMorePost"  v-if="nextPageUrl"
                    class="text-gray-900 hover:text-white border-2 border-gray-800 hover:bg-gray-900 focus:ring-2 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center hidden md:block">
                    Load More
                </button>
            </div>
        </main>
    </UserLayout>
</template>

<style scoped></style>