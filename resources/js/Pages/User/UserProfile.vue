<script setup>
import { Link, router, usePage } from '@inertiajs/vue3';
import CreatePostCard from '../../Components/CreatePostCard.vue';
import PostCard from '../../Components/PostCard.vue';
import { SingularPluralHelperTextOnly } from '../../Helpers/SingularPluralHelper';
import { reactive, ref } from 'vue';

const props = usePage().props;

const user = props.auth.user
const userProfileData = props.userProfileData;
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


const friendRequest = reactive({
    status: (userProfileData.received_friend_request_data)
        ? userProfileData.received_friend_request_data.status
        : (userProfileData.sent_friend_request_data)
        ? userProfileData.sent_friend_request_data.status
        : 'add friend',

    toggle() {
        router.visit(route('friend.request.toggle', userProfileData.user_name), {
            method: 'post',
            preserveScroll: true,
        })
    },

    withdraw() {
        router.visit(route('friend.request.toggle', userProfileData.user_name), {
            method: 'post',
            preserveScroll: true
        })
    },

    accept() {
        router.visit(route('friend.request.accept', userProfileData.sent_friend_request_data), {
            method: 'post',
            preserveScroll: true
        })
    },

    reject() {
        router.visit(route('friend.request.reject', userProfileData.sent_friend_request_data.id), {
            method: 'post',
            preserveScroll: true,
            onBefore: () => {
                return confirm(`Are you really want to reject this request ?`)
            }
        })
    },

    unfriendThisUser() {
        router.visit(route('unfriend', (userProfileData.received_friend_request_data) ? userProfileData.received_friend_request_data.id : userProfileData.sent_friend_request_data.id), {
            method: 'post',
            preserveScroll: true,
            onBefore: () => {
                return confirm(`Are you really want to unfriend ${userProfileData.first_name} ${userProfileData.last_name} ?`)
            }
        })
    }
})

</script>

