<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import UserLayout from '../../Layouts/UserLayout.vue';


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
    <!-- <pre>
        {{ userNotifications }}
    </pre> -->
    <UserLayout>
        <main class="container max-w-2xl mx-auto space-y-8 mt-8 px-2 min-h-screen">
            <article class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-5  sm:px-6">
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