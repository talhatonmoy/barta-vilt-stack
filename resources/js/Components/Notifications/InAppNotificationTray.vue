<script setup>
import { Link, router, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { ref, reactive, onMounted  } from 'vue';
import PostLikeNotificationItem from './PostLikeNotificationItem.vue';
import FriendRequestSentNotificationItem from './FriendRequestSentNotificationItem.vue';
const user = usePage().props.auth.user

const unreadNotifications = ref([]);
const unreadNotificationCount = ref(0);

onMounted(async () => {
    // fetchUnreadNotifications()


    // Echo.private(`App.Models.User.${user.id}`)
    //     .notification((notification) => {
    //         console.log(notification);
    //     });

    // Echo.private(`App.Models.User.2`)
    //     .listen( 'TestEvent' ,(event) => {
    //         console.log(event);
    //     });
   
})


async function fetchUnreadNotifications() {
    const response = await axios.get(route('user.notifications.tray'))
    unreadNotifications.value = response.data
    unreadNotificationCount.value = response.data.length
}

// Notification Tray State
const notificationTray = reactive({
    open: false,
    handleChange() {
        notificationTray.open = !notificationTray.open
        fetchUnreadNotifications()
    },
    reset() {
        notificationTray.open = false
    }
})

function markAllNotificationAsRead() {
    // Preventing unnecessary request
    if (!unreadNotifications.value.length) {
        return;
    }

    router.post(route('user.notifications.mark_all_as_read'), {}, {
        preserveScroll: true,
        onSuccess: () => {
            unreadNotificationCount.value = 0
        }
    })
}

</script>

<template>
    <div class="relative inline-block">
        <!-- Dropdown toggle button -->
        <button @click="notificationTray.handleChange" v-click-away="notificationTray.reset"
            class="relative z-10 block text-gray-700 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-5 sm:size-6 "
                :class="(notificationTray.open) ? 'stroke-blue-600' : ''">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
            </svg>
            <p v-if="unreadNotificationCount > 0"
                class="absolute -top-2 -right-1 text-xs bg-red-500 p-2 text-white w-5 h-5 flex items-center justify-center rounded-full leading-none">
                {{ unreadNotificationCount }}</p>
        </button>

        <!-- Dropdown menu -->
        <Transition name="slide-fade">
            <div v-show="notificationTray.open"
                class="absolute -right-7 lg:-right-40 top-14 lg:top-[4.7rem] z-20 w-72 overflow-hidden origin-top-right bg-white rounded-md shadow-lg sm:w-80 dark1:bg-gray-800">
                <div class="py-2 max-h-96 md:max-h-[450px]  overflow-x-hidden overflow-y-auto">

                    <!-- For no unread notification -->
                    <div v-show="unreadNotifications.length == 0" class="flex flex-col items-center py-5 space-y-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5 md:size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 3.75H6.912a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859M12 3v8.25m0 0-3-3m3 3 3-3" />
                        </svg>
                        <p class="mx-2 text-xs text-gray-600 dark1:text-white font-bold">
                            You don't have any unread notification
                        </p>
                    </div>

                    <!-- Displaying all unread notifications -->
                    <template v-show="unreadNotifications.length > 0"
                        v-for="(notification, index) in unreadNotifications" :key="index">
                        <!-- Post Like -->
                        <PostLikeNotificationItem v-if="notification.data.type === 'postLike'"
                            :notification="notification" />
                        
                        <!-- Friend Request Sent -->
                        <FriendRequestSentNotificationItem v-if="notification.data.type === 'friendRequestSent'"
                            :notification="notification" />
                    </template>

                </div>

                <!-- Actions -->
                <div class="flex justify-between w-full">
                    <Link :href="route('user.notifications')"
                        class="block w-1/2 py-2 border-r-2 border-r-gray-500 font-medium text-xs text-center text-white bg-gray-800 dark1:bg-gray-700 hover:underline">
                    See all notifications
                    </Link>

                    <button @click.prevent="markAllNotificationAsRead"
                        class="block w-1/2 py-2 font-medium text-xs text-center text-white bg-gray-800 dark1:bg-gray-700 hover:underline">
                        Mark all as read
                    </button>
                </div>
            </div>
        </Transition>

    </div>
</template>

<style scoped>
/*
  Enter and leave animations can use different
  durations and timing functions.
*/
.slide-fade-enter-active {
    transition: all 0.2s ease-out;
}

.slide-fade-leave-active {
    transition: all 0.2s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateY(-20px);
    opacity: 0;
}
</style>