<template>
    <!-- <pre>
            {{ userProfileData }}
    </pre>

    <pre>
        {{ friendRequest }}
    </pre> -->
    <main class="container max-w-2xl mx-auto space-y-8 mt-8 px-2 min-h-screen">
        <!-- Cover Container -->
        <section
            class="bg-white border-[1px] border-neutral-300  p-8 rounded-xl min-h-[350px] space-y-8 flex items-center flex-col justify-center">
            <!-- Profile Info -->
            <div class="flex gap-4 justify-center flex-col text-center items-center">
                <!-- Avatar -->
                <div class="relative">
                    <img class="w-32 h-32 rounded-full ring-2 ring-neutral-900" :src="userProfileData.profileImgUrl"
                        :alt="userProfileData.first_name" />
                    <!--            <span class="bottom-2 right-4 absolute w-3.5 h-3.5 bg-green-400 border-2 border-white dark1:border-gray-800 rounded-full"></span>-->
                </div>
                <!-- /Avatar -->

                <!-- User Meta -->
                <div>
                    <h1 class="font-bold md:text-2xl">{{ userProfileData.first_name }} {{ userProfileData.last_name }}</h1>
                    <p class="text-gray-700">{{ userProfileData.bio }}</p>
                </div>
                <!-- / User Meta -->
            </div>
            <!-- /Profile Info -->

            <!-- Profile Stats -->
            <div class="flex flex-row gap-16 justify-center text-center items-center">
                <!-- Total Posts Count -->
                <div class="flex flex-col justify-center items-center">
                    <h4 class="sm:text-xl font-bold">{{ userProfileData.posts_count }}</h4>
                    <p class="text-gray-600">{{ SingularPluralHelperTextOnly(userProfileData.posts_count, 'Post', 'Posts')
                        }}
                    </p>
                </div>

                <!-- Total Comments Count -->
                <div class="flex flex-col justify-center items-center">
                    <h4 class="sm:text-xl font-bold">{{ userProfileData.comments_count }}</h4>
                    <p class="text-gray-600">{{ SingularPluralHelperTextOnly(userProfileData.comments_count, 'Comment',
                        'Comments') }}</p>
                </div>
            </div>
            <!-- /Profile Stats -->

            <!-- Edit Profile Button (Only visible to the profile owner) -->
            <Link v-if="userProfileData.user_name == user.user_name" :href="route('user.profile.edit')"
                class="-m-2 flex gap-2 items-center rounded-full px-4 py-2 font-semibold bg-gray-100 hover:bg-gray-200 text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
            </svg>
            Edit Profile
            </Link>
            <!-- /Edit Profile Button -->

            <template v-if="userProfileData.user_name != user.user_name">
                <!-- Actions Buttons Before accepting (Request Receiver End - Accept - Reject)-->
                <div v-if="userProfileData.sent_friend_request_data != null && userProfileData.sent_friend_request_data.status !== 'accepted'"
                    class="inline-flex rounded-md shadow-sm" role="group">
                    <button @click.prevent="friendRequest.accept"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700  dark1:bg-gray-800 dark1:border-gray-700 dark1:text-white dark1:hover:text-white dark1:hover:bg-gray-700 ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="size-4 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                        </svg>
                        Accept
                    </button>
                    <button @click.prevent="friendRequest.reject"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium border-r-2 rounded-e-lg text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700  dark1:bg-gray-800 dark1:border-gray-700 dark1:text-white dark1:hover:text-white dark1:hover:bg-gray-700 ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="size-4 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m6 4.125 2.25 2.25m0 0 2.25 2.25M12 13.875l2.25-2.25M12 13.875l-2.25 2.25M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                        </svg>
                        Reject
                    </button>
                    <!-- <button type="button"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700  dark1:bg-gray-800 dark1:border-gray-700 dark1:text-white dark1:hover:text-white dark1:hover:bg-gray-700 ">
                        <svg class="w-3 h-3 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M14.707 7.793a1 1 0 0 0-1.414 0L11 10.086V1.5a1 1 0 0 0-2 0v8.586L6.707 7.793a1 1 0 1 0-1.414 1.414l4 4a1 1 0 0 0 1.416 0l4-4a1 1 0 0 0-.002-1.414Z" />
                            <path
                                d="M18 12h-2.55l-2.975 2.975a3.5 3.5 0 0 1-4.95 0L4.55 12H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2Zm-3 5a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z" />
                        </svg>
                        Block
                    </button>  -->
                </div>

                <!-- Actions buttons at pending status (Request Sender End View - Pending - Withdraw) -->
                <div
                    v-if="userProfileData.received_friend_request_data !== null && userProfileData.received_friend_request_data.status === 'pending'">
                    <div class="inline-flex rounded-md shadow-sm" role="group">
                        <button type="button"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg   dark1:bg-gray-800 dark1:border-gray-700 dark1:text-white dark1:hover:text-white dark1:hover:bg-gray-700 ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="size-3.5 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                            Pending
                        </button>


                        <button @click.prevent="friendRequest.toggle"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700  dark1:bg-gray-800 dark1:border-gray-700 dark1:text-white dark1:hover:text-white dark1:hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="size-4 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM4 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 10.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                            </svg>
                            Withdraw
                        </button>
                    </div>
                </div>

                <!-- Actions buttons after accepting -->
                <div v-if="friendRequest.status === 'accepted'">
                    <div class="inline-flex rounded-md shadow-sm" role="group">
                        <button type="button"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg   dark1:bg-gray-800 dark1:border-gray-700 dark1:text-white dark1:hover:text-white dark1:hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="size-3.5 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                            Connected
                        </button>

                        <Link :href="route('message.index', userProfileData.user_name )"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200  dark1:bg-gray-800 dark1:border-gray-700 dark1:text-white dark1:hover:text-white dark1:hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-4 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                            </svg>
                            Message
                        </Link>


                        <button @click.prevent="friendRequest.unfriendThisUser"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700  dark1:bg-gray-800 dark1:border-gray-700 dark1:text-white dark1:hover:text-white dark1:hover:bg-gray-700 ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="size-4 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM4 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 10.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                            </svg>
                            Unfriend
                        </button>
                    </div>
                </div>

                <!-- Sent Friend request - Default -->
                <div v-if="!userProfileData.sent_friend_request_data && !userProfileData.received_friend_request_data">
                    <div class="inline-flex rounded-md shadow-sm" role="group">
                        <button type="button" @click.prevent="friendRequest.toggle"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg rounded-e-lg   dark1:bg-gray-800 dark1:border-gray-700 dark1:text-white dark1:hover:text-white dark1:hover:bg-gray-700 ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="size-3.5 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                            Add Friend
                        </button>


                        <!-- <button type="button"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700  dark1:bg-gray-800 dark1:border-gray-700 dark1:text-white dark1:hover:text-white dark1:hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="size-4 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM4 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 10.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                            </svg>
                            Follow
                        </button> -->
                    </div>
                </div>
            </template>


        </section>

        <!-- Create Post Card -->
        <CreatePostCard rows="2" />

        <!-- User Specific Posts Feed -->
        <PostCard v-for="(post, index) in userPostsCollection" :key="index" :post="post" />

        <div class="flex justify-center">
            <button @click="loadMorePost" v-if="nextPageUrl"
                class="text-gray-900 hover:text-white border-2 border-gray-800 hover:bg-gray-900  font-medium rounded-lg text-sm px-5 py-2.5 text-center hidden md:block">
                Load More
            </button>
        </div>
    </main>
</template>

<style scoped></style>