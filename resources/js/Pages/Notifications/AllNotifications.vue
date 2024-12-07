<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import UserLayout from '../../Layouts/UserLayout.vue';
import { onMounted } from 'vue';

const user = usePage().props.auth.user


// onMounted(() => {
//     Echo.private('App.Models.User.' + user.id)
//         .notification((notification) => {
//             alert(notification.type)
//         });
// })


const { userNotifications } = usePage().props

// {
//     "id": "5ae4b462-6446-44f4-bc45-9435bfc948b5",
//         "type": "App\\Notifications\\Post\\PostLiked",
//             "notifiable_type": "App\\Models\\User",
//                 "notifiable_id": 2,
//                     "data": {
//         "message": "Arsalan liked your post",
//             "link": "http://127.0.0.1:8000/posts/e6f7c1d4-7de2-4664-b811-4080e1cd442c",
//                 "sender": {
//             "first_name": "Arsalan",
//                 "last_name": "Islam",
//                     "user_name": "arsalan",
//                         "bio": "Helping businesses developing the custom solutions on ad hoc basis | Freelance Web Developer",
//                             "profileImgUrl": "http://localhost:8000/storage/70/dummy-customer.jpg"
//         }
//     },
//     "read_at": null,
//         "created_at": "2024-12-02T14:21:41.000000Z",
//             "updated_at": "2024-12-02T14:21:41.000000Z"
// }
</script>

<template>
    <UserLayout>
        <main class="container max-w-2xl mx-auto space-y-8 mt-8 px-2 min-h-screen">
            <article
                class="bg-white border-[1px] border-neutral-300 rounded-lg shadow mx-auto max-w-none px-4 py-5  sm:px-6">
                <!-- For no unread notification -->
                <div v-show="userNotifications.length == 0" class="flex flex-col items-center py-5 space-y-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5 md:size-8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 3.75H6.912a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859M12 3v8.25m0 0-3-3m3 3 3-3" />
                    </svg>
                    <p class="mx-2 text-md text-gray-600 dark1:text-white font-bold">
                        You don't have any notification
                    </p>
                </div>

                <div class="">
                    <template v-for="(notification, index) in userNotifications" :key="index">
                        <Link :href="notification.data.post_link"
                            class="flex items-center py-2 -mx-2 transition-colors duration-300 transform border-b border-gray-100 hover:bg-gray-50 dark1:hover:bg-gray-700 dark1:border-gray-700">
                        <img class="flex-shrink-0 object-cover w-8 h-8 mx-1 rounded-full"
                            :src="notification.data.sender.profileImgUrl" :alt="notification.data.sender.first_name" />
                        <p class="mx-2 text-sm text-gray-600 dark1:text-white">
                            <span class="font-bold" href="#">
                                {{ notification.data.sender.first_name }} {{ notification.data.sender.last_name }}
                            </span> {{ notification.data.message }} . {{ notification.created_at }}
                        </p>
                        </Link>
                    </template>
                </div>
            </article>
        </main>

    </UserLayout>
</template>

<style scoped>

</style>